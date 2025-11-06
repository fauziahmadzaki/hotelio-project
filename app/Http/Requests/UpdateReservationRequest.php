<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
{
    return [
        'user_id' => 'nullable|exists:users,id',
        'room_id' => 'required|exists:rooms,id',

        'person_name' => 'required|string|max:255',
        'person_phone_number' => 'required|string|max:20',

        'total_guests' => 'required|integer|min:1',

        'total_price' => 'nullable|numeric|min:0',

        'status' => 'nullable|in:pending,confirmed,cancelled,checked_in,completed',
    ];
}

/**
 * Pesan error kustom.
 */
public function messages(): array
{
    return [
        'room_id.required' => 'Kamar wajib dipilih.',
        'room_id.exists' => 'Kamar yang dipilih tidak valid.',

        'person_name.required' => 'Nama pemesan wajib diisi.',
        'person_name.string' => 'Nama pemesan harus berupa teks.',
        'person_name.max' => 'Nama pemesan maksimal 255 karakter.',

        'person_phone_number.required' => 'Nomor telepon wajib diisi.',
        'person_phone_number.string' => 'Nomor telepon harus berupa teks.',
        'person_phone_number.max' => 'Nomor telepon maksimal 20 karakter.',

        'total_guests.required' => 'Jumlah tamu wajib diisi.',
        'total_guests.integer' => 'Jumlah tamu harus berupa angka.',
        'total_guests.min' => 'Minimal 1 tamu.',

        'total_price.numeric' => 'Total harga harus berupa angka.',
        'total_price.min' => 'Total harga tidak boleh negatif.',

        'status.in' => 'Status tidak valid. Pilihan: pending, confirmed, cancelled, atau completed.',
    ];
}
}
