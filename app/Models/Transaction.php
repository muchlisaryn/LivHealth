<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'programs_id',
        'user_id',
        'order_price',
        'shipping_price',
        'sub_total',
        'canceled_reason',
        'status',
    ];

    protected static function booted()
    {
        static::saving(function ($order) {
            $order->sub_total = $order->order_price + $order->shipping_price;
        });
    }

    public function programs()
    {
        return $this->belongsTo(Programs::class, 'programs_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(TransactionPayment::class, 'transaction_id');
    }

    public function delivery()
    {
        return $this->hasOne(OrderDelivery::class, 'transaction_id');
    }

    public function cooking()
    {
        return $this->hasOne(OrderCooking::class, 'transaction_id');
    }
}
