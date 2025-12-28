<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Showtimes</h2>
                <p class="text-sm text-white/60">Schedule and manage movie sessions.</p>
            </div>

            <a href="{{ route('admin.showtimes.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-5 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                      hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                + Add Showtime
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-cinema3-gold text-cinema3-navy px-5 py-4 font-semibold shadow-2xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Showtimes List -->
            <div class="space-y-4">
                @forelse($showtimes as $showtime)
                    @php
                        $movieTitle = optional($showtime->movie)->title ?? 'Movie Deleted';
                        $studioName = optional($showtime->studio)->name ?? 'Studio ?';
                        $start = $showtime->start_time ? \Carbon\Carbon::parse($showtime->start_time) : null;
                    @endphp

                    <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl border border-white/40 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col sm:flex-row items-center">
                        
                        <!-- Left: Date Box -->
                        <div class="w-full sm:w-32 bg-cinema3-navy/5 h-20 sm:h-auto flex flex-col items-center justify-center border-b sm:border-b-0 sm:border-r border-cinema3-navy/10 p-4">
                            @if($start)
                                <span class="text-xs font-bold text-cinema3-navy/40 uppercase tracking-widest">{{ $start->format('M') }}</span>
                                <span class="text-3xl font-black text-cinema3-navy">{{ $start->format('d') }}</span>
                                <span class="text-xs font-semibold text-cinema3-navy/60">{{ $start->format('D') }}</span>
                            @else
                                <span class="text-xs font-bold">N/A</span>
                            @endif
                        </div>

                        <!-- Middle: Details -->
                        <div class="flex-1 p-6 text-center sm:text-left">
                            <h3 class="text-lg font-black text-cinema3-navy leading-tight">{{ $movieTitle }}</h3>
                            
                            <div class="mt-2 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cinema3-gold/10 text-cinema3-goldDark text-xs font-bold ring-1 ring-cinema3-gold/30">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $start ? $start->format('H:i') : '--:--' }}
                                </span>

                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cinema3-navy/5 text-cinema3-navy/70 text-xs font-bold ring-1 ring-cinema3-navy/10">
                                    🏛️ {{ $studioName }}
                                </span>

                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold ring-1 ring-green-100">
                                    💵 IDR {{ number_format($showtime->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="p-4 sm:pr-8 flex items-center gap-3">
                            <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="h-10 w-10 flex items-center justify-center rounded-full bg-white border border-cinema3-navy/10 text-cinema3-navy hover:bg-cinema3-gold hover:text-cinema3-navy transition shadow-sm" title="Edit">
                                ✏️
                            </a>
                            
                            <form method="POST" action="{{ route('admin.showtimes.destroy', $showtime->id) }}" onsubmit="return confirm('Delete this showtime?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-600 border border-red-100 hover:bg-red-500 hover:text-white transition shadow-sm" title="Delete">
                                    🗑️
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="py-16 text-center bg-white/50 rounded-3xl border border-dashed border-cinema3-navy/20">
                        <div class="mx-auto h-16 w-16 rounded-2xl bg-cinema3-navy/5 flex items-center justify-center text-3xl mb-4">
                            🎬
                        </div>
                        <h3 class="text-xl font-bold text-cinema3-navy">No showtimes scheduled</h3>
                        <p class="text-cinema3-navy/50 mb-6">Create a schedule to start selling tickets.</p>
                        <a href="{{ route('admin.showtimes.create') }}" class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-bold text-cinema3-navy hover:bg-cinema3-goldDark transition shadow-sm">
                            + Add Showtime
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $showtimes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
