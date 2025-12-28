<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cards Data
        $totalMovies = \App\Models\Movie::count();
        $totalStudios = \App\Models\Studio::count();
        $totalShowtimes = \App\Models\Showtime::count();
        
        // Revenue & Tickets
        $paidBookings = \App\Models\Booking::where('status', 'paid');
        $totalRevenue = $paidBookings->sum('total_price');
        $totalTickets = \App\Models\BookingDetail::whereHas('booking', function($q) {
            $q->where('status', 'paid');
        })->count();

        // Recent Activity
        $recentBookings = \App\Models\Booking::with(['user', 'showtime.movie'])
            ->latest()
            ->take(5)
            ->get();

        // Upcoming Schedules
        $upcomingShowtimes = \App\Models\Showtime::with(['movie', 'studio'])
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMovies', 
            'totalStudios', 
            'totalShowtimes', 
            'totalRevenue',
            'totalTickets',
            'recentBookings',
            'upcomingShowtimes'
        ));
    }
}
