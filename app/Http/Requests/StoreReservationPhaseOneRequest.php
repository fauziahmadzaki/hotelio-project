<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationPhaseOneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->user()->role === "guest"){
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
        'user_id' => 'nullable|exists:users,id',
        'room_id' => 'required|exists:rooms,id',
        'person_name' => 'required|string|max:255',
        'person_phone_number' => 'required|string|max:20',
        'check_in_date' => 'required|date|after_or_equal:today',
        'check_out_date' => 'required|date|after:check_in_date',
        'total_guests' => 'required|integer|min:1',
        'notes' => 'nullable|max:500',
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

        'check_in_date.required' => 'Tanggal check-in wajib diisi.',
        'check_in_date.date' => 'Tanggal check-in harus berupa format tanggal yang valid.',
        'check_in_date.after_or_equal' => 'Tanggal check-in minimal hari ini.',

        'check_out_date.required' => 'Tanggal check-out wajib diisi.',
        'check_out_date.date' => 'Tanggal check-out harus berupa format tanggal yang valid.',
        'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in.',

        'total_guests.required' => 'Jumlah tamu wajib diisi.',
        'total_guests.integer' => 'Jumlah tamu harus berupa angka.',
        'total_guests.min' => 'Minimal 1 tamu.',

        'notes.max' => 'Catatan maksimal 500 karakter.',
    ];
}
}
