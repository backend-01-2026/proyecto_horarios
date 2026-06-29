<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = ['dia_semana', 'hora_inicio', 'hora_fin'];

    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }
}