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
            colors: {
                berkleyBlue: '#1D3557',
                oxfordBlue: '#0F1D2E',
                lightCyan: '#E0FBFC',
                cerulean : '#457B9D',
                ivory: '#F4F4F4',
                honeydew: '#F1FAEE',
                burntSienna: '#EE6C4D',

            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
