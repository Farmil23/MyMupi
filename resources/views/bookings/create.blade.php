<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-cinema3-gold leading-tight">
                    Select Seats
                </h2>
                <p class="text-sm text-white/60">
                    {{ $showtime->movie->title }}
                    <span class="mx-2">•</span>
                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M Y • H:i') }}
                    <span class="mx-2">•</span>
                    {{ $showtime->studio->name }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('movie.show', $showtime->movie->id) }}"
                   class="inline-flex items-center justify-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white
                          border border-white/10 hover:bg-white/15 transition">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    @php
        // buat aisle tengah (contoh 12 seat -> 6 | aisle | 6)
        $leftCount = (int) ceil($seatsPerRow / 2);
        $hasRightSide = $seatsPerRow > $leftCount;
        $displayRows = array_reverse($rows); // A paling bawah (back row)
    @endphp

    <div class="relative py-10" x-data="seatSelector({{ (int) $showtime->price }})">
        <!-- background vibe biar seiras -->
        <div class="absolute inset-0 bg-gradient-to-b from-cinema3-navy/25 via-cinema3-cream to-cinema3-cream"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($errors->has('error'))
                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 px-5 py-4 font-semibold">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Seat Map -->
                <div class="w-full lg:w-2/3">
                    <div class="rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 sm:p-8">

                        <!-- Screen -->
                        <div class="mb-8 text-center">
                            <div class="w-3/4 mx-auto h-2 bg-cinema3-gold shadow rounded-full mb-3"></div>
                            <div class="text-cinema3-navy/60 text-xs uppercase tracking-[0.35em] font-extrabold">
                                SCREEN (Front)
                            </div>
                        </div>

                        <!-- Seat map wrapper (scrollable kalau layar kecil) -->
                        <div class="overflow-x-auto -mx-2 px-2 pb-2">
                            <div class="min-w-[760px] mx-auto">
                                <!-- aisle dashed guide -->
                                <div class="relative inline-block mx-auto">
                                    <div class="pointer-events-none absolute inset-y-0 left-1/2 -translate-x-1/2 w-10 flex justify-center">
                                        <div class="h-full border-l border-dashed border-cinema3-navy/15"></div>
                                    </div>

                                    <div class="grid gap-4 justify-center">
                                        @foreach($displayRows as $row)
                                            <div class="flex gap-3 justify-center items-center">
                                                <!-- Row label -->
                                                <span class="text-cinema3-navy font-extrabold w-6 text-center">
                                                    {{ $row }}
                                                </span>

                                                <!-- LEFT SIDE seats -->
                                                @for($i = 1; $i <= $leftCount; $i++)
                                                    @php
                                                        $seatNum = $row.$i;
                                                        $isBooked = in_array($seatNum, $bookedSeats);
                                                    @endphp

                                                    <button
                                                        type="button"
                                                        @click="toggleSeat('{{ $seatNum }}', {{ $isBooked ? 'true' : 'false' }})"
                                                        :class="seatButtonClass('{{ $seatNum }}', {{ $isBooked ? 'true' : 'false' }})"
                                                        class="w-10 h-10 rounded-xl transition duration-200 font-extrabold text-xs sm:text-sm
                                                               border border-cinema3-navy/15"
                                                        {{ $isBooked ? 'disabled' : '' }}
                                                        title="{{ $seatNum }}{{ $isBooked ? ' (Booked)' : '' }}"
                                                    >
                                                        {{ $i }}
                                                    </button>
                                                @endfor

                                                <!-- AISLE GAP -->
                                                <div class="w-10 sm:w-12"></div>

                                                <!-- RIGHT SIDE seats -->
                                                @if($hasRightSide)
                                                    @for($i = $leftCount + 1; $i <= $seatsPerRow; $i++)
                                                        @php
                                                            $seatNum = $row.$i;
                                                            $isBooked = in_array($seatNum, $bookedSeats);
                                                        @endphp

                                                        <button
                                                            type="button"
                                                            @click="toggleSeat('{{ $seatNum }}', {{ $isBooked ? 'true' : 'false' }})"
                                                            :class="seatButtonClass('{{ $seatNum }}', {{ $isBooked ? 'true' : 'false' }})"
                                                            class="w-10 h-10 rounded-xl transition duration-200 font-extrabold text-xs sm:text-sm
                                                                   border border-cinema3-navy/15"
                                                            {{ $isBooked ? 'disabled' : '' }}
                                                            title="{{ $seatNum }}{{ $isBooked ? ' (Booked)' : '' }}"
                                                        >
                                                            {{ $i }}
                                                        </button>
                                                    @endfor
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back label -->
                        <div class="mt-6 text-center text-cinema3-navy/50 text-xs font-bold uppercase tracking-widest">
                            BACK (Row A)
                        </div>

                        <!-- Legend -->
                        <div class="mt-8 flex flex-wrap justify-center gap-x-6 gap-y-3 text-sm font-semibold text-cinema3-navy/70">
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
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-transparent border border-dashed border-cinema3-navy/30 rounded mr-2"></div>
                                Aisle
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 sm:p-7 sticky top-6">

                        <h3 class="text-xl sm:text-2xl font-extrabold text-cinema3-navy mb-6 border-b border-cinema3-navy/10 pb-4">
                            Booking Summary
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <span class="text-cinema3-navy/60 block text-sm font-semibold">Movie</span>
                                <span class="text-cinema3-navy font-extrabold text-lg">{{ $showtime->movie->title }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-cinema3-navy/60 block text-sm font-semibold">Studio</span>
                                    <span class="text-cinema3-navy font-bold">{{ $showtime->studio->name }}</span>
                                </div>
                                <div>
                                    <span class="text-cinema3-navy/60 block text-sm font-semibold">Price</span>
                                    <span class="text-cinema3-navy font-bold">
                                        IDR {{ number_format((int)$showtime->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <span class="text-cinema3-navy/60 block text-sm font-semibold">Time</span>
                                <span class="text-cinema3-navy font-bold">
                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M • H:i') }}
                                </span>
                            </div>

                            <div class="pt-4 border-t border-cinema3-navy/10">
                                <div class="flex items-center justify-between">
                                    <span class="text-cinema3-navy/60 font-semibold">Selected Seats</span>
                                    <span class="text-cinema3-navy font-extrabold" x-text="selectedSeats.length"></span>
                                </div>

                                <div class="mt-2 rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-4">
                                    <div class="text-sm font-extrabold text-cinema3-goldDark"
                                         x-text="selectedSeats.length ? selectedSeats.join(', ') : '-'"></div>
                                    <div class="text-xs text-cinema3-navy/50 mt-1">
                                        Tip: click again to unselect.
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-cinema3-navy/10">
                                <span class="text-cinema3-navy/60 font-semibold">Total</span>
                                <span class="text-2xl font-extrabold text-cinema3-navy">
                                    IDR <span x-text="total.toLocaleString('id-ID')">0</span>
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('booking.store') }}" class="mt-6">
                            @csrf
                            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">

                            <template x-for="seat in selectedSeats" :key="seat">
                                <input type="hidden" name="seats[]" :value="seat">
                            </template>

                            <button type="submit"
                                    :disabled="selectedSeats.length === 0"
                                    class="w-full rounded-2xl bg-cinema3-gold text-cinema3-navy font-extrabold py-3.5
                                           hover:bg-cinema3-goldDark transition shadow-sm
                                           disabled:opacity-50 disabled:cursor-not-allowed">
                                Confirm Booking
                            </button>
                        </form>

                        <div class="mt-4 text-xs text-cinema3-navy/50">
                            By confirming, your booking will be created and seats will be locked.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function seatSelector(price) {
            return {
                selectedSeats: [],
                total: 0,

                recalc() {
                    this.total = this.selectedSeats.length * price;
                },

                // class builder biar rapi & konsisten
                seatButtonClass(seat, booked) {
                    if (booked) {
                        return 'bg-gray-400 cursor-not-allowed opacity-60 text-white';
                    }
                    if (this.selectedSeats.includes(seat)) {
                        return 'bg-cinema3-gold text-cinema3-navy shadow-md scale-[1.06] border-cinema3-gold/60';
                    }
                    return 'bg-cinema3-cream text-cinema3-navy hover:bg-cinema3-gold hover:text-cinema3-navy hover:scale-[1.04]';
                },

                toggleSeat(seat, booked) {
                    if (booked) return;

                    if (this.selectedSeats.includes(seat)) {
                        this.selectedSeats = this.selectedSeats.filter(s => s !== seat);
                    } else {
                        this.selectedSeats.push(seat);
                        // biar rapi urut
                        this.selectedSeats.sort();
                    }
                    this.recalc();
                },

                init() {
                    this.recalc();
                }
            }
        }
    </script>
</x-app-layout>
