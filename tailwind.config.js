/* eslint-env node */

const plugin = require("tailwindcss/plugin");

module.exports = {
  //content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
    "./resources/js/**/*.js",
    "./node_modules/flowbite/**/*.js",
    'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
    'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
  ],
  darkMode: "class", // or 'media' or 'class'
  theme: {
    asideScrollbars: {
      light: "light",
      gray: "gray",
    },
    extend: {
      fontFamily: {
        twogether: ["TwogetherSans", "sans-serif"],
        karol: ["KarolSans", "sans-serif"],
        inter: ["Inter", "sans-serif"],
      },
      zIndex: {
        "-1": "-1",
      },
      flexGrow: {
        5: "5",
      },
      maxHeight: {
        "screen-menu": "calc(100vh - 3.5rem)",
        modal: "calc(100vh - 160px)",
      },
      transitionProperty: {
        position: "right, left, top, bottom, margin, padding",
        textColor: "color",
      },
      keyframes: {
        "fade-out": {
          from: { opacity: 1 },
          to: { opacity: 0 },
        },
        "fade-in": {
          from: { opacity: 0 },
          to: { opacity: 1 },
        },
      },
      animation: {
        "fade-out": "fade-out 250ms ease-in-out",
        "fade-in": "fade-in 250ms ease-in-out",
      },
      colors: {
        forest: {
          50: '#A0AA8D',   // lightGreen - muy claro
          100: '#6E795A',  // light - claro  
          200: '#565E46',  // light - medio
          300: '#436547',  // dark - medio oscuro
          400: '#283C2A',  // main - oscuro
          500: '#3E4432',  // light - oscuro alternativo
          600: '#1A8245',
          900: '#0C110C',  // dark - muy oscuro
        },
        earth: {
          50: '#E3CDB8',   // light
          150: '#D6B99B',
          100: '#C79B71',  // light main
          200: '#B77E48',  // text (B77E48)
          300: '#8E6238',  // dark (8E6238)  
          400: '#644528',  // dark main (644528)
        },
        sand: {
          50: '#E0DFD5',   // sand - muy claro
          100: '#DBDACE',  // sand light - claro
          200: '#A3A081',  // sand - medio
          300: '#827F5F',  // sand - oscuro
        },
        wine: {
          50: '#832B56',   // wine light - claro
          100: '#AE1A69',
          400: '#581D3A',  // wine main - medio
          800: '#2E0F1E',  // wine2 dark - oscuro
          950: '#030102',  // wine3 dark - muy oscuro
        },
        pantone: {
          400: '#7C4A36',
        },
        mono: {
          50: '#FFFFFF',   // white
          100: '#F4F4F4',  // gray light
          200: '#ACACAC',
          300: '#CBCABE',
          400: '#86857E',  // gray
          900: '#060606',  // black
        },
        success: {
          100: '#2CD673',   // green
          300: '#22AD5C',
          400: '#1A8245',
        },
        warning: {
          100: '#F59460',   // orange
          300: '#F27430',
          400: '#E1580E',
        },
        error: {
          100: '#F56060',   // red
          300: '#F23030',
          400: '#E10E0E',
        },
        alert: {
          100: '#FBBF24',   // yellow
          400: '#F59E0B',
          600: '#D97706',
        },
        accent: {
          yellow: '#FBBF24',  // yellow
          blue: '#3758F9' // blue
        },
      },
    },
  },
  plugins: [
    require("@tailwindcss/forms"),
    plugin(function ({ matchUtilities, theme }) {
      matchUtilities(
        {
          "aside-scrollbars": (value) => {
            const track = value === "light" ? "100" : "900";
            const thumb = value === "light" ? "300" : "600";
            const color = value === "light" ? "gray" : value;

            return {
              scrollbarWidth: "thin",
              scrollbarColor: `${theme(`colors.${color}.${thumb}`)} ${theme(
                `colors.${color}.${track}`
              )}`,
              "&::-webkit-scrollbar": {
                width: "8px",
                height: "8px",
              },
              "&::-webkit-scrollbar-track": {
                backgroundColor: theme(`colors.${color}.${track}`),
              },
              "&::-webkit-scrollbar-thumb": {
                borderRadius: "0.25rem",
                backgroundColor: theme(`colors.${color}.${thumb}`),
              },
            };
          },
        },
        { values: theme("asideScrollbars") }
      );
    }),
  ],
};
