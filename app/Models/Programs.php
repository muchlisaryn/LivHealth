<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Programs extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'description',
        'price',
        'duration_days',
        'attachments'
    ];


    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

}