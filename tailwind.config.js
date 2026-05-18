/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/**/*.php',
    './modules/**/*.php',
  ],
  darkMode: ['class', '.app-dark'],
  theme: {
    extend: {
      colors: {
        brand: {
          primary: '#222831',
          secondary: '#393E46',
          accent: '#00ADB5',
          danger: '#DC2626',
          warning: '#D97706',
          success: '#16A34A',
        },
        surface: {
          DEFAULT: '#FFFFFF',
          dark: '#222831',
          elevated: '#EEEEEE',
          'elevated-dark': '#393E46',
        },
        border: {
          DEFAULT: '#E5E7EB',
          dark: '#374151',
        },
        text: {
          DEFAULT: '#0F172A',
          muted: '#475569',
          dark: '#EEEEEE',
          'muted-dark': '#94A3B8',
        },
      },
      fontFamily: {
        display: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
        body: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'monospace'],
      },
      fontSize: {
        xs: '12px',
        sm: '14px',
        base: '16px',
        lg: '18px',
        xl: '20px',
        '2xl': '24px',
        '3xl': '30px',
        '4xl': '36px',
        '5xl': '48px',
      },
      lineHeight: {
        tight: '1.2',
        normal: '1.5',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}