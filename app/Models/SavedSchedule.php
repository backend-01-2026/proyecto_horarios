<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedSchedule extends Model
{
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function availableClasses()
    {
    return $this->belongsToMany(AvailableClass::class, 'class_selections');
    }
}
