<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'person_name',
        'person_phone_number',
        'notes',
        'check_in_date',
        'check_out_date',
        'total_guests',
        'total_price',
        'payment_method',
        'status',
        'number_of_nights',
        'confirmation_date',
        'cancellation_date',
    ];
    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
    ];


    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
