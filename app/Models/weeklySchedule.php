<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class WeeklySchedule extends Model
{
    protected $fillable = [
        'id',
        'menu_id',
        'category_id', 
    ];

    protected $casts = [
        'menu_id' => 'array'
    ];

    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
