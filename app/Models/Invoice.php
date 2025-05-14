<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'total_price',
        'discount_amount',
        'final_price',
        'payment_method',
        'status',
        'notes'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function saler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'saler_id');
    }

    const STATUS_DEPOSIT = 'deposit';
    const STATUS_PAYMENT = 'payment';
    const STATUS_WAREHOUSE = 'warehouse';
    const STATUS_SUCCESS = 'success';
    const STATUS_CANCEL = 'cancel';
    const PAYMENT_CASH = 'cash';
    const PAYMENT_CREDIT = 'credit';
    const PAYMENT_INSTALLMENT = 'installment';

    public function calculateTotals()
    {
        $this->total_price = $this->details->sum('subtotal');
        $this->final_price = $this->total_price - $this->discount_amount;
        $this->save();
    }

    public function updateStatus(string $status)
    {
        if (in_array($status, [
            self::STATUS_DEPOSIT,
            self::STATUS_PAYMENT,
            self::STATUS_WAREHOUSE,
            self::STATUS_SUCCESS,
            self::STATUS_CANCEL
        ])) {
            $this->process_status = $status;
            $this->save();
            return true;
        }
        return false;
    }
}
