<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Income;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('room')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->get();

        $view = Auth::user()->role === 'receptionist'
            ? 'private.receptionist.reservations.index'
            : 'private.admin.reservations.index';

        return view($view, compact('reservations'));
    }

public function create()
{
    $rooms = Room::where('room_status', 'available')->get();

    if ($rooms->isEmpty()) {
        $route = Auth::user()->role === 'receptionist'
            ? 'receptionist.reservations.index'
            : 'admin.reservations.index';

        return redirect()->route($route)
            ->with('error', 'Tidak ada kamar yang tersedia.');
    }
            session()->put('reservation_preview', new Reservation());
    $view = Auth::user()->role === 'receptionist'
        ? 'private.receptionist.reservations.create'
        : 'private.admin.reservations.create';
    return view($view, compact('rooms'));
}

public function store(StoreReservationRequest $request)
{
    $validated = $request->validated();
    
    $reservation = session('reservation_preview', new Reservation());


    $room = Room::findOrFail($validated['room_id']);

    $days = now()->parse($validated['check_in_date'])
        ->diffInDays(now()->parse($validated['check_out_date']));

    if ($days <= 0) {
        return back()->with('error', 'Tanggal check-out harus lebih besar dari tanggal check-in.');
    }

    $totalPrice = $days * $room->room_price;

    // PERBAIKAN: Isi objek $reservation, jangan buat array baru
    $reservation->fill($validated); // Isi data dari form
    $reservation->days = $days;
    $reservation->total_price = $totalPrice;
    
    // Simpan data tambahan untuk preview (bahkan jika bukan kolom di tabel)
    $reservation->room_name = $room->room_name;
    $reservation->room_price = $room->room_price;

    // PERBAIKAN: Simpan *objek* yang sudah diisi kembali ke sesi
    session(['reservation_preview' => $reservation]);

    $route = Auth::user()->role === 'admin'
        ? 'admin.reservations.preview'
        : 'receptionist.reservations.preview';

    return redirect()->route($route, $validated['room_id']);
}

public function preview($id)
{
    $reservation = session('reservation_preview');

    if (!$reservation || !$reservation->room_id) {
        $createRoute = Auth::user()->role === 'receptionist'
            ? 'receptionist.reservations.create'
            : 'admin.reservations.create';
            
        return redirect()->route($createRoute)
            ->with('error', 'Data reservasi tidak ditemukan, silakan isi ulang.');
    }

    if ($reservation->room_id != $id) {
        return redirect()
            ->route('guest.reservations.create1', $id) // Sesuaikan route ini jika perlu
            ->with('error', 'Terjadi kesalahan, ID ruangan tidak cocok. Silakan ulangi.');
    }

    $room = Room::findOrFail($id);

 
    $checkin = Carbon::parse($reservation->check_in_date);
    $checkout = Carbon::parse($reservation->check_out_date);
    
    $days = $reservation->days;

   
    $reservation->tax = $reservation->total_price * 0.1;
    $reservation->grand_total = $reservation->total_price + $reservation->tax;

   
    session(['reservation_preview' => $reservation]);

    $view = Auth::user()->role === 'receptionist'
        ? 'private.receptionist.reservations.confirm'
        : 'private.admin.reservations.confirm';

    return view($view, compact('room', 'reservation'));

}

 public function save(Request $request)
    {

        $reservation = session('reservation_preview');

        // 2. Tentukan route 'create' untuk redirect jika terjadi error
        $createRoute = Auth::user()->role === 'receptionist'
            ? 'receptionist.reservations.create'
            : 'admin.reservations.create';

        if (!$reservation || !$reservation->room_id) {
            return redirect()->route($createRoute)
                ->with('error', 'Sesi reservasi telah berakhir. Silakan isi ulang.');
        }

        $room = Room::findOrFail($reservation->room_id);

        if ($room->room_status !== 'available') {
            return redirect()->route($createRoute)
                ->with('error', 'Maaf, kamar ini baru saja dipesan. Silakan pilih kamar lain.');
        }

        // 5. Mulai Transaksi Database
        DB::beginTransaction();
        try {
            
            // 6. Buat record Reservasi baru
            Reservation::create([
                'user_id' => Auth::id(),
                'room_id' => $reservation->room_id,
                'person_name' => $reservation->person_name,
                'person_phone_number' => $reservation->person_phone_number,
                'check_in_date' => $reservation->check_in_date,
                'check_out_date' => $reservation->check_out_date,
                'total_guests' => $reservation->total_guests,
                
                // Ambil data kalkulasi dari sesi
                'total_price' => $reservation->total_price, // Ini adalah subtotal
                'tax' => $reservation->tax,
                'grand_total' => $reservation->grand_total, // Ini adalah total akhir

                'payment_method' => $reservation->payment_method,
                'notes' => $reservation->notes ?? null,
                'status' => $reservation->status, // 'pending' atau 'checked_in'
            ]);

            // 7. Update status kamar menjadi 'booked'
            $room->update(['room_status' => 'booked']);

            // 8. Commit transaksi jika sukses
            DB::commit();

            // 9. Hapus data dari sesi
            session()->forget('reservation_preview');

            // 10. Redirect ke halaman index dengan pesan sukses
            $indexRoute = Auth::user()->role === 'receptionist'
                ? 'receptionist.reservations.index'
                : 'admin.reservations.index';

            return redirect()->route($indexRoute)->with('success', 'Reservasi berhasil disimpan!');

        } catch (\Throwable $e) {
            // 11. Rollback jika terjadi error
            DB::rollBack();
            
            Log::error('Gagal menyimpan reservasi: ' . $e->getMessage()); 
            
            return back()->with('error', 'Gagal menyimpan reservasi: Terjadi kesalahan server.');
        }
    }

        public function show(Reservation $reservation) // Gunakan Route Model Binding
    {
        $reservation->load(['room.roomType', 'user']);

        $view = Auth::user()->role === 'receptionist'
            ? 'private.receptionist.reservations.detail'
            : 'private.admin.reservations.detail';
        
        $room = $reservation->room;

        return view($view, compact('reservation', 'room'));
    }

   public function edit(Reservation $reservation)
    {
        $view = Auth::user()->role === 'receptionist'
            ? 'private.receptionist.reservations.edit'
            : 'private.admin.reservations.edit';

        return view($view, compact('reservation'));
    }
