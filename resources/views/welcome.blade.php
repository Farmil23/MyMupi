<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MyMupi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        cinema3: {
                            navy: '#1D2A3A',
                            navySoft: '#24364C',
                            gold: '#F3C44E',
                            goldDark: '#D9A933',
                            cream: '#F6F1E7',
                            dark: '#0f172a'
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #1D2A3A; color: #F6F1E7; }
        .glass-nav { 
            background: rgba(29, 42, 58, 0.9); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid rgba(255,255,255,0.05); 
        }
        .hero-overlay {
            background: linear-gradient(to top, #1D2A3A 10%, rgba(29, 42, 58, 0.8) 50%, rgba(29, 42, 58, 0.4) 100%);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col overflow-x-hidden selection:bg-cinema3-gold selection:text-cinema3-navy">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="MyMupi Logo" class="h-12 w-auto object-contain transition-transform group-hover:scale-105">
                </a>

                <!-- Links -->
                <div class="flex items-center gap-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-white hover:text-cinema3-gold transition uppercase tracking-widest relative group">
                                Dashboard
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cinema3-gold transition-all group-hover:w-full"></span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-white hover:text-cinema3-gold transition uppercase tracking-widest">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-cinema3-gold text-cinema3-navy font-black text-sm uppercase tracking-wide hover:bg-white transition-all transform hover:-translate-y-0.5 shadow-lg shadow-cinema3-gold/20">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <!-- FIX: Increased z-index to 30 so dropdown floats ABOVE the main content -->
    <header class="relative min-h-[85vh] flex items-center justify-center overflow-visible pt-20">
        <!-- Dynamic Background -->
        @php
            $heroBg = $movies->isNotEmpty() && $movies->first()->poster 
                ? (\Illuminate\Support\Str::startsWith($movies->first()->poster, 'http') ? $movies->first()->poster : asset('storage/' . $movies->first()->poster))
                : 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=2525&auto=format&fit=crop';
        @endphp
        
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ $heroBg }}" class="w-full h-full object-cover opacity-50 contrast-125">
            <div class="absolute inset-0 hero-overlay"></div>
            <!-- Side Vignette -->
            <div class="absolute inset-0 bg-gradient-to-r from-cinema3-navy via-transparent to-cinema3-navy opacity-80"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 text-center mt-10">
            <div class="inline-block mb-6 px-4 py-1.5 rounded-full border border-cinema3-gold/30 bg-cinema3-gold/10 backdrop-blur-md animate-fade-in-up">
                <span class="text-cinema3-gold text-xs font-black uppercase tracking-[0.2em]">Premium Cinema Experience</span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black text-white leading-tight mb-6 animate-fade-in-up tracking-tight drop-shadow-2xl">
                Experience the <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cinema3-gold via-yellow-200 to-cinema3-gold">Magic of Movies</span>
            </h1>
            
            <p class="text-lg md:text-xl text-white/70 max-w-2xl mx-auto mb-12 font-medium leading-relaxed animate-fade-in-up" style="animation-delay: 0.1s;">
                Discover the latest blockbusters, book your perfect seat, and enjoy an immersive cinematic journey.
            </p>

            <!-- Search Area -->
            <!-- FIX: Ensure layout is relative so interactions work perfectly -->
            <div class="max-w-4xl mx-auto animate-fade-in-up relative z-50" style="animation-delay: 0.2s;" x-data="{ genreOpen: false, selectedGenre: '{{ request('genre') }}' }">
                <form action="{{ route('home') }}" method="GET" class="relative group">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-cinema3-gold to-yellow-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                    
                    <div class="relative bg-cinema3-navySoft border border-white/10 rounded-2xl p-2 flex flex-col sm:flex-row shadow-2xl">
                        
                        <!-- Input -->
                        <div class="flex-grow relative">
                             <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/30 pointer-events-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search for a movie..."
                                   class="w-full bg-transparent border-none text-white placeholder-white/30 text-lg font-medium focus:ring-0 pl-12 py-4">
                        </div>

                        <!-- Divider -->
                        <div class="hidden sm:block w-px bg-white/10 my-2"></div>

                        <!-- Dropdown -->
                        <div class="relative sm:w-64" @click.outside="genreOpen = false">
                             <select name="genre" x-model="selectedGenre" class="hidden">
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}">{{ $genre }}</option>
                                @endforeach
                            </select>

                            <button type="button" @click="genreOpen = !genreOpen" 
                                    class="w-full h-full text-left px-6 py-4 sm:py-0 text-white font-bold flex items-center justify-between hover:bg-white/5 transition rounded-xl">
                                <span x-text="selectedGenre || 'All Genres'" class="truncate"></span>
                                <svg class="w-4 h-4 text-cinema3-gold transition-transform duration-300" :class="{'rotate-180': genreOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="genreOpen" 
                                 x-transition.opacity.duration.200ms
                                 class="absolute top-full right-0 mt-3 w-full sm:w-64 bg-[#1a2634] border border-white/10 rounded-xl shadow-2xl py-2 z-50 max-h-60 overflow-y-auto ring-1 ring-white/5">
                                <div @click="selectedGenre = ''; genreOpen = false" class="px-5 py-3 text-white hover:bg-white/5 cursor-pointer text-sm font-medium">All Genres</div>
                                @foreach($genres as $genre)
                                    <div @click="selectedGenre = '{{ $genre }}'; genreOpen = false" class="px-5 py-3 text-white hover:bg-white/5 cursor-pointer text-sm font-medium border-t border-white/5">
                                         {{ $genre }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Button -->
                        <button type="submit" class="px-8 py-3 rounded-xl bg-cinema3-gold hover:bg-white text-cinema3-navy font-black uppercase tracking-wider transition-all">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <!-- CONTENT SECTION -->
    <!-- FIX: z-index 20 is LESS than header's 30, so specific overlays don't block the dropdown -->
    <main class="flex-grow bg-[#1D2A3A] relative z-10 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">

            <!-- Header -->
            <div class="flex items-end justify-between mb-12 border-b border-white/5 pb-6">
                <div>
                     <h2 class="text-3xl font-black text-white flex items-center gap-3">
                        <span class="text-cinema3-gold">🎬</span> Now Showing
                    </h2>
                </div>
                <div class="hidden sm:block text-white/50 font-bold text-sm">
                    {{ $movies->count() }} Movies Available
                </div>
            </div>

            <!-- Movies Grid -->
            @if($movies->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($movies as $movie)
                        <a href="{{ route('movie.show', $movie->id) }}" class="group relative block bg-cinema3-navySoft rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 ring-1 ring-white/5 hover:ring-cinema3-gold/30">
                            <!-- Image Container -->
                            <div class="aspect-[2/3] overflow-hidden relative">
                                <img src="{{ $movie->poster && \Illuminate\Support\Str::startsWith($movie->poster, 'http') ? $movie->poster : asset('storage/' . ($movie->poster ?? '')) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-cinema3-navy via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
                                
                                <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm px-2.5 py-1 rounded-lg text-cinema3-gold text-xs font-bold border border-white/10">
                                    ★ {{ $movie->rating }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <div class="text-[10px] font-bold text-cinema3-gold uppercase tracking-widest mb-1 opacity-80">
                                    {{ $movie->genre }}
                                </div>
                                <h3 class="text-lg font-bold text-white leading-tight mb-4 group-hover:text-cinema3-gold transition-colors line-clamp-1">
                                    {{ $movie->title }}
                                </h3>
                                <button class="w-full py-3 rounded-xl bg-white/5 border border-white/5 text-white text-xs font-bold uppercase tracking-wider group-hover:bg-cinema3-gold group-hover:text-cinema3-navy transition-all">
                                    Get Tickets
                                </button>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 text-white/50">
                    <div class="text-4xl mb-4">😔</div>
                    <p>No movies found. Try a different search.</p>
                </div>
            @endif

            <!-- REPLACED: Call to Action (Instead of Royal Club) -->
            @guest
            <div class="mt-24 relative rounded-[2.5rem] bg-gradient-to-br from-[#24364C] to-[#1D2A3A] border border-white/5 overflow-hidden p-10 lg:p-16 text-center shadow-2xl">
                 <div class="absolute top-0 right-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                 
                 <div class="relative z-10 max-w-3xl mx-auto">
                     <h2 class="text-3xl lg:text-5xl font-black text-white mb-6">Start Your Cinematic Journey</h2>
                     <p class="text-white/60 mb-10 text-lg">
                        Join thousands of movie lovers. Create an account to book tickets seamlessly, leave reviews, and track your watch history.
                     </p>
                     
                     <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                         <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 bg-cinema3-gold text-cinema3-navy font-bold rounded-xl hover:bg-white transition-colors shadow-lg shadow-cinema3-gold/10 uppercase tracking-widest text-sm transform hover:-translate-y-1">
                             Create Free Account
                         </a>
                         <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-4 bg-white/5 text-white border border-white/10 font-bold rounded-xl hover:bg-white/10 transition-colors uppercase tracking-widest text-sm transform hover:-translate-y-1">
                             Login
                         </a>
                     </div>
                 </div>
            </div>
            @else
            <!-- Optional: Show something else if logged in, or nothing -->
            <div class="mt-24 text-center pb-8 border-t border-white/5 pt-12">
                <p class="text-white/30 text-sm tracking-widest uppercase">You are logged in as <span class="text-cinema3-gold font-bold">{{ auth()->user()->name }}</span></p>
                 <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-white hover:text-cinema3-gold border-b border-cinema3-gold/30 hover:border-cinema3-gold transition pb-0.5">Go to Dashboard &rarr;</a>
            </div>
            @endguest

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#151f2b] border-t border-white/5 py-12 text-sm">
        <div class="max-w-7xl mx-auto px-4 text-center text-white/30">
            <div class="mb-4 flex justify-center">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto opacity-30 grayscale">
            </div>
            &copy; {{ date('Y') }} MyMupi Cinema. All rights reserved.
        </div>
    </footer>

</body>
</html>
