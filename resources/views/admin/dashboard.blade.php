<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-3xl text-cinema3-navy leading-tight">
                    Admin <span class="text-cinema3-gold">Dashboard</span>
                </h2>
                <p class="mt-1 text-sm text-cinema3-navy/60 font-medium">
                    Overview of cinema metrics and management.
                </p>
            </div>
            <div class="hidden sm:block">
                <span class="inline-flex items-center px-4 py-2 rounded-xl bg-cinema3-navy/5 text-cinema3-navy text-sm font-semibold border border-cinema3-navy/10">
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Grid Layout (Bento Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- 1. Stats Column (Left) -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Total Movies -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-md border border-white/40 shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl">
                        <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-125 transition duration-500">
                            <span class="text-8xl">🎬</span>
                        </div>
                        <div class="p-6 relative z-10">
                            <h3 class="text-sm font-bold text-cinema3-navy/50 uppercase tracking-wider">Movies</h3>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="text-4xl font-black text-cinema3-navy">{{ $totalMovies }}</span>
                                <span class="text-sm font-semibold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">+1 new</span>
                            </div>
                        </div>
                        <div class="h-1 w-full bg-gradient-to-r from-cinema3-gold to-transparent"></div>
                    </div>

                    <!-- Total Studios -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white/80 backdrop-blur-md border border-white/40 shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl">
                        <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-125 transition duration-500">
                            <span class="text-8xl">🏛️</span>
                        </div>
                         <div class="p-6 relative z-10">
                            <h3 class="text-sm font-bold text-cinema3-navy/50 uppercase tracking-wider">Studios</h3>
                            <div class="mt-2 flex items-baseline gap-2">
                                <span class="text-4xl font-black text-cinema3-navy">{{ $totalStudios }}</span>
                                <span class="text-sm font-semibold text-cinema3-navy/40">Active</span>
                            </div>
                        </div>
                        <div class="h-1 w-full bg-gradient-to-r from-cinema3-navy to-transparent"></div>
                    </div>
                </div>

                <!-- 2. Revenue & Highlight (Center-Wide) -->
                <div class="md:col-span-2 flex flex-col gap-6">
                    <!-- Revenue Card -->
                    <div class="flex-1 relative overflow-hidden rounded-3xl bg-gradient-to-br from-cinema3-navy to-cinema3-navySoft text-white shadow-2xl p-8">
                        <!-- Decorative bg -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-cinema3-gold/20 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-cinema3-gold font-bold text-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Total Revenue
                            </h3>
                            <div class="mt-4">
                                <span class="text-5xl sm:text-6xl font-black tracking-tight">
                                    <span class="text-2xl font-bold opacity-60 align-top mr-1">IDR</span>{{ number_format($totalRevenue, 0, ',', '.') }}
                                </span>
                            </div>
                             <p class="mt-4 text-white/50 text-sm max-w-sm">
                                Accumulated revenue from all ticket sales.
                            </p>
                        </div>
                    </div>

                    <!-- Active Showtimes Strip -->
                    <div class="relative overflow-hidden rounded-3xl bg-cinema3-gold text-cinema3-navy shadow-xl p-6 flex flex-row items-center justify-between">
                         <div>
                            <h3 class="text-cinema3-navySoft font-bold text-sm uppercase tracking-wide">Active Showtimes</h3>
                            <div class="text-3xl font-black">{{ $totalShowtimes }} <span class="text-lg font-bold opacity-60">sessions</span></div>
                        </div>
                         <div class="h-12 w-12 bg-white/30 rounded-full flex items-center justify-center text-xl backdrop-blur-sm">
                            ⏱️
                        </div>
                    </div>
                </div>

                <!-- 3. Quick Actions (Right) -->
                <div class="md:col-span-1 space-y-4">
                    <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-6 border border-white/40 shadow-lg h-full">
                        <h3 class="text-cinema3-navy font-extrabold text-lg mb-4">Quick Management</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('admin.movies.index') }}" class="group block p-4 rounded-2xl bg-white border border-cinema3-navy/5 shadow-sm hover:shadow-md hover:border-cinema3-gold/50 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-bold text-cinema3-navy group-hover:text-cinema3-goldDark transition">Movies</div>
                                        <div class="text-xs text-cinema3-navy/50">Catalog & Posters</div>
                                    </div>
                                    <span class="text-cinema3-navy/30 group-hover:translate-x-1 transition duration-300">→</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.showtimes.index') }}" class="group block p-4 rounded-2xl bg-white border border-cinema3-navy/5 shadow-sm hover:shadow-md hover:border-cinema3-gold/50 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-bold text-cinema3-navy group-hover:text-cinema3-goldDark transition">Schedule</div>
                                        <div class="text-xs text-cinema3-navy/50">Showtimes & Prices</div>
                                    </div>
                                    <span class="text-cinema3-navy/30 group-hover:translate-x-1 transition duration-300">→</span>
                                </div>
                            </a>
                            
                             <a href="{{ route('admin.studios.index') }}" class="group block p-4 rounded-2xl bg-white border border-cinema3-navy/5 shadow-sm hover:shadow-md hover:border-cinema3-gold/50 transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-bold text-cinema3-navy group-hover:text-cinema3-goldDark transition">Studios</div>
                                        <div class="text-xs text-cinema3-navy/50">Seats & Layouts</div>
                                    </div>
                                    <span class="text-cinema3-navy/30 group-hover:translate-x-1 transition duration-300">→</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Detailed Tables Section -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Recent Sales -->
                <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-white/40 shadow-xl overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-cinema3-navy/5 flex justify-between items-center bg-white/50">
                        <h3 class="font-bold text-cinema3-navy text-lg flex items-center gap-2">
                            <span>🎟️</span> Recent Sales
                        </h3>
                        <div class="text-xs font-semibold text-cinema3-navy/50 bg-cinema3-navy/5 px-2 py-1 rounded-lg">
                            Last 5
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-cinema3-navy/5 text-cinema3-navy/60 uppercase text-xs font-bold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Movie</th>
                                    <th class="px-6 py-4 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-cinema3-navy/5">
                                @forelse($recentBookings as $booking)
                                    <tr class="hover:bg-cinema3-gold/5 transition duration-150">
                                        <td class="px-6 py-4 font-semibold text-cinema3-navy">
                                            {{ $booking->user->name ?? 'Guest' }}
                                            <div class="text-xs font-normal text-cinema3-navy/50">{{ $booking->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-cinema3-navy font-medium line-clamp-1">{{ $booking->showtime->movie->title ?? 'Unknown' }}</div>
                                            <div class="text-xs text-cinema3-navy/50">
                                                {{ $booking->bookingDetails->count() }} seats
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-cinema3-navy">
                                            IDR {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-cinema3-navy/40 italic">
                                            No sales yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Upcoming Schedule -->
                <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-white/40 shadow-xl overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-cinema3-navy/5 flex justify-between items-center bg-white/50">
                        <h3 class="font-bold text-cinema3-navy text-lg flex items-center gap-2">
                            <span>🕒</span> Upcoming Schedule
                        </h3>
                         <a href="{{ route('admin.showtimes.index') }}" class="text-xs font-bold text-cinema3-goldDark hover:underline">
                            View All →
                        </a>
                    </div>

                    <div class="p-0">
                        @forelse($upcomingShowtimes as $showtime)
                            <div class="flex items-center gap-4 p-4 border-b border-cinema3-navy/5 last:border-0 hover:bg-cinema3-gold/5 transition duration-150">
                                <!-- Time Box -->
                                <div class="flex-shrink-0 w-16 text-center rounded-xl bg-cinema3-navy/5 border border-cinema3-navy/10 p-2">
                                    <div class="text-xs font-bold text-cinema3-navy/50 uppercase">{{ \Carbon\Carbon::parse($showtime->start_time)->format('M') }}</div>
                                    <div class="text-xl font-black text-cinema3-navy">{{ \Carbon\Carbon::parse($showtime->start_time)->format('d') }}</div>
                                    <div class="text-xs font-bold text-cinema3-navy/60">{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</div>
                                </div>
                                
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-cinema3-navy font-bold truncate">{{ $showtime->movie->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-cinema3-gold/20 text-cinema3-navy border border-cinema3-gold/30">
                                            {{ $showtime->studio->name }}
                                        </span>
                                        <span class="text-xs text-cinema3-navy/40">
                                            IDR {{ number_format($showtime->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                             <div class="p-8 text-center text-cinema3-navy/40 italic">
                                No upcoming showtimes today.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
            
            <!-- Additional Stats Row -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6 opacity-80">
                <div class="rounded-2xl border border-cinema3-navy/10 bg-white/50 p-4 flex items-center justify-between">
                    <span class="text-sm font-semibold text-cinema3-navy/60">Total Tickets Sold</span>
                    <span class="text-xl font-black text-cinema3-navy">{{ $totalTickets }}</span>
                </div>
                 <div class="rounded-2xl border border-cinema3-navy/10 bg-white/50 p-4 flex items-center justify-between">
                    <span class="text-sm font-semibold text-cinema3-navy/60">Avg. Ticket Price</span>
                    @php
                        $avgPrice = $totalTickets > 0 ? $totalRevenue / $totalTickets : 0;
                    @endphp
                    <span class="text-xl font-black text-cinema3-navy">
                        {{ number_format($avgPrice, 0, ',', '.') }}
                    </span>
                </div>
                 <div class="rounded-2xl border border-cinema3-navy/10 bg-white/50 p-4 flex items-center justify-between">
                    <span class="text-sm font-semibold text-cinema3-navy/60">System Status</span>
                    <span class="text-sm font-bold text-green-600 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Online
                    </span>
                </div>
            </div>
    </div>
</x-app-layout>