public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        // PERBAIKAN: Validasi sudah otomatis, ambil data
        $validated = $request->validated();

        $room = $reservation->room;
        $newPriceData = [];

        // Cek apakah tanggal berubah. Jika ya, hitung ulang harga.
        $checkInChanged = $validated['check_in_date'] !== $reservation->check_in_date->format('Y-m-d');
        $checkOutChanged = $validated['check_out_date'] !== $reservation->check_out_date->format('Y-m-d');

        if ($checkInChanged || $checkOutChanged) {
            $days = Carbon::parse($validated['check_in_date'])
                ->diffInDays(Carbon::parse($validated['check_out_date']));
            
            if ($days <= 0) $days = 1; // Minimum 1 malam

            $totalPrice = $days * $room->room_price;
            $tax = $totalPrice * 0.1;
            $grandTotal = $totalPrice + $tax;

            $newPriceData = [
                'total_price' => $totalPrice,
                'tax' => $tax,
                'grand_total' => $grandTotal,
            ];
        }

        DB::beginTransaction();
        try {
            $oldStatus = $reservation->status;
            $newStatus = $validated['status'];

            // PERBAIKAN: Logika status yang benar

            // Cek apakah status baru adalah 'selesai' (cancelled atau completed)
            $newStatusIsFinished = in_array($newStatus, ['cancelled', 'completed']);
            // Cek apakah status lama adalah 'selesai'
            $oldStatusIsFinished = in_array($oldStatus, ['cancelled', 'completed']);


            // LOGIKA 1: Jika status diubah MENJADI 'selesai' (dari aktif)
            // (misal: pending -> cancelled ATAU checked_in -> completed)
            if ($newStatusIsFinished && !$oldStatusIsFinished) {
                $room->update(['room_status' => 'available']);
            } 
            
            // LOGIKA 2: Jika status diubah DARI 'selesai' (menjadi aktif kembali)
            // (misal: cancelled -> pending ATAU completed -> checked_in)
            elseif (!$newStatusIsFinished && $oldStatusIsFinished) {
                // Periksa apakah kamar masih tersedia (karena mungkin sudah dibooking orang lain)
                if ($room->room_status !== 'available') {
                    return back()->with('error', 'Kamar ini sudah dipesan orang lain. Tidak bisa mengaktifkan kembali reservasi ini.');
                }
                $room->update(['room_status' => 'booked']);
            }
            
            if ($request->status === 'completed') {
            \App\Models\Income::create([
                'amount'         => $reservation->total_price,
                'payment_method' => $reservation->payment_method ?? 'cash',
                'type'           => 'income',
                'date'           => now(),
                'description'    => 'Reservasi #' . $reservation->id . ' - ' . ($reservation->room->room_name ?? 'Kamar'),
                'category'       => 'rental',
            ]);
        }
            // LOGIKA 3: Jika status berubah antar-aktif (pending -> checked_in)
            // atau antar-selesai (cancelled -> completed), tidak ada perubahan status kamar.

            // Update reservasi dengan data tervalidasi dan data harga baru (jika ada)
            $reservation->update(array_merge($validated, $newPriceData));

            DB::commit();

            $indexRoute = Auth::user()->role === 'receptionist'
                ? 'receptionist.reservations.index'
                : 'admin.reservations.index';

            return redirect()->route($indexRoute)->with('success', 'Reservasi berhasil diperbarui.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal update reservasi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui reservasi.');
        }
    }
    /**
     * Hapus reservasi
     */
    public function destroy(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            $reservation->room->update(['room_status' => 'available']);
            $reservation->delete();
            DB::commit();

            return back()->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus reservasi: ' . $e->getMessage());
        }
    }
}
