<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'logo', 'isActive'];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    // Scope to get only active makes
    public function scopeActive($query)
    {
        return $query->where('isActive', true);
    }

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

    // Define accessor for logo URL
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return asset('images/no-image.png');
        }

        return asset('storage/' . $this->logo);
    }
}
