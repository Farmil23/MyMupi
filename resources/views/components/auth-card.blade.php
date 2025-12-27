<div class="min-h-screen bg-cinema3-navy">
    <div class="min-h-screen lg:grid lg:grid-cols-2">

        <!-- LEFT: Promo Panel -->
        <div class="hidden lg:flex relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-cinema3-navySoft via-cinema3-navy to-cinema3-navy"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-cinema3-gold blur-3xl"></div>
                <div class="absolute -bottom-40 -right-40 h-[28rem] w-[28rem] rounded-full bg-white blur-3xl"></div>
            </div>

            <div class="relative z-10 w-full p-12 flex flex-col">
                @isset($promo)
                    {{ $promo }}
                @else
                    <!-- Default Promo (applies to all auth pages) -->
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center">
                            <span class="text-white font-bold">M</span>
                        </div>
                        <div class="text-white font-semibold tracking-wide">MyMupi</div>
                    </div>

                    <div class="mt-14">
                        <h1 class="text-4xl font-bold leading-tight text-white">
                            Start Your Movie Night<br>
                            <span class="text-cinema3-gold">Without the Hassle.</span>
                        </h1>

                        <p class="mt-5 text-white/70 max-w-md">
                            Book tickets, pick seats, and keep your tickets in one place — fast and simple.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-4 py-2 text-sm text-white">
                                ✓ Seat Selection
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-4 py-2 text-sm text-white">
                                ✓ Instant Tickets
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-4 py-2 text-sm text-white">
                                ✓ Movie Reviews
                            </span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="max-w-md rounded-2xl bg-white/10 border border-white/10 p-6">
                            <div class="text-cinema3-gold text-sm">★★★★★</div>
                            <p class="mt-2 text-white/80 text-sm">
                                “Booking is smooth and the seat selection is super clear. Looks premium!”
                            </p>
                            <p class="mt-4 text-white/60 text-xs">
                                — MyMupi User
                            </p>
                        </div>
                    </div>
                @endisset
            </div>
        </div>

        <!-- RIGHT: Form Panel -->
        <div class="flex items-center justify-center px-4 py-12 sm:px-6 lg:px-10">
            <div class="w-full max-w-md">
                <div class="flex justify-center mb-8">
                    {{ $logo }}
                </div>

                <div class="rounded-2xl bg-white/90 backdrop-blur-md border border-white/10 shadow-2xl px-8 py-7">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </div>
</div>
