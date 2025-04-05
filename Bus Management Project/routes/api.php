<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminTripController;
use App\Http\Controllers\bookingController;
use App\Http\Controllers\busController;
use App\Http\Controllers\seatController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\tripController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/signup',[UserController::class,'signup']);
Route::post('/signin',[UserController::class,'signin']);
Route::post('/logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::apiResource('/stations', StationController::class);
Route::apiResource('bus', BusController::class);
Route::apiResource('seat', seatController::class);
Route::apiResource('booking', bookingController::class)->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('trips', AdminTripController::class);
    Route::apiResource('bookings', AdminBookingController::class);
});

