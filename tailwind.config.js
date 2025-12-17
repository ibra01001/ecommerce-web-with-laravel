/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'theme-primary': 'var(--primary-color)',
        'theme-secondary': 'var(--secondary-color)',
        'theme-background': 'var(--background-color)',
        'theme-text': 'var(--text-color)',
      },
      fontFamily: {
        'theme': 'var(--font-family)',
      },
    },
  },
  plugins: [],
  safelist: [
    'bg-theme-primary',
    'bg-theme-secondary',
    'text-theme-primary',
    'text-theme-secondary',
    'border-theme-primary',
    'border-theme-secondary',
    'hover:bg-theme-primary',
    'hover:bg-theme-secondary',
    'hover:text-theme-primary',
    'hover:text-theme-secondary',
  ],
}