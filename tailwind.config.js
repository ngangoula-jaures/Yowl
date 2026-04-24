import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                yowl: {
                    50: '#fdf7ff',
                    100: '#fbeefe',
                    200: '#f3d6fb',
                    300: '#e9b8f6',
                    400: '#db84ee',
                    500: '#c758e6',
                    600: '#9f2fb8',
                    700: '#7b1f86',
                    800: '#56144f',
                    900: '#360a30'
                },
                accent: {
                    pink: '#ff69b4',
                    orange: '#ff7a18',
                    teal: '#34d399'
                },
                bg: {
                    DEFAULT: '#0b0b0d',
                    soft: '#0f0f12',
                    card: '#0f0f13'
                }
            },
            boxShadow: {
                'neon-lg': '0 20px 50px rgba(199,63,255,0.12), inset 0 -6px 40px rgba(0,0,0,0.5)'
            },
            keyframes: {
                float: {
                    '0%,100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-6px)' }
                },
                pulseNeon: {
                    '0%': { boxShadow: '0 0 0px rgba(199,63,255,0.0)' },
                    '50%': { boxShadow: '0 0 18px rgba(199,63,255,0.14)' },
                    '100%': { boxShadow: '0 0 0px rgba(199,63,255,0.0)' }
                }
            },
            animation: {
                float: 'float 6s ease-in-out infinite',
                'pulse-neon': 'pulseNeon 2.6s ease-in-out infinite'
            }
        },
    },

    plugins: [forms, typography],
};
