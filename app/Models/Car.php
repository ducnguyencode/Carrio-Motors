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
        'brand',
        'model_id',
        'engine_id',
        'seats',
        'transmission',
        'description',
        'release_date',
        'status'
    ];

    public function model() {
        return $this->belongsTo(\App\Models\Model::class);
    }

    public function engine() {
        return $this->belongsTo(\App\Models\Engine::class);
    }
}
