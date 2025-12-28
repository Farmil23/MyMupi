<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MyMupi') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Tailwind Config -->
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            cinema3: {
                                navy: '#1D2A3A',
                                navySoft: '#24364C',
                                gold: '#F3C44E',
                                goldDark: '#D9A933',
                                cream: '#F6F1E7',
                                dark: '#111827',
                            }
                        }
                    }
                }
            }
        </script>

        <!-- Alpine JS -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-cinema3-navy antialiased min-h-screen bg-cinema3-cream">
        
        <div class="min-h-screen w-full flex">
            
            <!-- Left Side: Hero / Brand (Hidden on Mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-cinema3-navy relative overflow-hidden flex-col justify-between p-12 text-white">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-cinema3-navySoft rounded-full opacity-50 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-cinema3-goldDark/20 rounded-full opacity-50 blur-3xl"></div>

                <!-- Logo -->
                <div class="relative z-10 w-full flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto object-contain">
                    <span class="font-bold text-2xl tracking-tight hidden">MyMupi</span>
                </div>

                <!-- Main Content -->
                <div class="relative z-10 max-w-lg">
                    <h1 class="text-6xl font-black leading-[1.1] mb-6">
                        Start <br/>
                        Your <br/>
                        Movie <br/>
                        Night <br/>
                        Without <br/>
                        <span class="text-cinema3-gold">the Hassle.</span>
                    </h1>
                    
                    <p class="text-lg text-white/70 mb-10 leading-relaxed font-light">
                        Book tickets, pick seats, and keep your tickets in one place — fast and simple.
                    </p>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 group">
                             <div class="h-12 w-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-cinema3-gold group-hover:text-cinema3-navy transition-all duration-300">
                                ✓
                            </div>
                            <div class="bg-white/5 border border-white/10 rounded-2xl px-6 py-3 text-sm font-bold tracking-wide uppercase group-hover:bg-white/10 transition-all">
                                Seat Selection
                            </div>
                        </div>
                         <div class="flex items-center gap-4 group">
                             <div class="h-12 w-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-cinema3-gold group-hover:text-cinema3-navy transition-all duration-300">
                                ✓
                            </div>
                            <div class="bg-white/5 border border-white/10 rounded-2xl px-6 py-3 text-sm font-bold tracking-wide uppercase group-hover:bg-white/10 transition-all">
                                Instant Tickets
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer/Creds -->
                <div class="relative z-10 text-white/30 text-xs font-medium">
                    &copy; {{ date('Y') }} MyMupi Cinemas.
                </div>
            </div>

            <!-- Right Side: Form (Full Width Mobile, Half Desktop) -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 md:p-12 overflow-y-auto relative bg-[#f8f9fa] lg:bg-white">
                 <!-- Mobile Logo (Only visible on small screens) -->
                <div class="lg:hidden absolute top-8 left-8 flex items-center gap-2 mb-8">
                     <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto">
                </div>

                <div class="w-full max-w-md bg-white p-8 lg:p-0 rounded-3xl lg:rounded-none shadow-xl lg:shadow-none">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
