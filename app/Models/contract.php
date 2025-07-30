<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contract extends Model
{

    protected $fillable = [
        'employee_id',
        'date_admission',
        'date_termination',
        'benefits',
        'position',
        'value_salary',
        'day_payment',
        'discount_salary',
        'total_salary',
];

    protected $casts = [
        'benefits' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(employee::class);
    }

}
