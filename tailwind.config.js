module.exports = {
    content: require('fast-glob').sync([
        'source/**/*.html',
        'source/**/*.md',
        'source/**/*.js',
        'source/**/*.php',
        'source/**/*.vue',
    ]),
    options: {
        safelist: [/language/, /hljs/, /mce/],
    },
    theme: {
        extend: {
            colors:  {
                "strava-orange": '#fc4c02',
                "mastodon-purple": '#595aff',
            },
            fontFamily: {
                'sans': [
                    'system-ui',
                    'sans-serif',
                ],
                'serif': [
                    'Charter',
                    'Bitstream Charter',
                    'Sitka Text',
                    'Cambria',
                    'serif',
                ],
                'mono': [
                    'ui-monospace',
                    'Cascadia Code',
                    'Source Code Pro',
                    'Menlo',
                    'Consolas',
                    'DejaVu Sans Mono',
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
        textColor: ['hover', 'group-hover'],
        textDecoration: ['hover', 'group-hover'],
    },
    plugins: []
}
