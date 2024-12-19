<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Programs extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'menu_id',
        'name',
        'description',
        'price',
        'duration_days'
    ];

    protected $casts = [
        'attachments' => 'array',
        'menu_id' => 'array'
    ];

    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }

}