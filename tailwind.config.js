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
                sans: ['Inter', '"Plus Jakarta Sans"', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                notion: {
                    bg: '#FFFFFF',
                    sidebar: '#F7F7F5',
                    text: '#37352F',
                    muted: '#787774',
                    border: '#EBEBEA',
                    hover: '#EFEFED',
                    active: '#E8E8E6',
                    primary: '#2F2E2B',
                },
                brand: {
                    50: '#F7F7F5',
                    100: '#EFEFED',
                    200: '#E8E8E6',
                    300: '#D3D3D0',
                    400: '#A4A4A0',
                    500: '#787774',
                    600: '#37352F',
                    700: '#2F2E2B',
                    800: '#191919',
                    900: '#0F0F0F',
                },
                darkrail: '#2F2E2B',
            },
        },
    },


    plugins: [forms],
};
