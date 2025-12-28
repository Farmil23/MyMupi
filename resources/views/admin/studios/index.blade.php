<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Studios</h2>
                <p class="text-sm text-white/60">Manage studio layout and capacity.</p>
            </div>

            <a href="{{ route('admin.studios.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-5 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                      hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                + Add New Studio
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

            <!-- Studios Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($studios as $studio)
                    <div class="group relative bg-white/80 backdrop-blur-sm rounded-3xl border border-white/40 shadow-xl overflow-hidden hover:scale-[1.02] transition-all duration-300">
                        <!-- Top Decor -->
                        <div class="h-2 w-full bg-gradient-to-r from-cinema3-navy via-cinema3-navySoft to-cinema3-gold"></div>
                        
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-2xl font-black text-cinema3-navy">{{ $studio->name }}</h3>
                                    <p class="text-sm font-semibold text-cinema3-navy/40">Studio ID: #{{ $studio->id }}</p>
                                </div>
                                <div class="h-10 w-10 rounded-full bg-cinema3-navy/5 flex items-center justify-center text-xl shadow-inner">
                                    🏛️
                                </div>
                            </div>
                            
                            <!-- Stats -->
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div class="bg-cinema3-cream rounded-2xl p-3 border border-cinema3-navy/5 text-center">
                                    <div class="text-xs font-bold text-cinema3-navy/40 uppercase">Total Seats</div>
                                    <div class="text-2xl font-black text-cinema3-navy">{{ $studio->capacity }}</div>
                                </div>
                                <div class="bg-cinema3-cream rounded-2xl p-3 border border-cinema3-navy/5 text-center">
                                    <div class="text-xs font-bold text-cinema3-navy/40 uppercase">Layout</div>
                                    <div class="text-2xl font-black text-cinema3-navy">{{ $studio->total_rows }}<span class="text-sm text-cinema3-navy/30">x</span>{{ $studio->seats_per_row }}</div>
                                </div>
                            </div>

                            <!-- Visual Seat Hint (Abstract) -->
                            <div class="mt-6 flex justify-center gap-1 opacity-20">
                                @for($i=0; $i<6; $i++)
                                    <div class="w-2 h-2 rounded-full bg-cinema3-navy"></div>
                                @endfor
                            </div>

                            <!-- Actions -->
                            <div class="mt-6 flex items-center gap-3 border-t border-cinema3-navy/5 pt-4">
                                <a href="{{ route('admin.studios.edit', $studio->id) }}" class="flex-1 rounded-xl bg-white border border-cinema3-navy/10 py-2 text-center text-sm font-bold text-cinema3-navy hover:bg-cinema3-cream transition">
                                    Edit Layout
                                </a>
                                
                                <form method="POST" action="{{ route('admin.studios.destroy', $studio->id) }}" onsubmit="return confirm('Delete this studio?');" class="block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="h-full px-4 rounded-xl bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition font-bold text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                     <div class="col-span-full py-16 text-center bg-white/50 rounded-3xl border border-dashed border-cinema3-navy/20">
                        <div class="mx-auto h-16 w-16 rounded-2xl bg-cinema3-navy/5 flex items-center justify-center text-3xl mb-4">
                            🏗️
                        </div>
                        <h3 class="text-xl font-bold text-cinema3-navy">No studios configured</h3>
                        <p class="text-cinema3-navy/50 mb-6 max-w-sm mx-auto">Create a studio layout (Rows x Seats) to start scheduling movie showtimes.</p>
                        <a href="{{ route('admin.studios.create') }}" class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-bold text-cinema3-navy hover:bg-cinema3-goldDark transition shadow-sm">
                            + Create First Studio
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $studios->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
