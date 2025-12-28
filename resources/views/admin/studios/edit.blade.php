<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-3xl text-cinema3-gold leading-tight tracking-tight">Edit Studio</h2>
                <p class="text-sm text-white/60 font-medium">Update studio layout and capacity.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-3xl bg-white/90 backdrop-blur-xl border border-white/40 shadow-2xl overflow-hidden relative">
                 <!-- Decorative gradient line -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cinema3-navy via-cinema3-gold to-cinema3-navy"></div>

                <div class="p-8 md:p-10">
                    <form method="POST" action="{{ route('admin.studios.update', $studio->id) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Configuration -->
                        <div>
                            <h3 class="text-lg font-extrabold text-cinema3-navy flex items-center gap-2 mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-cinema3-navy/5 text-cinema3-navy">🏗️</span>
                                Studio Configuration
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Studio Name</label>
                                    <input name="name" value="{{ old('name', $studio->name) }}" required
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                    @error('name') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Total Rows</label>
                                    <input type="number" name="total_rows" value="{{ old('total_rows', $studio->total_rows) }}" required min="1" max="26"
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                    @error('total_rows') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-cinema3-navy/70 uppercase tracking-wider mb-1.5 ml-1">Seats per Row</label>
                                    <input type="number" name="seats_per_row" value="{{ old('seats_per_row', $studio->seats_per_row) }}" required min="1" max="20"
                                           class="block w-full rounded-2xl border-2 border-cinema3-navy/5 bg-white px-4 py-3.5 text-cinema3-navy font-bold
                                                  focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/20 transition-all placeholder-cinema3-navy/20">
                                    @error('seats_per_row') <p class="mt-1 text-sm text-red-600 font-medium pl-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Capacity Info -->
                        <div class="md:col-span-2 rounded-2xl bg-cinema3-navy/5 border border-cinema3-navy/10 p-5 flex items-start gap-3">
                            <span class="text-xl">📊</span>
                            <div>
                                <h4 class="text-sm font-bold text-cinema3-navy uppercase tracking-wide">Current Capacity</h4>
                                <p class="mt-1 text-cinema3-navy/80 text-sm font-medium">
                                    {{ $studio->total_rows }} rows × {{ $studio->seats_per_row }} seats = <span class="font-black text-cinema3-goldDark">{{ $studio->capacity }} Seats</span>
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4 pt-6">
                            <button type="submit"
                                    class="flex-1 md:flex-none inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cinema3-gold to-cinema3-goldDark px-8 py-4 text-base font-black text-cinema3-navy shadow-lg shadow-cinema3-gold/20
                                           hover:shadow-xl hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition-all duration-300">
                                Update Studio
                            </button>

                            <a href="{{ route('admin.studios.index') }}"
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
