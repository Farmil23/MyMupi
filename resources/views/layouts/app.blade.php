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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

<body class="min-h-screen font-sans antialiased text-cinema3-dark">
    <div class="min-h-screen relative overflow-x-hidden">
        <!-- Background layer -->
        <div class="absolute inset-0 bg-gradient-to-b from-cinema3-navy via-cinema3-navySoft to-cinema3-cream"></div>
        <div class="absolute inset-0 opacity-25 pointer-events-none">
            <div class="absolute -top-28 -left-24 h-80 w-80 rounded-full bg-cinema3-gold blur-3xl"></div>
            <div class="absolute top-40 -right-40 h-[28rem] w-[28rem] rounded-full bg-white blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-cinema3-gold/60 blur-3xl"></div>
        </div>

        <!-- Content layer -->
        <div class="relative z-10 min-h-screen flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-cinema3-navy/70 backdrop-blur-md border-b border-white/10 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
