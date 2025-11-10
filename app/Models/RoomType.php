<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
protected $fillable = ['room_type_name'];

    public function facilities(){
        return $this->belongsToMany(Facility::class, 'facility_room');
}

    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
