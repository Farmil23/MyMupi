<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ __('Now Showing') }}
        </h2>
    </x-slot>

    <!-- Hero Section / Featured Movie -->
    <div class="relative bg-cinema-900 border-b border-cinema-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-lg overflow-hidden shadow-2xl">
                <!-- Placeholder Hero (In real app, this would be dynamic) -->
                <div class="absolute inset-0 bg-gradient-to-r from-cinema-900 via-cinema-900/80 to-transparent z-10"></div>
                <!-- Interactive Placeholder logic -->
                <img src="https://image.tmdb.org/t/p/original/8RpDCSfKTerf3rt5yqO5D0Fc17q.jpg" alt="Hero Movie" class="w-full h-96 object-cover object-top opacity-50">
                
                <div class="absolute inset-0 z-20 flex flex-col justify-center px-8 sm:px-12">
                     <h1 class="text-4xl sm:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                        <span class="text-cinema-gold">My</span>Mupi
                     </h1>
                     <p class="text-lg text-gray-300 max-w-xl mb-6 drop-shadow-md">
                         Experience cinema like never before. Book your tickets for the latest blockbusters with our premium service.
                     </p>
                     <div class="flex space-x-4">
                        <a href="#movies" class="bg-cinema-red hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 shadow-lg transform hover:scale-105">
                            Buy Tickets
                        </a>
                        <button class="border-2 border-cinema-gold text-cinema-gold font-bold py-3 px-8 rounded-full hover:bg-cinema-gold hover:text-cinema-900 transition duration-300">
                            Learn More
                        </button>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Movie Grid -->
    <div id="movies" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6 px-4 sm:px-0">
                <h3 class="text-2xl font-bold text-white border-l-4 border-cinema-gold pl-4">Now Playing</h3>
                <a href="#" class="text-cinema-gold hover:text-white transition">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4 sm:px-0">
                @foreach ($movies as $movie)
                    <div class="bg-cinema-800 rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 group border border-cinema-700">
                        <div class="relative overflow-hidden aspect-[2/3]">
                            <!-- Using a placeholder image service if poster is local filename -->
                            <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : 'https://placehold.co/400x600/1a1a1a/d4af37?text=' . urlencode($movie->title) }}" 
                                 alt="{{ $movie->title }}" 
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                            
                            <div class="absolute bottom-0 left-0 p-4 w-full">
                                <span class="bg-cinema-red text-white text-xs font-bold px-2 py-1 rounded inline-block mb-2 shadow-sm">
                                    {{ $movie->genre }}
                                </span>
                                <div class="flex items-center text-yellow-400 text-sm mb-1">
                                    <svg class="w-4 h-4 fill-current mr-1" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                    {{ $movie->rating }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h4 class="text-lg font-bold text-white mb-1 truncate" title="{{ $movie->title }}">{{ $movie->title }}</h4>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $movie->description }}
                            </p>
                            <a href="#" class="block w-full bg-cinema-gold text-cinema-900 font-bold text-center py-2 rounded hover:bg-yellow-400 transition shadow">
                                Book Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
