<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->user()->role == 'admin' || auth()->user()->role == 'receptionist'){
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
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,card',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'category' => 'nullable|in:rental,maintenance,food & beverage,other',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Nominal perlu diisi.',
            'amount.min' => 'Nominal harus lebih besar dari 0.',
            'payment_method.required' => 'Metode pembayaran perlu diisi.',
            'payment_method.in' => 'Invalid payment method.',
            'date.required' => 'Tanggal perlu diisi.',
            'description.string' => 'Description must be a string.',
            'category.in' => 'Invalid category.',
        ];
    }
}
