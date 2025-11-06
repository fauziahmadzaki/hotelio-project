<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService{

    public function getLatestUserReservation(){
        $user = Auth::user();

        return $user->reservations()
                ->with('room.facilities')
                ->latest()
                ->first();
    }

    public function getReservationCount($user = null){
        $query = Reservation::query();
        if($user){
            $query->where('user_id', $user->id);
        }

        return [
            'pending' => $query->where('status', 'pending')->count(),
            'confirmed' => $query->where('status', 'confirmed')->count(),
            'cancelled' => $query->where('status', 'cancelled')->count(),
        ];
    }



    public function calculate($reservation){
        $room = $reservation->room;
        $checkIn = Carbon::parse($reservation->check_in_date);
        $checkOut = Carbon::parse($reservation->check_out_date);
        $days = max(1, $checkOut->diffInDays($checkIn));
        $subtotal = $room->room_price * $days;
        $tax = $subtotal * 0.1;
        $grandTotal = $subtotal + $tax;

        return compact( 'checkIn', 'checkOut', 'days', 'subtotal', 'tax', 'grandTotal');
    }

    public function getColorStatus($status){
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
            'confirmed' => 'bg-green-100 text-green-700 border-green-300',
            'cancelled' => 'bg-red-100 text-red-700 border-red-300',
        ];
        return $colors[$status] ?? $colors['pending'];
    }

  
}

