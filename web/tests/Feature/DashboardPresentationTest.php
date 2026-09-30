<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use App\Models\Matrikula;
use Database\Seeders\AdminSeeder;
use Database\Seeders\IkastetxeaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPresentationTest extends TestCase
{
    use RefreshDatabase;

    public function test_statistics_exclude_admins_and_inactive_enrollments(): void
    {
        $this->seed([AdminSeeder::class, IkastetxeaSeeder::class]);
        $admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $student->update(['aktibo' => true]);
        $courses = Ikastaroa::orderBy('id_ikastaroa')->get();
        foreach (['aktibo', 'ez_aktibo'] as $index => $state) {
            Matrikula::create([
                'id_erabiltzailea' => $student->id_erabiltzailea,
                'id_ikastaroa' => $courses[$index]->id_ikastaroa,
                'matrikula_data' => '2026-09-30', 'egoera' => $state,
            ]);
        }
        $response = $this->actingAs($admin)->get('/administrazioa.php')->assertOk();
        $response->assertViewHas('stats', fn ($stats) => $stats === [
            'students' => 6, 'active_students' => 1, 'inactive_students' => 5,
            'enrollments' => 1, 'available' => 119, 'capacity' => 120,
        ]);
        $response->assertViewHas('courseStats', fn ($stats) => $stats->firstWhere('title', 'Web garapena')['percent'] === 3);
        $response->assertSee('Estatistikak')->assertSee('Ikastaroen okupazioa');
        $this->actingAs($student)->get('/administrazioa.php')->assertRedirect('/login.php');
    }

    public function test_empty_and_zero_capacity_statistics_render(): void
    {
        $this->seed(AdminSeeder::class);
        $admin = Erabiltzailea::firstOrFail();
        $this->actingAs($admin)->get('/administrazioa.php')->assertOk()
            ->assertViewHas('stats', fn ($stats) => $stats['capacity'] === 0 && $stats['students'] === 0);
        Ikastaroa::create([
            'izenburua' => 'Proba', 'edukiera' => 0,
            'hasiera_data' => '2026-10-01', 'amaiera_data' => '2026-12-01',
        ]);
        $this->get('/administrazioa.php')->assertOk()->assertSee('Edukierarik gabe');
    }

    public function test_student_pages_share_footer_and_ignore_unsafe_social_links(): void
    {
        config(['ikastetxea.socials' => ['Instagram' => 'https://example.com/instagram', 'Unsafe' => 'javascript:alert(1)']]);
        foreach (['/index.php', '/login.php', '/erregistratu.php'] as $url) {
            $this->get($url)->assertOk()->assertSee('Helbidea')->assertSee('Sare sozialak')
                ->assertSee('Eibar')->assertSee('uni@example.com')->assertSee('Eskubide guztiak erreserbatuta.')
                ->assertSee('https://example.com/instagram')->assertDontSee('javascript:alert(1)', false);
        }
    }
}
