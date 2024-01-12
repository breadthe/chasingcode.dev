window.axios = require('axios');
import Vue from 'vue';

import MastodonWebmention from './components/MastodonWebmention.vue';
import Search from './components/Search.vue';
// import VIcon from './components/icons/VIcon';
import hljs from 'highlight.js/lib/core';
import 'highlight.js/styles/monokai-sublime.css';

// Syntax highlighting
hljs.registerLanguage('bash', require('highlight.js/lib/languages/bash'));
hljs.registerLanguage('css', require('highlight.js/lib/languages/css'));
hljs.registerLanguage('html', require('highlight.js/lib/languages/xml'));
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'));
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'));
hljs.registerLanguage('markdown', require('highlight.js/lib/languages/markdown'));
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'));
hljs.registerLanguage('scss', require('highlight.js/lib/languages/scss'));
hljs.registerLanguage('yaml', require('highlight.js/lib/languages/yaml'));
hljs.registerLanguage('sql', require('highlight.js/lib/languages/sql'));
hljs.registerLanguage('rust', require('highlight.js/lib/languages/rust'));
hljs.registerLanguage('ts', require('highlight.js/lib/languages/typescript'));

document.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightBlock(block);
});

Vue.config.productionTip = false;

if (document.getElementById('mastodon-webmention')) {
    new Vue({
        components: {
            MastodonWebmention
        },
    }).$mount('#mastodon-webmention');
}

new Vue({
    components: {
        Search,
        // VIcon,
    },
}).$mount('#vue-search');

