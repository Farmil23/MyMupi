<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Add Studio</h2>
            <p class="text-sm text-white/60">Create a new studio layout.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 md:p-8">
                <form method="POST" action="{{ route('admin.studios.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Studio Name</label>
                            <input name="name" value="{{ old('name') }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Total Rows</label>
                            <input type="number" name="total_rows" value="{{ old('total_rows', 10) }}" required min="1" max="26"
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('total_rows') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            <p class="mt-1 text-xs text-cinema3-navy/50">Recommended max 26 (A–Z).</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Seats per Row</label>
                            <input type="number" name="seats_per_row" value="{{ old('seats_per_row', 12) }}" required min="1" max="20"
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('seats_per_row') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                       hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                            Save Studio
                        </button>

                        <a href="{{ route('admin.studios.index') }}"
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
