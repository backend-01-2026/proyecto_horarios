<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AvailableClass extends Model
{
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'classroom_id',
        'time_slot_id',
        'semester_id',
        'group_id',
        'specialty_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function savedSchedules()
    {
        return $this->belongsToMany(SavedSchedule::class, 'class_selections');
    }
}