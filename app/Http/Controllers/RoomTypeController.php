<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;


class RoomTypeController extends Controller
{
    
    public function index()
    {
        $roomTypes = RoomType::with('facilities')->get();
        return view('private.admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('private.admin.room-types.create', compact('facilities'));
    }

    public function store(StoreRoomTypeRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $roomType = RoomType::create([
                "room_type_name" => $validated["room_type_name"]
            ]);

            if ($request->filled('facilities')) {
                $roomType->facilities()->sync($request->facilities);
            }

            DB::commit();
            return redirect()
                ->route('admin.room-types.index')
                ->with('success', 'Tipe kamar berhasil dibuat!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal membuat tipe kamar: ' . $th->getMessage());
        }
    }

    public function edit(RoomType $roomType)
    {
        $facilities = Facility::all();
        // Ambil ID fasilitas yang sudah ter-assign ke Tipe Kamar ini
        $assignedFacilities = $roomType->facilities->pluck('id')->toArray();

        return view('private.admin.room-types.edit', compact('roomType', 'facilities', 'assignedFacilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomTypeRequest $request, RoomType $roomType)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            
            $roomType->update([
                "room_type_name" => $validated["room_type_name"]
            ]);
            $roomType->facilities()->sync($request->facilities ?? []);

            DB::commit();

            return redirect()
                ->route('admin.room-types.index')
                ->with('success', 'Tipe kamar berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal memperbarui tipe kamar: ' . $th->getMessage());
        }
    }


    public function destroy(RoomType $roomType)
    {
        if ($roomType->rooms()->exists()) {
            return back()->with('error', 'Tidak bisa menghapus! Tipe kamar ini masih digunakan oleh kamar lain.');
        }

        DB::beginTransaction();
        try {
            $roomType->facilities()->detach();
            
            $roomType->delete();

            DB::commit();

            return redirect()
                ->route('admin.room-types.index')
                ->with('success', 'Tipe kamar berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal menghapus tipe kamar: ' . $th->getMessage());
        }
    }
}
