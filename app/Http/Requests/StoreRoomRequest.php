<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        // Hanya user dengan role admin yang boleh menambah kamar
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi untuk form Tambah Kamar.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'room_name'        => 'required|string|max:255',
            'room_code'        => 'required|string|max:10|unique:rooms,room_code',
            'room_type_id'     => 'required|exists:room_types,id', // wajib ada dan valid
            'room_price'       => 'required|numeric|min:0',
            'room_capacity'    => 'required|integer|min:1',
            'room_description' => 'nullable|string|max:500',
            'image'            => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'room_status'      => 'nullable|in:available,booked,maintenance',
        ];
    }

    /**
     * Pesan error custom untuk validasi.
     */
    public function messages(): array
    {
        return [
            'room_name.required'        => 'Nama kamar wajib diisi!',
            'room_code.required'        => 'Nomor kamar wajib diisi!',
            'room_code.unique'          => 'Kode kamar sudah terdaftar!',
            'room_code.max'             => 'Nomor kamar maksimal 10 karakter!',
            'room_type_id.required'     => 'Tipe kamar wajib dipilih!',
            'room_type_id.exists'       => 'Tipe kamar yang dipilih tidak valid!',
            'room_price.required'       => 'Harga kamar wajib diisi!',
            'room_price.numeric'        => 'Harga kamar harus berupa angka!',
            'room_capacity.required'    => 'Kapasitas kamar wajib diisi!',
            'room_capacity.integer'     => 'Kapasitas kamar harus berupa angka!',
            'room_capacity.min'         => 'Kapasitas minimal 1 orang!',
            'image.required'            => 'Gambar harus diunggah!',
            'image.image'               => 'File yang diunggah harus berupa gambar!',
            'image.mimes'               => 'Format gambar harus jpeg, png, atau jpg!',
            'image.max'                 => 'Ukuran gambar maksimal 2MB!',
            'room_status.in'            => 'Status kamar harus salah satu dari: available, booked, atau maintenance!',
        ];
    }
}
