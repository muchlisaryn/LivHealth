<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    //
    protected $fillable = [
        'finance_id',
        'type',
        'total',
        'description',
        'attachments'
    ];

    public function user_finance()
    {
        return $this->belongsToMany(UserFinance::class, 'finance_id');
    }
}
