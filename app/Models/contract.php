<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_admission',
        'data_termination',
        'benefits',
        'position',
        'salary_id',
];

    protected $casts = [
        'benefits' => 'array',
    ];

    public function salary()
    {
        return $this->belongsTo(salary::class);
    }
}
