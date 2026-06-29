<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['sigla', 'nombre'];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }

    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }
}