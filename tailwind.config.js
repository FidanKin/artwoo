/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  mode: 'jit',
  content: [
    "./node_modules/flowbite-datepicker/**/*.js",
    "./resources/views/*.blade.php",
    "./resources/views/**/*.blade.php",
    "./resources/pages/admin/**/*.blade.php",
    "./resources/pages/blog/*.blade.php",
    "./app/Providers/AppServiceProvider.php",
    "./resources/js/**/*.js",
    "./resources/**/*.html",
    "./app/View/Components/shared/*.blade.php",
    "./app/View/Components/Layout/**/*.php",
    "./app/View/Components/Shared/**/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {
      colors: {
        primaryColor: '#2666E0',
        'dark-blue': '#0947BE',
        'invalid-value': '#FF0000',
        'md-gray': '#A9A9A9',
        'base-gray': '#F2F5F6',
        'sm-gray': '#939191',
        'strong-gray': '#686868',
        'dark-gray': '#E8EDEE',
        'light-gray': '#E8EEF0',
        'high-gray': '#77A0AD'
      },
      fontSize: {
        'xxsm': '10px',
        'xsm': '11px',
        'h2': '1.75rem',
        'h4': '21px',
        'xll': '1.3rem'
      },
      fontFamily: {
        'roboto': ['Roboto', 'sans-serif'],
      },
      lineHeight: {
        '0': '0',
      },
      spacing: {
        '2.5': '9px',
        '2.75': '11px',
        '3.75': '22px',
        '4.5': '18px',
        'card': '254px',
        '8.5': '34px',
        '5.5': '22px',
        '6.5': '25px',
        '10.5': '42px',
        '90': '360px'
      },
      maxWidth: {
        'card': '254px',
      },
      borderRadius: {
        card: '20px',
        tag: '9px',
        imageSm: '15px',
        imageMd: '20px',
        imageBig: '25px'
      },
      borderWidth: {
          '4.5': '6px'
      },
      gridTemplateRows: {
        // Simple 8 row grid
        '8': 'repeat(8, minmax(0, 1fr))',
        '9': 'repeat(9, minmax(0, 1fr))',
        '10': 'repeat(10, minmax(0, 1fr))',
        '11': 'repeat(11, minmax(0, 1fr))',
        '12': 'repeat(12, minmax(0, 1fr))',
        '13': 'repeat(13, minmax(0, 1fr))',
        '14': 'repeat(14, minmax(0, 1fr))',
      },
      screens: {
        'st': '1200px',
        'mm': '480px',
      },
      keyframes: {
        fadeIn: {
          '0%': { transform: 'translateY(100vh);' },
          '100%': { transform: 'translateY(0)' },
        }
      },
      animation: {
        fadeIn: 'fadeIn 1s linear',
      }
    },
  },
    variants: {
        extend: {
            backgroundColor: ['disabled'],
            textColor: ['disabled'],
        },
    },
  cache: false,
  safelist: [
    'bg-[#2666e0]',
    'text-h2',
    'font-bold',
    'text-xll',
    'bg-slate-100',
    'bg-white',
    'bg-base-gray',
    'flex-row-reverse',
    'bg-[#E8EDEE]',
      'px-8.5', 'py-5.5', 'px-11', 'p-2.5', 'border-primaryColor', 'pb-20', 'rounded-imageBig',
      'w-[225px]', 'h-[250px]', 'rounded-imageMd', 'rounded-imageSm', 'p-2.75', 'w-[95px]', 'h-[70px]',
      'peer-checked:bg-black', 'w-[30px]', 'h-[30px]', 'bg-dark-gray', 'w-[21px]', 'h-[21px]',
      'py-4.5 px-6.5 px-10 max-w-2xl bg-dark-blue'
  ]
}

