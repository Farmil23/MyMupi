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
    
    // Updated Dashboard with Richer Data (V3)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // 1. Basic Stats
        $bookings = \App\Models\Booking::where('user_id', $user->id)->with(['showtime.movie', 'showtime.studio'])->latest()->get();
        $bookingsCount = $bookings->count();
        $latestBooking = $bookings->first();
        
        // 2. Calculate Total Spent
        $totalSpent = $bookings->sum(function($booking) {
             return $booking->showtime ? $booking->showtime->price : 0;
        });

        // 3. Featured Movie (Random VALID "Now Showing")
        $featuredMovie = \App\Models\Movie::where('release_date', '<=', now())->inRandomOrder()->first();

        // 4. Now Showing (Strictly Released)
        $nowShowing = \App\Models\Movie::where('release_date', '<=', now())
            ->latest('release_date')
            ->take(8)
            ->get();

        // 5. Coming Soon (Strictly Future)
        $comingSoon = \App\Models\Movie::where('release_date', '>', now())
            ->orderBy('release_date', 'asc')
            ->take(4)
            ->get();

        // 6. User's Favorite Genre
        $favGenre = '-';
        if ($bookingsCount > 0) {
            $genres = $bookings->map(function($b) {
                return $b->showtime->movie->genre ?? null;
            })->filter()->countBy();
            
            $favGenre = $genres->sortDesc()->keys()->first() ?? '-';
        }

        return view('dashboard', compact('bookingsCount', 'latestBooking', 'totalSpent', 'featuredMovie', 'nowShowing', 'comingSoon', 'favGenre'));
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
});

// --- Fallback Logo Serving (Vercel Fix) ---
Route::get('/images/logo.png', function () {
    $path = public_path('images/logo.png');
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});

require __DIR__.'/auth.php';
