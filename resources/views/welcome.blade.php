<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'MyMupi') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- CINEMA3 COLORS -->
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
                                dark: '#111827'
                            }
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { background-color: #F6F1E7; color: #1D2A3A; }
            .glass {
                background: rgba(36, 54, 76, 0.8);
                backdrop-filter: blur(10px);
            }
        </style>
    </head>

    <body class="antialiased min-h-screen flex flex-col bg-cinema3-cream text-cinema3-navy">

        <!-- Navigation -->
        <nav class="border-b border-white/10 bg-cinema3-navy/90 backdrop-blur-md fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">

                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-cinema3-gold tracking-wide">
                            MyMupi
                        </a>
                    </div>

                    <!-- Links -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white hover:text-cinema3-gold transition font-medium">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-cinema3-gold transition font-medium">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-cinema3-gold text-cinema3-navy px-4 py-2 rounded font-bold hover:bg-cinema3-goldDark transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-cinema3-navy to-cinema3-navySoft">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-8 text-white">
                    Discover Your Next <span class="text-cinema3-gold">obsession</span>
                </h1>
                
                <!-- Search & Filter Form -->
                <div class="max-w-3xl mx-auto">
                    <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-4">

                        <!-- Search input -->
                        <div class="flex-grow relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search for movies..." 
                                class="w-full bg-white border border-cinema3-navy/20 rounded-lg py-4 px-6 text-cinema3-navy placeholder-gray-400 focus:ring-2 focus:ring-cinema3-gold text-lg">
                            <svg class="w-6 h-6 absolute right-4 top-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        <!-- Genre select -->
                        <div class="md:w-1/4">
                            <select name="genre" onchange="this.form.submit()" 
                                class="w-full h-full bg-white border border-cinema3-navy/20 rounded-lg py-4 px-6 text-cinema3-navy focus:ring-2 focus:ring-cinema3-gold cursor-pointer text-lg appearance-none">
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Button search -->
                        <button type="submit" class="hidden md:block bg-cinema3-gold text-cinema3-navy font-bold py-4 px-8 rounded-lg hover:bg-cinema3-goldDark transition">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Movie Grid -->
        <div class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">

            @if(request('search') || request('genre'))
                <div class="mb-8 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-cinema3-navy">
                        Search Results
                        @if(request('search')) for "<span class="font-bold">{{ request('search') }}</span>" @endif
                        @if(request('genre')) in <span class="text-cinema3-gold font-bold">{{ request('genre') }}</span> @endif
                    </h2>
                    <a href="{{ route('home') }}" class="text-cinema3-navySoft hover:underline text-sm font-semibold">
                        Clear Filters
                    </a>
                </div>
            @else
                <h2 class="text-2xl font-bold text-cinema3-navy mb-8 border-l-4 border-cinema3-gold pl-4">
                    Now Showing
                </h2>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($movies as $movie)

                    <!-- Card -->
                    <div class="group relative bg-white rounded-xl overflow-hidden shadow-lg border border-cinema3-navy/10 hover:border-cinema3-gold transition duration-300 transform hover:-translate-y-2">
                        
                        <!-- Poster -->
                        <div class="aspect-[2/3] overflow-hidden bg-cinema3-cream relative">
                            <a href="{{ route('movie.show', $movie->id) }}" class="block w-full h-full">

                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                                        No Poster
                                    </div>
                                @endif
                                
                                <!-- Rating Badge -->
                                <div class="absolute top-2 right-2 bg-cinema3-navy/80 backdrop-blur px-2 py-1 rounded text-xs font-bold text-cinema3-gold flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($movie->rating, 1) }}
                                </div>
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="text-xs text-cinema3-goldDark mb-1 uppercase tracking-wider">{{ $movie->genre }}</div>

                            <h3 class="font-bold text-lg leading-tight mb-2 truncate group-hover:text-cinema3-gold transition text-cinema3-navy">
                                {{ $movie->title }}
                            </h3>

                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $movie->duration }} mins
                            </div>
                            
                            <a href="{{ route('booking.create', $movie->id) }}" class="block w-full text-center bg-cinema3-navySoft hover:bg-cinema3-navy text-white py-2 rounded font-bold transition">
                                Book Now
                            </a>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full py-20 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-700">No movies found</h3>
                        <p class="text-gray-500">Try adjusting your search or filters.</p>
                        <a href="{{ route('home') }}" class="inline-block mt-4 text-cinema3-gold hover:underline font-bold">
                            Clear all filters
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-cinema3-navy border-t border-white/10 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 text-center text-white/70 text-sm">
                &copy; {{ date('Y') }} MyMupi. All rights reserved.
            </div>
        </footer>

    </body>
</html>
