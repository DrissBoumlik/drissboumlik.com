/** @type {import('tailwindcss').Config} */
export default {
    mode: 'jit',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {},
        container: {
            // you can configure the container to be centered
            center: true,
            // or have default horizontal padding
            padding: '1rem',
            // default breakpoints but with 40px removed
            screens: {
                sm: '576px',
                md: '768px',
                lg: '992px',
                xl: '1200px',
                '2xl': '1400px',
            },
        }
    },
    plugins: [],
}
