<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'programs_id',
        'user_id',
        'total_price',
        'status',
    ];

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
        return $this->hasOne(DeliveryStatus::class, 'transaction_id');
    }

    public function cooking()
    {
        return $this->hasOne(OrderCooking::class, 'transaction_id');
    }
}
