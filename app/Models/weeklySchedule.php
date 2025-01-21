<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklySchedule extends Model
{
    protected $fillable = [
        'id',
        'menu_id',
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'menu_id' => 'array'
    ];

    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }
}
