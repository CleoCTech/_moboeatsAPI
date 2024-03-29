import defaultTheme from 'tailwindcss/defaultTheme';

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
                sans: ['CenturyGothic', ...defaultTheme.fontFamily.sans],
                comfortaa: ['Comfortaa'],
            },
            backgroundImage: {
                'home-hero' : "url('/public/assets/img/Ad-copy.jpg')",
                'merchant-hero' : "url('/public/assets/img/merchant-home.png')",
            },
            screens: {
                '4xl': '1900px'
            },
            colors: {
                'primary-one': '#2E5945',
                'primary-two': '#F8C410',
                'secondary-one': '#FFE5D3',
                'secondary-two': '#F2F2F2',
                'secondary-three': '#FFFFFF',
                'secondary-four': '#F9CB0B',
                'secondary-five': '#30D1D1',
                'secondary-six': '#00D666',
                'primary-three': '#F8F7F0'
            },
        },
    },
};
