<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;

    protected $table = 'salary';

    protected $fillable = [
        'value',
        'day',
        'discount',
        'total',
    ];
}
