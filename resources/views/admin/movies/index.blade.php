<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Movies</h2>
                <p class="text-sm text-white/60">Manage movie catalog, posters, and details.</p>
            </div>

            <a href="{{ route('admin.movies.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-5 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                      hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                + Add New Movie
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-cinema3-gold text-cinema3-navy px-5 py-4 font-semibold shadow-2xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter Bar (Optional for future, placeholder for spacing) -->
            <!-- <div class="mb-6 flex gap-4"> ... </div> -->

            <!-- Movies Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($movies as $movie)
                    @php
                        $poster = $movie->poster ?? null;
                         if ($poster && !str_starts_with($poster, 'http')) {
                            $poster = asset('storage/' . $poster);
                        }
                        $release = $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : '';
                    @endphp

                    <div class="group relative bg-white rounded-3xl border border-cinema3-navy/10 shadow-lg overflow-hidden flex flex-col transition-all hover:-translate-y-1 hover:shadow-xl">
                         <!-- Poster Section -->
                        <div class="aspect-[2/3] w-full bg-cinema3-cream relative overflow-hidden">
                            @if($poster)
                                <img src="{{ $poster }}" alt="{{ $movie->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-cinema3-navy/40 bg-cinema3-navy/5">
                                    <span class="text-4xl">🎬</span>
                                    <span class="text-xs font-bold mt-2 uppercase">No Poster</span>
                                </div>
                            @endif
                            
                            <!-- Overlay Actions -->
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3 backdrop-blur-sm">
                                <a href="{{ route('admin.movies.edit', $movie->id) }}" 
                                   class="h-10 w-10 rounded-full bg-white text-cinema3-navy flex items-center justify-center hover:bg-cinema3-gold hover:text-white transition shadow-lg"
                                   title="Edit Movie">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                
                                <form method="POST" action="{{ route('admin.movies.destroy', $movie->id) }}" onsubmit="return confirm('Delete this movie?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="h-10 w-10 rounded-full bg-red-500 text-white flex items-center justify-center hover:bg-red-600 transition shadow-lg"
                                            title="Delete Movie">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>

                             <!-- Rating Badge -->
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-black text-cinema3-navy shadow-sm">
                                ⭐ {{ $movie->rating }}
                            </div>
                        </div>

                        <!-- Info Section -->
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-cinema3-goldDark border border-cinema3-gold/30 px-2 py-0.5 rounded-md bg-cinema3-gold/10">
                                    {{ $movie->genre }}
                                </span>
                                <span class="text-xs font-semibold text-cinema3-navy/40">{{ $release }}</span>
                            </div>

                            <h3 class="text-lg font-black text-cinema3-navy leading-tight mb-2 line-clamp-1" title="{{ $movie->title }}">
                                {{ $movie->title }}
                            </h3>

                             <p class="text-xs text-cinema3-navy/60 line-clamp-2 mb-4 flex-1">
                                {{ $movie->description ?? 'No description available.' }}
                            </p>

                            <div class="pt-4 border-t border-cinema3-navy/5 flex items-center justify-between text-xs font-semibold text-cinema3-navy/50">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $movie->duration_minutes }}m
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                                    {{ $movie->id }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white/50 rounded-3xl border border-dashed border-cinema3-navy/20">
                        <div class="mx-auto h-16 w-16 rounded-2xl bg-cinema3-navy/5 flex items-center justify-center text-3xl mb-4">
                            🎬
                        </div>
                        <h3 class="text-xl font-bold text-cinema3-navy">No movies ordered yet</h3>
                        <p class="text-cinema3-navy/50 mb-6">Start building your catalog by adding a new movie.</p>
                        <a href="{{ route('admin.movies.create') }}" class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-bold text-cinema3-navy hover:bg-cinema3-goldDark transition shadow-sm">
                            + Add First Movie
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $movies->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
