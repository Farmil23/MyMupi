@props(['booking', 'isUpcoming'])

@php
    $showtime = $booking->showtime;
    $movie = optional($showtime)->movie;
    $studio = optional($showtime)->studio;
    $posterUrl = ($movie && \Illuminate\Support\Str::startsWith($movie->poster, 'http')) ? $movie->poster : asset('storage/' . ($movie->poster ?? ''));
    $date = \Carbon\Carbon::parse($showtime->start_time);
    
    // Classes based on state
    $holoClass = $isUpcoming ? 'relative overflow-hidden' : '';
    $filterClass = $isUpcoming ? '' : 'filter grayscale contrast-75 hover:grayscale-0 hover:contrast-100 transition duration-500';
    $bgClass = $isUpcoming ? 'bg-white' : 'bg-gray-200';
    $textClass = $isUpcoming ? 'text-cinema3-navy' : 'text-gray-600';
@endphp

<div class="group w-full flex flex-col sm:flex-row rounded-3xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 {{ $filterClass }} {{ $holoClass }}">
    
    @if($isUpcoming)
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent skew-x-12 translate-x-[-150%] group-hover:animate-shine pointer-events-none z-20"></div>
    @endif
    
    <!-- LEFT: POSTER -->
    <div class="sm:w-48 h-64 sm:h-auto bg-cover bg-center rounded-t-3xl sm:rounded-l-3xl sm:rounded-tr-none relative" 
         style="background-image: url('{{ $posterUrl }}')">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent sm:bg-gradient-to-r"></div>
        <div class="absolute bottom-4 left-4 text-white sm:hidden">
            <div class="font-bold text-lg">{{ $movie->title }}</div>
        </div>
    </div>

    <!-- PERFORATION (Visual Trick) -->
    <div class="hidden sm:flex flex-col justify-between py-4 -ml-4 z-10 w-8">
        @for($i = 0; $i < 6; $i++)
            <div class="w-4 h-4 rounded-full bg-cinema3-navy mb-2"></div>
        @endfor
    </div>

    <!-- MIDDLE: DETAILS -->
    <div class="{{ $bgClass }} flex-1 p-6 sm:p-8 flex flex-col justify-between relative">
        <div>
             <div class="flex justify-between items-start">
                <div class="text-xs font-bold uppercase tracking-widest opacity-50 {{ $textClass }}">Movie Ticket</div>
                <div class="text-xs font-bold uppercase tracking-widest opacity-50 {{ $textClass }}">ID: #{{ $booking->id }}</div>
            </div>
            
            <h3 class="text-2xl sm:text-3xl font-black mt-2 leading-none {{ $textClass }}">{{ $movie->title }}</h3>
            
            <div class="mt-6 grid grid-cols-3 gap-2 sm:gap-4">
                <div class="overflow-hidden">
                    <div class="text-[10px] uppercase font-bold opacity-50 {{ $textClass }}">Date</div>
                    <div class="text-base sm:text-lg font-bold {{ $textClass }} truncate">{{ $date->format('d M') }}</div>
                </div>
                <div class="overflow-hidden">
                    <div class="text-[10px] uppercase font-bold opacity-50 {{ $textClass }}">Time</div>
                    <div class="text-base sm:text-lg font-bold {{ $textClass }} truncate">{{ $date->format('H:i') }}</div>
                </div>
                <div class="overflow-hidden">
                    <div class="text-[10px] uppercase font-bold opacity-50 {{ $textClass }}">Studio</div>
                    <div class="text-base sm:text-lg font-bold {{ $textClass }} truncate" title="{{ $studio->name }}">{{ $studio->name }}</div>
                </div>
            </div>

             <div class="mt-4">
                <div class="text-[10px] uppercase font-bold opacity-50 {{ $textClass }}">Seats</div>
                <div class="text-lg font-black tracking-wide {{ $textClass }}">
                    {{ $booking->bookingDetails->pluck('seat_number')->join(', ') }}
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-black/5 flex justify-between items-center">
             <div class="text-xs font-bold {{ $textClass }} opacity-60">Total Paid</div>
             <div class="text-xl font-black {{ $textClass }}">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- RIGHT: ACTION / BARCODE -->
    <div class="{{ $bgClass }} sm:border-l border-dashed border-black/10 p-6 sm:w-48 flex flex-row sm:flex-col items-center justify-between sm:justify-center gap-4 rounded-b-3xl sm:rounded-r-3xl sm:rounded-bl-none">
        
        <!-- Simulated Barcode -->
        <div class="h-12 sm:h-auto sm:w-full flex-1 flex items-center justify-center opacity-70">
             <div class="flex gap-0.5 h-full w-full justify-center">
                @for($b=0; $b<4; $b++)
                    <div class="w-0.5 h-full bg-black"></div><div class="w-1 h-full bg-transparent"></div><div class="w-1.5 h-full bg-black"></div>
                @endfor
             </div>
        </div>
        
        <a href="{{ route('booking.success', $booking->id) }}"
           class="w-full text-center rounded-xl bg-cinema3-navy text-cinema3-gold py-3 text-sm font-bold hover:bg-black transition shadow-lg">
            View E-Ticket
        </a>
    </div>
</div>
