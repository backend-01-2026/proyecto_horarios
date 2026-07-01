<?php

namespace App\Http\Controllers;
use App\Models\Enrollment;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validación
    $request->validate([
        'student_id' => 'required',
        'group_id' => 'required',
        'semester_id' => 'required',
    ]);

    // 2. Evitar duplicados (EXPANDE LÓGICA)
    $exists = Enrollment::where('student_id', $request->student_id)
        ->where('group_id', $request->group_id)
        ->where('semester_id', $request->semester_id)
        ->exists();

    if ($exists) {
        return redirect()->back()
            ->with('error', 'Este estudiante ya está matriculado en este grupo y semestre');
    }

    // 3. Crear matrícula
    Enrollment::create($request->all());

    return redirect()->route('enrollments.index')
        ->with('success', 'Matrícula registrada correctamente');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function report()
{
    $enrollments = Enrollment::with(
        'student',
        'group',
        'semester'
    )->get();

    return view(
        'reports.enrollments',
        compact('enrollments')
    );
}
}
