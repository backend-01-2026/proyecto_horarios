<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['codigo'];

    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }
}