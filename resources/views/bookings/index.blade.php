<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <div>
                <h2 class="font-black text-3xl text-cinema3-gold leading-tight tracking-tight">
                    My Ticket Wallet
                </h2>
                <p class="text-sm text-white/60 font-medium">
                    Manage your upcoming shows and booking history.
                </p>
            </div>
            <div class="hidden sm:block text-right">
                <div class="text-xs text-white/40 uppercase tracking-widest font-bold">Total Spent</div>
                <div class="text-xl font-black text-white">
                    Rp {{ number_format($bookings->sum('total_price'), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($bookings->count() > 0)
                
                <!-- UPCOMING TICKETS -->
                @php
                    $upcoming = $bookings->filter(function($b) {
                        return optional($b->showtime)->start_time > now();
                    });
                    $history = $bookings->filter(function($b) {
                        return optional($b->showtime)->start_time <= now();
                    });
                @endphp

                @if($upcoming->count() > 0)
                    <div class="mb-12">
                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Upcoming Shows
                        </h3>

                        <div class="grid grid-cols-1 gap-8">
                            @foreach($upcoming as $booking)
                                <x-ticket-card :booking="$booking" :isUpcoming="true" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- TICKET HISTORY -->
                @if($history->count() > 0)
                    <div>
                        <h3 class="text-lg font-bold text-white/50 mb-6 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-white/20"></span>
                            Past History
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-80 hover:opacity-100 transition duration-500">
                            @foreach($history as $booking)
                                <x-ticket-card :booking="$booking" :isUpcoming="false" />
                            @endforeach
                        </div>
                    </div>
                @endif

            @else
                <!-- EMPTY STATE -->
                <div class="rounded-[2.5rem] bg-white/5 border border-white/10 p-16 text-center backdrop-blur-md">
                    <div class="mx-auto h-24 w-24 rounded-full bg-gradient-to-tr from-cinema3-navy to-cinema3-navySoft border border-white/10 flex items-center justify-center text-5xl shadow-2xl">
                        🎫
                    </div>
                    <h3 class="mt-8 text-3xl font-black text-white">Your Wallet is Empty</h3>
                    <p class="mt-2 text-lg text-white/50 max-w-md mx-auto">
                        You haven't booked any movies yet. Catch the latest blockbusters and fill up your collection!
                    </p>
                    <a href="{{ route('home') }}"
                       class="mt-8 inline-flex items-center justify-center rounded-2xl bg-cinema3-gold px-8 py-4 text-base font-black text-cinema3-navy shadow-lg shadow-cinema3-gold/20
                              hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition-all duration-300">
                        Browse Movies
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>

<!-- COMPONENT: TICKET CARD -->
@php
if(!function_exists('ticket_card_render')) {
    function ticket_card_render($booking, $isUpcoming) {
        $showtime = $booking->showtime;
        $movie = optional($showtime)->movie;
        $studio = optional($showtime)->studio;
        $posterUrl = ($movie && \Illuminate\Support\Str::startsWith($movie->poster, 'http')) ? $movie->poster : asset('storage/' . ($movie->poster ?? ''));
        $date = \Carbon\Carbon::parse($showtime->start_time);
        
        // Holographic sheen for upcoming
        $holoClass = $isUpcoming ? 'relative overflow-hidden' : '';
        $holoEffect = $isUpcoming ? '<div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent skew-x-12 translate-x-[-150%] group-hover:animate-shine pointer-events-none z-20"></div>' : '';
        
        // Grayscale for history
        $filterClass = $isUpcoming ? '' : 'filter grayscale contrast-75 hover:grayscale-0 hover:contrast-100 transition duration-500';
        $bgClass = $isUpcoming ? 'bg-white' : 'bg-gray-200';
        $textClass = $isUpcoming ? 'text-cinema3-navy' : 'text-gray-600';

        return "
        <div class='group w-full flex flex-col sm:flex-row rounded-3xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 {$filterClass} {$holoClass}'>
            {$holoEffect}
            
            <!-- LEFT: POSTER -->
            <div class='sm:w-48 h-64 sm:h-auto bg-cover bg-center rounded-t-3xl sm:rounded-l-3xl sm:rounded-tr-none relative' style='background-image: url(\"{$posterUrl}\")'>
                <div class='absolute inset-0 bg-gradient-to-t from-black/80 to-transparent sm:bg-gradient-to-r'></div>
                <div class='absolute bottom-4 left-4 text-white sm:hidden'>
                    <div class='font-bold text-lg'>{$movie->title}</div>
                </div>
            </div>

            <!-- PERFORATION (Visual Trick) -->
            <div class='hidden sm:flex flex-col justify-between py-4 -ml-4 z-10 w-8'>
                " . str_repeat("<div class='w-4 h-4 rounded-full bg-cinema3-navy mb-2'></div>", 6) . "
            </div>

            <!-- MIDDLE: DETAILS -->
            <div class='{$bgClass} flex-1 p-6 sm:p-8 flex flex-col justify-between relative'>
                 <!-- Serrated edge top/bottom mobile only -->
                
                <div>
                     <div class='flex justify-between items-start'>
                        <div class='text-xs font-bold uppercase tracking-widest opacity-50 {$textClass}'>Movie Ticket</div>
                        <div class='text-xs font-bold uppercase tracking-widest opacity-50 {$textClass}'>ID: #{$booking->id}</div>
                    </div>
                    
                    <h3 class='text-2xl sm:text-3xl font-black mt-2 leading-none {$textClass}'>{$movie->title}</h3>
                    
                    <div class='mt-6 grid grid-cols-3 gap-4'>
                        <div>
                            <div class='text-[10px] uppercase font-bold opacity-50 {$textClass}'>Date</div>
                            <div class='text-lg font-bold {$textClass}'>{$date->format('d M')}</div>
                        </div>
                        <div>
                            <div class='text-[10px] uppercase font-bold opacity-50 {$textClass}'>Time</div>
                            <div class='text-lg font-bold {$textClass}'>{$date->format('H:i')}</div>
                        </div>
                        <div>
                            <div class='text-[10px] uppercase font-bold opacity-50 {$textClass}'>Studio</div>
                            <div class='text-lg font-bold {$textClass}'>{$studio->name}</div>
                        </div>
                    </div>

                     <div class='mt-4'>
                        <div class='text-[10px] uppercase font-bold opacity-50 {$textClass}'>Seats</div>
                        <div class='text-lg font-black tracking-wide {$textClass}'>
                            " . $booking->bookingDetails->pluck('seat_number')->join(', ') . "
                        </div>
                    </div>
                </div>

                <div class='mt-6 pt-6 border-t border-black/5 flex justify-between items-center'>
                     <div class='text-xs font-bold {$textClass} opacity-60'>Total Paid</div>
                     <div class='text-xl font-black {$textClass}'>Rp " . number_format($booking->total_price, 0, ',', '.') . "</div>
                </div>
            </div>

            <!-- RIGHT: ACTION / BARCODE -->
            <div class='{$bgClass} sm:border-l border-dashed border-black/10 p-6 sm:w-48 flex flex-row sm:flex-col items-center justify-between sm:justify-center gap-4 rounded-b-3xl sm:rounded-r-3xl sm:rounded-bl-none'>
                
                <!-- Simulated Barcode -->
                <div class='h-12 sm:h-auto sm:w-full flex-1 flex items-center justify-center opacity-70'>
                     <div class='flex gap-0.5 h-full w-full justify-center'>
                        " . str_repeat("<div class='w-0.5 h-full bg-black'></div><div class='w-1 h-full bg-transparent'></div><div class='w-1.5 h-full bg-black'></div>", 4) . "
                     </div>
                </div>
                
                <a href='" . route('booking.success', $booking->id) . "'
                   class='w-full text-center rounded-xl bg-cinema3-navy text-cinema3-gold py-3 text-sm font-bold hover:bg-black transition shadow-lg'>
                    View E-Ticket
                </a>
            </div>
        </div>
        ";
    }
}
@endphp

<!-- Blade Component Wrapper to call the function -->
@foreach($bookings as $booking)
    <!-- This loop is just to register the component logic effectively or we can use a simpler approach. 
         Ideally, we should move the function to a Helper or a real detailed Blade component. 
         For this single file rewrite constraint, I'll inline the component call logic above in the main loop. -->
@endforeach

<style>
    @keyframes shine {
        100% {
            transform: translateX(200%) skewX(12deg);
        }
    }
    .animate-shine {
        animation: shine 2s infinite;
    }
</style>
