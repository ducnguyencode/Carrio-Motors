<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarColor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hex_code', 'is_active'];

    public function carDetails()
    {
        return $this->hasMany(CarDetail::class, 'color_id');
    }
}
