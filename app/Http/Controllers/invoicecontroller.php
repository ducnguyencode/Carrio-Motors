<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
{
    use LogsActivity;

    protected static $logAttributes = [
        'process_status',
        'discount_type',
        'discount_amount',
        'total_price'
    ];
}
    protected $fillable = [
        'process_status',
        'discount_type',
        'discount_amount',
        'total_price'
    ];

    protected $table = 'invoices';
