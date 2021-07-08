module.exports = {
    purge: [],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Raleway', 'sans-serif']
            },
            colors: {
                blue: {
                    DEFAULT: '#01509f'
                },
                green: {
                    DEFAULT: '#4cb050'
                },
                grey: {
                    DEFAULT: '#f2f2f2',
                    dark: '#eeeeee'
                },
                white: {
                    DEFAULT: '#FFFFFF'
                }
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}