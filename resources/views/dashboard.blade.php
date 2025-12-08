<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Welcome Card -->
                <div class="bg-cinema-800 overflow-hidden shadow-xl sm:rounded-lg border border-cinema-700 p-8">
                    <h3 class="text-2xl font-bold text-white mb-4">
                        Welcome back, <span class="text-cinema-gold">{{ Auth::user()->name }}</span>!
                    </h3>
                    <p class="text-gray-400 mb-6">
                        Ready to watch another blockbuster? Check out what's playing now.
                    </p>
                    <a href="{{ route('home') }}" class="inline-block bg-cinema-red text-white font-bold py-2 px-6 rounded hover:bg-red-700 transition">
                        Browse Movies
                    </a>
                </div>

                <!-- Stats Card -->
                <div class="bg-cinema-800 overflow-hidden shadow-xl sm:rounded-lg border border-cinema-700 p-8">
                    <h3 class="text-xl font-bold text-white mb-4">Your Activity</h3>
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-cinema-700 rounded-full">
                             <svg class="w-8 h-8 text-cinema-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-3xl font-bold text-white">{{ $bookingsCount }}</span>
                            <span class="text-gray-400 text-sm">Tickets Purchased</span>
                        </div>
                    </div>
                    <a href="{{ route('booking.index') }}" class="text-cinema-gold hover:text-white transition font-bold text-sm">
                        View All History &rarr;
                    </a>
                </div>
            </div>

            <!-- Latest Booking -->
            <div class="mt-8">
                <h3 class="text-xl font-bold text-white mb-4">Latest Ticket</h3>
                @if($latestBooking)
                     <div class="bg-gradient-to-r from-cinema-800 to-cinema-700 border border-cinema-600 rounded-lg p-6 flex flex-col sm:flex-row justify-between items-center shadow-lg">
                        <div class="mb-4 sm:mb-0">
                             <h4 class="text-2xl font-bold text-white">{{ $latestBooking->showtime->movie->title }}</h4>
                             <p class="text-cinema-gold">{{ \Carbon\Carbon::parse($latestBooking->showtime->start_time)->format('D, d M Y • H:i') }}</p>
                             <div class="mt-2 text-gray-400 text-sm">
                                 {{ $latestBooking->showtime->studio->name }} • {{ $latestBooking->status }}
                             </div>
                        </div>
                        <a href="{{ route('booking.success', $latestBooking->id) }}" class="bg-white text-cinema-900 font-bold py-2 px-6 rounded hover:bg-gray-200 transition">
                            View e-Ticket
                        </a>
                     </div>
                @else
                    <div class="bg-cinema-800 border border-cinema-700 rounded-lg p-6 text-center text-gray-500 italic">
                        No recent activity found.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
