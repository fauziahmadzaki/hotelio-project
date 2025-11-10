<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Room;
use Illuminate\Validation\Validator;

class UpdateReservationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'person_name' => 'required|string|max:255',
            'person_phone_number' => [
                'required',
                'string',
                'max:20',
                'regex:/^(08|\+628)\d{8,12}$/' // Validasi Telepon Indonesia
            ],
            'notes' => 'nullable|string|max:500',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_guests' => 'required|integer|min:1',
            
            'status' => ['required', Rule::in(['pending', 'checked_in', 'completed', 'cancelled'])],
            'payment_method' => ['required', Rule::in(['cash', 'transfer', 'card'])],
        ];
    }

    public function messages(): array
    {
        return [
            'person_phone_number.regex' => 'Format nomor telepon tidak valid. Gunakan 08... atau +628...',
            'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in.',
            'total_guests.min' => 'Minimal 1 tamu.',
        ];
    }


    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();
            $totalGuests = $data['total_guests'] ?? null;
            $room = $this->route('reservation')->room;

            if ($room && $totalGuests) {
                if ($totalGuests > $room->room_capacity) {
                    $validator->errors()->add(
                        'total_guests',
                        "Jumlah tamu ({$totalGuests}) melebihi kapasitas kamar ({$room->room_capacity})."
                    );
                }
            }
        });
    }
}