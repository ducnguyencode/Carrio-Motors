<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'purchase_date',
        'total_price',
        'payment_method',
        'status',
        'saler_id'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'total_price' => 'decimal:2',
        'deleted_at' => 'datetime'
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_RECHECK = 'recheck';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCEL = 'cancel';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($invoice) {
            // Ensure status is always lowercase and valid
            if ($invoice->status) {
                $invoice->status = strtolower($invoice->status);

                // Check if status is valid
                $validStatuses = [
                    self::STATUS_PENDING,
                    self::STATUS_RECHECK,
                    self::STATUS_DONE,
                    self::STATUS_CANCEL
                ];

                if (!in_array($invoice->status, $validStatuses)) {
                    throw new \InvalidArgumentException('Invalid status value: ' . $invoice->status);
                }
            } else {
                // If no status is set, default to pending
                $invoice->status = self::STATUS_PENDING;
            }
        });
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    /**
     * Get the user that owns the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saler()
    {
        return $this->belongsTo(User::class, 'saler_id');
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_RECHECK => 'Recheck',
            self::STATUS_DONE => 'Done',
            self::STATUS_CANCEL => 'Cancel',
        ];
    }

    public function scopeFilterByStatus($query, $status = null)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSearch($query, $searchTerm)
    {
        if (!$searchTerm) {
            return $query;
        }

        $searchTerm = trim($searchTerm);
        $searchTermLower = mb_strtolower($searchTerm, 'UTF-8');
        $searchTermNoAccents = $this->convertToNonAccented($searchTerm);
        $searchTermLowerNoAccents = mb_strtolower($searchTermNoAccents, 'UTF-8');

        return $query->where(function($q) use ($searchTerm, $searchTermLower, $searchTermNoAccents, $searchTermLowerNoAccents) {
            $q->where('customer_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('customer_email', 'LIKE', "%{$searchTerm}%")
              ->orWhere('customer_phone', 'LIKE', "%{$searchTerm}%")
              ->orWhere('customer_address', 'LIKE', "%{$searchTerm}%")
              ->orWhere(DB::raw('LOWER(customer_name)'), 'LIKE', "%{$searchTermLower}%")
              ->orWhere(DB::raw('LOWER(customer_email)'), 'LIKE', "%{$searchTermLower}%")
              ->orWhere(DB::raw('LOWER(customer_address)'), 'LIKE', "%{$searchTermLower}%");
        });
    }

    private function convertToNonAccented($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }

    private function containsVietnamese($str)
    {
        $pattern = '/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|ì|í|ị|ỉ|ĩ|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|ỳ|ý|ỵ|ỷ|ỹ|đ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|Ì|Í|Ị|Ỉ|Ĩ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|Ỳ|Ý|Ỵ|Ỷ|Ỹ|Đ)/u';
        return preg_match($pattern, $str);
    }
}
