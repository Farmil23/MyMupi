<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Add Movie</h2>
            <p class="text-sm text-white/60">Create a new movie entry.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 md:p-8">
                <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700">
                            <div class="font-semibold">Please fix the errors below.</div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Title</label>
                            <input name="title" value="{{ old('title') }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Genre</label>
                            <input name="genre" value="{{ old('genre') }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('genre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Duration (minutes)</label>
                            <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('duration_minutes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Rating (0–10)</label>
                            <input type="number" step="0.1" name="rating" value="{{ old('rating') }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('rating') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Release Date</label>
                            <input type="date" name="release_date" value="{{ old('release_date') }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('release_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Description</label>
                            <textarea name="description" rows="4" required
                                      class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                             focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Synopsis (optional)</label>
                            <textarea name="synopsis" rows="3"
                                      class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                             focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">{{ old('synopsis') }}</textarea>
                            @error('synopsis') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Poster URL (optional)</label>
                            <input name="poster_url" value="{{ old('poster_url') }}"
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('poster_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Trailer URL (YouTube)</label>
                            <input name="trailer_url" value="{{ old('trailer_url') }}" placeholder="https://www.youtube.com/watch?v=..."
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('trailer_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Poster File (optional)</label>
                            <input type="file" name="poster_file" accept="image/*"
                                   class="mt-1 w-full text-sm text-cinema3-navy/70
                                          file:mr-4 file:rounded-xl file:border-0 file:bg-cinema3-gold file:px-4 file:py-2 file:font-semibold file:text-cinema3-navy
                                          hover:file:bg-cinema3-goldDark transition">
                            @error('poster_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                       hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                            Save Movie
                        </button>

                        <a href="{{ route('admin.movies.index') }}"
                           class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-cinema3-navy border border-cinema3-navy/10 shadow-sm
                                  hover:bg-white/80 focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
