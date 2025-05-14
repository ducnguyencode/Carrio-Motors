<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'car_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detail) {
            $detail->subtotal = $detail->quantity * $detail->unit_price;
        });

        static::updating(function ($detail) {
            $detail->subtotal = $detail->quantity * $detail->unit_price;
        });

        static::saved(function ($detail) {
            $detail->invoice->calculateTotals();
        });
    }
}
