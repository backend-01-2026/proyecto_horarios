<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }
}
