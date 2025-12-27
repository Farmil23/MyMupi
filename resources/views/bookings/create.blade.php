<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema3-gold leading-tight">
            Select Seats for {{ $showtime->movie->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema3-cream min-h-screen" x-data="seatSelector()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">

                <!-- Seat Map -->
                <div class="w-full md:w-2/3 bg-white p-8 rounded-xl shadow-lg border border-cinema3-navy/10">
                    
                    <!-- Screen -->
                    <div class="mb-10 text-center">
                        <div class="w-2/3 mx-auto h-2 bg-cinema3-gold shadow rounded-full mb-4"></div>
                        <span class="text-cinema3-navy/60 text-sm uppercase tracking-widest font-semibold">
                            SCREEN
                        </span>
                    </div>

                    <!-- Seats -->
                    <div class="grid gap-4 justify-center">
                        @foreach($rows as $row)
                            <div class="flex gap-4 justify-center items-center">
                                <span class="text-cinema3-navy font-bold w-6 text-center">
                                    {{ $row }}
                                </span>

                                @for($i = 1; $i <= $seatsPerRow; $i++)
                                    @php 
                                        $seatNum = $row.$i;
                                        $isBooked = in_array($seatNum, $bookedSeats);
                                    @endphp

                                    <button 
                                        @click="toggleSeat('{{ $seatNum }}')"
                                        :class="{
                                            'bg-gray-400 cursor-not-allowed opacity-60 text-white': {{ $isBooked ? 'true' : 'false' }},
                                            'bg-cinema3-gold text-cinema3-navy shadow-md scale-110': selectedSeats.includes('{{ $seatNum }}'),
                                            'bg-cinema3-cream border border-cinema3-navy/20 text-cinema3-navy hover:bg-cinema3-gold hover:text-cinema3-navy': !selectedSeats.includes('{{ $seatNum }}') && !{{ $isBooked ? 'true' : 'false' }}
                                        }"
                                        class="w-10 h-10 rounded-lg transition duration-200 font-bold text-xs"
                                        {{ $isBooked ? 'disabled' : '' }}>
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                        @endforeach
                    </div>

                    <!-- Legend -->
                    <div class="mt-12 flex justify-center space-x-6 text-sm font-semibold text-cinema3-navy/70">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-cinema3-cream border border-cinema3-navy/20 rounded mr-2"></div>
                            Available
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-cinema3-gold rounded mr-2"></div>
                            Selected
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-gray-400 rounded mr-2 opacity-60"></div>
                            Booked
                        </div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="w-full md:w-1/3">
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-cinema3-navy/10 sticky top-6">

                        <h3 class="text-2xl font-bold text-cinema3-navy mb-6 border-b border-cinema3-navy/10 pb-4">
                            Booking Summary
                        </h3>
                        
                        <div class="mb-4">
                            <span class="text-cinema3-navy/60 block text-sm font-semibold">Movie</span>
                            <span class="text-cinema3-navy font-bold text-lg">{{ $showtime->movie->title }}</span>
                        </div>
                        
                        <div class="mb-4">
                            <span class="text-cinema3-navy/60 block text-sm font-semibold">Studio</span>
                            <span class="text-cinema3-navy font-bold">{{ $showtime->studio->name }}</span>
                        </div>

                        <div class="mb-4">
                            <span class="text-cinema3-navy/60 block text-sm font-semibold">Time</span>
                            <span class="text-cinema3-navy font-bold">
                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M H:i') }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <span class="text-cinema3-navy/60 block text-sm font-semibold">Selected Seats</span>
                            <span class="text-cinema3-goldDark font-bold text-lg"
                                  x-text="selectedSeats.length > 0 ? selectedSeats.join(', ') : '-'">
                            </span>
                        </div>

                        <div class="flex justify-between items-center mb-8 pt-4 border-t border-cinema3-navy/10">
                            <span class="text-cinema3-navy/60 font-semibold">Total Price</span>
                            <span class="text-2xl font-bold text-cinema3-navy">
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
                                    class="w-full bg-cinema3-gold text-cinema3-navy font-bold py-3 rounded-lg hover:bg-cinema3-goldDark transition disabled:opacity-50 disabled:cursor-not-allowed">
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
