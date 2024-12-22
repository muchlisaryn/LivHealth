<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{
    protected $fillable = [
        'transaction_id',
        'courier_id',
        'status_delivery',
        'description',
        'attachments'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }
}
