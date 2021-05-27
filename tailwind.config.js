const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: [],
  darkMode: 'media', // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
      },
      colors:{
        'blue': {
          '50': '#f4f7ff',
          '100': '#eaefff',
          '200': '#cad8ff',
          '300': '#a9c1ff',
          '400': '#6992ff',
          '500': '#2963ff',
          '600': '#2559e6',
          '700': '#1f4abf',
          '800': '#193b99',
          '900': '#14317d'
        },
        'gray': {
          '50': '#f5f5f5',
          '100': '#ebebeb',
          '200': '#cccccc',
          '300': '#adadad',
          '400': '#707070',
          '500': '#333333',
          '600': '#2e2e2e',
          '700': '#262626',
          '800': '#1f1f1f',
          '900': '#191919'
        }
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [require("@tailwindcss/ui"), require('@tailwindcss/custom-forms'),require('@tailwindcss/aspect-ratio'),]
}
