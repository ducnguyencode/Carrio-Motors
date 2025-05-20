<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'model_id',
        'engine_id',
        'seat_number',
        'transmission',
        'description',
        'date_manufactured',
        'isActive',
        'main_image',
        'additional_images',
        'is_featured'
    ];

    protected $casts = [
        'additional_images' => 'array',
        'isActive' => 'boolean',
        'is_featured' => 'boolean'
    ];

    /**
     * Get the model that the car belongs to.
     */
    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    /**
     * Get the make/brand of the car through the model relationship.
     */
    public function make()
    {
        return $this->hasOneThrough(
            Make::class,
            CarModel::class,
            'id',
            'id',
            'model_id',
            'make_id'
        );
    }

    public function engine() {
        return $this->belongsTo(\App\Models\Engine::class);
    }

    public function carDetails() {
        return $this->hasMany(\App\Models\CarDetail::class);
    }

    public function invoices() {
        return $this->hasManyThrough(
            \App\Models\Invoice::class,
            \App\Models\CarDetail::class
        );
    }
}
