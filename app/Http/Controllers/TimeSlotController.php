<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeSlotRequest;
use App\Http\Requests\UpdateTimeSlotRequest;
use App\Models\TimeSlot;

class TimeSlotController extends Controller
{
    public function index()
    {
        $timeSlots = TimeSlot::latest()->paginate(15);

        return view('time-slots.index', compact('timeSlots'));
    }

    public function create()
    {
        return view('time-slots.create');
    }

    public function store(StoreTimeSlotRequest $request)
    {
        TimeSlot::create($request->validated());

        return redirect()->route('time-slots.index')
            ->with('success', 'Bloque horario registrada correctamente.');
    }

    public function show(TimeSlot $time_slot)
    {
        return view('time-slots.show', compact('time_slot'));
    }

    public function edit(TimeSlot $time_slot)
    {
        return view('time-slots.edit', compact('time_slot'));
    }

    public function update(UpdateTimeSlotRequest $request, TimeSlot $time_slot)
    {
        $time_slot->update($request->validated());

        return redirect()->route('time-slots.index')
            ->with('success', 'Bloque horario actualizada correctamente.');
    }

    public function destroy(TimeSlot $time_slot)
    {
        $time_slot->delete();

        return redirect()->route('time-slots.index')
            ->with('success', 'Bloque horario eliminada correctamente.');
    }
}
