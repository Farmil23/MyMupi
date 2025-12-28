<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">
                My Tickets
            </h2>
            <p class="text-sm text-white/60">
                Your booking history and e-tickets.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl overflow-hidden">

                @if($bookings->count() > 0)
                    <div class="p-6 md:p-8 space-y-4">
                        @foreach($bookings as $booking)
                            @php
                                $showtime = $booking->showtime;
                                $movie = optional($showtime)->movie;
                                $studio = optional($showtime)->studio;
                                $start = optional($showtime)->start_time;

                                $poster = null;
                                if ($movie && $movie->poster) {
                                    $poster = \Illuminate\Support\Str::startsWith($movie->poster, 'http')
                                        ? $movie->poster
                                        : asset('storage/' . $movie->poster);
                                }
                            @endphp

                            <div class="group rounded-2xl border border-cinema3-navy/10 bg-white/90 shadow-sm hover:shadow-md transition overflow-hidden">
                                <div class="p-6 flex flex-col md:flex-row gap-6">

                                    <!-- Poster -->
                                    <div class="w-full md:w-40">
                                        <div class="aspect-[2/3] rounded-xl overflow-hidden bg-cinema3-cream border border-cinema3-navy/10">
                                            @if($poster)
                                                <img src="{{ $poster }}" alt="Poster" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-cinema3-navy/40 font-semibold">
                                                    No Poster
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-xl font-bold text-cinema3-navy">
                                                    {{ optional($movie)->title ?? 'Movie' }}
                                                </h3>

                                                <p class="mt-1 text-sm text-cinema3-navy/60">
                                                    {{ $start ? \Carbon\Carbon::parse($start)->format('D, d M Y • H:i') : '-' }}
                                                    • Studio: {{ optional($studio)->name ?? '-' }}
                                                </p>

                                                @if($start)
                                                    <div
                                                        class="mt-3 inline-flex items-center px-4 py-1.5 rounded-full bg-cinema3-navySoft/10 border border-cinema3-navy/10 text-sm font-semibold text-cinema3-navy countdown"
                                                        data-start="{{ \Carbon\Carbon::parse($start)->toIso8601String() }}"
                                                    >
                                                        Loading...
                                                    </div>
                                                @endif
                                            </div>

                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                                {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-cinema3-navy/10 text-cinema3-navy' }}">
                                                {{ strtoupper($booking->status) }}
                                            </span>
                                        </div>

                                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">

                                            <div class="rounded-xl bg-white border border-cinema3-navy/10 p-3">
                                                <div class="text-cinema3-navy/50 text-xs font-semibold">Seats</div>
                                                <div class="mt-1 font-bold text-cinema3-navy">
                                                    {{ $booking->bookingDetails->pluck('seat_number')->join(', ') }}
                                                </div>
                                            </div>

                                            <div class="rounded-xl bg-white border border-cinema3-navy/10 p-3">
                                                <div class="text-cinema3-navy/50 text-xs font-semibold">Total</div>
                                                <div class="mt-1 font-bold text-cinema3-navy">
                                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                </div>
                                            </div>

                                            <div class="rounded-xl bg-white border border-cinema3-navy/10 p-3 flex items-center justify-between">
                                                <div>
                                                    <div class="text-cinema3-navy/50 text-xs font-semibold">E-Ticket</div>
                                                    <div class="mt-1 text-sm text-cinema3-navy/70">View details</div>
                                                </div>

                                                <a href="{{ route('booking.success', $booking->id) }}"
                                                   class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-4 py-2 text-sm font-semibold text-cinema3-navy shadow-sm
                                                          hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 border-t border-white/30 bg-white/60">
                        {{ $bookings->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="mx-auto h-14 w-14 rounded-2xl bg-cinema3-navy/10 border border-cinema3-navy/10 flex items-center justify-center text-2xl">
                            🎟️
                        </div>

                        <h3 class="mt-4 text-xl font-extrabold text-cinema3-navy">No Tickets Found</h3>
                        <p class="mt-1 text-cinema3-navy/60">You haven't booked any movies yet.</p>

                        <a href="{{ route('home') }}"
                           class="mt-6 inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                  hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                            Book a Movie Now
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const countdownEls = document.querySelectorAll(".countdown");

            const pad = (num) => String(num).padStart(2, "0");

            function updateCountdown() {
                countdownEls.forEach(el => {
                    const startTime = new Date(el.dataset.start);
                    const now = new Date();
                    const diff = startTime - now;

                    if (diff > 0) {
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const secs = Math.floor((diff % (1000 * 60)) / 1000);
                   
                        const isUrgent = diff < 5 * 60 * 1000;
                        const textColor = isUrgent ? "text-red-600" : "text-cinema3-navy";

                        el.innerHTML = `
                            ⏳ <span class="text-cinema3-navy/60">Start in</span>
                            <span class="font-bold ml-2 ${textColor}">
                                ${pad(hours)}h ${pad(mins)}m ${pad(secs)}s
                            </span>
                        `;
                    }
                    else if (diff > -7200000) {
                        el.innerHTML = `<span class="text-green-600 font-bold">🎬 Now Playing</span>`;
                    }
                    else {
                        el.innerHTML = `<span class="text-gray-500 font-bold">✅ Finished</span>`;
                    }
                });
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
</x-app-layout>
