<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomTypeRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh mengirim request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk form update.
     */
    public function rules(): array
    {
        // Ambil ID tipe kamar dari route
        $roomTypeId = $this->route('room_type')->id;

        return [
            "room_type_name" => [
                "required",
                "string",
                "max:255",
                Rule::unique('room_types')->ignore($roomTypeId),
            ],
            "facilities" => "array"
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            "room_type_name.required" => "Nama tipe kamar harus diisi.",
            "room_type_name.unique" => "Nama tipe kamar sudah terdaftar.",
        ];
    }
}