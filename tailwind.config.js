import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
         './node_modules/flowbite/**/*.js'
    ],

    theme: {

        //colors
        colors: {
          transparent: 'transparent',
          current: 'currentColor',
          black: colors.black,
          white: colors.white,
          red: colors.red,
          orange: colors.orange,
          yellow: colors.yellow,
          green: colors.green,
          gray: colors.slate,
          indigo: {
            100: '#e6e8ff',
            300: '#b2b7ff',
            400: '#7886d7',
            500: '#6574cd',
            600: '#5661b3',
            800: '#2f365f',
            900: '#191e38',
        },
    },

        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                sans: ['Cerebri Sans', ...defaultTheme.fontFamily.sans],
            },
            borderColor: theme => ({
        DEFAULT: theme('colors.gray.200', 'currentColor'),
      }),
      boxShadow: theme => ({
        outline: '0 0 0 2px ' + theme('colors.indigo.500'),
      }),
      fill: theme => theme('colors'),
      zIndex: {
                '-1': '-1',
            },
            flexGrow: {
                '5' : '5'
            },
            colors: {
                      primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
              transparent: 'transparent',
              current: 'currentColor',
              'white': '#ffffff',
              'coralred': {
                50: '#fef2f2',
                100: '#ffe1e1',
                200: '#67e8f9',
                300: '#ffa2a2',
                400: '#fc6d6d',
                500: '#f54747',
                600: '#e22020',
                700: '#be1717',
                800: '#9d1717',
                900: '#821a1a',
                950: '#470808',
            },
            'Black': {
                50: '#fef2f2',
                100: '#ffe1e1',
                200: '#67e8f9',
                300: '#ffa2a2',
                400: '#fc6d6d',
                500: '#f54747',
                600: '#e22020',
                700: '#be1717',
                800: '#9d1717',
                900: '#821a1a',
                950: '#470808',
            },
        },

        },
    },
    variants: {
    extend: {
      fill: ['focus', 'group-hover'],
        },
    },
    plugins: [
    forms,
    require('flowbite/plugin')({
  })
    ],
};
