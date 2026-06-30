<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Classroom::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:255|unique:classrooms,codigo',
        ]);

        $classroom = Classroom::create($validated);

        return response()->json($classroom, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return response()->json($classroom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('classrooms')->ignore($classroom->id),
            ],
        ]);

        $classroom->update($validated);

        return response()->json($classroom);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return response()->json(null, 204);
    }
}
