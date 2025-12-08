<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'cinema': {
                                900: '#121212',
                                800: '#1a1a1a',
                                700: '#262626',
                                'gold': '#d4af37',
                                'red': '#e50914',
                            }
                        }
                    }
                }
            }
        </script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-cinema-900">
        <div class="font-sans text-gray-100 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
