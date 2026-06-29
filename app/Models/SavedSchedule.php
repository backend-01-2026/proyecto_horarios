<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedSchedule extends Model
{
    protected $fillable = ['user_id', 'nombre_horario', 'gestion'];

    protected $observables = [
        'pivotAttached',
        'pivotDetached',
        'pivotUpdated',
        'pivotAttaching',
        'pivotDetaching',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availableClasses()
    {
        return $this->belongsToMany(AvailableClass::class, 'class_selections');
        // Sin withTimestamps() porque class_selections no tiene created_at/updated_at
    }
}