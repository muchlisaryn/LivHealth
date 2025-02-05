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
        'created_at'
    ];

    protected $casts = [
       'menu_id' => 'array',
    ];



    public function user_program()
    {
        return $this->belongsTo(ProgramPlans::class, 'user_program_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }

   
}
