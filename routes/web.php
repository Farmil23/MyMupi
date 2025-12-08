<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/movie/{movie}', [App\Http\Controllers\MovieController::class, 'show'])->name('movie.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/movie/{movie}/review', [App\Http\Controllers\MovieController::class, 'storeReview'])->name('movie.review.store');
    
    Route::get('/dashboard', function () {
        $bookingsCount = \App\Models\Booking::where('user_id', auth()->id())->count();
        $latestBooking = \App\Models\Booking::where('user_id', auth()->id())->latest()->first();
        return view('dashboard', compact('bookingsCount', 'latestBooking'));
    })->name('dashboard');

    Route::get('/booking/{showtime}', [App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/success/{booking}', [App\Http\Controllers\BookingController::class, 'success'])->name('booking.success');
    Route::get('/my-tickets', [App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
    
    // User Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('movies', App\Http\Controllers\Admin\MovieController::class);
    Route::resource('showtimes', App\Http\Controllers\Admin\ShowtimeController::class);
    Route::resource('studios', App\Http\Controllers\Admin\StudioController::class);
    // Add logic for adding booking seat if needed, but usually admin manages showtimes/movies
});

require __DIR__.'/auth.php';
