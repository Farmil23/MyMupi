<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 h-10 w-10 rounded-2xl bg-emerald-500/15 border border-emerald-400/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-emerald-400 leading-tight">
                        Booking Successful!
                    </h2>
                    <p class="text-sm text-white/60">
                        Your ticket is ready. You can print it or view it later in My Tickets.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('booking.index') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white
                          border border-white/10 hover:bg-white/15 transition">
                    My Tickets
                </a>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white
                          border border-white/10 hover:bg-white/15 transition">
                    Back Home
                </a>
                <button onclick="window.print()"
                        class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-4 py-2 text-sm font-extrabold text-cinema3-navy
                               hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Ticket
                </button>
            </div>
        </div>
    </x-slot>

    @php
        $movie = $booking->showtime->movie;
        $showtime = $booking->showtime;

        $poster = $movie->poster ?? '';
        $posterUrl = null;
        if (!empty($poster)) {
            $posterUrl = \Illuminate\Support\Str::startsWith($poster, 'http')
                ? $poster
                : asset('storage/' . ltrim($poster, '/'));
        }
        $posterFallback = 'https://via.placeholder.com/600x900/1D2A3A/F3C44E?text=' . urlencode($movie->title);

        $seats = $booking->bookingDetails->pluck('seat_number')->sort()->values()->join(', ');
        $totalPaid = (int) ($booking->total_price ?? 0); // FIX: pakai total_price
        $totalPaidText = 'IDR ' . number_format($totalPaid, 0, ',', '.');

        $dateTime = \Carbon\Carbon::parse($showtime->start_time)->format('D, d M Y • H:i');
        $paymentMethod = strtoupper($booking->payment_method ?? 'QRIS');
        $status = ucfirst($booking->status ?? 'paid');

        // booking code biar keren (fake, tapi konsisten)
        $ticketCode = strtoupper(substr(md5('MYMUPI|' . $booking->id . '|' . $booking->user_id), 0, 10));

        // ===== Fake QR generator (SVG) =====
        $qrSeed = 'MYMUPI|BOOKING|' . $booking->id . '|' . $booking->user_id . '|' . ($showtime->id ?? '-') . '|' . $seats;
        $hex = '';
        for ($i = 0; $i < 40; $i++) { $hex .= md5($qrSeed . '|' . $i); } // banyakin biar cukup
        $hexLen = strlen($hex);

        $qrSize = 29;     // grid modules
        $quiet  = 4;      // margin
        $module = 4;      // px per module
        $svgSize = ($qrSize + $quiet*2) * $module;
        $hexPos = 0;

        $inFinder = function($r, $c, $top, $left) {
            return ($r >= $top && $r < $top + 7 && $c >= $left && $c < $left + 7);
        };

        $finderIsDark = function($r, $c, $top, $left) {
            $dr = $r - $top;
            $dc = $c - $left;

            // outer 7x7 border black
            if ($dr === 0 || $dr === 6 || $dc === 0 || $dc === 6) return true;

            // inner border white
            if ($dr === 1 || $dr === 5 || $dc === 1 || $dc === 5) return false;

            // center 3x3 black
            return ($dr >= 2 && $dr <= 4 && $dc >= 2 && $dc <= 4);
        };

        $isInAnyFinder = function($r, $c) use ($inFinder) {
            return $inFinder($r,$c,0,0) || $inFinder($r,$c,0,($GLOBALS['qrSize'] ?? 29) - 7) || $inFinder($r,$c,($GLOBALS['qrSize'] ?? 29) - 7,0);
        };
        // Note: $GLOBALS trick di atas biar aman, tapi kita gak pakai $isInAnyFinder untuk hitung; kita cek manual di loop.
    @endphp

    <style>
        @media print {
            nav, header { display: none !important; }
            body { background: white !important; }
            .print-area { padding: 0 !important; }
            .no-print { display: none !important; }
            .ticket-wrap { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        }
    </style>

    <div class="relative py-10 print-area">
        <div class="absolute inset-0 bg-gradient-to-b from-cinema3-navy/25 via-cinema3-cream to-cinema3-cream"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="ticket-wrap rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl overflow-hidden">

                <!-- Top banner -->
                <div class="relative bg-gradient-to-r from-cinema3-navy to-cinema3-navySoft px-8 py-8 text-center">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-4 py-2">
                        <span class="text-cinema3-gold font-extrabold tracking-[0.35em] uppercase">Movie Ticket</span>
                    </div>

                    <div class="mt-3 text-white/70 text-sm font-semibold">
                        Booking ID: <span class="text-white font-extrabold">#{{ $booking->id }}</span>
                        <span class="mx-2">•</span>
                        Code: <span class="text-cinema3-gold font-extrabold">{{ $ticketCode }}</span>
                    </div>

                    <!-- soft glow -->
                    <div class="pointer-events-none absolute -top-20 left-1/2 -translate-x-1/2 h-44 w-44 rounded-full bg-cinema3-gold/15 blur-3xl"></div>
                </div>

                <!-- Ticket body -->
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                        <!-- Poster -->
                        <div class="md:col-span-4">
                            <div class="rounded-2xl overflow-hidden shadow-lg border border-cinema3-navy/10 bg-cinema3-cream">
                                <img
                                    src="{{ $posterUrl ?: $posterFallback }}"
                                    alt="{{ $movie->title }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <div class="mt-4 rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-4">
                                <div class="text-xs text-cinema3-navy/60 font-semibold uppercase tracking-widest">Status</div>
                                <div class="mt-1 flex items-center justify-between">
                                    <span class="font-extrabold text-cinema3-navy">{{ $status }}</span>
                                    <span class="text-xs font-extrabold text-cinema3-goldDark bg-cinema3-gold/20 border border-cinema3-gold/30 px-2 py-1 rounded-full">
                                        {{ $paymentMethod }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Info + QR -->
                        <div class="md:col-span-8">
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-cinema3-navy">
                                    {{ $movie->title }}
                                </h2>
                                <p class="text-cinema3-navy/60 font-semibold">
                                    {{ $movie->genre }}
                                </p>
                            </div>

                            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-b border-cinema3-navy/10 py-5">
                                <div>
                                    <div class="text-xs text-cinema3-navy/50 uppercase tracking-widest font-bold">Studio</div>
                                    <div class="mt-1 text-cinema3-navy font-extrabold">{{ $showtime->studio->name }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-cinema3-navy/50 uppercase tracking-widest font-bold">Date & Time</div>
                                    <div class="mt-1 text-cinema3-navy font-extrabold">{{ $dateTime }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-cinema3-navy/50 uppercase tracking-widest font-bold">Seats</div>
                                    <div class="mt-1 text-cinema3-navy font-extrabold">{{ $seats }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-cinema3-navy/50 uppercase tracking-widest font-bold">Total Paid</div>
                                    <div class="mt-1 text-cinema3-goldDark font-extrabold">{{ $totalPaidText }}</div>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                                <!-- QR -->
                                <div class="text-center">
                                    <div class="inline-block rounded-2xl bg-white border border-cinema3-navy/10 shadow-sm p-4">
                                        <svg width="{{ $svgSize }}" height="{{ $svgSize }}" viewBox="0 0 {{ $svgSize }} {{ $svgSize }}" role="img" aria-label="Fake QR Code">
                                            <rect x="0" y="0" width="{{ $svgSize }}" height="{{ $svgSize }}" fill="#ffffff"/>
                                            @for ($r = -$quiet; $r < $qrSize + $quiet; $r++)
                                                @for ($c = -$quiet; $c < $qrSize + $quiet; $c++)
                                                    @php
                                                        $x = ($c + $quiet) * $module;
                                                        $y = ($r + $quiet) * $module;

                                                        $dark = false;

                                                        // outside main grid -> keep white
                                                        if ($r < 0 || $c < 0 || $r >= $qrSize || $c >= $qrSize) {
                                                            $dark = false;
                                                        } else {
                                                            // finder patterns: TL, TR, BL
                                                            $isTL = ($r < 7 && $c < 7);
                                                            $isTR = ($r < 7 && $c >= $qrSize - 7);
                                                            $isBL = ($r >= $qrSize - 7 && $c < 7);

                                                            if ($isTL) {
                                                                $dark = $finderIsDark($r,$c,0,0);
                                                            } elseif ($isTR) {
                                                                $dark = $finderIsDark($r,$c,0,$qrSize-7);
                                                            } elseif ($isBL) {
                                                                $dark = $finderIsDark($r,$c,$qrSize-7,0);
                                                            } else {
                                                                // pseudo-random deterministic based on seed
                                                                $val = hexdec($hex[$hexPos % $hexLen]);
                                                                $hexPos++;
                                                                // bikin pola lumayan "QR-ish"
                                                                $dark = ((($val + $r + $c) % 3) === 0);
                                                            }
                                                        }
                                                    @endphp

                                                    @if($dark)
                                                        <rect x="{{ $x }}" y="{{ $y }}" width="{{ $module }}" height="{{ $module }}" fill="#1D2A3A"/>
                                                    @endif
                                                @endfor
                                            @endfor
                                        </svg>
                                    </div>
                                    <p class="mt-2 text-xs text-cinema3-navy/60 font-semibold">
                                        Scan this at the entrance
                                    </p>
                                </div>

                                <!-- Notes -->
                                <div class="rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-5">
                                    <div class="text-xs text-cinema3-navy/50 uppercase tracking-widest font-bold">Important</div>
                                    <ul class="mt-2 text-sm text-cinema3-navy/75 space-y-2 font-semibold">
                                        <li>• Arrive 10–15 minutes before showtime.</li>
                                        <li>• Seats are locked after booking confirmation.</li>
                                        <li>• Show this ticket (or print) at the entrance.</li>
                                    </ul>

                                    <div class="mt-4 rounded-xl bg-white border border-cinema3-navy/10 px-4 py-3">
                                        <div class="text-xs text-cinema3-navy/50 uppercase tracking-widest font-bold">Ticket Code</div>
                                        <div class="mt-1 text-cinema3-navy font-extrabold tracking-widest text-lg">
                                            {{ $ticketCode }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perforation + footer -->
                <div class="relative bg-cinema3-cream p-4 border-t border-dashed border-cinema3-navy/20">
                    <!-- tear circles -->
                    <div class="absolute left-0 top-0 -translate-x-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-cinema3-cream"></div>
                    <div class="absolute right-0 top-0 translate-x-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-cinema3-cream"></div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('home') }}"
                           class="text-cinema3-navy font-extrabold hover:text-cinema3-goldDark transition">
                            ← Back to Home
                        </a>

                        <a href="{{ route('booking.index') }}"
                           class="text-cinema3-navy font-extrabold hover:text-cinema3-goldDark transition">
                            View in My Tickets →
                        </a>
                    </div>
                </div>

            </div>

            <div class="no-print mt-6 text-center text-xs text-cinema3-navy/50">
                Tip: Click <span class="font-bold">Print Ticket</span> for a cleaner printable layout.
            </div>
        </div>
    </div>
</x-app-layout>
