<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                    <div class="text-gray-400 text-sm">Total Movies</div>
                    <div class="text-white text-3xl font-bold">{{ $totalMovies }}</div>
                </div>
                <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                    <div class="text-gray-400 text-sm">Total Studios</div>
                    <div class="text-white text-3xl font-bold">{{ $totalStudios }}</div>
                </div>
                <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                    <div class="text-gray-400 text-sm">Active Showtimes</div>
                    <div class="text-white text-3xl font-bold">{{ $totalShowtimes }}</div>
                </div>
                <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                    <div class="text-gray-400 text-sm">Total Revenue</div>
                    <div class="text-cinema-gold text-2xl font-bold">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Management Links -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Manage Movies -->
                <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                    <h3 class="text-xl font-bold text-white mb-4">Manage Movies</h3>
                    <p class="text-gray-400 mb-4">Add, edit, or remove movies from the catalog.</p>
                    <a href="{{ route('admin.movies.index') }}" class="bg-cinema-red text-white py-2 px-4 rounded hover:bg-red-700">
                        View All Movies
                    </a>
                    <a href="{{ route('admin.movies.create') }}" class="ml-2 text-cinema-red hover:text-white">
                        + Add New
                    </a>
                </div>

                <!-- Manage Showtimes -->
                <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                    <h3 class="text-xl font-bold text-white mb-4">Manage Schedule</h3>
                    <p class="text-gray-400 mb-4">Set showtimes, assign studios, and manage ticket prices.</p>
                    <a href="{{ route('admin.showtimes.index') }}" class="bg-cinema-gold text-cinema-900 font-bold py-2 px-4 rounded hover:bg-yellow-400">
                        View Schedule
                    </a>
                     <a href="{{ route('admin.showtimes.create') }}" class="ml-2 text-cinema-gold hover:text-white">
                        + Add Schedule
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
