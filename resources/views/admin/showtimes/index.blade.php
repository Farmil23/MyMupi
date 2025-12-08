<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            Manage Showtimes
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-white text-lg font-bold">Schedule List</h3>
                <a href="{{ route('admin.showtimes.create') }}" class="bg-cinema-gold text-cinema-900 font-bold py-2 px-4 rounded hover:bg-yellow-400">
                    + Add New Schedule
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
                                <th class="px-6 py-3">Movie</th>
                                <th class="px-6 py-3">Studio</th>
                                <th class="px-6 py-3">Date & Time</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cinema-700">
                            @foreach($showtimes as $showtime)
                                <tr class="hover:bg-cinema-700/50 transition">
                                    <td class="px-6 py-4 font-bold text-white">{{ $showtime->movie->title }}</td>
                                    <td class="px-6 py-4">{{ $showtime->studio->name }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M Y H:i') }}</td>
                                    <td class="px-6 py-4">{{ number_format($showtime->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                        <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                    {{ $showtimes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
