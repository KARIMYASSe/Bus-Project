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

// // لعرض نموذج تسجيل الدخول
// Route::get('/admin/login', function () {
//     return view('admin.login');
// })->name('admin.login');

// // مسار تسجيل الدخول (إذا لم يكن موجودًا بالفعل)
// Route::post('/signin', [UserController::class, 'signin'])->name('signin');


// use App\Http\Controllers\AdminController; // تأكد من المسار الصحيح
// Route::get('/admin/welcome', function () {
//     $user = session('user');
//     return view('admin.welcome', compact('user'));
// })->name('admin.welcome');


Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/signin', [UserController::class, 'signin'])->name('signin');

// صفحات الأدمن بعد تسجيل الدخول
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/welcome', function () {
        return view('admin.welcome');
    })->name('admin.welcome');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/panel', function () {
        return view('admin.panel'); // دي ممكن تكون صفحة تدير منها الرحلات والحجوزات
    })->name('admin.panel');

    Route::get('/user/home', function () {
        return 'Welcome User!';
    })->name('user.home');
});


// Route::get('/admin/bookings', function () {
//     return view('admin.bookings');
// })->name('admin.bookings')->middleware('auth');

// Route::get('/admin/bookings', function () {
//     if (Auth::user()->role !== 'admin') {
//         abort(403, 'Unauthorized');
//     }
//     return view('admin.bookings');
// })->name('admin.bookings')->middleware('auth');
Route::get('/admin/bookings', function () {
    return view('admin.bookings');
})->name('admin.bookings');