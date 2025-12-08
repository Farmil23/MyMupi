<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            Edit Schedule
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-cinema-800 overflow-hidden shadow-xl sm:rounded-lg border border-cinema-700 p-8">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.showtimes.update', $showtime->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Select Movie</label>
                        <select name="movie_id" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                            @foreach($movies as $movie)
                                <option value="{{ $movie->id }}" {{ $showtime->movie_id == $movie->id ? 'selected' : '' }}>{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                             <label class="block text-gray-400 text-sm font-bold mb-2">Select Studio</label>
                            <select name="studio_id" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                                @foreach($studios as $studio)
                                    <option value="{{ $studio->id }}" {{ $showtime->studio_id == $studio->id ? 'selected' : '' }}>{{ $studio->name }} (Cap: {{ $studio->capacity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Ticket Price (IDR)</label>
                            <input type="number" name="price" value="{{ $showtime->price }}" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Start Time</label>
                        <input type="datetime-local" name="start_time" value="{{ \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d\TH:i') }}" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="submit" class="bg-cinema-gold text-cinema-900 font-bold py-3 px-6 rounded hover:bg-yellow-400 w-full md:w-auto">
                            Update Schedule
                        </button>
                         <a href="{{ route('admin.showtimes.index') }}" class="bg-gray-600 text-white font-bold py-3 px-6 rounded hover:bg-gray-500 w-full md:w-auto text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
