<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminTripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('trips', AdminTripController::class);
    Route::resource('bookings', AdminBookingController::class);
});

Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/signin', [UserController::class, 'signin'])->name('signin');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/welcome', function () {
        return view('admin.welcome');
    })->name('admin.welcome');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/panel', function () {
        return view('admin.panel'); 
    })->name('admin.panel');

    Route::get('/user/home', function () {
        return 'Welcome User!';
    })->name('user.home');
});

Route::get('/admin/bookings', function () {
    return view('admin.bookings');
})->name('admin.bookings');
