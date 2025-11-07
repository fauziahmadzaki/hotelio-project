<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Income;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    //
     public function index()
    {
    
        $totalUsers = User::count();
        $totalRooms = Room::count();
        $totalReservations = Reservation::count();

       
       $totalRevenue = Income::where('type', 'income')->sum('amount');

        $statusCounts = Reservation::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $pending   = $statusCounts['pending'] ?? 0;
        $confirmed = $statusCounts['checked_in'] ?? 0;
        $cancelled = $statusCounts['cancelled'] ?? 0;
        $completed = $statusCounts['completed'] ?? 0;

        $recentReservations = Reservation::with(['user:id,name', 'room:id,room_name'])
            ->latest()
            ->take(5)
            ->get([
                'id', 'user_id', 'room_id', 'check_in_date',
                'check_out_date', 'status', 'total_price', 'created_at'
            ]);

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


    public function showActiveReservations()
    {
        $reservations =  Reservation::where('status', '!=', 'completed')->where('status', '!=', 'cancelled')->with(['room'])->latest()->get();
        return view('private.admin.reservations.index', compact('reservations'));
    }

    public function showCompletedReservations(){
        $reservations =  Reservation::where('status', 'completed')->with(['room'])->latest()->get();
        return view('private.admin.reservations.completed', compact('reservations'));
    }

    public function showCancelledReservations(){
        $reservations =  Reservation::where('status', 'cancelled')->with(['room'])->latest()->get();
        return view('private.admin.reservations.cancelled', compact('reservations'));
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

    public function detail(Reservation $reservation){
        return view('private.admin.reservations.detail', compact('reservation'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', "User  berhasil dihapus!");
    }
}
