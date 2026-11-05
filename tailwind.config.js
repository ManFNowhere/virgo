import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    light:   '#ff6b6b',
                    // DEFAULT: '#e50914', 
                    DEFAULT: '#500071', 
                    dark:    '#b20710',
                },
                surface: {
                    DEFAULT: '#141414', 
                    card:    '#1f1f1f', 
                    raised:  '#2a2a2a', 
                    border:  '#3a3a3a', 
                },
                content: {
                    primary:   '#ffffff',
                    secondary: '#b3b3b3',
                    muted:     '#6b6b6b',
                },
            },
        },
    },

    safelist: [
        'accent-brand',
    ],

    plugins: [forms],
};
