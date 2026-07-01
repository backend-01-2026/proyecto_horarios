<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relación con matrículas
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relación many-to-many con materias
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_student');
    }
}