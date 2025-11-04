<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            //
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|max:32',
            'confirmPassword' => 'required|same:password|min:3|max:32',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'email.unique' => 'Email sudah terdaftar!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.max' => 'Password maksimal 32 karakter!',
            'confirmPassword.required' => 'Konfirmasi Password harus diisi!',
            'confirmPassword.same' => 'Konfirmasi Password harus sama dengan Password!',
            'confirmPassword.min' => 'Konfirmasi Password minimal 8 karakter!',
            'confirmPassword.max' => 'Konfirmasi Password maksimal 32 karakter!',
        ];
    }
}
