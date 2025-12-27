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

            <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl overflow-hidden">
                <div class="p-6 md:p-8 flex items-center justify-between gap-4">
                    <h3 class="text-lg font-extrabold text-cinema3-navy">Studio List</h3>
                    <span class="text-sm text-cinema3-navy/60">{{ $studios->total() }} total</span>
                </div>

                <div class="overflow-x-auto border-t border-white/30">
                    <table class="min-w-full divide-y divide-cinema3-navy/10">
                        <thead class="bg-cinema3-navy/95 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Rows</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Seats/Row</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Capacity</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-cinema3-navy/10 bg-white/60">
                            @forelse($studios as $studio)
                                <tr class="hover:bg-white/80 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-cinema3-navy">{{ $studio->name }}</div>
                                        <div class="text-sm text-cinema3-navy/60">Layout: {{ $studio->total_rows }} × {{ $studio->seats_per_row }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-cinema3-navy/80">{{ $studio->total_rows }}</td>
                                    <td class="px-6 py-4 text-cinema3-navy/80">{{ $studio->seats_per_row }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full bg-cinema3-gold/20 text-cinema3-navy px-3 py-1 text-xs font-semibold border border-cinema3-gold/30">
                                            {{ $studio->capacity }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.studios.edit', $studio->id) }}"
                                               class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-cinema3-navy border border-cinema3-navy/10 shadow-sm
                                                      hover:bg-white/80 focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.studios.destroy', $studio->id) }}"
                                                  onsubmit="return confirm('Delete this studio?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center justify-center rounded-xl bg-cinema3-navy px-4 py-2 text-sm font-semibold text-white shadow-sm
                                                               hover:bg-cinema3-navySoft focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center">
                                        <div class="mx-auto h-14 w-14 rounded-2xl bg-cinema3-navy/10 border border-cinema3-navy/10 flex items-center justify-center text-2xl">
                                            🏛️
                                        </div>
                                        <h3 class="mt-4 text-xl font-extrabold text-cinema3-navy">No studios yet</h3>
                                        <p class="mt-1 text-cinema3-navy/60">Create a studio layout to schedule showtimes.</p>
                                        <a href="{{ route('admin.studios.create') }}"
                                           class="mt-6 inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-6 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                                  hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                            + Add Studio
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-white/60 border-t border-white/30">
                    {{ $studios->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
