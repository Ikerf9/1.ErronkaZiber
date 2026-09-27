<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use App\Models\Matrikula;
use Database\Seeders\AdminSeeder;
use Database\Seeders\IkastetxeaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class IkastetxeaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([AdminSeeder::class, IkastetxeaSeeder::class]);
    }

    public function test_catalog_is_public_and_guests_cannot_enroll(): void
    {
        $response = $this->get('/index.php')->assertOk()->assertSee('Erregistratu')
            ->assertSee('Saioa hasi')->assertDontSee('>Matrikulatu</button>', false);
        foreach (Ikastaroa::all() as $course) {
            $response->assertSee($course->izenburua);
        }
        $this->post(route('enroll', Ikastaroa::first()))->assertRedirect('/login.php');
        $this->assertDatabaseCount('matrikulak', 0);
        $this->get('/erregistratu.php')->assertOk()->assertSee('Kontua aktibatu');
    }

    public function test_preapproved_student_can_register_login_and_enroll_once(): void
    {
        $student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $course = Ikastaroa::firstOrFail();
        $this->post('/erregistratu.php', $this->registration('ANE@example.com'))->assertRedirect('/login.php');
        $student->refresh();
        $this->assertTrue(Hash::check('Ikasle123', $student->pasahitza));
        $this->assertTrue((bool) $student->aktibo);
        $this->assertSame('ikasleak', $student->rola->rola_izena);
        $this->post('/login.php', ['emaila' => 'ane@example.com', 'pasahitza' => 'Ikasle123'])
            ->assertRedirect('/index.php');
        $this->assertAuthenticatedAs($student);
        $this->get('/index.php')->assertSee('>Matrikulatu</button>', false);
        $this->post(route('enroll', $course))->assertRedirect('/index.php')->assertSessionHasNoErrors();
        $this->assertDatabaseHas('matrikulak', [
            'id_erabiltzailea' => $student->id_erabiltzailea,
            'id_ikastaroa' => $course->id_ikastaroa, 'egoera' => 'aktibo',
        ]);
        $this->get('/index.php')->assertSee('Matrikulatuta zaude');
        $this->post(route('enroll', $course))->assertSessionHasErrors('matrikula');
        $this->assertDatabaseCount('matrikulak', 1);
    }

    public function test_registration_cannot_create_unapproved_accounts_or_claim_admins(): void
    {
        $hash = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail()->pasahitza;
        foreach (['unknown@example.com', 'admin@example.com'] as $email) {
            $this->post('/erregistratu.php', $this->registration($email))->assertSessionHasErrors('emaila');
        }
        $this->assertDatabaseCount('erabiltzaileak', 7);
        $this->assertSame($hash, Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail()->pasahitza);
        $this->assertGuest();
    }

    public function test_registration_cannot_reset_a_registered_students_password(): void
    {
        $this->post('/erregistratu.php', $this->registration('ane@example.com'))->assertRedirect('/login.php');
        $student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $hash = $student->pasahitza;
        $this->post('/erregistratu.php', [
            'emaila' => $student->emaila, 'pasahitza' => 'Changed123', 'pasahitza_confirmation' => 'Changed123',
        ])->assertSessionHasErrors('emaila');
        $this->assertSame($hash, $student->fresh()->pasahitza);
    }

    public function test_password_confirmation_is_required_and_passwords_are_not_flashed(): void
    {
        $this->post('/erregistratu.php', [
            'emaila' => 'ane@example.com', 'pasahitza' => 'Ikasle123', 'pasahitza_confirmation' => 'different',
        ])->assertSessionHasErrors('pasahitza')->assertSessionMissing('_old_input.pasahitza')
            ->assertSessionMissing('_old_input.pasahitza_confirmation');
        $this->assertNull(Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail()->pasahitza);
    }

    public function test_admin_can_preapprove_a_student_but_students_cannot(): void
    {
        $admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin)->post('/ikasleak', [
            'izena' => 'Nerea', 'abizenak' => 'Goikoetxea', 'emaila' => 'NEREA@example.com',
        ])->assertRedirect('/administrazioa.php');
        $newStudent = Erabiltzailea::where('emaila', 'nerea@example.com')->firstOrFail();
        $this->assertNull($newStudent->pasahitza);
        $this->assertSame('ikasleak', $newStudent->rola->rola_izena);
        $this->post('/irten');
        $this->post('/erregistratu.php', $this->registration($newStudent->emaila))->assertRedirect('/login.php');
        $this->actingAs($newStudent->fresh())->post('/ikasleak', [
            'izena' => 'Beste', 'abizenak' => 'Ikaslea', 'emaila' => 'other@example.com',
        ])->assertRedirect('/login.php');
        $this->assertDatabaseMissing('erabiltzaileak', ['emaila' => 'other@example.com']);
    }

    public function test_capacity_and_role_are_checked_on_the_server(): void
    {
        $course = Ikastaroa::firstOrFail();
        $course->update(['edukiera' => 1]);
        $student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $student->update(['aktibo' => true, 'pasahitza' => Hash::make('Ikasle123')]);
        $other = Erabiltzailea::where('emaila', 'mikel@example.com')->firstOrFail();
        Matrikula::create([
            'id_erabiltzailea' => $other->id_erabiltzailea,
            'id_ikastaroa' => $course->id_ikastaroa, 'matrikula_data' => now()->toDateString(), 'egoera' => 'aktibo',
        ]);
        $this->actingAs($student)->post(route('enroll', $course))->assertSessionHasErrors('matrikula');
        $this->assertDatabaseCount('matrikulak', 1);
        $emptyCourse = Ikastaroa::where('id_ikastaroa', '!=', $course->id_ikastaroa)->firstOrFail();
        $admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin)->post(route('enroll', $emptyCourse))->assertSessionHasErrors('matrikula');
        $student->update(['aktibo' => false]);
        $this->actingAs($student)->post(route('enroll', $emptyCourse))->assertSessionHasErrors('matrikula');
        $this->assertDatabaseCount('matrikulak', 1);
    }

    public function test_students_cannot_view_admin_and_inactive_students_cannot_login(): void
    {
        $this->post('/login.php', ['emaila' => 'ane@example.com', 'pasahitza' => 'Ikasle123'])
            ->assertSessionHasErrors('emaila');
        $this->assertGuest();
        $student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $this->actingAs($student)->get('/administrazioa.php')->assertRedirect('/login.php');
    }

    public function test_seeding_does_not_duplicate_or_reset_registered_students(): void
    {
        $this->post('/erregistratu.php', $this->registration('ane@example.com'));
        $hash = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail()->pasahitza;
        $this->seed(IkastetxeaSeeder::class);
        $this->assertDatabaseCount('erabiltzaileak', 7);
        $this->assertDatabaseCount('ikastaroak', 4);
        $this->assertSame($hash, Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail()->pasahitza);
    }

    private function registration(string $email): array
    {
        return ['emaila' => $email, 'pasahitza' => 'Ikasle123', 'pasahitza_confirmation' => 'Ikasle123'];
    }
}
