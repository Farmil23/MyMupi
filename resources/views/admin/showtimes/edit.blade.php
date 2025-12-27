<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Edit Showtime</h2>
            <p class="text-sm text-white/60">Update schedule and pricing.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 md:p-8">
                <form method="POST" action="{{ route('admin.showtimes.update', $showtime->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @php
                        $startLocal = $showtime->start_time
                            ? \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d\TH:i')
                            : '';
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Movie</label>
                            <select name="movie_id" required
                                    class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                           focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                                @foreach($movies as $movie)
                                    <option value="{{ $movie->id }}" @selected(old('movie_id', $showtime->movie_id) == $movie->id)>
                                        {{ $movie->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('movie_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Studio</label>
                            <select name="studio_id" required
                                    class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                           focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                                @foreach($studios as $studio)
                                    <option value="{{ $studio->id }}" @selected(old('studio_id', $showtime->studio_id) == $studio->id)>
                                        {{ $studio->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('studio_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Price</label>
                            <input type="number" name="price" value="{{ old('price', $showtime->price) }}" required min="0"
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Start Time</label>
                            <input type="datetime-local" name="start_time" value="{{ old('start_time', $startLocal) }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('start_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                       hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                            Update Showtime
                        </button>

                        <a href="{{ route('admin.showtimes.index') }}"
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
