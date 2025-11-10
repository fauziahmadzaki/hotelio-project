<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "room_type_name" => "required|string|max:255|unique:room_types,room_type_name",
            "facilities" => "array"
        ];
    }

    public function messages(): array
    {
        return [
            "room_type_name.required" => "Nama tipe kamar harus diisi.",
            "room_type_name.string" => "Nama tipe kamar harus berupa teks.",
            "room_type_name.max" => "Nama tipe kamar maksimal 255 karakter.",
            "room_type_name.unique" => "Nama tipe kamar sudah terdaftar.",
        ];
    }
}