<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = 
    [
    'description',
    'type',
    'payment_method',
    'date',
    'category',
    'amount',
    ];
}
