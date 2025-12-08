<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ __('Edit Studio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-cinema-800 overflow-hidden shadow-2xl rounded-lg border border-cinema-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.studios.update', $studio->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-6">
                            <label class="block text-gray-300 text-sm font-bold mb-2">Studio Name</label>
                            <input type="text" name="name" value="{{ old('name', $studio->name) }}" required
                                class="w-full bg-cinema-700 text-white border-none rounded px-4 py-3 focus:ring-2 focus:ring-cinema-gold">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <!-- Total Rows -->
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2">Total Rows (A-Z)</label>
                                <input type="number" name="total_rows" value="{{ old('total_rows', $studio->total_rows) }}" min="1" max="26" required
                                    class="w-full bg-cinema-700 text-white border-none rounded px-4 py-3 focus:ring-2 focus:ring-cinema-gold">
                                <p class="text-xs text-gray-500 mt-1">Changing this affects all future bookings!</p>
                                @error('total_rows') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Seats Per Row -->
                            <div>
                                <label class="block text-gray-300 text-sm font-bold mb-2">Seats Per Row</label>
                                <input type="number" name="seats_per_row" value="{{ old('seats_per_row', $studio->seats_per_row) }}" min="1" max="20" required
                                    class="w-full bg-cinema-700 text-white border-none rounded px-4 py-3 focus:ring-2 focus:ring-cinema-gold">
                                @error('seats_per_row') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('admin.studios.index') }}" class="text-gray-400 hover:text-white mr-4 transition">Cancel</a>
                            <button type="submit" class="bg-cinema-gold text-cinema-900 font-bold px-6 py-3 rounded hover:bg-yellow-400 transition transform hover:scale-105">
                                Update Studio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
