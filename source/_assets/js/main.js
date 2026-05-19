import {createApp} from 'vue';
import MastodonWebmention from './components/MastodonWebmention.vue';
import Search from './components/Search.vue';
// import VIcon from './components/icons/VIcon';
import hljs from 'highlight.js/lib/core';
import bash from 'highlight.js/lib/languages/bash';
import css from 'highlight.js/lib/languages/css';
import html from 'highlight.js/lib/languages/xml';
import javascript from 'highlight.js/lib/languages/javascript';
import json from 'highlight.js/lib/languages/json';
import markdown from 'highlight.js/lib/languages/markdown';
import php from 'highlight.js/lib/languages/php';
import scss from 'highlight.js/lib/languages/scss';
import yaml from 'highlight.js/lib/languages/yaml';
import sql from 'highlight.js/lib/languages/sql';
import rust from 'highlight.js/lib/languages/rust';
import typescript from 'highlight.js/lib/languages/typescript';

// Syntax highlighting
hljs.registerLanguage('bash', bash);
hljs.registerLanguage('css', css);
hljs.registerLanguage('html', html);
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('json', json);
hljs.registerLanguage('markdown', markdown);
hljs.registerLanguage('php', php);
hljs.registerLanguage('scss', scss);
hljs.registerLanguage('yaml', yaml);
hljs.registerLanguage('sql', sql);
hljs.registerLanguage('rust', rust);
hljs.registerLanguage('ts', typescript);

document.querySelectorAll('pre code').forEach((block) => {
    hljs.highlightBlock(block);
});

const mastodonWebmention = document.getElementById('mastodon-webmention');

if (mastodonWebmention) {
    createApp(MastodonWebmention, {
        pageUrl: mastodonWebmention.dataset.pageUrl,
        mastodonTootUrl: mastodonWebmention.dataset.mastodonTootUrl,
    }).mount(mastodonWebmention);
}

const vueSearch = document.getElementById('vue-search');

if (vueSearch) {
    createApp(Search, {
        dataBelongsToBlog: vueSearch.dataset.belongsToBlog,
    }).mount(vueSearch);
}
