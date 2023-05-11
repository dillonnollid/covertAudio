/** @type {import('tailwindcss').Config} */
/** add this to package.json under 'dev' -> npx tailwindcss -i ./assets/css/tailwind.css -o ./assets/css/tailwind.output.css --watch */
module.exports = {  
  darkMode: 'class',
  content: [
    './*.php',
    './assets/**/*.{js,php}',
    './controllers/*.php',
    './includes/**/*.{js,php}',
    './views/**/*.php',
  ],
  theme: {
    extend: {
      boxShadow: {
        highlight: 'inset 0 0 0 1px rgba(255, 255, 255, 0.05)',
      },
      screens: {
        narrow: { raw: '(max-aspect-ratio: 3 / 2)' },
        wide: { raw: '(min-aspect-ratio: 3 / 2)' },
        'taller-than-854': { raw: '(min-height: 854px)' },
      },
      'animation': {
        'gradient-x':'gradient-x 15s ease infinite',
        'gradient-y':'gradient-y 15s ease infinite',
        'gradient-xy':'gradient-xy 15s ease infinite',
      },
      'keyframes': {
        'gradient-y': {
            '0%, 100%': {
                'background-size':'400% 400%',
                'background-position': 'center top'
            },
            '50%': {
                'background-size':'200% 200%',
                'background-position': 'center center'
            }
        },
        'gradient-x': {
            '0%, 100%': {
                'background-size':'200% 200%',
                'background-position': 'left center'
            },
            '50%': {
                'background-size':'200% 200%',
                'background-position': 'right center'
            }
        },
        'gradient-xy': {
            '0%, 100%': {
                'background-size':'400% 400%',
                'background-position': 'left center'
            },
            '50%': {
                'background-size':'200% 200%',
                'background-position': 'right center'
            }
        }
      }
    },
  },
  plugins: [],
  purge: ['./**/*.html', './**/*.php', './**/*.js'],
}