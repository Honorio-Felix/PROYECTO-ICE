/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./src/**/*.{html,js}",
    "./js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        ice: {
          blue: '#123BFF',      // Azul Principal
          night: '#101B3D',     // Azul Noche / Fondo Oscuro
          jade: '#00A889',      // Verde Jade / CTA
          'jade-hover': '#008F73' // Verde Jade más oscuro para hovers
        }
      }
    },
  },
  plugins: [],
}