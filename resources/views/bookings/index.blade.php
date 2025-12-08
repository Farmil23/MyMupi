<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            My Tickets
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-cinema-800 overflow-hidden shadow-xl sm:rounded-lg border border-cinema-700">
                @if($bookings->count() > 0)
                    <div class="p-6 md:p-8 space-y-6">
                        @foreach($bookings as $booking)
                            <div class="bg-cinema-900 border border-cinema-700 rounded-lg p-6 flex flex-col md:flex-row gap-6 relative overflow-hidden group hover:border-cinema-gold transition duration-300">
                                <!-- Movie Poster -->
                                <div class="w-full md:w-32 shrink-0">
                                    <img src="{{ Str::startsWith($booking->showtime->movie->poster, 'http') ? $booking->showtime->movie->poster : asset('storage/'.$booking->showtime->movie->poster) }}" 
                                         class="w-full h-48 object-cover rounded shadow-lg group-hover:scale-105 transition duration-300">
                                </div>
                                
                                <!-- Ticket Info -->
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-2xl font-bold text-white mb-2">{{ $booking->showtime->movie->title }}</h3>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                <span class="bg-cinema-700 text-gray-300 px-2 py-1 rounded text-xs uppercase tracking-wide">
                                                    {{ $booking->showtime->studio->name }}
                                                </span>
                                                <span class="bg-cinema-gold text-cinema-900 px-2 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                                    {{ $booking->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-gray-400 text-sm">Booking ID</div>
                                            <div class="text-white font-mono font-bold">#{{ $booking->id }}</div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-6">
                                        <div>
                                            <span class="block text-gray-500">Date</span>
                                            <span class="block text-gray-300 font-bold">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('D, d M Y') }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-500">Time</span>
                                            <span class="block text-gray-300 font-bold">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-500">Seats</span>
                                            <span class="block text-gray-300 font-bold">
                                                {{ $booking->bookingDetails->pluck('seat_number')->join(', ') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-500">Total Price</span>
                                            <span class="block text-cinema-gold font-bold">IDR {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <a href="{{ route('booking.success', $booking->id) }}" class="bg-cinema-red text-white py-2 px-6 rounded hover:bg-red-700 transition flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            View Ticket
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-4 border-t border-cinema-700">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        <h3 class="text-xl font-bold text-gray-400 mb-2">No Tickets Found</h3>
                        <p class="text-gray-500 mb-6">You haven't booked any movies yet.</p>
                        <a href="{{ route('home') }}" class="bg-cinema-gold text-cinema-900 font-bold py-3 px-8 rounded hover:bg-yellow-400 transition">
                            Book a Movie Now
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
