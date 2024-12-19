<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFinance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'bank_name_id',
        'bank_account',
        'bank_account_name',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');  
    }

    public function bank_name()
    {
        return $this->belongsTo(BankName::class, 'bank_name_id');
    }
}
