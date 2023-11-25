import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
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
                primary: '#35F69A',
                primarylight: '#C9FDE4',
                secondary: '#373737',
                secondarylight: '#474747',
                gray1: '#313131',
                gray2: '#97989A',
                gray3: '#BEBFC1',
                gray4: '#D9D9D9',
            }
        },
    },

    plugins: [forms, typography],
};
