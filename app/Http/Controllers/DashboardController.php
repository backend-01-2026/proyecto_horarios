<?php

namespace App\Http\Controllers;

use App\Models\AvailableClass;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Specialty;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;

class DashboardController extends Controller
{
    public function index()
    {
        $counters = [
            'specialties' => Specialty::count(),
            'semesters' => Semester::count(),
            'teachers' => Teacher::count(),
            'subjects' => Subject::count(),
            'classrooms' => Classroom::count(),
            'time_slots' => TimeSlot::count(),
            'groups' => Group::count(),
            'available_classes' => AvailableClass::count(),
        ];

        $classroomsTotal = Classroom::count();
        $classroomsConClases = AvailableClass::distinct('classroom_id')->count('classroom_id');
        $classroomsLibres = max($classroomsTotal - $classroomsConClases, 0);

        $teachersTotal = Teacher::count();
        $teachersConClases = AvailableClass::distinct('teacher_id')->count('teacher_id');
        $teachersSinClases = max($teachersTotal - $teachersConClases, 0);

        return view('dashboard.index', compact('counters', 'classroomsTotal', 'classroomsConClases', 'classroomsLibres', 'teachersTotal', 'teachersConClases', 'teachersSinClases'));
    }
}
