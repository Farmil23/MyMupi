<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-500 leading-tight">
            Booking Successful!
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema3-cream min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden relative">
                <!-- Ticket Header -->
                <div class="bg-gradient-to-r from-cinema3-navy to-cinema3-navySoft p-6 text-center text-white">
                    <h3 class="text-3xl font-bold uppercase tracking-widest text-cinema3-gold ">
                        Movie Ticket
                    </h3>
                    <p class="mt-2 text-white/70 font-semibold">
                        Booking ID: #{{ $booking->id }}
                    </p>

                </div>

                <!-- Ticket Content -->
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="w-full md:w-1/3">
                            <img src="{{ Str::startsWith($booking->showtime->movie->poster, 'http') ? $booking->showtime->movie->poster : 'https://placehold.co/400x600/1a1a1a/d4af37?text=' . urlencode($booking->showtime->movie->title) }}" 
                                 class="w-full rounded shadow-lg border border-cinema3-navy/10">
                        </div>
                        <div class="w-full md:w-2/3 space-y-4">
                            <div>
                                <h2 class="text-2xl font-bold text-cinema3-navy">
                                    {{ $booking->showtime->movie->title }}
                                </h2>
                                <p class="text-gray-600">
                                    {{ $booking->showtime->movie->genre }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 border-t border-b border-cinema3-navy/10 py-4">
                                <div>
                                    <span class="block text-xs text-gray-500 uppercase">Studio</span>
                                    <span class="block text-cinema3-navy font-bold">{{ $booking->showtime->studio->name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500 uppercase">Date & Time</span>
                                    <span class="block text-cinema3-navy font-bold">
                                        {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('D, d M Y - H:i') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500 uppercase">Seats</span>
                                    <span class="block text-cinema3-navy font-bold">
                                        {{ $booking->bookingDetails->pluck('seat_number')->join(', ') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500 uppercase">Total Paid</span>
                                    <span class="block text-cinema3-goldDark font-bold">
                                        ${{ number_format($booking->total_amount, 2) }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-center pt-4">
                                <div class="inline-block bg-cinema3-cream p-3 rounded border border-cinema3-navy/10">
                                    <div class="w-32 h-32 bg-cinema3-navy mx-auto flex items-center justify-center text-white text-xs rounded">
                                        QR CODE
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">
                                    Scan this at the entrance
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Footer (Tear-off effect) -->
                <div class="bg-cinema3-cream p-4 border-t border-dashed border-cinema3-navy/20 flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-cinema3-navy font-bold hover:text-cinema3-gold transition">
                        &larr; Back to Home
                    </a>
                    <button onclick="window.print()" class="text-cinema3-navy hover:text-black flex items-center font-semibold transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
