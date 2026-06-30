<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedSchedule extends Model
{
    protected $fillable = ['user_id', 'nombre_horario', 'gestion'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availableClasses()
    {
        return $this->belongsToMany(AvailableClass::class, 'class_selections');
    }
}
