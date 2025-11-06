<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $fillable = [
        'phone_number',
        'address',
        'user_id',
        'gender'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
