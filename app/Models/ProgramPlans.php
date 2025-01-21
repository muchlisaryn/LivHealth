<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPlans extends Model
{
    protected $fillable = [
        "transaction_id",
        "status",
        'start_date',
        'remaining_duration',
        'end_date',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if($model->transaction) {
                $program = $model->transaction->programs;
                if($program) {
                    $model->remaining_duration = $program->duration_days;
                }
            }
        });
    }
}
