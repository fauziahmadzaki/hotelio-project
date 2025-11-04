<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function (){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware('auth')->group(function (){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:user,admin'])->
    group(function () {
        Route::prefix('/admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('');

            Route::prefix('/rooms')
            ->name('rooms.')
            ->group(function(){
                Route::get('/', [RoomController::class, 'index'])->name('index');
                Route::get('/create', [RoomController::class, 'create'])->name('create');
                Route::post('/store', [RoomController::class, 'store'])->name('store');
                Route::get('/destroy/{id}', [RoomController::class, 'destroy'])->name('destroy');

            });
        });
});