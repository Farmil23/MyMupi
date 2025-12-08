<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = \App\Models\Movie::count();
        $totalStudios = \App\Models\Studio::count();
        $totalShowtimes = \App\Models\Showtime::count();
        $totalRevenue = \App\Models\Booking::where('status', 'paid')->sum('total_price');

        return view('admin.dashboard', compact('totalMovies', 'totalStudios', 'totalShowtimes', 'totalRevenue'));
    }
}
