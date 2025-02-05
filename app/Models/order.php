<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'transaction_id',
        'category_id',
        'date',
        'status'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

   public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
