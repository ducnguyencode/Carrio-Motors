<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Random\Engine;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'brand',
        'model_id',
        'engine_id',
        'seat_number',
        'transmission',
        'description',
        'release_date',
        'isActive'
    ];

    public function model() {
        return $this->belongsTo(Model::class);
    }
    public function engine(){
        return $this->belongsTo(Engine::class);
    }
}
