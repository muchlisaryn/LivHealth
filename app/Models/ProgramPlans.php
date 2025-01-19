<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPlans extends Model
{
    protected $fillable = [
        "transaction_id",
        "status",
        'start_date',
        'end_date',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
