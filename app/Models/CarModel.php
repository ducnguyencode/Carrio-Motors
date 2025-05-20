<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'models'; // Explicitly set the table name

    protected $fillable = ['name', 'year', 'make_id', 'description', 'isActive'];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    // Scope to get only active models
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

    // Relationship with Make
    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    // Relationship with Car
    public function cars()
    {
        return $this->hasMany(Car::class, 'model_id');
    }
}
