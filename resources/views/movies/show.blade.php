<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cinema-gold leading-tight">
            {{ $movie->title }}
        </h2>
    </x-slot>
    <div class="py-12 bg-cinema-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-cinema-800 rounded-lg shadow-2xl overflow-hidden border border-cinema-700">
                <div class="md:flex">
                    <!-- Movie Poster -->
                    <div class="md:w-1/3 relative">
                         <img src="{{ Str::startsWith($movie->poster, 'http') ? $movie->poster : 'https://placehold.co/400x600/1a1a1a/d4af37?text=' . urlencode($movie->title) }}" 
                                 alt="{{ $movie->title }}" 
                                 class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-cinema-900/90 to-transparent md:bg-none"></div>
                    </div>

                    <!-- Movie Info -->
                    <div class="p-8 md:w-2/3 md:p-12">
                        <div class="flex items-center space-x-2 text-sm text-cinema-gold font-bold mb-4 uppercase tracking-wide">
                            <span>{{ $movie->genre }}</span>
                            <span>&bull;</span>
                            <span>{{ $movie->duration_minutes }} Min</span>
                            <span>&bull;</span>
                            <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                            {{ $movie->title }}
                        </h1>

                        <div class="flex items-center mb-6">
                            <div class="flex items-center bg-cinema-700 text-yellow-400 px-3 py-1 rounded-md border border-cinema-gold/30">
                                <svg class="w-5 h-5 fill-current mr-1" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <span class="font-bold text-lg">{{ $movie->rating }}</span>
                                <span class="text-gray-400 text-sm ml-1">/ 10</span>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-white font-bold text-lg mb-2">Synopsis</h3>
                            <p class="text-gray-300 text-lg leading-relaxed">
                                {{ $movie->synopsis ?? $movie->description }}
                            </p>
                        </div>

                        <!-- Showtimes -->
                        <div class="border-t border-cinema-700 pt-8">
                            <h3 class="text-xl font-bold text-white mb-4">Available Showtimes</h3>
                            
                            @if($movie->showtimes->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($movie->showtimes as $showtime)
                                        <div class="bg-cinema-700 p-4 rounded-lg border border-cinema-600 hover:border-cinema-gold transition duration-300 flex justify-between items-center group">
                                            <div>
                                                <div class="text-white font-bold text-lg">
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('h:i A') }}
                                                </div>
                                                <div class="text-gray-400 text-sm">
                                                    {{ $showtime->studio->name }} &bull; 
                                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('D, d M') }}
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-cinema-gold font-bold">
                                                     IDR {{ number_format($showtime->price, 0, ',', '.') }}
                                                </div>
                                                @auth
                                                    <a href="{{ route('booking.create', $showtime) }}" class="inline-block mt-2 bg-cinema-red text-white text-xs px-3 py-1 rounded hover:bg-red-700 transition">
                                                        Book Seat
                                                    </a>
                                                @else
                                                     <a href="{{ route('login') }}" class="inline-block mt-2 bg-gray-600 text-white text-xs px-3 py-1 rounded hover:bg-gray-500 transition">
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
                        <div class="border-t border-cinema-700 pt-8 mt-8">
                            <h3 class="text-xl font-bold text-white mb-6">Reviews & Ratings</h3>

                            <!-- Review Form -->
                            @auth
                                @if(!$movie->reviews->where('user_id', auth()->id())->count())
                                    <div class="bg-cinema-700 p-6 rounded-lg mb-8 border border-cinema-600">
                                        <h4 class="text-white font-bold mb-4">Write a Review</h4>
                                        <form action="{{ route('movie.review.store', $movie) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block text-gray-400 text-sm mb-2">Rating</label>
                                                <div class="flex space-x-4">
                                                    @foreach([1, 2, 3, 4, 5] as $star)
                                                        <label class="cursor-pointer">
                                                            <input type="radio" name="rating" value="{{ $star }}" class="hidden peer" required>
                                                            <svg class="w-8 h-8 text-gray-600 peer-checked:text-cinema-gold hover:text-yellow-500 transition" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-gray-400 text-sm mb-2">Review</label>
                                                <textarea name="review" rows="3" class="w-full bg-cinema-800 border border-cinema-600 text-white rounded p-2 focus:border-cinema-gold focus:ring-1 focus:ring-cinema-gold" placeholder="Share your thoughts..."></textarea>
                                            </div>
                                            <button type="submit" class="bg-cinema-gold text-cinema-900 font-bold py-2 px-6 rounded hover:bg-yellow-400 transition">
                                                Submit Review
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="bg-green-900/50 border border-green-700 text-green-200 p-4 rounded mb-8">
                                        You have already reviewed this movie.
                                    </div>
                                @endif
                            @else
                                <div class="bg-cinema-700 p-4 rounded mb-8 text-center">
                                    <p class="text-gray-300">Please <a href="{{ route('login') }}" class="text-cinema-gold underline">login</a> to leave a review.</p>
                                </div>
                            @endauth

                            <!-- Reviews List -->
                            <div class="space-y-6">
                                @forelse($movie->reviews as $review)
                                    <div class="bg-cinema-800 p-6 rounded-lg border border-cinema-700">
                                        <div class="flex items-center mb-4">
                                            <div class="w-10 h-10 rounded-full bg-cinema-600 flex items-center justify-center text-white font-bold mr-4 overflow-hidden border border-cinema-gold">
                                                @if($review->user->avatar)
                                                    <img src="{{ asset('storage/' . $review->user->avatar) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($review->user->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-white font-bold">{{ $review->user->name }}</div>
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <span class="text-cinema-gold font-bold mr-2">★ {{ $review->rating }}/5</span>
                                                    <span>{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-gray-300">{{ $review->review }}</p>
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
