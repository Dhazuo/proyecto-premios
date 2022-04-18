const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
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
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                lochmara: {
                    DEFAULT: '#076FB8',
                    '50': '#7DC6FA',
                    '100': '#69BEF9',
                    '200': '#42ADF8',
                    '300': '#1A9CF6',
                    '400': '#0887DF',
                    '500': '#076FB8',
                    '600': '#054E82',
                    '700': '#032E4C',
                    '800': '#010D16',
                    '900': '#000000'
                },
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
