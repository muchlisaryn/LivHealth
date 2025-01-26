<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Menus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
        'category_id' => 'array'
    ];


    public function category()
    {
        return $this->hasMany(Categories::class, 'category_id');
    }

    public function schedules()
    {
        return $this->hasMany(Menus::class, 'menu_id');
    }
}
