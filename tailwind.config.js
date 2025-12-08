const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'cinema': {
                    900: '#121212', // Main Background
                    800: '#1a1a1a', // Secondary Background
                    700: '#262626', // Cards
                    'gold': '#d4af37', // Brand Color
                    'red': '#e50914', // Accent Color
                }
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
