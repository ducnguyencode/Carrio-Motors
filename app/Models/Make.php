<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'logo'];

    // Relationship with Model
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }

    // Relationship with Car
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
