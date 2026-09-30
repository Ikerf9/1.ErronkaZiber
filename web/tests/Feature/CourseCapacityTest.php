<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use App\Models\Matrikula;
use App\Models\Rola;
use Database\Seeders\AdminSeeder;
use Database\Seeders\IkastetxeaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CourseCapacityTest extends TestCase
{
    use RefreshDatabase;

    public function test_thirtieth_enrollment_succeeds_but_thirty_first_and_reactivation_fail(): void
    {
        $this->seed([AdminSeeder::class, IkastetxeaSeeder::class]);
        $this->assertTrue(Ikastaroa::all()->every(fn ($course) => $course->edukiera === 30));
        $course = Ikastaroa::firstOrFail();
        $role = Rola::where('rola_izena', 'ikasleak')->firstOrFail();
        $students = collect();
        for ($i = 0; $i < 32; $i++) {
            $students->push(Erabiltzailea::create([
                'izena' => 'Student', 'abizenak' => (string) $i,
                'emaila' => "capacity{$i}@example.com", 'id_rola' => $role->id_rola,
                'aktibo' => true, 'pasahitza' => null,
            ]));
        }
        foreach ($students->take(29) as $student) {
            $course->matrikulak()->create([
                'id_erabiltzailea' => $student->id_erabiltzailea,
                'matrikula_data' => '2026-09-30', 'egoera' => 'aktibo',
            ]);
        }
        $this->actingAs($students[29])->post(route('enroll', $course))->assertSessionHasNoErrors();
        $this->assertSame(30, $course->matrikulak()->where('egoera', 'aktibo')->count());
        // Even an accidentally oversized stored capacity cannot bypass the limit.
        DB::table('ikastaroak')->where('id_ikastaroa', $course->id_ikastaroa)->update(['edukiera' => 99]);
        $this->actingAs($students[30])->post(route('enroll', $course))->assertSessionHasErrors('matrikula');
        $this->assertDatabaseMissing('matrikulak', ['id_erabiltzailea' => $students[30]->id_erabiltzailea]);
        $inactive = $course->matrikulak()->create([
            'id_erabiltzailea' => $students[31]->id_erabiltzailea,
            'matrikula_data' => '2026-09-30', 'egoera' => 'ez_aktibo',
        ]);
        $admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin)->patch(route('enrollments.update', $inactive), ['egoera' => 'aktibo'])
            ->assertSessionHasErrors('matrikula');
        $this->assertSame('ez_aktibo', $inactive->fresh()->egoera);
        $active = $course->matrikulak()->where('egoera', 'aktibo')->firstOrFail();
        $this->patch(route('enrollments.update', $active), ['egoera' => 'ez_aktibo'])->assertSessionHasNoErrors();
        $this->patch(route('enrollments.update', $inactive), ['egoera' => 'aktibo'])->assertSessionHasNoErrors();
        $this->assertSame(30, $course->matrikulak()->where('egoera', 'aktibo')->count());
    }

    public function test_new_courses_default_to_thirty_and_migration_updates_existing_courses(): void
    {
        $course = Ikastaroa::create([
            'izenburua' => 'Proba', 'hasiera_data' => '2026-10-01', 'amaiera_data' => '2026-12-01',
        ]);
        $this->assertSame(30, $course->fresh()->edukiera);
        $course->update(['edukiera' => 15]);
        $migration = require database_path('migrations/2026_09_30_000000_set_course_capacity_to_thirty.php');
        $migration->up();
        $this->assertSame(30, $course->fresh()->edukiera);
    }
}
