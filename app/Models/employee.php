<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
   protected $fillable = [
       'name',
       'age',
       'marital_status',
       'address',
       'data_of_birth',
       'phone',
       'email',
       'document',


   ];

    protected $casts = [
        'address' => 'array',
    ];
}
