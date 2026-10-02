<?php

namespace Tests\Feature;

use App\Models\Erabiltzailea;
use App\Models\Ikastaroa;
use Database\Seeders\AdminSeeder;
use Database\Seeders\IkastetxeaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    private Erabiltzailea $admin;
    private Erabiltzailea $student;
    private Ikastaroa $course;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([AdminSeeder::class, IkastetxeaSeeder::class]);
        $this->admin = Erabiltzailea::where('emaila', 'admin@example.com')->firstOrFail();
        $this->student = Erabiltzailea::where('emaila', 'ane@example.com')->firstOrFail();
        $this->course = Ikastaroa::firstOrFail();
    }

    private function data(): array
    {
        return [
            'izenburua' => 'Ikastaro berria', 'deskribapena' => 'Deskribapen berria',
            'edukiera' => 20, 'hasiera_data' => '2026-10-05', 'amaiera_data' => '2026-12-20',
        ];
    }

    public function test_admin_can_create_and_edit_courses_from_the_catalog(): void
    {
        $this->actingAs($this->admin)->get(route('home'))->assertOk()
            ->assertSee('admin-catalog')->assertSee(route('courses.create'))
            ->assertSee(route('courses.edit', $this->course))->assertSee(route('courses.destroy', $this->course));
        $this->get(route('administrazioa'))->assertOk()->assertSee($this->course->izenburua)
            ->assertDontSee(route('courses.create'))->assertDontSee(route('courses.edit', $this->course))
            ->assertDontSee(route('courses.destroy', $this->course));
        $this->get(route('courses.create'))->assertOk()->assertSee('Ikastaro berria sortu');
        $this->post(route('courses.store'), $this->data())->assertRedirect(route('home'))->assertSessionHasNoErrors();
        $created = Ikastaroa::where('izenburua', 'Ikastaro berria')->firstOrFail();
        $this->get(route('courses.edit', $created))->assertOk()->assertSee('Deskribapen berria');
        $this->patch(route('courses.update', $created), [...$this->data(), 'izenburua' => 'Eguneratuta'])
            ->assertRedirect(route('home'))->assertSessionHasNoErrors();
        $this->assertSame('Eguneratuta', $created->fresh()->izenburua);
        $this->assertSame(20, $created->fresh()->edukiera);
    }

    public function test_invalid_dates_and_capacity_are_rejected_and_input_is_preserved(): void
    {
        $count = Ikastaroa::count();
        $this->actingAs($this->admin)->from(route('courses.create'))->post(route('courses.store'), [
            ...$this->data(), 'amaiera_data' => '2026-10-01', 'edukiera' => 31,
        ])->assertRedirect(route('courses.create'))->assertSessionHasErrors(['amaiera_data', 'edukiera'])
            ->assertSessionHasInput('izenburua', 'Ikastaro berria');
        $this->assertDatabaseCount('ikastaroak', $count);
        $this->patch(route('courses.update', $this->course), [...$this->data(), 'izenburua' => '', 'edukiera' => 0])
            ->assertSessionHasErrors(['izenburua', 'edukiera']);
        $this->assertNotSame('Ikastaro berria', $this->course->fresh()->izenburua);
    }

    public function test_capacity_cannot_be_reduced_below_active_enrollments(): void
    {
        $this->course->matrikulak()->create([
            'id_erabiltzailea' => $this->student->id_erabiltzailea,
            'matrikula_data' => '2026-10-02', 'egoera' => 'aktibo',
        ]);
        $second = Erabiltzailea::where('emaila', '!=', $this->student->emaila)
            ->whereHas('rola', fn ($query) => $query->where('rola_izena', 'ikasleak'))->firstOrFail();
        $enrollment = $this->course->matrikulak()->create([
            'id_erabiltzailea' => $second->id_erabiltzailea,
            'matrikula_data' => '2026-10-02', 'egoera' => 'aktibo',
        ]);
        $this->actingAs($this->admin)->patch(route('courses.update', $this->course), [...$this->data(), 'edukiera' => 1])
            ->assertSessionHasErrors('edukiera');
        $this->assertSame(30, $this->course->fresh()->edukiera);
        $enrollment->update(['egoera' => 'ez_aktibo']);
        $this->patch(route('courses.update', $this->course), [...$this->data(), 'edukiera' => 1])
            ->assertSessionHasNoErrors();
        $this->assertSame(1, $this->course->fresh()->edukiera);
    }

    public function test_deletion_removes_only_the_course_and_its_enrollments(): void
    {
        $other = Ikastaroa::whereKeyNot($this->course->getKey())->firstOrFail();
        foreach ([$this->course, $other] as $course) {
            $course->matrikulak()->create([
                'id_erabiltzailea' => $this->student->id_erabiltzailea,
                'matrikula_data' => '2026-10-02', 'egoera' => 'aktibo',
            ]);
        }
        $this->actingAs($this->admin)->delete(route('courses.destroy', $this->course))->assertRedirect(route('home'));
        $this->assertDatabaseMissing('ikastaroak', ['id_ikastaroa' => $this->course->getKey()]);
        $this->assertDatabaseMissing('matrikulak', ['id_ikastaroa' => $this->course->getKey()]);
        $this->assertDatabaseHas('matrikulak', ['id_ikastaroa' => $other->getKey()]);
        $this->assertDatabaseHas('erabiltzaileak', ['id_erabiltzailea' => $this->student->getKey()]);
    }

    public function test_guests_and_students_cannot_manage_courses(): void
    {
        $count = Ikastaroa::count();
        foreach ([null, $this->student] as $user) {
            foreach (['create', 'edit', 'store', 'update', 'destroy'] as $action) {
                if ($user) {
                    $this->actingAs($user);
                }
                $response = match ($action) {
                    'create' => $this->get(route('courses.create')),
                    'edit' => $this->get(route('courses.edit', $this->course)),
                    'store' => $this->post(route('courses.store'), $this->data()),
                    'update' => $this->patch(route('courses.update', $this->course), $this->data()),
                    'destroy' => $this->delete(route('courses.destroy', $this->course)),
                };
                $response->assertRedirect(route('login'));
            }
        }
        $this->assertDatabaseCount('ikastaroak', $count);
        $this->assertNotSame('Ikastaro berria', $this->course->fresh()->izenburua);
        $this->actingAs($this->student)->get(route('home'))->assertOk()
            ->assertDontSee('admin-catalog')->assertDontSee(route('courses.create'));
    }
}
