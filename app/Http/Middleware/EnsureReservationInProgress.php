<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureReservationInProgress
{
    public function handle(Request $request, Closure $next)
    {
        // Kalau session "reservation" tidak ada, redirect user
        if (!session()->has('reservation')) {
            return redirect()
                ->route('home');
                
        }

        // Matikan cache halaman (supaya tidak bisa diakses dengan tombol Back / Next)
        return $next($request)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
