<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRoomRequest;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar kamar.
     */
    public function index(Request $request)
    {
        $query = Room::query();

        // Contoh filter (bisa dikembangkan nanti)
        if ($request->filled('status')) {
            $query->where('room_status', $request->status);
        }

        // Pagination hasil
        $rooms = $query->paginate(5)->appends($request->query());

        return view('private.admin.room.index', [
            'rooms'   => $rooms,
            'filters' => $request->only(['status', 'min_price', 'max_price', 'capacity']),
        ]);
    }

    /**
     * Menampilkan form tambah kamar.
     */
    public function create()
    {
        return view('private.admin.room.create', [
            'roomTypes' => RoomType::all(),
        ]);
    }

    /**
     * Menyimpan data kamar baru.
     */
    public function store(StoreRoomRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Upload gambar
            $imagePath = $request->file('image')->storeAs(
                'images',
                time() . '.' . $request->file('image')->extension(),
                'public'
            );

            // Simpan kamar
            Room::create([
                'room_name'        => $validated['room_name'],
                'room_code'        => $validated['room_code'],
                'room_description' => $validated['room_description'] ?? null,
                'room_capacity'    => $validated['room_capacity'],
                'room_price'       => $validated['room_price'],
                'image'            => $imagePath,
                'room_type_id'     => $validated['room_type_id'],
                'room_status'      => 'available',
            ]);

            DB::commit();

            return redirect()
                ->route('admin.rooms.index')
                ->with('success', 'Sukses menambahkan data kamar!');
        } catch (Exception $e) {
            DB::rollBack();

            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data kamar.'. $e->getMessage());
        }
    }

    /**
     * Menampilkan detail kamar (versi admin).
     */

public function detail($id)
{
    $room = Room::with(['roomType', 'facilities'])->findOrFail($id);

    return view('private.admin.room.detail', [
        'room' => $room,
    ]);
}




public function edit($id)
{
    $room = Room::with('roomType')->findOrFail($id);

    return view('private.admin.room.edit', [
        'room' => $room,
        'roomTypes' => \App\Models\RoomType::all(), // ⬅️ tambahkan ini
    ]);
}

    /**
     * Mengupdate data kamar.
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_name'        => 'required|string|max:255',
            'room_code'        => 'required|string|max:10|unique:rooms,room_code,' . $room->id,
            'room_description' => 'nullable|string|max:500',
            'room_capacity'    => 'required|integer|min:1',
            'room_price'       => 'required|numeric|min:0',
            'room_type_id'     => 'required|exists:room_types,id',
            'room_status'      => 'nullable|in:available,booked,maintenance',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Update gambar jika diunggah ulang
            if ($request->hasFile('image')) {
                if ($room->image && Storage::disk('public')->exists($room->image)) {
                    Storage::disk('public')->delete($room->image);
                }

                $validated['image'] = $request->file('image')->storeAs(
                    'images',
                    time() . '.' . $request->file('image')->extension(),
                    'public'
                );
            }

            // Update data kamar
            $room->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.rooms.index')
                ->with('success', 'Data kamar berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data kamar.');
        }
    }

    /**
     * Menampilkan detail kamar untuk tamu.
     */
    public function showRoomDetail($id)
    {
        $room = Room::with('roomType')->findOrFail($id);

        return view('detail', [
            'title' => 'Detail Kamar - ' . $room->room_name,
            'room'  => $room,
        ]);
    }

    /**
     * Menghapus data kamar.
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if (! $room) {
            return redirect()->back()->with('error', 'Data kamar tidak ditemukan!');
        }

        // Hapus gambar dari storage
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()
            ->back()
            ->with('success', 'Data kamar berhasil dihapus!');
    }
}
