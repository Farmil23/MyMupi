<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(\App\Models\Showtime $showtime)
    {
        $showtime->load(['movie', 'studio']);
        
        // Get booked seats
        $bookedSeats = \App\Models\BookingDetail::whereHas('booking', function($q) use ($showtime) {
            $q->where('showtime_id', $showtime->id)
              ->where('status', '!=', 'cancelled');
        })->pluck('seat_number')->toArray();

        // Dynamic Layout
        $rows = [];
        $totalRows = $showtime->studio->total_rows ?? 5; // Default fallback
        for ($i = 0; $i < $totalRows; $i++) {
            $rows[] = chr(65 + $i); // A, B, C...
        }
        $seatsPerRow = $showtime->studio->seats_per_row ?? 8;

        return view('bookings.create', compact('showtime', 'bookedSeats', 'rows', 'seatsPerRow'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'string'
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // High Value: Concurrency Control
            // Pessimistic Locking on the Showtime record ensures that transactions 
            // for the same showtime are processed sequentially.
            $showtime = \App\Models\Showtime::lockForUpdate()->find($request->showtime_id);
            
            // Double check availability inside the lock
            $takenSeats = \App\Models\BookingDetail::whereHas('booking', function($q) use ($showtime) {
                $q->where('showtime_id', $showtime->id)
                  ->where('status', '!=', 'cancelled');
            })->whereIn('seat_number', $request->seats)->exists();

            if ($takenSeats) {
                throw new \Exception("Seats have just been booked by another user.");
            }

            $totalPrice = $showtime->price * count($request->seats);

            $booking = \App\Models\Booking::create([
                'user_id' => auth()->id(),
                'showtime_id' => $showtime->id,
                'total_price' => $totalPrice,
                'status' => 'paid', // Simulating direct payment
                'payment_method' => 'qris',
            ]);

            foreach ($request->seats as $seat) {
                \App\Models\BookingDetail::create([
                    'booking_id' => $booking->id,
                    'seat_number' => $seat,
                    'price' => $showtime->price
                ]);
            }
            
            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('booking.success', $booking);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function success(\App\Models\Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        $booking->load(['showtime.movie', 'bookingDetails']);
        return view('bookings.success', compact('booking'));
    }

    public function index()
    {
        $bookings = \App\Models\Booking::where('user_id', auth()->id())
            ->with(['showtime.movie', 'showtime.studio', 'bookingDetails'])
            ->latest()
            ->paginate(10);
            
        return view('bookings.index', compact('bookings'));
    }
}
