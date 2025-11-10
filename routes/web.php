<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReceptionistController;

// public 
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/room', [HomeController::class, 'rooms'])->name('room');
Route::get('/room/detail/{id}', [RoomController::class, 'showRoomDetail'])->name('room.detail');

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/reset-password', 'showResetPassword')->name('reset-password');
        Route::post('/reset-password', 'resetPassword');
        Route::post('/logout', 'logout')->name('logout');
    });
});


// private
Route::middleware(['auth', 'role:user,admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/users', 'users')->name('users');
            Route::patch('/users/{user}/update-role', 'updateUserRole')->name('users.updateRole');
            route::get('/reservations/completed', 'showCompletedReservations')->name('reservations.completed');
            route::get('/reservations/cancelled', 'showCancelledReservations')->name('reservations.cancelled');
            Route::get('/reservations/detail/{reservation}', 'detail')->name('reservations.detail');
        });

        Route::controller(RoomController::class)
            ->prefix('rooms')
            ->name('rooms.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/detail/{id}', 'detail')->name('detail');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        Route::controller(RoomTypeController::class)
            ->prefix('room-types')
            ->name('room-types.')
            ->group(function () {
               Route::get('/', 'index')->name('index'); 
               Route::get('/create', 'create')->name('create'); 
               Route::post('/store', 'store')->name('store');
               Route::get('/edit/{roomType}', 'edit')->name('edit');
               Route::put('/update/{roomType}', 'update')->name('update');
               Route::delete('/{roomType}', 'destroy')->name('destroy');
            });

        Route::controller(ReservationController::class)
            ->prefix('reservations')
            ->name('reservations.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store'); // Phase 1 ➡️ Preview
                Route::post('/save', 'save')->name('save'); // Phase 1 ➡️ Preview
                Route::get('/create/preview/{id}', 'preview')->name('preview'); // Phase 2 ➡️ Simpan ke DB
                Route::get('/edit/{reservation}', 'edit')->name('edit');
                Route::get('/show/{reservation}', 'show')->name('detail');
                Route::put('/update/{reservation}', 'update')->name('update');
                Route::delete('/{reservation}', 'destroy')->name('destroy');
            });

        Route::controller(FacilityController::class)
            ->prefix('facilities')
            ->name('facilities.')
            ->group(function () {
               Route::get('/', 'index')->name('index');
               Route::get('/create', 'create')->name('create');
               Route::post('/store', 'store')->name('store');
               Route::get('/{facility}', 'show')->name('show');
               Route::put('/{facility}', 'update')->name('update');
               Route::delete('/{facility}', 'destroy')->name('destroy');
            });

        Route::controller(IncomeController::class)
                ->prefix('incomes')
                ->name('incomes.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/edit/{income}', 'edit')->name('edit');
                    Route::put('/update/{income}', 'update')->name('update');
                    Route::delete('/destroy/{income}', 'destroy')->name('destroy');
    });

    
});

Route::middleware(['auth', 'role:receptionist,admin'])
    ->prefix('receptionist')
    ->name('receptionist.')
    ->group(function () {
        Route::controller(ReceptionistController::class)->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/reservations', 'showActiveReservations')->name('reservations.index');
            Route::patch('/reservations/update/{id}', 'updateReservationStatus')->name('reservations.update');
            Route::get('/reservations/completed', 'showCompletedReservations')->name('reservations.completed');
            Route::get('/reservations/cancelled', 'showCancelledReservations')->name('reservations.cancelled');
        });
        Route::prefix('reservations')
            ->name('reservations.')->controller(\App\Http\Controllers\ReservationController::class)->group(function () {
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store'); // Phase 1 ➡️ Preview
                Route::get('/create/preview/{id}', 'preview')->name('preview'); // Phase 2 ➡️ Simpan ke DB
                Route::post('/save', 'save')->name('save'); // Phase 1 ➡️ Preview
                Route::get('/show/{reservation}', 'show')->name('detail');
                Route::delete('/destroy/{reservation}', 'destroy')->name('destroy');
            
        });
            

    });

