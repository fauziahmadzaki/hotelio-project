<?php

namespace App\Models;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        "facility_name"
    ];

    public function rooms()   {
        return $this->belongsToMany(RoomType::class, 'facility_room');
    }
}
