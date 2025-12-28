<x-app-layout>
    <div class="relative min-h-screen bg-cinema3-navy" x-data="{ selectedDate: '{{ now()->format('Y-m-d') }}' }">
        
        <!-- 1. IMMERSIVE BACKDROP (Fixed) -->
        <div class="fixed inset-0 z-0 pointer-events-none">
             @php
                $posterUrl = \Illuminate\Support\Str::startsWith($movie->poster, 'http') 
                    ? $movie->poster 
                    : asset('storage/' . $movie->poster);
            @endphp
            <img src="{{ $posterUrl }}" class="w-full h-full object-cover opacity-20 blur-[100px] scale-125">
            <div class="absolute inset-0 bg-gradient-to-t from-cinema3-navy via-cinema3-navy/80 to-transparent"></div>
            <div class="absolute inset-0 bg-cinema3-navy/30 mix-blend-multiply"></div>
        </div>

        <!-- 2. MAIN CONTENT -->
        <div class="relative z-10 pt-20 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- BREADCRUMB & BACK -->
                <nav class="flex items-center gap-4 mb-8 text-sm font-medium text-white/50">
                    <a href="{{ route('home') }}" class="hover:text-cinema3-gold transition-colors">Movies</a>
                    <span>/</span>
                    <span class="text-white">{{ $movie->title }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    
                    <!-- LEFT COLUMN: POSTER (Floating) -->
                    <div class="lg:col-span-4 sticky top-24">
                        <div class="relative group perspective-1000">
                            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-[8px] border-white/5 transition-transform duration-700 transform group-hover:rotate-y-6 group-hover:rotate-x-6 shadow-black/50">
                                <img src="{{ $posterUrl }}" class="w-full h-auto object-cover shadow-inner">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                            <!-- Reflection/Glow -->
                            <div class="absolute -inset-4 bg-cinema3-gold/20 blur-3xl rounded-full -z-10 opacity-0 group-hover:opacity-40 transition-opacity duration-700"></div>
                        </div>

                        <!-- TRAILER BUTTON (Mobile/Desktop) -->
                        @if(!empty($movie->trailer_url))
                            <a href="{{ $movie->trailer_url }}" target="_blank" class="mt-8 w-full group relative flex items-center justify-center gap-3 rounded-2xl bg-white/5 border border-white/10 px-6 py-4 text-white font-bold backdrop-blur-md hover:bg-white/10 hover:border-white/20 transition-all overflow-hidden cursor-pointer">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <span class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white pl-1 shadow-lg group-hover:scale-110 transition-transform">▶</span>
                                <span>Watch Trailer</span>
                            </a>
                        @else
                            <button class="mt-8 w-full group relative flex items-center justify-center gap-3 rounded-2xl bg-white/5 border border-white/10 px-6 py-4 text-white/50 font-bold backdrop-blur-md cursor-not-allowed">
                                <span class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white/30 pl-1">▶</span>
                                <span>No Trailer Available</span>
                            </button>
                        @endif
                    </div>

                    <!-- RIGHT COLUMN: DETAILS & BOOKING -->
                    <div class="lg:col-span-8 space-y-12">
                        
                        <!-- HEADER INFO -->
                        <div class="space-y-6">
                            <div class="flex flex-wrap items-center gap-3 text-xs font-bold tracking-widest uppercase text-cinema3-gold mb-2">
                                <span class="bg-cinema3-gold/10 border border-cinema3-gold/20 px-3 py-1 rounded-lg backdrop-blur-sm">{{ $movie->genre }}</span>
                                <span class="text-white/40">•</span>
                                <span class="text-white/60">{{ (int)$movie->duration_minutes }} MIN</span>
                                <span class="text-white/40">•</span>
                                <span class="text-white/60">{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                            </div>
                            
                            <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tight drop-shadow-xl">
                                {{ $movie->title }}
                            </h1>

                            <div class="flex items-center gap-6 text-white/80">
                                <div class="flex items-center gap-2">
                                    <span class="text-3xl text-cinema3-gold">★</span>
                                    <span class="text-2xl font-bold">{{ number_format($movie->rating, 1) }}</span>
                                    <span class="text-sm opacity-50 self-end mb-1">/ 10</span>
                                </div>
                                <div class="h-8 w-px bg-white/10"></div>
                                <div>
                                    <div class="text-xs opacity-50 uppercase tracking-widest">Director</div>
                                    <div class="font-bold">Christopher Nolan</div> <!-- Placeholder if no data -->
                                </div>
                            </div>
                        </div>

                        <!-- SYNOPSIS -->
                        <div class="prose prose-lg prose-invert text-white/70 leading-relaxed max-w-none">
                            <h3 class="text-white font-bold text-xl mb-3 flex items-center gap-2">
                                <span class="w-1 h-6 bg-cinema3-gold rounded-full"></span>
                                Synopsis
                            </h3>
                            <p>{{ $movie->synopsis ?? $movie->description }}</p>
                        </div>

                        <!-- BOOKING SECTION -->
                        <div id="booking" class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-cinema3-gold/5 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
                            
                            <h3 class="text-2xl font-black text-white mb-8 flex items-center gap-3">
                                🎟️ Get Your Tickets
                            </h3>

                            @if($movie->showtimes->count() > 0)
                                <!-- SHOWTIMES GRID -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($movie->showtimes as $showtime)
                                        <a href="{{ route('booking.create', $showtime->id) }}" 
                                           class="group relative flex flex-col justify-center p-5 rounded-2xl bg-white/5 border border-white/10 hover:bg-cinema3-gold hover:border-cinema3-gold transition-all duration-300">
                                            
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-lg font-black text-white group-hover:text-cinema3-navy">
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                                </span>
                                                <span class="text-xs font-bold px-2 py-1 rounded bg-white/10 text-white group-hover:bg-cinema3-navy/10 group-hover:text-cinema3-navy uppercase tracking-wider">
                                                    {{ $showtime->studio->name }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex justify-between items-end border-t border-white/10 pt-3 group-hover:border-cinema3-navy/10">
                                                <div class="text-xs text-white/50 group-hover:text-cinema3-navy/60">
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M') }}
                                                </div>
                                                <div class="font-bold text-cinema3-gold group-hover:text-cinema3-navy">
                                                    Rp {{ number_format($showtime->price, 0, ',', '.') }}
                                                </div>
                                            </div>

                                            <!-- Hover Arrow -->
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all font-black text-cinema3-navy text-2xl">
                                                →
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="text-4xl mb-4 opacity-50">📅</div>
                                    <h4 class="text-white font-bold text-lg">No Showtimes Available</h4>
                                    <p class="text-white/50 text-sm mt-2">Check back later for updates.</p>
                                </div>
                            @endif
                        </div>

                        <!-- REVIEWS SECTION -->
                        <div class="border-t border-white/10 pt-12">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-2xl font-black text-white flex items-center gap-3">
                                    💬 Fan Reviews 
                                    <span class="text-sm font-normal text-white/40 bg-white/10 px-2 py-0.5 rounded-full">{{ $movie->reviews->count() }}</span>
                                </h3>
                                
                                @auth
                                    @if(!$movie->reviews->where('user_id', auth()->id())->count())
                                    <button onclick="document.getElementById('review-form').classList.toggle('hidden')" 
                                            class="text-sm font-bold text-cinema3-gold hover:text-white transition-colors underline decoration-2 underline-offset-4">
                                        + Write a Review
                                    </button>
                                    @endif
                                @endauth
                            </div>

                            <!-- REVIEW FORM (Hidden by default) -->
                            <div id="review-form" class="hidden mb-10 bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">
                                <form action="{{ route('movie.review.store', $movie) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div x-data="{ rating: 0, hover: 0 }">
                                        <label class="block text-sm font-bold text-white mb-2">Your Rating</label>
                                        <input type="hidden" name="rating" :value="rating">
                                        <div class="flex gap-2">
                                            @foreach(range(1,5) as $i)
                                                <button type="button" @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0" @click="rating = {{ $i }}"
                                                        class="text-2xl transition-transform hover:scale-110"
                                                        :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-cinema3-gold' : 'text-gray-600'">
                                                    ★
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-white mb-2">Review</label>
                                        <textarea name="review" rows="3" class="w-full bg-black/20 border border-white/10 rounded-xl p-4 text-white placeholder-white/30 focus:border-cinema3-gold focus:ring-1 focus:ring-cinema3-gold outline-none transition" placeholder="What did you think?"></textarea>
                                    </div>
                                    <button type="submit" class="bg-cinema3-gold text-cinema3-navy font-bold px-6 py-3 rounded-xl hover:bg-white transition-colors">Submit Review</button>
                                </form>
                            </div>

                            <!-- REVIEWS LIST -->
                            <div class="space-y-6">
                                @forelse($movie->reviews as $review)
                                    <div class="bg-white/5 border border-white/5 rounded-2xl p-6 hover:bg-white/10 transition duration-300">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cinema3-gold to-orange-500 flex items-center justify-center text-cinema3-navy font-black text-sm">
                                                    {{ substr($review->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-white font-bold text-sm">{{ $review->user->name }}</div>
                                                    <div class="text-white/30 text-[10px] uppercase font-bold tracking-wide">{{ $review->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            <div class="flex text-cinema3-gold text-sm gap-0.5">
                                                @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                            </div>
                                        </div>
                                        <p class="text-white/70 text-sm leading-relaxed italic">"{{ $review->review }}"</p>
                                    </div>
                                @empty
                                    <div class="text-white/30 text-center py-8 italic font-light">No reviews yet. Be the first to share your thoughts!</div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
