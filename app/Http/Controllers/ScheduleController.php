<?php

namespace App\Http\Controllers;

use App\Models\AvailableClass;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Specialty;
use App\Models\Teacher;
use Illuminate\Http\Request;

// Esto muestra tdas las clases que ya están programadas de forma de
// tabla tipo calendario (días en columnas, horas en filas)
// es para ver y filtrar.


class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = AvailableClass::with(['subject', 'teacher', 'classroom', 'timeSlot', 'group', 'semester', 'specialty']);

        $this->applyFilters($query, $request);

        $availableClasses = $query->get();

        $grid = $this->buildGrid($availableClasses);

      // Esto es para llenar los <select> de los filtros.
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


    // Si en la URL viene algún filtro (especialidad, semestre, profesor, grupo),
    // lo aplica. Si no viene nada, muestra todo sin filtrar.
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
