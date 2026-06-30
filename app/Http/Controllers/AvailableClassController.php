<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvailableClassRequest;
use App\Http\Requests\UpdateAvailableClassRequest;
use App\Models\AvailableClass;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Specialty;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;

class AvailableClassController extends Controller
{
    public function index()
    {
        $availableClasses = AvailableClass::with(['subject', 'teacher', 'classroom', 'timeSlot', 'semester', 'group', 'specialty'])
            ->latest()
            ->paginate(15);

        return view('available_classes.index', compact('availableClasses'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $timeSlots = TimeSlot::all();
        $semesters = Semester::all();
        $groups = Group::all();
        $specialties = Specialty::all();

        return view('available_classes.create', compact('subjects', 'teachers', 'classrooms', 'timeSlots', 'semesters', 'groups', 'specialties'));
    }

    public function store(StoreAvailableClassRequest $request)
    {
        AvailableClass::create($request->validated());

        return redirect()->route('available-classes.index')
            ->with('success', 'Clase disponible registrada correctamente.');
    }

    public function show(AvailableClass $availableClass)
    {
        $availableClass->load(['subject', 'teacher', 'classroom', 'timeSlot', 'semester', 'group', 'specialty']);

        return view('available_classes.show', compact('availableClass'));
    }

    public function edit(AvailableClass $availableClass)
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $timeSlots = TimeSlot::all();
        $semesters = Semester::all();
        $groups = Group::all();
        $specialties = Specialty::all();

        return view('available_classes.edit', compact('availableClass', 'subjects', 'teachers', 'classrooms', 'timeSlots', 'semesters', 'groups', 'specialties'));
    }

    public function update(UpdateAvailableClassRequest $request, AvailableClass $availableClass)
    {
        $availableClass->update($request->validated());

        return redirect()->route('available-classes.index')
            ->with('success', 'Clase disponible actualizada correctamente.');
    }

    public function destroy(AvailableClass $availableClass)
    {
        $availableClass->delete();

        return redirect()->route('available-classes.index')
            ->with('success', 'Clase disponible eliminada correctamente.');
    }
}
