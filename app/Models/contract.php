<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    use HasFactory;

    protected $fillable = [
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

}
