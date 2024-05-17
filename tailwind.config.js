import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "virtual-blue": "#0019DA",
                "gray-circles": "#E5E7EB",
                "graybell": "#d4d4d4",
                "audostrade" : "#40865c",
                "audostradeHover" : "#47ae70",
                "blu": "#446995",
                "icon-color": "#64748b",
                "bg-icon": "#F1F5F9",
            },
            zIndex: {
                '900': '999999999',
                '700': '999999',
                '400': '40000',
                '200': '2000',
            },
        },
    },

    plugins: [forms],
};
