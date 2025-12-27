<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema3-gold leading-tight">
            {{ $movie->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cinema3-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-lg shadow-2xl overflow-hidden border border-cinema3-navy/10">
                <div class="md:flex">

                    <!--  Movie Poster -->
                    <div class="md:w-1/3 relative">
                        <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : 'https://placehold.co/400x600/1a1a1a/d4af37?text=' . urlencode($movie->title) }}"
                             alt="{{ $movie->title }}"
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Movie Info -->
                    <div class="p-8 md:w-2/3 md:p-12">

                        <!-- Genre / Year / Duration -->
                        <div class="flex items-center space-x-2 text-sm text-cinema3-navySoft font-bold mb-4 uppercase tracking-wide">
                            <span>{{ $movie->genre }}</span>
                            <span>&bull;</span>
                            <span>{{ $movie->duration_minutes }} Min</span>
                            <span>&bull;</span>
                            <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-4xl md:text-5xl font-bold text-cinema3-navy mb-6 leading-tight">
                            {{ $movie->title }}
                        </h1>

                        <!-- Rating -->
                        <div class="flex items-center mb-6">
                            <div class="flex items-center bg-cinema3-cream text-cinema3-gold px-3 py-1 rounded-md border border-cinema3-navy/10">
                                <svg class="w-5 h-5 fill-current mr-1" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <span class="font-bold text-lg text-cinema3-navy">{{ $movie->rating }}</span>
                                <span class="text-gray-600 text-sm ml-1">/ 10</span>
                            </div>
                        </div>

                        <!-- Synopsis -->
                        <div class="mb-8">
                            <h3 class="text-cinema3-navy font-bold text-lg mb-2">Synopsis</h3>
                            <p class="text-gray-700 text-lg leading-relaxed">
                                {{ $movie->synopsis ?? $movie->description }}
                            </p>
                        </div>

                        <!-- Showtimes -->
                        <div class="border-t border-cinema3-navy/10 pt-8">
                            <h3 class="text-xl font-bold text-cinema3-navy mb-4">Available Showtimes</h3>

                            @if($movie->showtimes->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($movie->showtimes as $showtime)
                                        <div class="bg-cinema3-cream p-4 rounded-lg border border-cinema3-navy/10 hover:border-cinema3-gold transition duration-300 flex justify-between items-center group">

                                            <div>
                                                <div class="text-cinema3-navy font-bold text-lg">
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('h:i A') }}
                                                </div>
                                                <div class="text-gray-600 text-sm">
                                                    {{ $showtime->studio->name }} &bull;
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M') }}
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <div class="text-cinema3-goldDark font-bold">
                                                    IDR {{ number_format($showtime->price, 0, ',', '.') }}
                                                </div>

                                                @auth
                                                    <a href="{{ route('booking.create', $showtime) }}"
                                                       class="inline-block mt-2 bg-cinema3-gold text-cinema3-navy text-xs px-3 py-2 rounded-lg font-bold hover:bg-cinema3-goldDark transition">
                                                        Book Seat
                                                    </a>
                                                @else
                                                    <a href="{{ route('login') }}"
                                                       class="inline-block mt-2 bg-cinema3-navy text-white text-xs px-3 py-2 rounded-lg font-bold hover:bg-cinema3-navySoft transition">
                                                        Login to Book
                                                    </a>
                                                @endauth
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">No showtimes available for this movie.</p>
                            @endif
                        </div>

                        <!-- Reviews Section -->
                        <div class="border-t border-cinema3-navy/10 pt-8 mt-8">
                            <h3 class="text-xl font-bold text-cinema3-navy mb-6">Reviews & Ratings</h3>

                            @auth
                                @if(!$movie->reviews->where('user_id', auth()->id())->count())
                                    <div class="bg-cinema3-cream p-6 rounded-lg mb-8 border border-cinema3-navy/10">
                                        <h4 class="text-cinema3-navy font-bold mb-4">Write a Review</h4>

                                        <form action="{{ route('movie.review.store', $movie) }}" method="POST">
                                            @csrf

                                            <!-- Rating -->
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm mb-2">Rating</label>
                                                <div class="flex space-x-4">
                                                    @foreach([1, 2, 3, 4, 5] as $star)
                                                        <label class="cursor-pointer">
                                                            <input type="radio" name="rating" value="{{ $star }}" class="hidden peer" required>
                                                            <svg class="w-8 h-8 text-gray-300 peer-checked:text-cinema3-gold hover:text-cinema3-goldDark transition"
                                                                 fill="currentColor"
                                                                 viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Review -->
                                            <div class="mb-4">
                                                <label class="block text-gray-700 text-sm mb-2">Review</label>
                                                <textarea name="review" rows="3"
                                                          class="w-full bg-white border border-cinema3-navy/10 text-cinema3-navy rounded p-3 focus:border-cinema3-gold focus:ring-1 focus:ring-cinema3-gold"
                                                          placeholder="Share your thoughts..."></textarea>
                                            </div>

                                            <button type="submit"
                                                    class="bg-cinema3-gold text-cinema3-navy font-bold py-2 px-6 rounded-lg hover:bg-cinema3-goldDark transition">
                                                Submit Review
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-8">
                                        You have already reviewed this movie.
                                    </div>
                                @endif
                            @else
                                <div class="bg-cinema3-cream p-4 rounded mb-8 text-center border border-cinema3-navy/10">
                                    <p class="text-gray-700">
                                        Please <a href="{{ route('login') }}" class="text-cinema3-goldDark underline font-bold">login</a> to leave a review.
                                    </p>
                                </div>
                            @endauth

                            <!-- Review List -->
                            <div class="space-y-6">
                                @forelse($movie->reviews as $review)
                                    <div class="bg-white p-6 rounded-lg border border-cinema3-navy/10 shadow">
                                        <div class="flex items-center mb-4">
                                            <div class="w-10 h-10 rounded-full bg-cinema3-cream flex items-center justify-center text-cinema3-navy font-bold mr-4 overflow-hidden border border-cinema3-gold">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-cinema3-navy font-bold">{{ $review->user->name }}</div>
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <span class="text-cinema3-goldDark font-bold mr-2">★ {{ $review->rating }}/5</span>
                                                    <span>{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-gray-700">{{ $review->review }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">No reviews yet. Be the first to review!</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
