<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'horsepower', 'level', 'max_speed', 'drive_type', 'engine_type', 'isActive'];

    // Relationship with Car
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
