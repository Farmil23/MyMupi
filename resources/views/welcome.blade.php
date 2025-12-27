<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MyMupi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CINEMA3 COLORS -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
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
        .glass-dark {
            background: rgba(29, 42, 58, 0.55);
            border: 1px solid rgba(255,255,255,0.10);
            backdrop-filter: blur(14px);
        }
        .glass-card {
            background: rgba(255,255,255,0.86);
            border: 1px solid rgba(29, 42, 58, 0.08);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col bg-cinema3-cream text-cinema3-navy">

    <!-- NAVBAR -->
    <nav class="border-b border-white/10 bg-cinema3-navy/90 backdrop-blur-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold text-cinema3-gold tracking-wide">
                        MyMupi
                    </a>
                </div>

                <!-- Links -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="text-white/90 hover:text-cinema3-gold transition font-semibold">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-white/90 hover:text-cinema3-gold transition font-semibold">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-4 py-2 text-sm font-extrabold text-cinema3-navy shadow-sm
                                          hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

            </div>
        </div>
    </nav>

    <!-- HERO -->
    <header class="relative pt-28 pb-16 sm:pt-32 sm:pb-20 px-4 sm:px-6 lg:px-8">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-b from-cinema3-navy to-cinema3-navySoft"></div>
        <div class="absolute inset-0 opacity-60"
             style="background: radial-gradient(900px 450px at 50% 20%, rgba(243,196,78,0.20), transparent 60%);"></div>

        <div class="relative max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight mb-4 text-white">
                    Discover Your Next <span class="text-cinema3-gold">obsession</span>
                </h1>
                <p class="text-white/70 max-w-2xl mx-auto text-base sm:text-lg">
                    Search by title or filter by genre — then jump into showtimes and book seats in seconds.
                </p>

                <!-- Quick chips -->
                <div class="mt-6 flex flex-wrap items-center justify-center gap-2">
                    <span class="glass-dark text-white/80 text-xs font-semibold px-3 py-1.5 rounded-full">
                        ✨ Smooth booking flow
                    </span>
                    <span class="glass-dark text-white/80 text-xs font-semibold px-3 py-1.5 rounded-full">
                        ⭐ Ratings & reviews
                    </span>
                    <span class="glass-dark text-white/80 text-xs font-semibold px-3 py-1.5 rounded-full">
                        🎟️ Real-time showtimes
                    </span>
                </div>

                <!-- Search Card -->
                <div class="mt-10 max-w-4xl mx-auto">
                    <form action="{{ route('home') }}" method="GET"
                          class="glass-dark rounded-3xl p-4 sm:p-5 shadow-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-stretch">

                            <!-- Search -->
                            <div class="md:col-span-7 relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Search for movies..."
                                       class="w-full h-full bg-white/95 border border-white/20 rounded-2xl py-4 pl-5 pr-12
                                              text-cinema3-navy placeholder-gray-400 focus:ring-2 focus:ring-cinema3-gold/40 focus:border-cinema3-gold text-base sm:text-lg">
                                <svg class="w-6 h-6 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <!-- Genre -->
                            <div class="md:col-span-3">
                                <select name="genre"
                                        class="w-full h-full bg-white/95 border border-white/20 rounded-2xl py-4 px-5
                                               text-cinema3-navy focus:ring-2 focus:ring-cinema3-gold/40 focus:border-cinema3-gold
                                               cursor-pointer text-base sm:text-lg appearance-none">
                                    <option value="">All Genres</option>
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                            {{ $genre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Button -->
                            <div class="md:col-span-2">
                                <button type="submit"
                                        class="w-full h-full rounded-2xl bg-cinema3-gold text-cinema3-navy font-extrabold
                                               py-4 px-6 hover:bg-cinema3-goldDark transition shadow-lg
                                               focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40">
                                    Search
                                </button>
                            </div>

                        </div>

                        <!-- Small helper row -->
                        <div class="mt-3 flex flex-wrap items-center justify-between gap-2 text-sm">
                            <div class="text-white/60">
                                Tip: try “Action” or “Drama” to explore faster.
                            </div>

                            @if(request('search') || request('genre'))
                                <a href="{{ route('home') }}" class="text-cinema3-gold font-bold hover:underline">
                                    Clear all filters
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            <!-- Section header -->
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    @if(request('search') || request('genre'))
                        <h2 class="text-2xl font-extrabold text-cinema3-navy">
                            Search Results
                        </h2>
                        <p class="text-cinema3-navy/60">
                            @if(request('search')) for "<span class="font-bold">{{ request('search') }}</span>" @endif
                            @if(request('genre')) in <span class="text-cinema3-goldDark font-bold">{{ request('genre') }}</span> @endif
                        </p>
                    @else
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-cinema3-navy flex items-center gap-3">
                            <span class="h-7 w-1.5 rounded-full bg-cinema3-gold"></span>
                            Now Showing
                        </h2>
                        <p class="text-cinema3-navy/60">Browse what’s available today.</p>
                    @endif
                </div>

                <div class="text-sm text-cinema3-navy/60 font-semibold">
                    {{ $movies->count() }} movies
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8">
                @forelse($movies as $movie)
                    @php
                        $posterUrl = null;
                        if (!empty($movie->poster)) {
                            $posterUrl = Str::startsWith($movie->poster, 'http')
                                ? $movie->poster
                                : asset('storage/' . ltrim($movie->poster, '/'));
                        }
                        $year = $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : null;
                    @endphp

                    <div class="group rounded-2xl overflow-hidden shadow-xl border border-cinema3-navy/10 bg-white hover:-translate-y-1 transition duration-300">
                        <!-- Poster -->
                        <a href="{{ route('movie.show', $movie->id) }}" class="block relative bg-cinema3-cream">
                            <div class="aspect-[2/3] overflow-hidden">
                                @if($posterUrl)
                                    <img src="{{ $posterUrl }}" alt="{{ $movie->title }}"
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-cinema3-navy/50 font-semibold">
                                        No Poster
                                    </div>
                                @endif
                            </div>

                            <!-- gradient overlay (subtle) -->
                            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition"></div>

                            <!-- Rating badge -->
                            <div class="absolute top-3 right-3 bg-cinema3-navy/80 backdrop-blur px-2.5 py-1.5 rounded-xl text-xs font-extrabold text-cinema3-gold flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ number_format((float)$movie->rating, 1) }}
                            </div>
                        </a>

                        <!-- Content -->
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-cinema3-goldDark">
                                    {{ $movie->genre }}
                                </span>
                                <span class="text-[11px] sm:text-xs font-semibold text-cinema3-navy/50">
                                    {{ $year ?? '' }}
                                </span>
                            </div>

                            <h3 class="font-extrabold text-sm sm:text-lg leading-snug mb-2 text-cinema3-navy group-hover:text-cinema3-goldDark transition line-clamp-2">
                                {{ $movie->title }}
                            </h3>

                            <div class="flex items-center text-xs sm:text-sm text-cinema3-navy/60 mb-4">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ (int) $movie->duration_minutes }} mins
                            </div>

                            <div class="flex flex-col gap-2">
                                <a href="{{ route('movie.show', $movie->id) }}"
                                   class="w-full text-center rounded-xl bg-cinema3-navySoft hover:bg-cinema3-navy text-white py-2.5 font-extrabold transition">
                                    View Details
                                </a>

                                @auth
                                    <a href="{{ route('movie.show', $movie->id) }}"
                                       class="w-full text-center rounded-xl bg-white border border-cinema3-navy/10 text-cinema3-navy py-2.5 font-bold
                                              hover:bg-white/80 transition">
                                        See Showtimes
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="w-full text-center rounded-xl bg-white border border-cinema3-navy/10 text-cinema3-navy py-2.5 font-bold
                                              hover:bg-white/80 transition">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="glass-card rounded-3xl p-10 sm:p-14 text-center shadow-2xl">
                            <div class="mx-auto h-14 w-14 rounded-2xl bg-cinema3-navy/10 border border-cinema3-navy/10 flex items-center justify-center text-2xl">
                                🎞️
                            </div>
                            <h3 class="mt-5 text-2xl font-extrabold text-cinema3-navy">No movies found</h3>
                            <p class="mt-2 text-cinema3-navy/60">Try adjusting your search or filters.</p>
                            <a href="{{ route('home') }}"
                               class="inline-flex mt-6 items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-extrabold text-cinema3-navy shadow-sm
                                      hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                Clear all filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-cinema3-navy border-t border-white/10 py-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="text-white/80 font-bold text-lg">MyMupi</div>
            <div class="mt-2 text-white/60 text-sm">
                &copy; {{ date('Y') }} MyMupi. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
