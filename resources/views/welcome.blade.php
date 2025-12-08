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
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            cinema: {
                                900: '#0F1014', // Main bg
                                800: '#181A20', // Card bg
                                700: '#2A2D35', // Border/Input
                                600: '#3F4451',
                                gold: '#D4AF37', // Gold accent
                                red: '#E50914', // Netflix red
                            }
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { background-color: #0F1014; color: white; }
            .glass {
                background: rgba(24, 26, 32, 0.8);
                backdrop-filter: blur(10px);
            }
        </style>
    </head>
    <body class="antialiased min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="border-b border-cinema-700 bg-cinema-800/80 backdrop-blur-md fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cinema-gold to-yellow-200">
                            MyMupi
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-cinema-gold text-cinema-900 px-4 py-2 rounded font-bold hover:bg-yellow-400 transition">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-cinema-800 to-cinema-900">
            <div class="max-w-7xl mx-auto text-center">
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-8">
                    Discover Your Next <span class="text-cinema-red">obsession</span>
                </h1>
                
                <!-- Search & Filter Form -->
                <div class="max-w-3xl mx-auto">
                    <form action="{{ route('home') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-grow relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search for movies..." 
                                class="w-full bg-cinema-700 border-none rounded-lg py-4 px-6 text-white placeholder-gray-400 focus:ring-2 focus:ring-cinema-gold text-lg">
                            <svg class="w-6 h-6 absolute right-4 top-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        
                        <div class="md:w-1/4">
                            <select name="genre" onchange="this.form.submit()" 
                                class="w-full h-full bg-cinema-700 border-none rounded-lg py-4 px-6 text-white focus:ring-2 focus:ring-cinema-gold cursor-pointer text-lg appearance-none">
                                <option value="">All Genres</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="hidden md:block bg-cinema-gold text-cinema-900 font-bold py-4 px-8 rounded-lg hover:bg-yellow-400 transition">
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
                    <h2 class="text-xl font-semibold text-gray-300">
                        Search Results
                        @if(request('search')) for "<span class="text-white">{{ request('search') }}</span>" @endif
                        @if(request('genre')) in <span class="text-cinema-gold">{{ request('genre') }}</span> @endif
                    </h2>
                    <a href="{{ route('home') }}" class="text-cinema-red hover:underline text-sm">Clear Filters</a>
                </div>
            @else
                <h2 class="text-2xl font-bold text-white mb-8 border-l-4 border-cinema-gold pl-4">Now Showing</h2>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($movies as $movie)
                    <div class="group relative bg-cinema-800 rounded-xl overflow-hidden shadow-lg border border-cinema-700 hover:border-cinema-gold transition duration-300 transform hover:-translate-y-2">
                        <!-- Poster -->
                        <div class="aspect-[2/3] overflow-hidden bg-cinema-700 relative">
                            <a href="{{ route('movie.show', $movie->id) }}" class="block w-full h-full">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                                        No Poster
                                    </div>
                                @endif
                                
                                <!-- Rating Badge -->
                                <div class="absolute top-2 right-2 bg-black/70 backdrop-blur px-2 py-1 rounded text-xs font-bold text-yellow-500 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ number_format($movie->rating, 1) }}
                                </div>
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="text-xs text-cinema-gold mb-1 uppercase tracking-wider">{{ $movie->genre }}</div>
                            <h3 class="font-bold text-lg leading-tight mb-2 truncate group-hover:text-cinema-gold transition">{{ $movie->title }}</h3>
                            <div class="flex items-center text-sm text-gray-400 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $movie->duration }} mins
                            </div>
                            
                            <a href="{{ route('booking.create', $movie->id) }}" class="block w-full text-center bg-cinema-700 hover:bg-cinema-red text-white py-2 rounded font-bold transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                        <h3 class="text-xl font-bold text-gray-400">No movies found</h3>
                        <p class="text-gray-500">Try adjusting your search or filters.</p>
                        <a href="{{ route('home') }}" class="inline-block mt-4 text-cinema-gold hover:underline">Clear all filters</a>
                    </div>
                @endforelse
            </div>
        </div>

        <footer class="bg-cinema-900 border-t border-cinema-700 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} MyMupi. All rights reserved.
            </div>
        </footer>
    </body>
</html>
