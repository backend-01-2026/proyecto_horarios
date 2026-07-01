<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentSubjectController extends Controller
{
    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('student_subjects.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'subject_id' => 'required',
        ]);

        $student = Student::find($request->student_id);

        // evitar duplicados
        if ($student->subjects()->where('subject_id', $request->subject_id)->exists()) {
            return back()->with('error', 'El estudiante ya tiene esta materia');
        }

        $student->subjects()->attach($request->subject_id);

        return back()->with('success', 'Materia asignada correctamente');
    }
}