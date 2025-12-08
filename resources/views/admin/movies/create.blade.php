<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            Add New Movie
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

                <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Movie Title</label>
                        <input type="text" name="title" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Genre</label>
                            <input type="text" name="genre" placeholder="e.g. Action, Sci-Fi" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Duration (Minutes)</label>
                            <input type="number" name="duration_minutes" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Rating (0-10)</label>
                            <input type="number" step="0.1" name="rating" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Release Date</label>
                            <input type="date" name="release_date" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Short Description</label>
                        <textarea name="description" rows="3" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0" required></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Full Synopsis (Detailed)</label>
                        <textarea name="synopsis" rows="6" class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                             <label class="block text-gray-400 text-sm font-bold mb-2">Poster URL (Optional)</label>
                             <input type="url" name="poster_url" placeholder="https://..." class="w-full bg-cinema-900 border border-cinema-700 text-white rounded focus:border-cinema-gold focus:ring-0">
                        </div>
                        <div>
                             <label class="block text-gray-400 text-sm font-bold mb-2">Or Upload Poster</label>
                             <input type="file" name="poster_file" class="w-full text-gray-400">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-cinema-gold text-cinema-900 font-bold py-3 px-6 rounded hover:bg-yellow-400 w-full md:w-auto">
                            Save Movie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
