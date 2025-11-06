<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->where('status', 'checkin')
            ->count();

        $activeReservations = Reservation::whereIn('status', ['confirmed', 'checkin'])->count();

        // Total pendapatan (dari status confirmed, checkin, completed)
        $totalRevenue = Reservation::whereIn('status', ['confirmed', 'checkin', 'completed'])
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
    /**
     * Lihat detail reservasi tertentu.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['user', 'room'])->findOrFail($id);
        return view('private.receptionist.reservations.show', compact('reservation'));
    }
}
