<x-app-layout>
    <div class="pb-12">
        
        <!-- 1. HERO SECTION (Featured Movie) -->
        <div class="relative w-full bg-cinema3-navy overflow-hidden group h-[500px] md:h-[600px] flex items-center">
            <!-- Background Image Blurry -->
            @if($featuredMovie)
                <div class="absolute inset-0 z-0 select-none">
                    <img src="{{ Str::startsWith($featuredMovie->poster, 'http') ? $featuredMovie->poster : asset('storage/' . $featuredMovie->poster) }}" 
                         class="w-full h-full object-cover opacity-40 blur-3xl scale-125 group-hover:scale-110 transition-transform duration-[10s]">
                    <div class="absolute inset-0 bg-gradient-to-r from-cinema3-navy via-cinema3-navy/60 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-cinema3-navy via-cinema3-navy/30 to-transparent"></div>
                </div>

                <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center gap-12">
                    <!-- Poster -->
                    <div class="hidden md:block shrink-0 w-80 rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/5 rotate-2 group-hover:rotate-0 transition-all duration-700 shadow-black/50 hover:shadow-cinema3-gold/20">
                        <img src="{{ Str::startsWith($featuredMovie->poster, 'http') ? $featuredMovie->poster : asset('storage/' . $featuredMovie->poster) }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Content -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-cinema3-gold text-xs font-bold uppercase tracking-widest mb-8 backdrop-blur-md shadow-lg animate-fade-in-down">
                            🔥 Trending #1
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight leading-none mb-6 drop-shadow-2xl animate-fade-in-up">
                            {{ $featuredMovie->title }}
                        </h1>
                        <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto md:mx-0 mb-10 line-clamp-3 font-light leading-relaxed drop-shadow-md animate-fade-in-up delay-100">
                            {{ $featuredMovie->description }}
                        </p>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 animate-fade-in-up delay-200">
                            <a href="{{ route('booking.create', $featuredMovie->showtimes->first()->id ?? 0) }}" 
                               class="inline-flex items-center justify-center rounded-2xl bg-cinema3-gold px-10 py-5 text-lg font-bold text-cinema3-navy shadow-xl shadow-cinema3-gold/20 hover:bg-white hover:text-cinema3-navy hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                                Book Now
                            </a>
                            <a href="{{ route('movie.show', $featuredMovie->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-8 py-5 text-lg font-bold text-white border border-white/10 hover:bg-white/20 hover:border-white/30 transition-all backdrop-blur-md group/btn">
                                <span class="mr-3 text-xl group-hover/btn:scale-110 transition-transform">▶</span> Watch Trailer
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Fallback if no movies -->
                <div class="w-full text-center text-white/50">No movies available yet.</div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
            
            <!-- 2. STATS BENTO GRID (RESTORED V2 COLORS) -->
            <div id="stats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <!-- Welcome Card (White/Light) -->
                <div class="md:col-span-2 rounded-[2rem] bg-white/90 backdrop-blur-xl border border-white/40 shadow-xl p-8 flex flex-col justify-center relative overflow-hidden ring-1 ring-black/5">
                    <div class="absolute right-0 top-0 w-48 h-48 bg-cinema3-gold/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black text-cinema3-navy">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                        <p class="text-cinema3-navy/60 font-medium mt-3 text-lg">You've watched <span class="text-cinema3-gold font-bold">{{ $bookingsCount }} movies</span>. <br/>Ready for your next adventure?</p>
                    </div>
                </div>

                <!-- Total Tickets (Dark Navy) -->
                <div class="rounded-[2rem] bg-cinema3-navy text-white p-8 shadow-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="absolute right-0 top-0 opacity-10 text-[10rem] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-500 rotate-12">🎟️</div>
                    <div class="relative z-10">
                        <div class="text-white/60 text-xs font-bold uppercase tracking-wider mb-2">My History</div>
                        <div class="text-6xl font-black">{{ $bookingsCount }}</div>
                        <div class="text-white/60 font-medium mt-1">Movies Watched</div>
                    </div>
                </div>

                <!-- Total Spent (Gold Gradient) -->
                <div class="rounded-[2rem] bg-gradient-to-br from-cinema3-gold to-cinema3-goldDark text-cinema3-navy p-8 shadow-2xl relative overflow-hidden group hover:-translate-y-1 transition-transform">
                    <div class="absolute right-0 top-0 opacity-20 text-[10rem] -mr-10 -mt-10 group-hover:scale-110 transition-transform duration-500 -rotate-12">💎</div>
                    <div class="relative z-10">
                        <div class="text-cinema3-navy/70 text-xs font-bold uppercase tracking-wider mb-2">Total Value</div>
                        <div class="text-5xl font-black tracking-tight">
                            <span class="text-xl align-top opacity-70 font-bold mr-1">Rp</span>{{ number_format($totalSpent/1000, 0, ',', '.') }}k
                        </div>
                        <div class="text-cinema3-navy/60 font-bold mt-1">Invested in Fun</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-12">
                
                <!-- 3. NOW SHOWING (Left Column) -->
                <div class="lg:col-span-2 space-y-12">
                    
                    <!-- Now Showing Section -->
                    <div class="space-y-8">
                        <div class="flex items-center justify-between">
                            <!-- FIX: Changed text-cinema3-navy to text-white for contrast against dark gradient background -->
                            <h3 class="text-3xl font-black text-white flex items-center gap-3">
                                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 text-white text-lg shadow-lg backdrop-blur-sm border border-white/10">🎬</span>
                                Now Showing
                            </h3>
                            <a href="{{ route('home') }}" class="group flex items-center gap-1 text-sm font-bold text-cinema3-gold hover:text-white transition-all">
                                View All Movies 
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                            @foreach($nowShowing as $movie)
                                <a href="{{ route('movie.show', $movie->id) }}" class="group relative rounded-3xl overflow-hidden shadow-lg aspect-[2/3] hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 bg-cinema3-navy isolate">
                                    <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : asset('storage/' . $movie->poster) }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 group-hover:opacity-40 transition-all duration-500">
                                    
                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none p-4 text-center">
                                        <div class="transform translate-y-8 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 delay-75">
                                            <span class="inline-block px-3 py-1 bg-cinema3-gold text-cinema3-navy text-xs font-bold rounded-lg mb-3 shadow-lg">
                                                ★ {{ $movie->rating }}
                                            </span>
                                            <h4 class="text-white font-bold text-lg leading-tight mb-2 drop-shadow-md">{{ $movie->title }}</h4>
                                            <p class="text-white/70 text-xs font-semibold uppercase tracking-wider">{{ $movie->genre }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Coming Soon Section -->
                    @if($comingSoon->isNotEmpty())
                    <div class="space-y-8 pt-6">
                        <div class="flex items-center gap-3 opacity-50">
                             <div class="h-px bg-white/30 flex-1"></div>
                             <!-- FIX: Changed text color to white -->
                             <h3 class="text-xl font-bold text-white uppercase tracking-widest">Coming Soon</h3>
                             <div class="h-px bg-white/30 flex-1"></div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                             @foreach($comingSoon as $movie)
                                <a href="{{ route('movie.show', $movie->id) }}" class="relative rounded-3xl overflow-hidden shadow-inner aspect-[2/3] grayscale hover:grayscale-0 transition-all duration-700 cursor-pointer group ring-1 ring-white/10 block">
                                     <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : asset('storage/' . $movie->poster) }}" 
                                         class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold rounded-lg uppercase tracking-wider border border-white/20">Coming Soon</span>
                                    </div>
                                    <div class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                         <h4 class="text-white font-bold text-sm">{{ $movie->title }}</h4>
                                         <p class="text-white/70 text-[10px] mt-1">{{ \Carbon\Carbon::parse($movie->release_date)->format('d M Y') }}</p>
                                    </div>
                                </a>
                             @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <!-- 4. LATEST TICKET (Right Column) -->
                <div class="space-y-8">
                    <!-- FIX: Changed text color to white -->
                    <h3 class="text-2xl font-black text-white">Latest Ticket</h3>
                    
                    @if($latestBooking)
                        <!-- REALISTIC TICKET STUB (V2 Style - White Card) -->
                        <div class="relative group perspective">
                            <div class="relative rounded-[1.5rem] bg-white shadow-2xl overflow-hidden transition-transform duration-500 hover:rotate-1 hover:shadow-cinema3-navy/20">
                                <!-- Top: Movie Info -->
                                <div class="bg-cinema3-navy p-8 relative overflow-hidden">
                                    <div class="absolute -right-12 -top-12 w-48 h-48 bg-cinema3-gold rounded-full blur-[60px] opacity-40 animate-pulse"></div>
                                    
                                    <div class="flex items-center gap-3 mb-6 relative z-10">
                                         <div class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-white text-xs font-bold shadow-lg">
                                             📅 {{ \Carbon\Carbon::parse($latestBooking->showtime->start_time)->format('D, d M') }}
                                         </div>
                                         <div class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-white text-xs font-bold shadow-lg">
                                             ⏰ {{ \Carbon\Carbon::parse($latestBooking->showtime->start_time)->format('H:i') }}
                                         </div>
                                    </div>

                                    <h4 class="text-white font-black text-3xl relative z-10 leading-none drop-shadow-md">{{ $latestBooking->showtime->movie->title }}</h4>
                                </div>

                                <!-- Middle: Tear Line -->
                                <div class="relative h-8 bg-cinema3-navy">
                                    <div class="absolute top-0 left-0 w-8 h-8 rounded-full bg-cinema3-cream -mt-4 -ml-4 shadow-inner"></div>
                                    <div class="absolute top-0 right-0 w-8 h-8 rounded-full bg-cinema3-cream -mt-4 -mr-4 shadow-inner"></div>
                                    <div class="absolute top-1/2 left-6 right-6 border-b-2 border-dashed border-white/20"></div>
                                </div>

                                <!-- Bottom: Details -->
                                <div class="p-8 pt-6 bg-white relative">
                                    <div class="space-y-5">
                                        <div class="flex justify-between items-center pb-2">
                                            <span class="text-[10px] font-bold text-cinema3-navy/40 uppercase tracking-[0.2em]">Studio</span>
                                            <span class="text-lg font-black text-cinema3-navy">{{ $latestBooking->showtime->studio->name }}</span>
                                        </div>
                                        <div class="flex justify-between items-center pb-2">
                                            <span class="text-[10px] font-bold text-cinema3-navy/40 uppercase tracking-[0.2em]">Seats</span>
                                            <span class="px-3 py-1 bg-cinema3-navy/5 rounded font-bold text-cinema3-navy text-sm">
                                                {{ $latestBooking->bookingDetails->pluck('seat_number')->join(', ') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <a href="{{ route('booking.success', $latestBooking->id) }}" class="flex w-full items-center justify-center rounded-2xl bg-cinema3-navy py-4 text-sm font-bold text-white shadow-xl hover:bg-black transition-all">
                                            Open E-Ticket
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Fallback Card -->
                        <div class="rounded-[2rem] border-2 border-dashed border-white/20 bg-white/10 p-12 text-center backdrop-blur-sm hover:border-cinema3-gold/50 transition-colors">
                            <h4 class="text-white font-bold text-xl">No Active Tickets</h4>
                            <a href="{{ route('home') }}" class="inline-block mt-4 text-sm font-bold text-cinema3-gold underline">Browse Movies</a>
                        </div>
                    @endif

                    <!-- Shortcuts (White Card) -->
                    <div class="bg-white rounded-[2rem] border border-cinema3-navy/5 shadow-xl p-8">
                       <h4 class="text-[10px] font-black text-cinema3-navy mb-6 uppercase tracking-[0.2em] opacity-30">Shortcuts</h4>
                       <div class="grid grid-cols-2 gap-4">
                           <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-6 rounded-3xl bg-gray-50 hover:bg-cinema3-cream hover:scale-105 transition-all group">
                               <span class="text-3xl mb-3">👤</span>
                               <span class="text-xs font-bold text-cinema3-navy uppercase">Profile</span>
                           </a>
                            <a href="{{ url('/my-tickets') }}" class="flex flex-col items-center justify-center p-6 rounded-3xl bg-gray-50 hover:bg-cinema3-cream hover:scale-105 transition-all group">
                               <span class="text-3xl mb-3">📜</span>
                               <span class="text-xs font-bold text-cinema3-navy uppercase">History</span>
                           </a>
                       </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
