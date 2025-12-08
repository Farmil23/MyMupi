<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ __('Manage Studios') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-white text-lg font-bold">List of Studios</h3>
                <a href="{{ route('admin.studios.create') }}" class="bg-cinema-gold text-cinema-900 px-4 py-2 rounded font-bold hover:bg-yellow-400 transition">
                    + Add New Studio
                </a>
            </div>

            <div class="bg-cinema-800 overflow-hidden shadow-sm sm:rounded-lg border border-cinema-700">
                <div class="p-6 text-white border-b border-cinema-700">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-700">
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4">Layout (Rows x Seats)</th>
                                <th class="py-3 px-4">Capacity</th>
                                <th class="py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studios as $studio)
                                <tr class="border-b border-cinema-700 hover:bg-cinema-700 transition">
                                    <td class="py-4 px-4 font-semibold text-white">{{ $studio->name }}</td>
                                    <td class="py-4 px-4 text-gray-300">
                                        {{ $studio->total_rows }} Rows x {{ $studio->seats_per_row }} Seats
                                    </td>
                                    <td class="py-4 px-4 text-cinema-gold font-bold">
                                        {{ $studio->capacity }} Seats
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.studios.edit', $studio->id) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                            <form method="POST" action="{{ route('admin.studios.destroy', $studio->id) }}" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">
                                        No studios found. Start by adding one!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $studios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
