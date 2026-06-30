<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSavedScheduleRequest;
use App\Models\AvailableClass;
use App\Models\SavedSchedule;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SavedScheduleController extends Controller
{
    /**
     * Devuelve el id del usuario autenticado. Si el modulo de login aun no esta
     * activo en este punto del proyecto, usa el primer usuario registrado como
     * modo demo, sin que esto afecte el trabajo de auth de los demas companeros.
     */
    protected function currentUserId(): ?int
    {
        return Auth::id() ?? User::query()->value('id');
    }

    public function index()
    {
        $savedSchedules = SavedSchedule::where('user_id', $this->currentUserId())
            ->latest()
            ->get();

        return view('saved_schedules.index', compact('savedSchedules'));
    }

    public function create()
    {
        $semesters = Semester::all();
        $availableClasses = AvailableClass::with(['subject', 'teacher', 'classroom', 'timeSlot', 'group'])
            ->orderBy('time_slot_id')
            ->get();

        return view('saved_schedules.create', compact('semesters', 'availableClasses'));
    }

    public function store(StoreSavedScheduleRequest $request)
    {
        $savedSchedule = SavedSchedule::create([
            'user_id' => $this->currentUserId(),
            'nombre_horario' => $request->validated('nombre_horario'),
            'gestion' => $request->validated('gestion'),
        ]);

        $savedSchedule->availableClasses()->sync($request->validated('available_class_ids'));

        return redirect()->route('saved-schedules.show', $savedSchedule)
            ->with('success', 'Horario guardado correctamente.');
    }

    public function show(SavedSchedule $savedSchedule)
    {
        $savedSchedule->load(['availableClasses.subject', 'availableClasses.teacher', 'availableClasses.classroom', 'availableClasses.timeSlot']);

        $grid = $this->buildGrid($savedSchedule->availableClasses);

        return view('saved_schedules.show', compact('savedSchedule', 'grid'));
    }

    public function print(SavedSchedule $savedSchedule)
    {
        $savedSchedule->load(['availableClasses.subject', 'availableClasses.teacher', 'availableClasses.classroom', 'availableClasses.timeSlot']);

        $grid = $this->buildGrid($savedSchedule->availableClasses);

        return view('saved_schedules.print', compact('savedSchedule', 'grid'));
    }

    public function destroy(SavedSchedule $savedSchedule)
    {
        $savedSchedule->delete();

        return redirect()->route('saved-schedules.index')
            ->with('success', 'Horario eliminado correctamente.');
    }

 // guarda una sola clase (no un arreglo), porque es el horario
    // personal de un usuario y no debería tener choques.
    
    protected function buildGrid($availableClasses): array
    {
        $grid = [];

        foreach ($availableClasses as $class) {
            $dia = $class->timeSlot->dia_semana;
            $hora = $class->timeSlot->hora_inicio;
            $grid[$dia][$hora] = $class;
        }

        return $grid;
    }
}
