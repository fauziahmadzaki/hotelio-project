<?php

namespace App\Models;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'room_type_id',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }


}
