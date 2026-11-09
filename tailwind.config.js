import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                arroz: {
                    verde: '#436851',   // Verde primario: Tarjetas principales
                    oscuro: '#2B503A',  // Verde oscuro: Botones y navegación
                    dorado: '#D2A736',  // Dorado: Identidad del arroz
                    morado: '#6B338A',  // Morado: Identidad de conecta
                    azul: '#316194',    // Azul: Humedad y agua
                    fondo: '#FBF9F6',   // Blanco cálido: Fondo
                    texto: '#1A1C1A',   // Casi negro: Textos
                    suave: '#EBF2ED',   // Tono suave complementario
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};

