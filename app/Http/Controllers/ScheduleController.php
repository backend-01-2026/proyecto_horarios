<?php

namespace App\Http\Controllers;

use App\Models\AvailableClass;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Specialty;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = AvailableClass::with(['subject', 'teacher', 'classroom', 'timeSlot', 'group', 'semester', 'specialty']);

        $this->applyFilters($query, $request);

        $availableClasses = $query->get();

        $grid = $this->buildGrid($availableClasses);

        $specialties = Specialty::all();
        $semesters = Semester::all();
        $teachers = Teacher::all();
        $groups = Group::all();

        return view('schedule.grid', compact('grid', 'specialties', 'semesters', 'teachers', 'groups'));
    }

    public function print(Request $request)
    {
        $query = AvailableClass::with(['subject', 'teacher', 'classroom', 'timeSlot', 'group', 'semester', 'specialty']);

        $this->applyFilters($query, $request);

        $availableClasses = $query->get();

        $grid = $this->buildGrid($availableClasses);

        return view('schedule.print', compact('grid'));
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('specialty_id')) {
            $query->where('specialty_id', $request->input('specialty_id'));
        }

        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->input('semester_id'));
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }

        if ($request->filled('group_id')) {
            $query->where('group_id', $request->input('group_id'));
        }
    }

    /**
     * Arma una matriz [dia_semana][hora_inicio] = coleccion de clases, para pintar la grilla semanal.
     */
    protected function buildGrid($availableClasses): array
    {
        $grid = [];

        foreach ($availableClasses as $class) {
            $dia = $class->timeSlot->dia_semana;
            $hora = $class->timeSlot->hora_inicio;
            $grid[$dia][$hora][] = $class;
        }

        return $grid;
    }
}
