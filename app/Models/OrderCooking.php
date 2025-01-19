<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCooking extends Model
{
    protected $fillable = [
        'user_program_id',
        'menu_id',
        'chef_id',
        'status',
    ];


    public function user_program()
    {
        return $this->belongsTo(ProgramPlans::class, 'user_program_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }

    public function chef()
    {
        return $this->belongsTo(OrderCooking::class, 'chef_id');
    }
}
