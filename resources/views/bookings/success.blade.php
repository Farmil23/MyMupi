<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-500 leading-tight">
            Booking Successful!
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden relative">
                <!-- Ticket Header -->
                <div class="bg-cinema-red p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, #000 10px, #000 20px);"></div>
                    <h3 class="text-3xl font-bold uppercase tracking-widest relative z-10">Movie Ticket</h3>
                    <p class="mt-2 text-red-100 relative z-10">Booking ID: #{{ $booking->id }}</p>
                </div>

                <!-- Ticket Content -->
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8 items-center">
                        <div class="w-full md:w-1/3">
                            <img src="{{ Str::startsWith($booking->showtime->movie->poster, 'http') ? $booking->showtime->movie->poster : 'https://placehold.co/400x600/1a1a1a/d4af37?text=' . urlencode($booking->showtime->movie->title) }}" 
                                 class="w-full rounded shadow-lg">
                        </div>
                        <div class="w-full md:w-2/3 space-y-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $booking->showtime->movie->title }}</h2>
                                <p class="text-gray-500">{{ $booking->showtime->movie->genre }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 border-t border-b border-gray-200 py-4">
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Studio</span>
                                    <span class="block text-gray-800 font-bold">{{ $booking->showtime->studio->name }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Date & Time</span>
                                    <span class="block text-gray-800 font-bold">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('d M Y, H:i') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Seats</span>
                                    <span class="block text-gray-800 font-bold">
                                        {{ $booking->bookingDetails->pluck('seat_number')->join(', ') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-400 uppercase">Total Paid</span>
                                    <span class="block text-green-600 font-bold">IDR {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="text-center pt-4">
                                <div class="inline-block bg-gray-100 p-2 rounded">
                                    <!-- Fake QR Code -->
                                    <div class="w-32 h-32 bg-gray-900 mx-auto flex items-center justify-center text-white text-xs">
                                        QR CODE
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">Scan this at the entrance</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Footer (Tear-off effect) -->
                <div class="bg-gray-50 p-4 border-t-2 border-dashed border-gray-300 flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-cinema-red font-bold hover:underline">&larr; Back to Home</a>
                    <button onclick="window.print()" class="text-gray-600 hover:text-black flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
