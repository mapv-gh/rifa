/** @type {import('tailwindcss').Config} */

module.exports = {
  content: ["./**/*.html", "./**/*.php", "./src/**/*.{js,jsx,ts,tsx,vue}"],
  darkMode: "class",
  theme: {
    extend: {
      fontFamily: {
        dancing: ["Dancing Script", "cursive"],
        pacifico: ["Pacifico", "cursive"],
      },
    },
  },
  plugins: [],
};
