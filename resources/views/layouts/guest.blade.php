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
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">

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
                            cinema: {
                                900: '#121212',
                                800: '#1a1a1a',
                                700: '#242424',
                                red: '#e50914',
                            },
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

    <body class="min-h-screen bg-cinema3-cream">
        <div class="min-h-screen font-sans text-cinema3-navy antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
