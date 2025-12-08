<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            Manage Movies
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-white text-lg font-bold">Movie List</h3>
                <a href="{{ route('admin.movies.create') }}" class="bg-cinema-red text-white py-2 px-4 rounded hover:bg-red-700">
                    + Add New Movie
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-cinema-800 overflow-hidden shadow-xl sm:rounded-lg border border-cinema-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-400">
                        <thead class="bg-cinema-700 text-cinema-gold uppercase font-bold text-sm">
                            <tr>
                                <th class="px-6 py-3">Poster</th>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Genre</th>
                                <th class="px-6 py-3">Rating</th>
                                <th class="px-6 py-3">Duration</th>
                                <th class="px-6 py-3">Release Year</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cinema-700">
                            @foreach($movies as $movie)
                                <tr class="hover:bg-cinema-700/50 transition">
                                    <td class="px-6 py-4">
                                        <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : asset('storage/'.$movie->poster) }}" 
                                             class="w-12 h-16 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white">{{ $movie->title }}</td>
                                    <td class="px-6 py-4">{{ $movie->genre }}</td>
                                    <td class="px-6 py-4 text-yellow-400">{{ $movie->rating }}</td>
                                    <td class="px-6 py-4">{{ $movie->duration_minutes }}m</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-300">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $movies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
