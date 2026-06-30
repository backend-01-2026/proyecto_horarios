<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;

// ajustes de semestres/gestiones (ej: "2026-I").
// Igual que especialidades: se usa como filtro y para etiquetar los horarios guardados.


class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::latest()->paginate(15);

        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('semesters.create');
    }

    public function store(StoreSemesterRequest $request)
    {
        Semester::create($request->validated());

        return redirect()->route('semesters.index')
            ->with('success', 'Semestre registrada correctamente.');
    }

    public function show(Semester $semester)
    {
        return view('semesters.show', compact('semester'));
    }

    public function edit(Semester $semester)
    {
        return view('semesters.edit', compact('semester'));
    }

    public function update(UpdateSemesterRequest $request, Semester $semester)
    {
        $semester->update($request->validated());

        return redirect()->route('semesters.index')
            ->with('success', 'Semestre actualizada correctamente.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()->route('semesters.index')
            ->with('success', 'Semestre eliminada correctamente.');
    }
}
