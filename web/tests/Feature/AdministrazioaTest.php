<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use App\Models\Rola;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdministrazioaTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_is_in_basque_and_guests_cannot_view_users(): void
    {
        $this->get('/login.php')->assertOk()->assertSee('lang="eu"', false)->assertSee('Saioa hasi');
        $this->get('/administrazioa.php')->assertRedirect('/login.php');
    }

    public function test_seeded_admin_can_login_view_every_user_and_logout(): void
    {
        $this->seed(AdminSeeder::class);
        $admin = Erabiltzailea::firstOrFail();
        $other = $this->createMember();
        $this->assertTrue(Hash::check('Admin123', $admin->pasahitza));

        $this->post('/login.php', ['emaila' => $admin->emaila, 'pasahitza' => 'Admin123'])
            ->assertRedirect('/administrazioa.php');
        $this->assertAuthenticatedAs($admin);
        $this->get('/administrazioa.php')->assertOk()->assertSee($admin->emaila)->assertSee($other->emaila)
            ->assertDontSee($admin->pasahitza)->assertDontSee('Admin123');
        $this->post('/irten')->assertRedirect('/login.php');
        $this->assertGuest();
        $this->get('/administrazioa.php')->assertRedirect('/login.php');
    }

    public function test_invalid_password_and_non_admin_role_are_rejected(): void
    {
        $this->seed(AdminSeeder::class);
        $this->from('/login.php')->post('/login.php', [
            'emaila' => 'admin@example.com', 'pasahitza' => 'wrong',
        ])->assertRedirect('/login.php')->assertSessionHasErrors('emaila');
        $this->assertGuest();

        $member = $this->createMember();
        $this->post('/login.php', ['emaila' => $member->emaila, 'pasahitza' => 'Admin123'])
            ->assertSessionHasErrors('emaila');
        $this->assertGuest();
        $this->actingAs($member)->get('/administrazioa.php')->assertRedirect('/login.php');
    }

    public function test_role_is_rechecked_after_login(): void
    {
        $this->seed(AdminSeeder::class);
        $admin = Erabiltzailea::firstOrFail();
        $this->actingAs($admin);
        $admin->rola()->update(['rola_izena' => 'ikaslea']);
        $this->get('/administrazioa.php')->assertRedirect('/login.php');
        $this->assertGuest();
    }

    public function test_seeding_twice_does_not_duplicate_records(): void
    {
        $this->seed(AdminSeeder::class);
        $hash = Erabiltzailea::firstOrFail()->pasahitza;
        $this->seed(AdminSeeder::class);
        $this->assertDatabaseCount('rolak', 1);
        $this->assertDatabaseCount('erabiltzaileak', 1);
        $this->assertSame($hash, Erabiltzailea::firstOrFail()->pasahitza);
    }

    public function test_validation_and_rate_limit_are_in_basque(): void
    {
        $this->post('/login.php', [])->assertSessionHasErrors([
            'emaila' => 'Idatzi zure helbide elektronikoa.',
            'pasahitza' => 'Idatzi zure pasahitza.',
        ]);
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $response = $this->from('/login.php')->post('/login.php', [
                'emaila' => 'missing@example.com', 'pasahitza' => 'wrong',
            ]);
        }
        $response->assertSessionHasErrors('emaila');
        $this->get('/login.php')->assertSee('Saiakera gehiegi');
        $this->assertGuest();
    }

    public function test_password_rehash_uses_the_pasahitza_column(): void
    {
        $this->seed(AdminSeeder::class);
        Erabiltzailea::firstOrFail()->update([
            'pasahitza' => password_hash('Admin123', PASSWORD_BCRYPT, ['cost' => 5]),
        ]);
        $this->post('/login.php', [
            'emaila' => 'admin@example.com', 'pasahitza' => 'Admin123',
        ])->assertRedirect('/administrazioa.php');
        $this->assertAuthenticated();
    }

    private function createMember(): Erabiltzailea
    {
        $role = Rola::create(['rola_izena' => 'ikaslea']);

        return Erabiltzailea::create([
            'izena' => 'Ane', 'abizenak' => 'Etxeberria', 'emaila' => 'ane@example.com',
            'pasahitza' => Hash::make('Admin123'), 'id_rola' => $role->id_rola, 'aktibo' => true,
        ]);
    }
}
