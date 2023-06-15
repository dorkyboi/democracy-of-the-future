/** @type {import('tailwindcss').Config} */
export default {
  content: [
      './storage/framework/views/*.php',
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
  ],
  theme: {
    extend: {
        colors: {
            'main-blue': '#0e5a93',
            'soft-blue': '#d1e4f3',
            'soft-yellow': '#fde9a1',
        },
    },
  },
  plugins: [],
}

