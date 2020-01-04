module.exports = {
    theme: {
        extend: {
            fontFamily: {
                'sans': [
                    'Lato',
                    'system-ui',
                    'BlinkMacSystemFont',
                    '-apple-system',
                    'Segoe UI',
                    'Roboto',
                    'Oxygen',
                    'Ubuntu',
                    'Cantarell',
                    'Fira Sans',
                    'Droid Sans',
                    'Helvetica Neue',
                    'sans-serif',
                ],
                'serif': [
                    'Bitter',
                    'Constantia',
                    'Lucida Bright',
                    'Lucidabright',
                    'Lucida Serif',
                    'Lucida',
                    'DejaVu Serif',
                    'Bitstream Vera Serif',
                    'Liberation Serif',
                    'Georgia',
                    'serif',
                ],
                'mono': [
                    'Consolas',
                    'Menlo',
                    'Monaco',
                    'Liberation Mono',
                    'Courier New',
                    'monospace',
                ]
            },
        },
        cursor: {
            auto: 'auto',
            default: 'default',
            pointer: 'pointer',
            wait: 'wait',
            text: 'text',
            move: 'move',
            'not-allowed': 'not-allowed',
            // crosshair: 'crosshair',
            'zoom-in': 'zoom-in',
        }
    },
    variants: {
        margin: ['responsive', 'first'],
    },
    plugins: []
}
