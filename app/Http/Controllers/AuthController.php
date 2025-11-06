<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
    $validated = $request->validated();
    $input = $request->input('email'); 
    $password = $request->input('password');

    $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

    if ($fieldType === 'name') {
        $user = \App\Models\User::where('name', $input)->first();

        if (!$user || $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Kredensial tidak valid.',
            ])->onlyInput('email');
        }

        if (!\Hash::check($password, $user->password)) {
            return back()->withErrors([
                'email' => 'Kredensial tidak valid.',
            ])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/admin');
    }

    // Kalau login pakai email seperti biasa
    if (Auth::attempt(['email' => $input, 'password' => $password])) {
        $request->session()->regenerate();
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->intended('/admin');
            case 'receptionist':
                return redirect()->intended('/receptionist');
            default:
                return redirect()->intended('/');
        }
    }

    return back()->withErrors([
        'email' => 'Kredensial tidak valid.',
    ])->onlyInput('email');
}

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->profile()->create([
            'phone_number' => null,
            'address'      => null,
            'gender'       => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

  
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLogin()
    {
        return view('auth.login');
    }


    public function showRegister()
    {
        return view('auth.register');
    }
}
