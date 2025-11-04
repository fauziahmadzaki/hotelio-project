<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
         $validated = $request->validated();
         $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();
            
            if($user->role == 'admin'){
                return redirect()->intended('/admin');
            }else if(
                $user->role == 'receptionist'
            ){
                return redirect()->intended('/receptionist');
            }
            return redirect()->intended('/');
        }
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are incorrect.'
        ]);
    }

    public function register(StoreUserRequest $request){
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return redirect()->back()->with('success', 'Register Berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showLogin(){
        return view('auth.login');
    }
    public function showRegister(){
        return view('auth.register');
    }
}
