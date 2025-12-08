<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            Select Seats for {{ $showtime->movie->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen" x-data="seatSelector()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Seat Map -->
                <div class="w-full md:w-2/3 bg-cinema-800 p-8 rounded-lg shadow-2xl border border-cinema-700">
                    <div class="mb-10 text-center">
                        <div class="w-2/3 mx-auto h-2 bg-cinema-gold shadow-[0_0_20px_rgba(212,175,55,0.5)] rounded mb-4"></div>
                        <span class="text-gray-400 text-sm uppercase tracking-widest">SCREEN</span>
                    </div>

                    <div class="grid gap-4 justify-center">
                        {{-- Dynamic Layout --}}
                        @foreach($rows as $row)
                            <div class="flex gap-4 justify-center">
                                <span class="text-gray-500 w-6 text-center pt-1">{{ $row }}</span>
                                @for($i = 1; $i <= $seatsPerRow; $i++)
                                    @php 
                                        $seatNum = $row.$i;
                                        $isBooked = in_array($seatNum, $bookedSeats);
                                    @endphp
                                    <button 
                                        @click="toggleSeat('{{ $seatNum }}')"
                                        :class="{
                                            'bg-gray-700 cursor-not-allowed opacity-50': {{ $isBooked ? 'true' : 'false' }},
                                            'bg-cinema-red text-white shadow-lg scale-110': selectedSeats.includes('{{ $seatNum }}'),
                                            'bg-cinema-700 text-gray-300 hover:bg-cinema-gold hover:text-black': !selectedSeats.includes('{{ $seatNum }}') && !{{ $isBooked ? 'true' : 'false' }} 
                                        }"
                                        class="w-10 h-10 rounded-t-lg transition duration-200 font-bold text-xs"
                                        {{ $isBooked ? 'disabled' : '' }}>
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                        @endforeach
                    </div>

                    <!-- Legend -->
                    <div class="mt-12 flex justify-center space-x-6 text-sm text-gray-400">
                        <div class="flex items-center"><div class="w-4 h-4 bg-cinema-700 rounded mr-2"></div> Available</div>
                        <div class="flex items-center"><div class="w-4 h-4 bg-cinema-red rounded mr-2"></div> Selected</div>
                        <div class="flex items-center"><div class="w-4 h-4 bg-gray-700 rounded mr-2 opacity-50"></div> Booked</div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="w-full md:w-1/3">
                    <div class="bg-cinema-800 p-6 rounded-lg shadow-2xl border border-cinema-700 sticky top-6">
                        <h3 class="text-xl font-bold text-white mb-6 border-b border-cinema-700 pb-4">Booking Summary</h3>
                        
                        <div class="mb-4">
                            <span class="text-gray-400 block text-sm">Movie</span>
                            <span class="text-white font-bold text-lg">{{ $showtime->movie->title }}</span>
                        </div>
                        
                        <div class="mb-4">
                            <span class="text-gray-400 block text-sm">Studio</span>
                            <span class="text-white">{{ $showtime->studio->name }}</span>
                        </div>

                        <div class="mb-4">
                            <span class="text-gray-400 block text-sm">Time</span>
                            <span class="text-white">{{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M H:i') }}</span>
                        </div>

                        <div class="mb-6">
                            <span class="text-gray-400 block text-sm">Selected Seats</span>
                            <span class="text-cinema-gold font-bold text-lg" x-text="selectedSeats.length > 0 ? selectedSeats.join(', ') : '-'"></span>
                        </div>

                        <div class="flex justify-between items-center mb-8 pt-4 border-t border-cinema-700">
                            <span class="text-gray-300">Total Price</span>
                            <span class="text-2xl font-bold text-white">
                                IDR <span x-text="(selectedSeats.length * {{ $showtime->price }}).toLocaleString('id-ID')">0</span>
                            </span>
                        </div>

                        <form method="POST" action="{{ route('booking.store') }}">
                            @csrf
                            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                            <template x-for="seat in selectedSeats">
                                <input type="hidden" name="seats[]" :value="seat">
                            </template>
                            
                            <button type="submit" 
                                    :disabled="selectedSeats.length === 0"
                                    class="w-full bg-cinema-gold text-cinema-900 font-bold py-3 rounded hover:bg-yellow-400 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function seatSelector() {
            return {
                selectedSeats: [],
                toggleSeat(seat) {
                    if (this.selectedSeats.includes(seat)) {
                        this.selectedSeats = this.selectedSeats.filter(s => s !== seat);
                    } else {
                        this.selectedSeats.push(seat);
                    }
                }
            }
        }
    </script>
</x-app-layout>
