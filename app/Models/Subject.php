<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Profesores (many-to-many)
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }

    // Clases disponibles
    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }

    // 🔥 NUEVO: estudiantes (many-to-many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'subject_student');
    }
}