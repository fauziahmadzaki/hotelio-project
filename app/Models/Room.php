<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'room_id',
        'room_name',
        'room_code',
        'room_description',
        'room_capacity',
        'room_price',
        'image',
        'room_status',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function facilities(){
        return $this->belongsToMany(Facility::class, 'facility_room');
    }
}
