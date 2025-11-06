<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;

class ReceptionistController extends Controller
{
    /**
     * Dashboard utama resepsionis.
     */
    public function index()
    {
        // Ambil data statistik cepat
        $totalGuests = User::where('role', 'guest')->count();
        $totalRooms = Room::count();

        $todayCheckIns = Reservation::whereDate('check_in_date', today())
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();

        $todayCheckOuts = Reservation::whereDate('check_out_date', today())
            ->where('status', 'checked_in')
            ->count();

        $activeReservations = Reservation::whereIn('status', ['confirmed', 'checked_in'])->count();

        // Total pendapatan (dari status confirmed, checkin, completed)
        $totalRevenue = Reservation::whereIn('status', ['confirmed', 'checked_in', 'completed'])
            ->sum('total_price');

        return view('private.receptionist.index', compact(
            'totalGuests',
            'totalRooms',
            'todayCheckIns',
            'todayCheckOuts',
            'activeReservations',
            'totalRevenue'
        ));
    }

    /**
     * Tampilkan daftar semua reservasi untuk resepsionis.
     */
   public function reservations()
    {
        $reservations = Reservation::with(['user', 'room'])
            ->latest()
            ->paginate(10);

        return view('private.receptionist.reservation.index', compact('reservations'));
    }

    /**
     * Update status reservasi (confirm, checkin, complete, cancel)
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checkin,completed,cancelled',
        ]);

        DB::beginTransaction();
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update(['status' => $request->status]);
            DB::commit();

            return back()->with('success', 'Status reservasi berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status: ' . $th->getMessage());
        }
    }

    public function create(){
        $rooms = Room::where('room_status', 'available')->get();
        return view('private.receptionist.reservation.create', compact('rooms'));
    }

    public function storeReservation(StoreReservationRequest $request){
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
            DB::commit();
            return redirect()->route('receptionist.reservations.index')->with('success', 'Reservasi berhasil dibuat!');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Gagal membuat reservasi: ' . $th->getMessage());
        }
    }

    /**
     * Lihat detail reservasi tertentu.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['user', 'room'])->findOrFail($id);
        return view('private.receptionist.reservations.show', compact('reservation'));
    }
}
