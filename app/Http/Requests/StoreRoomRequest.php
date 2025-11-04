<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->user()->role == 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules(): array
    {
        return [
            'room_name' => 'required|string|max:255',
            'room_code' => 'required|string|max:10|unique:rooms,room_code',
            'room_price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'room_capacity' => 'nullable|integer|min:1',
            'room_description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'room_code.required' => 'Nomor kamar wajib diisi!',
            'room_name.required' => 'Nama kamar wajib diisi!',
            'room_price.required' => 'Harga kamar wajib diisi!',
            'room_code.unique' => 'Kode kamar sudah terdaftar!',
            'image.image' => 'File harus berupa gambar!',
            'image.required' => 'Gambar harus ada!',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg!',
            'image.max' => 'Ukuran gambar maksimal 2MB!',
        ];
    }
}
