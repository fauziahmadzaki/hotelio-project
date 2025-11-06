<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;

class ReservationController extends Controller
{
    /**
     * Tampilkan daftar semua reservasi.
     */
    public function index()
    {
        $reservations =  Reservation::with(['room'])->latest()->get();
        return view('private.admin.reservations.index', compact('reservations'));
    }

    /**
     * Form tambah reservasi.
     */
    public function create(){
        $rooms = Room::where('room_status', 'available')->get();
        if($rooms->isEmpty()){
             return redirect()->route('admin.reservations.index')->with('error', 'Tidak ada kamar yang tersedia!');
        }
        return view('private.admin.reservations.create', compact('rooms'));
    }
    

    /**
     * Simpan reservasi baru.
     */
    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Ambil harga kamar
            $room = Room::findOrFail($validated['room_id']);
            $days = now()->parse($validated['check_in_date'])->diffInDays(now()->parse($validated['check_out_date']));
            $totalPrice = $days * $room->room_price;

            // Simpan reservasi
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
            return redirect()->route('admin.reservations.index')->with('success', 'Reservasi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat reservasi: '.$e->getMessage());
        }
    }

    /**
     * Tampilkan detail reservasi.
     */
    public function show(Reservation $reservation)
    {
         $rooms = Room::where('room_status', 'available')->get();
        return view('private.admin.reservations.edit', compact('reservation', 'rooms'));
    }

    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $reservation->update($validated);
            if($request->status == 'cancel' || $request->status == 'completed'){
            $room = Room::where('id', $reservation->room_id)->update([
                'room_status' => 'available'
            ]);
            $reservation->update($validated);
            DB::commit();
            return redirect()->route('admin.reservations.index')->with('success', 'Status reservasi diperbarui.');
        }//code...
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui reservasi: '.$th->getMessage());
        }
        return redirect()->back()->with('success', 'Status reservasi diperbarui.');
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
