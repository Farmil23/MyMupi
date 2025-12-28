<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-3xl text-cinema3-gold leading-tight tracking-tight">Edit Showtime</h2>
                <p class="text-sm text-white/60 font-medium">Update schedule and pricing details.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-white/90 backdrop-blur-xl border border-white/40 shadow-2xl overflow-hidden relative">
                 <!-- Decorative gradient line -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cinema3-navy via-cinema3-gold to-cinema3-navy"></div>

                <div class="p-8 md:p-10">
                    <form method="POST" action="{{ route('admin.showtimes.update', $showtime->id) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        @php
                            $startLocal = $showtime->start_time 
                                ? \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d\TH:i') 
                                : '';
                        @endphp

                        <!-- Section 1: Selection -->
                        <div>
                             <h3 class="text-lg font-extrabold text-cinema3-navy flex items-center gap-2 mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-cinema3-navy/5 text-cinema3-navy">🎬</span>
                                Session Details
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Movie Select --}}
                                <div class="relative group">
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Select Movie</label>
                                    <select name="movie_id" required
                                            class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                   focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all cursor-pointer">
                                        @foreach($movies as $movie)
                                            <option value="{{ $movie->id }}" {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}>
                                                {{ $movie->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('movie_id') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Studio Select --}}
                                <div class="relative group">
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Select Studio</label>
                                    <select name="studio_id" required
                                            class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                   focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all cursor-pointer">
                                        @foreach($studios as $studio)
                                            <option value="{{ $studio->id }}" {{ old('studio_id', $showtime->studio_id) == $studio->id ? 'selected' : '' }}>
                                                {{ $studio->name }} (Cap: {{ $studio->capacity }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('studio_id') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="w-full h-px bg-cinema3-navy/5"></div>

                        <!-- Section 2: Timing & Price -->
                        <div>
                             <h3 class="text-lg font-extrabold text-cinema3-navy flex items-center gap-2 mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-cinema3-navy/5 text-cinema3-navy">⏱️</span>
                                Timing & Pricing
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Start Time --}}
                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Start Time</label>
                                    <input type="datetime-local" name="start_time" value="{{ old('start_time', $startLocal) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all">
                                    @error('start_time') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Price --}}
                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Ticket Price (IDR)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-cinema3-navy/40 font-bold">Rp</span>
                                        <input type="number" name="price" value="{{ old('price', $showtime->price) }}" required min="0"
                                               class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white pl-12 pr-4 py-3.5 text-cinema3-navy font-bold
                                                      focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                    </div>
                                    @error('price') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 pt-6">
                            <button type="submit"
                                    class="flex-1 md:flex-none inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cinema3-gold to-cinema3-goldDark px-8 py-4 text-base font-black text-cinema3-navy shadow-lg shadow-cinema3-gold/20
                                           hover:shadow-xl hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition-all duration-300">
                                Update Schedule
                            </button>

                            <a href="{{ route('admin.showtimes.index') }}"
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
