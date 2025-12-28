<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-cinema3-gold leading-tight">
                    {{ $movie->title }}
                </h2>
                <p class="text-sm text-white/60">
                    {{ strtoupper($movie->genre) }}
                    <span class="mx-2">•</span>
                    {{ (int) $movie->duration_minutes }} MIN
                    @if(!empty($movie->release_date))
                        <span class="mx-2">•</span>
                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                    @endif
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white
                          border border-white/10 hover:bg-white/15 transition">
                    ← Back to Browse
                </a>

                <a href="#showtimes"
                   class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-4 py-2 text-sm font-extrabold text-cinema3-navy
                          shadow-sm hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                    See Showtimes
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $posterUrl = null;
        if (!empty($movie->poster)) {
            $posterUrl = \Illuminate\Support\Str::startsWith($movie->poster, 'http')
                ? $movie->poster
                : asset('storage/' . ltrim($movie->poster, '/'));
        }
        $posterFallback = 'https://via.placeholder.com/600x900/1D2A3A/F3C44E?text=' . urlencode($movie->title);
        $year = !empty($movie->release_date) ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : null;

        $authId = auth()->id();
        $hasReviewed = auth()->check() ? $movie->reviews->where('user_id', $authId)->count() : false;
    @endphp

    <div class="relative py-10">
        <!-- subtle background glow -->
        <div class="absolute inset-0 bg-gradient-to-b from-cinema3-navy/25 via-cinema3-cream to-cinema3-cream"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- LEFT: Poster / quick info -->
                <aside class="lg:col-span-4">
                    <div class="rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl overflow-hidden">
                        <div class="relative">
                            <div class="aspect-[2/3] bg-cinema3-cream">
                                <img
                                    src="{{ $posterUrl ?: $posterFallback }}"
                                    alt="{{ $movie->title }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-black/55 to-transparent"></div>

                            <!-- Rating badge -->
                            <div class="absolute top-4 left-4 inline-flex items-center gap-2 rounded-2xl bg-cinema3-navy/85 backdrop-blur px-3 py-2 text-sm font-extrabold text-cinema3-gold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ number_format((float) $movie->rating, 1) }} <span class="text-white/70 font-semibold">/10</span>
                            </div>

                            <!-- Quick meta -->
                            <div class="absolute bottom-4 left-4 right-4 flex flex-wrap gap-2">
                                <span class="inline-flex items-center rounded-full bg-white/15 border border-white/10 text-white/90 px-3 py-1 text-xs font-bold">
                                    {{ $movie->genre }}
                                </span>
                                <span class="inline-flex items-center rounded-full bg-white/15 border border-white/10 text-white/90 px-3 py-1 text-xs font-bold">
                                    {{ (int) $movie->duration_minutes }} mins
                                </span>
                                @if($year)
                                    <span class="inline-flex items-center rounded-full bg-white/15 border border-white/10 text-white/90 px-3 py-1 text-xs font-bold">
                                        {{ $year }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="text-cinema3-navy/70 text-sm">
                                Ready to watch? Check available showtimes and book your seats.
                            </div>

                            <div class="mt-4 flex flex-col gap-2">
                                <a href="#showtimes"
                                   class="w-full text-center rounded-xl bg-cinema3-gold px-4 py-3 text-sm font-extrabold text-cinema3-navy
                                          hover:bg-cinema3-goldDark transition shadow-sm">
                                    Browse Showtimes
                                </a>

                                @guest
                                    <a href="{{ route('login') }}"
                                       class="w-full text-center rounded-xl bg-white border border-cinema3-navy/10 px-4 py-3 text-sm font-bold text-cinema3-navy
                                              hover:bg-white/80 transition">
                                        Login to Book
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- RIGHT: Details / showtimes / reviews -->
                <section class="lg:col-span-8 space-y-6">

                    <!-- Synopsis / details card -->
                    <div class="rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-cinema3-navy">Synopsis</h3>
                                <p class="mt-1 text-cinema3-navy/60 text-sm">Story overview & highlights.</p>
                            </div>
                        </div>

                        <div class="mt-5 text-cinema3-navy/80 leading-relaxed">
                            {{ $movie->synopsis ?? $movie->description }}
                        </div>
                    </div>

                    <!-- Showtimes -->
                    <div id="showtimes" class="rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 sm:p-8">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-cinema3-navy">Available Showtimes</h3>
                                <p class="mt-1 text-cinema3-navy/60 text-sm">Pick a time and book instantly.</p>
                            </div>
                        </div>

                        @if($movie->showtimes->count() > 0)
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($movie->showtimes as $showtime)
                                    <div class="rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-5 hover:bg-cinema3-cream transition">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <div class="text-cinema3-navy font-extrabold text-lg">
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('h:i A') }}
                                                </div>
                                                <div class="text-cinema3-navy/60 text-sm mt-1">
                                                    {{ optional($showtime->studio)->name ?? '-' }}
                                                    <span class="mx-1">•</span>
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M Y') }}
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <div class="text-cinema3-navy font-extrabold">
                                                    Rp {{ number_format((int)$showtime->price, 0, ',', '.') }}
                                                </div>
                                                <div class="text-xs text-cinema3-navy/50">per ticket</div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            @auth
                                                <a href="{{ route('booking.create', $showtime->id) }}"
                                                   class="inline-flex w-full items-center justify-center rounded-xl bg-cinema3-navy px-4 py-3 text-sm font-extrabold text-white
                                                          hover:bg-cinema3-navySoft focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                                                    Book Seats →
                                                </a>
                                            @else
                                                <a href="{{ route('login') }}"
                                                   class="inline-flex w-full items-center justify-center rounded-xl bg-white border border-cinema3-navy/10 px-4 py-3 text-sm font-bold text-cinema3-navy
                                                          hover:bg-white/80 transition">
                                                    Login to Book
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mt-6 rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-6 text-center">
                                <div class="mx-auto h-12 w-12 rounded-2xl bg-cinema3-navy/10 border border-cinema3-navy/10 flex items-center justify-center text-xl">
                                    ⏱️
                                </div>
                                <div class="mt-3 font-extrabold text-cinema3-navy">No showtimes available</div>
                                <div class="text-sm text-cinema3-navy/60 mt-1">Please check back later.</div>
                            </div>
                        @endif
                    </div>

                    <!-- Reviews -->
                    <div class="rounded-3xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 sm:p-8">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-extrabold text-cinema3-navy">Reviews & Ratings</h3>
                            <p class="mt-1 text-cinema3-navy/60 text-sm">Share your thoughts and help others choose.</p>
                        </div>

                        <!-- Write review -->
                        <div class="mt-6">
                            @auth
                                @if(!$hasReviewed)
                                    <div class="rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-6">
                                        <h4 class="font-extrabold text-cinema3-navy">Write a Review</h4>

                                        <form action="{{ route('movie.review.store', $movie) }}" method="POST" class="mt-4 space-y-4">
                                            @csrf

                                            <div
                                                x-data="{
                                                    rating: {{ (int) old('rating', 0) }},
                                                    hover: 0,
                                                    max: 5
                                                }"
                                            >
                                                <label class="block text-sm font-bold text-cinema3-navy mb-2">Rating</label>

                                                <!-- nilai rating yang akan dikirim ke backend -->
                                                <input type="hidden" name="rating" :value="rating" required>

                                                <div class="flex items-center gap-2">
                                                    <template x-for="n in max" :key="n">
                                                        <button
                                                            type="button"
                                                            class="h-10 w-10 rounded-xl border text-lg font-extrabold transition flex items-center justify-center"
                                                            :class="
                                                                ((hover || rating) >= n)
                                                                    ? 'bg-cinema3-gold/20 border-cinema3-gold/50 text-cinema3-gold'
                                                                    : 'bg-white border-cinema3-navy/10 text-cinema3-navy/30 hover:text-cinema3-gold'
                                                            "
                                                            @mouseenter="hover = n"
                                                            @mouseleave="hover = 0"
                                                            @click="rating = n"
                                                            :aria-label="'Rate ' + n + ' out of ' + max"
                                                            title="Click to rate"
                                                        >
                                                            ★
                                                        </button>
                                                    </template>

                                                    <div class="ml-2 text-sm font-bold text-cinema3-navy/70">
                                                        <span x-text="rating ? (rating + '/5') : 'Select'"></span>
                                                    </div>
                                                </div>

                                                @error('rating')
                                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-cinema3-navy mb-2">Review</label>
                                                <textarea name="review" rows="4" required
                                                          class="w-full rounded-2xl border border-cinema3-navy/15 bg-white px-4 py-3 text-cinema3-navy
                                                                 focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30"
                                                          placeholder="Share your thoughts...">{{ old('review') }}</textarea>
                                                @error('review')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-extrabold text-cinema3-navy
                                                           hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition shadow-sm">
                                                Submit Review
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="rounded-2xl bg-green-50 border border-green-200 text-green-700 p-4 font-semibold">
                                        You have already reviewed this movie.
                                    </div>
                                @endif
                            @else
                                <div class="rounded-2xl bg-cinema3-cream/70 border border-cinema3-navy/10 p-5 text-center">
                                    <p class="text-cinema3-navy/70">
                                        Please
                                        <a href="{{ route('login') }}" class="text-cinema3-goldDark font-extrabold hover:underline">login</a>
                                        to leave a review.
                                    </p>
                                </div>
                            @endauth
                        </div>

                        <!-- Review list -->
                        <div class="mt-7 space-y-4">
                            @forelse($movie->reviews as $review)
                                @php
                                    $name = optional($review->user)->name ?? 'User';
                                    $initial = strtoupper(mb_substr($name, 0, 1));
                                @endphp

                                <div class="rounded-2xl bg-white/70 border border-cinema3-navy/10 p-6 shadow-sm">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-11 w-11 rounded-full bg-cinema3-navy text-cinema3-gold font-extrabold flex items-center justify-center border border-cinema3-gold/50">
                                                {{ $initial }}
                                            </div>
                                            <div>
                                                <div class="font-extrabold text-cinema3-navy">{{ $name }}</div>
                                                <div class="text-xs text-cinema3-navy/50">
                                                    {{ $review->created_at ? $review->created_at->diffForHumans() : '' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="inline-flex items-center rounded-xl bg-cinema3-gold/20 border border-cinema3-gold/30 px-3 py-1 text-sm font-extrabold text-cinema3-navy">
                                            ★ {{ (int)$review->rating }}/5
                                        </div>
                                    </div>

                                    <div class="mt-4 text-cinema3-navy/80 leading-relaxed">
                                        {{ $review->review }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-cinema3-navy/60 italic">No reviews yet. Be the first to review!</p>
                            @endforelse
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</x-app-layout>
