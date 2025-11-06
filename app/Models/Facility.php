<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        "facility_name"
    ];

    public function rooms()   {
        return $this->belongsToMany(Room::class, 'facility_room');
    }
}
