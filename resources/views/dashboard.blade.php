<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-2xl text-cinema3-gold leading-tight">
                Dashboard
            </h2>
            <p class="text-sm text-white/60">
                Your account overview and latest activity.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Top Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Hero -->
                <div class="lg:col-span-2 rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-8">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <!-- ✅ Dibesar-in -->
                            <p class="text-lg font-medium text-cinema3-navy/65">
                                Welcome back,
                            </p>

                            <h3 class="mt-1 text-4xl sm:text-5xl font-extrabold tracking-tight text-cinema3-navy">
                                {{ auth()->user()->name }}
                            </h3>

                            <p class="mt-4 text-cinema3-navy/70 max-w-2xl">
                                Ready for another movie night? Browse what’s playing and book your seats in seconds.
                            </p>

                            <!-- ✅ Button dibuat konsisten -->
                            <div class="mt-7 flex flex-wrap gap-3">
                                <a href="{{ route('home') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-5 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                          hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                    Browse Movies
                                </a>

                                <a href="{{ route('booking.index') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-cinema3-navy px-5 py-3 text-sm font-semibold text-white shadow-sm
                                          hover:bg-cinema3-navySoft focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                                    My Tickets
                                </a>

                                <a href="{{ route('profile.edit') }}"
                                   class="inline-flex items-center justify-center rounded-xl bg-white/90 px-5 py-3 text-sm font-semibold text-cinema3-navy border border-cinema3-navy/10 shadow-sm
                                          hover:bg-white focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                                    Edit Profile
                                </a>
                            </div>
                        </div>

                        <div class="hidden sm:flex">
                            <div class="h-16 w-16 rounded-2xl bg-cinema3-gold/20 border border-cinema3-gold/30 flex items-center justify-center">
                                <span class="text-2xl">🎬</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity -->
                <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-8">
                    <h4 class="text-lg font-semibold text-cinema3-navy">Your Activity</h4>

                    <div class="mt-6 flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-cinema3-navy/10 border border-cinema3-navy/10 flex items-center justify-center">
                            <span class="text-xl">🎟️</span>
                        </div>

                        <div>
                            <div class="text-4xl font-extrabold text-cinema3-navy">
                                {{ $bookingsCount ?? 0 }}
                            </div>
                            <div class="text-sm text-cinema3-navy/60">
                                Tickets Purchased
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('booking.index') }}"
                       class="mt-6 inline-flex items-center text-sm font-semibold text-cinema3-navy hover:text-cinema3-navySoft underline">
                        View all history →
                    </a>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Latest Ticket -->
                <div class="lg:col-span-2 rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-8">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-cinema3-navy">Latest Ticket</h4>
                        <span class="text-xs text-cinema3-navy/50">Most recent booking</span>
                    </div>

                    @if($latestBooking)
                        @php
                            $start = optional($latestBooking->showtime)->start_time;
                            $movieTitle = optional(optional($latestBooking->showtime)->movie)->title ?? 'Movie';
                            $studioName = optional(optional($latestBooking->showtime)->studio)->name ?? '-';
                        @endphp

                        <div class="mt-6 rounded-2xl bg-white border border-cinema3-navy/10 shadow p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                                <div>
                                    <div class="text-xl font-bold text-cinema3-navy">
                                        {{ $movieTitle }}
                                    </div>

                                    <div class="mt-1 text-sm text-cinema3-navy/70">
                                        {{ $start ? \Carbon\Carbon::parse($start)->format('D, d M Y • H:i') : '-' }}
                                    </div>

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center rounded-full bg-cinema3-gold/20 text-cinema3-navy px-3 py-1 text-xs font-semibold border border-cinema3-gold/30">
                                            {{ $studioName }}
                                        </span>

                                        <span class="inline-flex items-center rounded-full bg-cinema3-navy/10 text-cinema3-navy px-3 py-1 text-xs font-semibold border border-cinema3-navy/10">
                                            Status: {{ $latestBooking->status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('booking.index') }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-white/90 px-5 py-3 text-sm font-semibold text-cinema3-navy border border-cinema3-navy/10 shadow-sm
                                              hover:bg-white focus:outline-none focus:ring-2 focus:ring-cinema3-gold/30 transition">
                                        All Tickets
                                    </a>

                                    <a href="{{ route('booking.success', $latestBooking->id) }}"
                                       class="inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-5 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                              hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                        View e-Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-white/40 bg-white/60 p-10 text-center">
                            <div class="text-cinema3-navy font-semibold">
                                No tickets yet
                            </div>
                            <p class="mt-1 text-sm text-cinema3-navy/60">
                                Book your first movie and it will appear here.
                            </p>
                            <a href="{{ route('home') }}"
                               class="mt-5 inline-flex items-center justify-center rounded-xl bg-cinema3-gold px-5 py-3 text-sm font-semibold text-cinema3-navy shadow-sm
                                      hover:bg-cinema3-goldDark focus:outline-none focus:ring-2 focus:ring-cinema3-gold/40 transition">
                                Browse Movies
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="rounded-2xl bg-white/85 backdrop-blur-md border border-white/20 shadow-2xl p-8">
                    <h4 class="text-lg font-semibold text-cinema3-navy">Quick Actions</h4>

                    <div class="mt-6 grid gap-3">
                        <a href="{{ route('home') }}"
                           class="rounded-xl border border-cinema3-navy/10 bg-white/90 px-4 py-4 shadow-sm hover:bg-white transition">
                            <div class="font-semibold text-cinema3-navy">Browse Movies</div>
                            <div class="text-sm text-cinema3-navy/60">See what’s playing now</div>
                        </a>

                        <a href="{{ route('booking.index') }}"
                           class="rounded-xl border border-cinema3-navy/10 bg-white/90 px-4 py-4 shadow-sm hover:bg-white transition">
                            <div class="font-semibold text-cinema3-navy">My Tickets</div>
                            <div class="text-sm text-cinema3-navy/60">View your booking history</div>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="rounded-xl border border-cinema3-navy/10 bg-white/90 px-4 py-4 shadow-sm hover:bg-white transition">
                            <div class="font-semibold text-cinema3-navy">Edit Profile</div>
                            <div class="text-sm text-cinema3-navy/60">Update password & avatar</div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
