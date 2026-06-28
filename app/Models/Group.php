<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function availableClasses()
    {
    return $this->hasMany(AvailableClass::class);
    }
}
