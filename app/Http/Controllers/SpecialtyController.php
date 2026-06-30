<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::latest()->paginate(15);

        return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }

    public function store(StoreSpecialtyRequest $request)
    {
        Specialty::create($request->validated());

        return redirect()->route('specialties.index')
            ->with('success', 'Especialidad registrada correctamente.');
    }

    public function show(Specialty $specialty)
    {
        return view('specialties.show', compact('specialty'));
    }

    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(UpdateSpecialtyRequest $request, Specialty $specialty)
    {
        $specialty->update($request->validated());

        return redirect()->route('specialties.index')
            ->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Specialty $specialty)
    {
        $specialty->delete();

        return redirect()->route('specialties.index')
            ->with('success', 'Especialidad eliminada correctamente.');
    }
}
