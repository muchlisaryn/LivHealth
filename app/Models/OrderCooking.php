<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCooking extends Model
{
    protected $fillable = [
        'transaction_id',
        'chef_id',
        'status',
    ];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function chef()
    {
        return $this->belongsTo(OrderCooking::class, 'chef_id');
    }
}
