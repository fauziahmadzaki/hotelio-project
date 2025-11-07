<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Room;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
   public function index(Request $request)
{
    $query = Room::query()->with('facilities');

    // Filter berdasarkan status
    if ($request->filled('status')) {
        $query->where('room_status', $request->status);
    }

    // Filter berdasarkan fasilitas
    if ($request->filled('facility')) {
        $query->whereHas('facilities', function ($q) use ($request) {
            $q->where('facilities.id', $request->facility);
        });
    }

    // Filter berdasarkan rentang harga
    if ($request->filled('min_price')) {
        $query->where('room_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('room_price', '<=', $request->max_price);
    }

    // Filter berdasarkan kapasitas
    if ($request->filled('capacity')) {
        $query->where('room_capacity', '>=', $request->capacity);
    }

    // Ambil hasil dengan pagination
    $rooms = $query->paginate(5)->appends($request->query());

    return view('private.admin.room.index', [
        'rooms' => $rooms,
        'facilities' => Facility::all(),
        'filters' => $request->only(['status', 'facility', 'min_price', 'max_price', 'capacity']),
    ]);
}


    public function create(){

        return view('private.admin.room.create', ['facilities'=>Facility::all()]);
    }

    public function detail($id){
        
        return view('private.admin.room.detail', [
            'room' => Room::find($id), 'facilities' => Facility::all()
        ]);
    }

public function store(StoreRoomRequest $request)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
       
       $image = $request->file('image')
    ->storeAs('images', time().'.'.$request->file('image')->extension(), 'public');
       
       $room = Room::create([
            'room_name'        => $validated['room_name'],
            'room_code'        => $validated['room_code'],
            'room_description' => $validated['room_description'],
            'room_capacity'    => $validated['room_capacity'],
            'room_price'       => $validated['room_price'],
            'image'            => $image,
            'room_status'           => 'available',
        ]);

        if ($request->filled('facilities')) {
        $room->facilities()->sync($request->facilities);
    }

        DB::commit();

        return redirect()
            ->back()
            ->with('success', 'Sukses menambahkan data kamar!');
    } 
    catch (Exception $e) {
        DB::rollBack();
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan data. Silakan coba lagi.');
    }
}

   
public function update(Request $request, $id)
{
    $room = Room::findOrFail($id);

    $validated = $request->validate([
        'room_name' => 'required|string|max:255',
        'room_code' => 'required|string|max:50|unique:rooms,room_code,' . $room->id,
        'room_description' => 'nullable|string',
        'room_capacity' => 'required|integer|min:1',
        'room_price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'facilities' => 'array',
        'room_status' => 'nullable|in:available,booked,maintenance',
        
    ]);

    try {
        \DB::beginTransaction();

        if ($request->hasFile('image')) {
            if ($room->image && \Storage::disk('public')->exists($room->image)) {
                \Storage::disk('public')->delete($room->image);
            }

            $validated['image'] = $request->file('image')->storeAs(
                'images',
                time() . '.' . $request->file('image')->extension(),
                'public'
            );
        }

        
        $room->update($validated);

        
        if ($request->filled('facilities')) {
            $room->facilities()->sync($request->facilities);
        } else {
            $room->facilities()->detach(); 
        }

        \DB::commit();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Data kamar berhasil diperbarui!');
    } catch (\Exception $e) {
        \DB::rollBack();
        report($e);
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat memperbarui data kamar.');
    }
}

    public function showRoomDetail($id)
    {
        $room = \App\Models\Room::with('facilities')->findOrFail($id);

        return view('private.guest.detail', [
            'title' => 'Detail Kamar - ' . $room->room_name,
            'room' => $room,
        ]);
    }



    public function destroy($id)
    {
        $room = Room::find($id);
        if (! $room) {
            return redirect()->back()->with('error', 'Data kamar tidak ditemukan!');
        }

        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();
        return redirect()
            ->back()
            ->with('success', 'Data kamar berhasil dihapus!');
    }
}
