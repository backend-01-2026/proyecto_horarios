<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['nombre'];

    public function availableClasses()
    {
        return $this->hasMany(AvailableClass::class);
    }
}