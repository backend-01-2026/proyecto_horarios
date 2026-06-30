<?php

use App\Models\AvailableClass;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
);

beforeEach(function () {
    $this->subject = Subject::factory()->create();
    $this->teacher = Teacher::factory()->create();
    $this->classroom = Classroom::factory()->create();
    $this->timeSlot = TimeSlot::factory()->create();
    $this->semester = Semester::factory()->create();
    $this->group = Group::factory()->create();
});

it('creates an available class without conflicts', function () {
    $response = $this->post(route('available-classes.store'), [
        'subject_id' => $this->subject->id,
        'teacher_id' => $this->teacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('available-classes.index'));

    $this->assertDatabaseHas('available_classes', [
        'teacher_id' => $this->teacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);
});

it('detects teacher conflict', function () {
    AvailableClass::factory()->create([
        'teacher_id' => $this->teacher->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
    ]);

    $response = $this->post(route('available-classes.store'), [
        'subject_id' => $this->subject->id,
        'teacher_id' => $this->teacher->id,
        'classroom_id' => Classroom::factory()->create()->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => Group::factory()->create()->id,
    ]);

    $response->assertSessionHasErrors('teacher_id');
    $this->assertStringContainsString(
        'profesor ya tiene una clase',
        session('errors')->get('teacher_id')[0]
    );
});

it('detects classroom conflict', function () {
    AvailableClass::factory()->create([
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
    ]);

    $response = $this->post(route('available-classes.store'), [
        'subject_id' => $this->subject->id,
        'teacher_id' => Teacher::factory()->create()->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => Group::factory()->create()->id,
    ]);

    $response->assertSessionHasErrors('classroom_id');
    $this->assertStringContainsString(
        'aula ya está ocupada',
        session('errors')->get('classroom_id')[0]
    );
});

it('detects group conflict', function () {
    AvailableClass::factory()->create([
        'group_id' => $this->group->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
    ]);

    $response = $this->post(route('available-classes.store'), [
        'subject_id' => $this->subject->id,
        'teacher_id' => Teacher::factory()->create()->id,
        'classroom_id' => Classroom::factory()->create()->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response->assertSessionHasErrors('group_id');
    $this->assertStringContainsString(
        'grupo ya tiene una clase',
        session('errors')->get('group_id')[0]
    );
});

it('allows update without conflicts when data is unchanged', function () {
    $availableClass = AvailableClass::factory()->create([
        'teacher_id' => $this->teacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response = $this->put(route('available-classes.update', $availableClass), [
        'subject_id' => $this->subject->id,
        'teacher_id' => $this->teacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('available-classes.index'));
});

it('detects teacher conflict on update with different class', function () {
    $otherTeacher = Teacher::factory()->create();

    $availableClass = AvailableClass::factory()->create([
        'teacher_id' => $this->teacher->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
    ]);

    AvailableClass::factory()->create([
        'teacher_id' => $otherTeacher->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
    ]);

    $response = $this->put(route('available-classes.update', $availableClass), [
        'subject_id' => $this->subject->id,
        'teacher_id' => $otherTeacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response->assertSessionHasErrors('teacher_id');
});

it('does not detect conflict when updating the same record itself', function () {
    $availableClass = AvailableClass::factory()->create([
        'teacher_id' => $this->teacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response = $this->put(route('available-classes.update', $availableClass), [
        'subject_id' => $this->subject->id,
        'teacher_id' => $this->teacher->id,
        'classroom_id' => $this->classroom->id,
        'time_slot_id' => $this->timeSlot->id,
        'semester_id' => $this->semester->id,
        'group_id' => $this->group->id,
    ]);

    $response->assertSessionHasNoErrors();
});
