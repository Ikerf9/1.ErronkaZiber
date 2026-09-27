<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use App\Models\Matrikula;
use Database\Seeders\AdminSeeder;
use Database\Seeders\IkastetxeaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatrikulaTest extends TestCase
{
    use RefreshDatabase;

    private Erabiltzailea $admin;
    private Erabiltzailea $student;
    private Ikastaroa $course;
    private Matrikula $enrollment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([AdminSeeder::class, IkastetxeaSeeder::class]);
        $this->admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $this->student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $this->student->update(['aktibo' => true]);
        $this->course = Ikastaroa::firstOrFail();
        $this->enrollment = Matrikula::create([
            'id_erabiltzailea' => $this->student->id_erabiltzailea,
            'id_ikastaroa' => $this->course->id_ikastaroa,
            'matrikula_data' => '2026-09-27', 'egoera' => 'aktibo',
        ]);
    }

    public function test_admin_sees_course_rosters_and_empty_courses(): void
    {
        $this->actingAs($this->admin)->get('/administrazioa.php')->assertOk()
            ->assertSee('Ikastaroak eta ikasleak')->assertSee('Desaktibatu')
            ->assertSee('Oraindik ez dago ikaslerik matrikulatuta.');
        $this->get('/index.php')->assertOk()->assertSee('Ikastaroko ikasleak')
            ->assertSee($this->student->emaila)->assertSee('Desaktibatu');
        $courses = Ikastaroa::with('matrikulak.erabiltzailea')->get();
        $this->assertCount(1, $courses->firstWhere('id_ikastaroa', $this->course->id_ikastaroa)->matrikulak);
        $this->assertCount(0, $courses->first(fn ($course) => $course->id_ikastaroa !== $this->course->id_ikastaroa)->matrikulak);
    }

    public function test_deactivation_preserves_account_other_courses_and_enrollment_date(): void
    {
        $other = Matrikula::create([
            'id_erabiltzailea' => $this->student->id_erabiltzailea,
            'id_ikastaroa' => Ikastaroa::where('id_ikastaroa', '!=', $this->course->id_ikastaroa)->firstOrFail()->id_ikastaroa,
            'matrikula_data' => '2026-09-27', 'egoera' => 'aktibo',
        ]);
        $this->actingAs($this->admin)->from('/administrazioa.php')
            ->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'ez_aktibo'])
            ->assertRedirect('/administrazioa.php')->assertSessionHasNoErrors();
        $this->assertSame('ez_aktibo', $this->enrollment->fresh()->egoera);
        $this->assertTrue((bool) $this->student->fresh()->aktibo);
        $this->assertSame('aktibo', $other->fresh()->egoera);
        $this->assertSame('2026-09-27', $this->enrollment->fresh()->matrikula_data);
        $this->assertSame(0, $this->course->matrikulak()->where('egoera', 'aktibo')->count());
        $this->get('/administrazioa.php')->assertSee('Aktibatu');
        $this->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'aktibo'])
            ->assertSessionHasNoErrors();
        $this->assertSame('aktibo', $this->enrollment->fresh()->egoera);
        $this->assertDatabaseCount('matrikulak', 2);
    }

    public function test_students_see_their_inactive_status_and_cannot_reactivate_themselves(): void
    {
        $this->enrollment->update(['egoera' => 'ez_aktibo']);
        $this->actingAs($this->student)->get('/index.php')->assertOk()
            ->assertSee('Matrikula ez dago aktibo')->assertDontSee('Ikastaroko ikasleak');
        $this->post(route('enroll', $this->course))->assertSessionHasErrors('matrikula');
        $this->assertSame('ez_aktibo', $this->enrollment->fresh()->egoera);
        $this->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'aktibo'])
            ->assertRedirect('/login.php');
        $this->assertSame('ez_aktibo', $this->enrollment->fresh()->egoera);
        $this->assertDatabaseCount('matrikulak', 1);
    }

    public function test_guests_cannot_see_rosters_or_change_enrollment_status(): void
    {
        $this->get('/index.php')->assertOk()->assertDontSee($this->student->emaila)->assertDontSee('Ikastaroko ikasleak');
        $this->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'ez_aktibo'])
            ->assertRedirect('/login.php');
        $this->assertSame('aktibo', $this->enrollment->fresh()->egoera);
    }

    public function test_reactivation_respects_capacity_and_inactive_accounts(): void
    {
        $this->enrollment->update(['egoera' => 'ez_aktibo']);
        $this->course->update(['edukiera' => 1]);
        $otherStudent = Erabiltzailea::where('emaila', 'mikel@example.com')->firstOrFail();
        $other = Matrikula::create([
            'id_erabiltzailea' => $otherStudent->id_erabiltzailea,
            'id_ikastaroa' => $this->course->id_ikastaroa,
            'matrikula_data' => '2026-09-27', 'egoera' => 'aktibo',
        ]);
        $this->actingAs($this->admin)->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'aktibo'])
            ->assertSessionHasErrors('matrikula');
        $this->assertSame('ez_aktibo', $this->enrollment->fresh()->egoera);
        $other->update(['egoera' => 'ez_aktibo']);
        $this->student->update(['aktibo' => false]);
        $this->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'aktibo'])
            ->assertSessionHasErrors('matrikula');
        $this->assertSame('ez_aktibo', $this->enrollment->fresh()->egoera);
    }

    public function test_invalid_status_is_rejected_and_repeated_activation_is_idempotent(): void
    {
        $this->course->update(['edukiera' => 1]);
        $this->actingAs($this->admin)->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'invalid'])
            ->assertSessionHasErrors('egoera');
        $this->assertSame('aktibo', $this->enrollment->fresh()->egoera);
        $this->patch(route('enrollments.update', $this->enrollment), ['egoera' => 'aktibo']);
        $this->assertSame('aktibo', $this->enrollment->fresh()->egoera);
        $this->assertDatabaseCount('matrikulak', 1);
        $this->patch('/matrikulak/999999', ['egoera' => 'aktibo'])->assertNotFound();
    }
}
