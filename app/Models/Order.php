<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const ORDER_NO_PREFIX = 'INV';
    const ORDER_NO_SEPARATOR = '-';

    protected $fillable = [
        'order_no',
        'customer_name',
        'order_date',
        'grand_total',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_no = self::getNextOrderNo();
        });
    }

    public static function getNextOrderNo()
    {
        return self::ORDER_NO_PREFIX .
         self::ORDER_NO_SEPARATOR . date('ymd') . 
         self::ORDER_NO_SEPARATOR . str_pad(self::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
