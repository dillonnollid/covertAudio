/** @type {import('tailwindcss').Config} */

/** npx tailwindcss -i ./assets/css/tailwind.css -o ./assets/css/tailwind.output.css --watch */
module.exports = {
  content: [
    './*.php',
    './assets/**/*.{js,php}',
    './controllers/*.php',
    './includes/**/*.{js,php}',
    './views/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

