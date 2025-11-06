<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacilityController extends Controller
{
    /**
     * Tampilkan semua fasilitas
     */
    public function index()
    {
        $facilities = Facility::orderBy('created_at', 'desc')->get();

        return view('private.admin.facilities.index', compact('facilities'));
    }

    /**
     * Form tambah fasilitas
     */
    public function create()
    {
        return view('private.admin.facilities.create');
    }

    /**
     * Simpan fasilitas baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facility_name' => 'required|string|max:255|unique:facilities,facility_name',
        ], [
            'facility_name.required' => 'Nama fasilitas harus diisi.',
            'facility_name.string' => 'Nama fasilitas harus berupa teks.',
            'facility_name.max' => 'Nama fasilitas maksimal 255 karakter.',
            'facility_name.unique' => 'Nama fasilitas sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            Facility::create([
                'facility_name' => $validator->validated()['facility_name'],
            ]);

            DB::commit();
            return redirect()->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil ditambahkan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan fasilitas: ' . $th->getMessage());
        }
    }

    /**
     * Halaman edit fasilitas
     */
    public function show(Facility $facility)
    {
        return view('private.admin.facilities.edit', compact('facility'));
    }

    /**
     * Update fasilitas
     */
    public function update(Request $request, Facility $facility)
    {
        $validator = Validator::make($request->all(), [
            'facility_name' => 'required|string|max:255|unique:facilities,facility_name,' . $facility->id,
        ], [
            'facility_name.required' => 'Nama fasilitas harus diisi.',
            'facility_name.string' => 'Nama fasilitas harus berupa teks.',
            'facility_name.max' => 'Nama fasilitas maksimal 255 karakter.',
            'facility_name.unique' => 'Nama fasilitas sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $facility->update([
                'facility_name' => $validator->validated()['facility_name'],
            ]);

            DB::commit();
            return redirect()->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengubah fasilitas: ' . $th->getMessage());
        }
    }

    /**
     * Hapus fasilitas
     */
    public function destroy(Facility $facility)
    {
        DB::beginTransaction();
        try {
            $facility->delete();

            DB::commit();
            return redirect()->route('admin.facilities.index')
                ->with('success', 'Fasilitas berhasil dihapus!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus fasilitas: ' . $th->getMessage());
        }
    }
}
