<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">Edit Studio</h2>
            <p class="text-sm text-white/60">Update studio layout and capacity.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-6 md:p-8">
                <form method="POST" action="{{ route('admin.studios.update', $studio->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-cinema3-navy">Studio Name</label>
                            <input name="name" value="{{ old('name', $studio->name) }}" required
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Total Rows</label>
                            <input type="number" name="total_rows" value="{{ old('total_rows', $studio->total_rows) }}" required min="1" max="26"
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('total_rows') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-cinema3-navy">Seats per Row</label>
                            <input type="number" name="seats_per_row" value="{{ old('seats_per_row', $studio->seats_per_row) }}" required min="1" max="20"
                                   class="mt-1 w-full rounded-xl border border-cinema3-navy/20 bg-white px-3 py-2 text-cinema3-navy
                                          focus:border-cinema3-gold focus:ring focus:ring-cinema3-gold/30">
                            @error('seats_per_row') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white border border-cinema3-navy/10 p-4">
                        <div class="text-sm font-semibold text-cinema3-navy">Current capacity</div>
                        <div class="mt-1 text-cinema3-navy/70 text-sm">
                            {{ $studio->total_rows }} rows × {{ $studio->seats_per_row }} seats = <span class="font-bold">{{ $studio->capacity }}</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                       hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                            Update Studio
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
