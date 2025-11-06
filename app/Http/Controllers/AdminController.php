<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    //
     public function index()
    {
        // Hitung total dasar
        $totalUsers = User::count();
        $totalRooms = Room::count();
        $totalReservations = Reservation::count();

        // Hitung total pendapatan (hanya dari reservasi yang sudah dikonfirmasi)
       $totalRevenue = Reservation::whereIn('status', ['confirmed', 'checkin', 'completed'])
    ->sum('total_price');


        // Statistik status reservasi
        $statusCounts = Reservation::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $pending   = $statusCounts['pending'] ?? 0;
        $confirmed = $statusCounts['confirmed'] ?? 0;
        $cancelled = $statusCounts['cancelled'] ?? 0;
        $completed = $statusCounts['completed'] ?? 0;

        // Ambil reservasi terbaru (dengan relasi user & room)
        $recentReservations = Reservation::with(['user:id,name', 'room:id,room_name'])
            ->latest()
            ->take(5)
            ->get([
                'id', 'user_id', 'room_id', 'check_in_date',
                'check_out_date', 'status', 'total_price', 'created_at'
            ]);

        // Data kamar
        $availableRooms = Room::where('room_status', 'available')->count();
        $bookedRooms    = Room::where('room_status', 'booked')->count();

        return view('private.admin.index', compact(
            'totalUsers',
            'totalRooms',
            'totalReservations',
            'totalRevenue',
            'pending',
            'confirmed',
            'cancelled',
            'completed',
            'recentReservations',
            'availableRooms',
            'bookedRooms'
        ));
    }

    /**
     * Menampilkan semua reservasi (untuk manajemen admin)
     */
    public function reservations()
    {
        $reservations = Reservation::with(['user:id,name,email', 'room:id,room_name'])
            ->latest()
            ->paginate(10);

        return view('private.admin.reservations.index', compact('reservations'));
    }



public function users(Request $request)
{
    $search = $request->input('search');
    $query = User::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $users = $query->where('name', '!=', 'admin')->orderBy('created_at', 'desc')->paginate(10);

    return view('private.admin.users.index', compact('users'));
}

public function updateUserRole(Request $request, User $user)
{
    $validated = $request->validate([
        'role' => 'required|in:guest,receptionist,admin',
    ]);

    $user->update(['role' => $validated['role']]);

    return redirect()->route('admin.users')->with('success', "Role {$user->name} berhasil diubah!");
}

}
