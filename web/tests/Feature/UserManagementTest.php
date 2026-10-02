<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use Database\Seeders\AdminSeeder;
use Database\Seeders\IkastetxeaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private Erabiltzailea $admin;
    private Erabiltzailea $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([AdminSeeder::class, IkastetxeaSeeder::class]);
        $this->admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $this->student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
    }

    private function data(Erabiltzailea $user): array
    {
        return $user->only(['izena', 'abizenak', 'emaila', 'id_rola', 'aktibo']);
    }

    public function test_admin_can_edit_users_without_changing_passwords_or_enrollments(): void
    {
        $password = $this->student->pasahitza;
        $this->actingAs($this->admin)->get(route('administrazioa'))->assertOk()
            ->assertSee(route('users.edit', $this->student));
        $this->get(route('users.edit', $this->student))->assertOk()->assertSee($this->student->emaila);
        $this->patch(route('users.update', $this->student), [
            ...$this->data($this->student), 'izena' => 'Ane berria', 'abizenak' => 'Berria',
            'emaila' => '  BERRIA@example.com  ', 'id_rola' => $this->admin->id_rola, 'aktibo' => 1,
            'pasahitza' => 'unwanted-password',
        ])->assertRedirect(route('administrazioa'))->assertSessionHasNoErrors();
        $updated = $this->student->fresh();
        $this->assertSame('Ane berria', $updated->izena);
        $this->assertSame('Berria', $updated->abizenak);
        $this->assertSame('berria@example.com', $updated->emaila);
        $this->assertSame($this->admin->id_rola, $updated->id_rola);
        $this->assertTrue((bool) $updated->aktibo);
        $this->assertSame($password, $updated->pasahitza);
        $this->assertDatabaseCount('matrikulak', 0);
        $this->patch(route('users.update', $updated), [...$this->data($updated), 'aktibo' => 0])
            ->assertSessionHasNoErrors();
        $this->assertFalse((bool) $updated->fresh()->aktibo);
    }

    public function test_invalid_fields_are_rejected_and_input_is_preserved(): void
    {
        $this->actingAs($this->admin)->from(route('users.edit', $this->student))
            ->patch(route('users.update', $this->student), [
                ...$this->data($this->student), 'izena' => '', 'abizenak' => '',
                'emaila' => 'ADMIN@example.com', 'id_rola' => 99999, 'aktibo' => 'invalid',
            ])->assertRedirect(route('users.edit', $this->student))
            ->assertSessionHasErrors(['izena', 'abizenak', 'emaila', 'id_rola', 'aktibo'])
            ->assertSessionHasInput('emaila', 'admin@example.com');
        $this->assertSame('ane@example.com', $this->student->fresh()->emaila);
    }

    public function test_admin_can_edit_own_details_but_cannot_disable_or_demote_self(): void
    {
        $this->actingAs($this->admin)->patch(route('users.update', $this->admin), $this->data($this->admin))
            ->assertRedirect(route('administrazioa'))->assertSessionHasNoErrors();
        foreach ([['aktibo' => 0], ['id_rola' => $this->student->id_rola]] as $change) {
            $this->patch(route('users.update', $this->admin), [...$this->data($this->admin), ...$change])
                ->assertSessionHasErrors('erabiltzailea');
        }
        $this->assertTrue((bool) $this->admin->fresh()->aktibo);
        $this->assertSame('admin', $this->admin->fresh()->rola->rola_izena);
    }

    public function test_guests_and_students_cannot_edit_users(): void
    {
        $this->get(route('users.edit', $this->student))->assertRedirect(route('login'));
        $this->patch(route('users.update', $this->student), $this->data($this->student))->assertRedirect(route('login'));
        $this->actingAs($this->student)->get(route('users.edit', $this->admin))->assertRedirect(route('login'));
        $this->patch(route('users.update', $this->student), [
            ...$this->data($this->student), 'id_rola' => $this->admin->id_rola,
        ])->assertRedirect(route('login'));
        $this->assertSame('ikasleak', $this->student->fresh()->rola->rola_izena);
    }
}
