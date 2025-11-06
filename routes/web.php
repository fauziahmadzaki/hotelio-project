<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/room/detail/{id}', [RoomController::class, 'showRoomDetail'])->name('room.detail');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', 'logout')->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| Admin & User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user,admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/users', 'users')->name('users');
            Route::put('/users/{user}/update-role', 'updateUserRole')->name('users.updateRole');
        });

        // Rooms Controller Group
        Route::controller(RoomController::class)
            ->prefix('rooms')
            ->name('rooms.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/detail/{id}', 'detail')->name('detail');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/destroy/{id}', 'destroy')->name('destroy');
            });

        // Reservations Controller Group
        Route::controller(ReservationController::class)
            ->prefix('reservations')
            ->name('reservations.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{reservation}', 'show')->name('show');
                Route::put('/{reservation}', 'update')->name('update');
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
    });


/*
|--------------------------------------------------------------------------
| Receptionist Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:receptionist,admin'])
    ->prefix('receptionist')
    ->name('receptionist.')
    ->group(function () {

        // Dashboard Receptionist
        Route::controller(\App\Http\Controllers\ReceptionistController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');

            // Manajemen Reservasi
            Route::get('/reservations', 'listReservations')->name('reservations.index');
            Route::get('/reservations',  'reservations')->name('reservations.index');
            Route::patch('/reservations/{id}',  'updateReservationStatus')->name('reservations.update');
        });
    });


/*
|--------------------------------------------------------------------------
| Guest Routes (User Dashboard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user,guest'])
    ->prefix('dashboard')
    ->name('guest.')
    ->group(function () {

        // Guest Dashboard
        Route::controller(GuestController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::get('/data', 'getDashboardData')->name('dashboard.data');
            Route::get('/profile', 'showProfile')->name('profile.show');
            Route::post('/profile', 'updateProfile')->name('profile.update');
        });

        // Guest Reservation Steps
        Route::controller(GuestController::class)
            ->prefix('reservations')
            ->name('reservations.')
            ->group(function () {
                Route::get('/',  'myReservations')->name('index');

                Route::get('/create/{id}/step1', 'showCreateReservation')->name('create1');

                Route::middleware('reservation.inprogress')->group(function () {
                    Route::post('/create/step1', 'storePhaseOne')->name('store1');
                    Route::get('/create/{id}/step2', 'showCreatePhaseTwo')->name('create2');
                    Route::post('/create/step2', 'storeReservation')->name('store2');
                });

                Route::get('/receipt/{id}', 'showReceipt')->name('receipt');
            });
    });