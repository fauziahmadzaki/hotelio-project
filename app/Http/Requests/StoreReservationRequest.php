<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Room;
use Illuminate\Validation\Validator;

class StoreReservationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'person_name' => 'required|string|max:255',
            
            'person_phone_number' => [
                'required',
                'string',
                'max:12',
                'regex:/^(08|\+628)\d{8,12}$/' 
            ],

            'notes' => 'nullable|string|max:500',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_guests' => 'required|integer|min:1', 
            'payment_method' => 'required|in:cash,transfer,card',
            'status' => 'nullable|in:pending,confirmed,checked_in,completed,cancelled',
            'total_price' => 'nullable|numeric|min:0',
        ];
    }

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
            'person_phone_number.max' => 'Nomor telepon maksimal 12 karakter.',
            'person_phone_number.regex' => 'Format nomor telepon tidak valid. Gunakan 08... atau +628...',

            'notes.max' => 'Catatan maksimal 500 karakter.',

            'check_in_date.required' => 'Tanggal check-in wajib diisi.',
            'check_in_date.date' => 'Tanggal check-in tidak valid.',
            'check_in_date.after_or_equal' => 'Tanggal check-in minimal hari ini.',

            'check_out_date.required' => 'Tanggal check-out wajib diisi.',
            'check_out_date.date' => 'Tanggal check-out tidak valid.',
            'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in.',

            'total_guests.required' => 'Jumlah tamu wajib diisi.',
            'total_guests.integer' => 'Jumlah tamu harus berupa angka.',
            'total_guests.min' => 'Minimal 1 tamu.',

            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',

            'status.in' => 'Status reservasi tidak valid.',

            'total_price.numeric' => 'Total harga harus berupa angka.',
            'total_price.min' => 'Total harga tidak boleh negatif.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->status ?? 'pending',
        ]);
    }

    /**
     * 
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();

            $roomId = $data['room_id'] ?? null;
            $totalGuests = $data['total_guests'] ?? null;

            if ($roomId && $totalGuests) {
                $room = Room::find($roomId);

                if ($room) {
                    if ($totalGuests > $room->room_capacity) {
                        $validator->errors()->add(
                            'total_guests',
                            "Jumlah tamu ({$totalGuests}) melebihi kapasitas kamar ({$room->room_capacity})."
                        );
                    }
                }
            }
        });
    }
}