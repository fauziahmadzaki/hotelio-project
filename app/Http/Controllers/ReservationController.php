<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    
    public function index()
    {
        $reservations =  Reservation::with(['room'])->latest()->get();
        return view('private.admin.reservations.index', compact('reservations'));
    }

    public function create(){
        $rooms = Room::where('room_status', 'available')->get();
        if($rooms->isEmpty()){
             if(Auth::user()->role == 'receptionist'){
                return redirect()->route('receptionist.reservations.index')->with('error', 'Tidak ada kamar yang tersedia');
             }else{
                return redirect()->route('admin.reservations.index')->with('error', 'Tidak ada kamar yang tersedia');
             }
        }
        
        if(Auth::user()->role == 'receptionist'){
            return view('private.receptionist.reservation.create', compact('rooms'));
        }else{
            return view('private.admin.reservations.create', compact('rooms'));
        }
    }
    

    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $room = Room::findOrFail($validated['room_id']);
            $days = now()->parse($validated['check_in_date'])->diffInDays(now()->parse($validated['check_out_date']));
            $totalPrice = $days * $room->room_price;

            Reservation::create([
                'user_id' => Auth::user()->id,
                'room_id' => $validated['room_id'],
                'person_name' => $validated['person_name'],
                'person_phone_number' => $validated['person_phone_number'],
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'total_guests' => $validated['total_guests'],
                'total_price' => $totalPrice,
                'status' => $validated['status'],
            ]);
            
            $room = Room::where('id', $validated['room_id'])->update([
                'room_status' => 'booked'
            ]);
            DB::commit();
            if(Auth::user()->role == 'receptionist'){
                return redirect()->route('receptionist.reservations.index')->with('success', 'Reservasi berhasil dibuat.');
            }else{
                return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil dibuat.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat reservasi: '.$e->getMessage());
        }
    }


    public function show(Reservation $reservation)
    {
         $rooms = Room::where('room_status', 'available')->get();
        return view('private.admin.reservations.edit', compact('reservation', 'rooms'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
    $validated = $request->validated();
    DB::beginTransaction();

    try {
        $reservation->update($validated);

        if (in_array($validated['status'], ['cancel', 'completed'])) {
            Room::where('id', $reservation->room_id)->update([
                'room_status' => 'available'
            ]);
        }

        DB::commit();
        
        if(Auth::user()->role == 'receptionist'){
            return redirect()->route('receptionist.reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
        }else{
            return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
        }
    } catch (\Throwable $th) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui reservasi: '.$th->getMessage());
    }
    }

    /**
     * Hapus reservasi.
     */
    public function destroy(Reservation $reservation)
    {
        $room = Room::where('id', $reservation->room_id)->update([
            'room_status' => 'available'
        ]);
        $reservation->delete();
        return redirect()->back()->with('success', 'Reservasi berhasil dihapus.');
    }
}
