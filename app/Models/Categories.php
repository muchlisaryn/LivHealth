<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description',
        'attachments',
    ];


    public function menu() : HasMany
    {
        return $this->hasMany(Menus::class, 'category_id');
    }

    public function schedule()
    {
        return $this->hasOne(WeeklySchedule::class, 'category_id');
    }

    
}
