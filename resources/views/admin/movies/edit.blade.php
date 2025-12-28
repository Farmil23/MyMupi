<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-3xl text-cinema3-gold leading-tight tracking-tight">Edit Movie</h2>
                <p class="text-sm text-white/60 font-medium">Update movie details.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-white/90 backdrop-blur-xl border border-white/40 shadow-2xl overflow-hidden relative">
                 <!-- Decorative gradient line -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cinema3-navy via-cinema3-gold to-cinema3-navy"></div>

                <div class="p-8 md:p-10">
                    <form method="POST" action="{{ route('admin.movies.update', $movie->id) }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        @if($errors->any())
                            <div class="rounded-2xl bg-red-50 border border-red-200 p-4 flex items-start gap-3">
                                <span class="text-red-600 text-xl">⚠️</span>
                                <div>
                                    <h3 class="font-bold text-red-800">Please fix the following errors:</h3>
                                    <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row items-start gap-6 border-b border-cinema3-navy/5 pb-8">
                            <div class="h-48 w-32 rounded-2xl overflow-hidden shadow-lg border-2 border-white bg-cinema3-cream relative shrink-0">
                                @if($movie->poster)
                                    <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : asset('storage/' . $movie->poster) }}" alt="Poster" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex flex-col items-center justify-center text-cinema3-navy/30 bg-cinema3-navy/5">
                                        <span class="text-3xl">🎬</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 pt-2">
                                <h3 class="text-2xl font-black text-cinema3-navy">{{ $movie->title }}</h3>
                                <p class="text-cinema3-navy/60 font-medium max-w-lg mt-1">{{ Str::limit($movie->description, 100) }}</p>
                                
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="px-3 py-1 rounded-lg bg-cinema3-gold/20 text-cinema3-navy text-xs font-bold uppercase tracking-wider border border-cinema3-gold/30">
                                        {{ $movie->genre }}
                                    </span>
                                    <span class="px-3 py-1 rounded-lg bg-cinema3-navy/5 text-cinema3-navy text-xs font-bold uppercase tracking-wider border border-cinema3-navy/10">
                                        ⭐ {{ $movie->rating }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 1: Basic Info -->
                        <div>
                            <h3 class="text-lg font-extrabold text-cinema3-navy flex items-center gap-2 mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-cinema3-navy/5 text-cinema3-navy">🎬</span>
                                Movie Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Title</label>
                                    <input name="title" value="{{ old('title', $movie->title) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Genre</label>
                                    <input name="genre" value="{{ old('genre', $movie->genre) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Duration (min)</label>
                                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $movie->duration_minutes) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Rating (0-10)</label>
                                    <input type="number" step="0.1" name="rating" value="{{ old('rating', $movie->rating) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Release Date</label>
                                    <input type="date" name="release_date" value="{{ old('release_date', $movie->release_date) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                </div>
                            </div>
                        </div>

                        <div class="w-full h-px bg-cinema3-navy/5"></div>

                        <!-- Section 2: Details & Assets -->
                        <div>
                             <h3 class="text-lg font-extrabold text-cinema3-navy flex items-center gap-2 mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-cinema3-navy/5 text-cinema3-navy">📝</span>
                                Details & Assets
                            </h3>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Description</label>
                                    <textarea name="description" rows="4" required
                                              class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-medium leading-relaxed
                                                     focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">{{ old('description', $movie->description) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Synopsis (Optional)</label>
                                    <textarea name="synopsis" rows="3"
                                              class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-medium leading-relaxed
                                                     focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">{{ old('synopsis', $movie->synopsis) }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Poster URL (Optional)</label>
                                        <input name="poster_url" value="{{ old('poster_url') }}"
                                               placeholder="Leave empty if uploading a file"
                                               class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                      focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Trailer URL (YouTube)</label>
                                        <input name="trailer_url" value="{{ old('trailer_url', $movie->trailer_url) }}"
                                               placeholder="https://www.youtube.com/watch?v=..."
                                               class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                      focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Upload Poster (Optional)</label>
                                        <div class="relative">
                                            <input type="file" name="poster_file" accept="image/*"
                                                   class="block w-full text-sm text-cinema3-navy
                                                          file:mr-4 file:py-3.5 file:px-6 file:rounded-2xl file:border-0
                                                          file:text-sm file:font-bold file:bg-cinema3-navy/5 file:text-cinema3-navy
                                                          hover:file:bg-cinema3-gold hover:file:text-white
                                                          transition-all cursor-pointer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 pt-6">
                            <button type="submit"
                                    class="flex-1 md:flex-none inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cinema3-gold to-cinema3-goldDark px-8 py-4 text-base font-black text-cinema3-navy shadow-lg shadow-cinema3-gold/20
                                           hover:shadow-xl hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition-all duration-300">
                                Update Movie
                            </button>

                            <a href="{{ route('admin.movies.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl px-6 py-4 text-sm font-bold text-cinema3-navy hover:bg-cinema3-cream/50 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
