<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ReservationService;
use App\Http\Requests\StoreReservationPhaseOneRequest;

class GuestController extends Controller
{

public function index()
    {
    $user = auth()->user();

    $reservations = Reservation::with('room')
        ->where('user_id', $user->id)
        ->get();

    $pendingCount   = $reservations->where('status', 'pending')->count();
    $confirmedCount = $reservations->where('status', 'confirmed')->count();
    $cancelledCount = $reservations->where('status', 'cancelled')->count();

    $latestReservation = $reservations
        ->whereIn('status', ['pending', 'confirmed'])
        ->sortByDesc('created_at')
        ->first();

    return view('private.guest.index', [
        'user'           => $user,
        'reservation'    => $latestReservation,
        'pendingCount'   => $pendingCount,
        'confirmedCount' => $confirmedCount,
        'cancelledCount' => $cancelledCount,
    ]);
    }


    public function getDashboardData()
    {
    $user = auth()->user();

    $latestReservation = Reservation::with('room')
        ->where('user_id', $user->id)
        ->whereIn('status', ['pending', 'confirmed'])
        ->latest()
        ->first();

    $data = [
        'pending'   => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
        'confirmed' => Reservation::where('user_id', $user->id)->where('status', 'confirmed')->count(),
        'cancelled' => Reservation::where('user_id', $user->id)->where('status', 'cancelled')->count(),
        'latest'    => $latestReservation ? [
            'room_name'       => $latestReservation->room->room_name,
            'check_in'        => $latestReservation->check_in_date->format('d M Y'),
            'check_out'       => $latestReservation->check_out_date->format('d M Y'),
            'status'          => ucfirst($latestReservation->status),
            'room_image'      => $latestReservation->room->image ? asset('storage/'.$latestReservation->room->image) : null,
        ] : null,
    ];

    return response()->json($data);
    }

    public function showReservation()
    {
        $reservations = Reservation::with('room')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('private.guest.reservation.index', compact('reservations'));
    }

 
    public function showCreateReservation($id)
    {
        $room = Room::findOrFail($id);

        session()->put('reservation', new Reservation());

        return view('private.guest.reservation.create.phase1', compact('room'));
    }

    public function storePhaseOne(StoreReservationPhaseOneRequest $request)
    {
        $validated = $request->validated();

        $reservation = session('reservation', new Reservation());
        $reservation->fill($validated);

        session(['reservation' => $reservation]);

        return redirect()->route('guest.reservations.create2', $validated['room_id']);
    }

 
    public function showCreatePhaseTwo($id)
    {
        $reservation = session('reservation');

        if (!$reservation) {
            return redirect()->route('home')
                ->with('error', 'Sesi reservasi tidak ditemukan.');
        }

        $roomId = $reservation->room_id ?? $reservation['room_id'] ?? null;

        if ((int) $roomId !== (int) $id) {
            return redirect()
                ->route('guest.reservations.create1', $id)
                ->with('error', 'Selesaikan step pertama terlebih dahulu.');
        }

        $room = Room::findOrFail($id);

        $checkin = Carbon::parse($reservation['check_in_date']);
        $checkout = Carbon::parse($reservation['check_out_date']);
        $days = $checkin->diffInDays($checkout);

        $reservation->days = $days;
        $reservation->total_price = $days * $room->room_price;
        $reservation->tax = $room->room_price * 0.1;
        $reservation->grand_total = $reservation->total_price + $reservation->tax;

        return view('private.guest.reservation.create.phase2', compact('room', 'reservation'));
    }


    public function storeReservation(Request $request)
    {
        DB::beginTransaction();

        try {
            $reservation = Reservation::create([
                'user_id'              => auth()->id(),
                'room_id'              => $request->room_id,
                'person_name'          => $request->person_name,
                'person_phone_number'  => $request->person_phone_number,
                'check_in_date'        => $request->check_in_date,
                'check_out_date'       => $request->check_out_date,
                'total_guests'         => $request->total_guests,
                'total_price'          => $request->total_price,
                'number_of_nights'     => $request->number_of_nights,
                'status'               => 'pending',
            ]);

            $request->room_id && Room::whereKey($request->room_id)->update(['room_status' => 'booked']);

            DB::commit();

            session()->forget('reservation');

            return redirect()
                ->route('guest.reservations.receipt', $reservation->id)
                ->with('success', 'Reservasi berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Gagal membuat reservasi: ' . $th->getMessage());
        }
    }


    public function myReservations()
{
    $user = auth()->user();

    $reservations = \App\Models\Reservation::with('room')
        ->where('user_id', $user->id)
        ->latest()
        ->get(['id', 'room_id', 'check_in_date', 'check_out_date', 'status', 'total_price', 'created_at']);

    return view('private.guest.reservation.index', compact('reservations'));
}

    public function showReceipt($id)
    {
        $reservation = Reservation::with('room')->findOrFail($id);

        return view('private.guest.reservation.create.receipt', compact('reservation'));
    }


    public function showProfile()
    {
        $user = auth()->user()->load('profile');

        $profile = $user->profile ?? (object) [
            'phone_number' => null,
            'address'      => null,
            'gender'       => null,
        ];

        return view('private.guest.reservation.profile', compact('user', 'profile'));
    }


    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'gender'       => 'nullable|in:male,female,other',
        ]);

        $user = auth()->user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
