<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(){
        $rooms = Room::paginate(5);
        return view('private.admin.room.index', [
            'rooms' => $rooms]);
    }

    public function create(){
        return view('private.admin.room.create');
    }

    public function detail($id){
        return view('private.admin.room.detail', [
            'room' => Room::find($id)
        ]);
    }

public function store(StoreRoomRequest $request)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        // Simpan file gambar
        // dd($request->file('image'));
       $image = $request->file('image')
    ->storeAs('images', time().'.'.$request->file('image')->extension(), 'public');

       
       

        // Simpan data kamar
        Room::create([
            'room_name'        => $validated['room_name'],
            'room_code'        => $validated['room_code'],
            'room_description' => $validated['room_description'],
            'room_capacity'    => $validated['room_capacity'],
            'room_price'       => $validated['room_price'],
            'image'            => $image,
        ]);

        DB::commit();

        return redirect()
            ->back()
            ->with('success', 'Sukses menambahkan data kamar!');
    } 
    catch (Exception $e) {
        DB::rollBack();
        // Log error biar mudah di-debug
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan data. Silakan coba lagi.');
    }
}

   
public function destroy($id)
{
    $room = Room::find($id);

    // Jika data tidak ditemukan
    if (! $room) {
        return redirect()->back()->with('error', 'Data kamar tidak ditemukan!');
    }

    // Hapus gambar jika ada dan file-nya masih tersimpan
    if ($room->image && Storage::disk('public')->exists($room->image)) {
       Storage::delete($room->image);
    }

    // Hapus data kamar dari database
    $room->delete();

    return redirect()
        ->back()
        ->with('success', 'Data kamar berhasil dihapus!');
}
}
