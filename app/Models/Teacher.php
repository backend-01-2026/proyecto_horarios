<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['prefijo_academico', 'nombre_completo'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher');
    }

    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }
}
