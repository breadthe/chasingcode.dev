<nav class="hidden lg:flex items-center justify-end text-lg">
    <a
        title="{{ $page->siteName }} Blog"
        href="/blog"
        class="
            ml-6
            {{
                $page->belongsTo('/blog') ?
                'active text-gray-900 border-b-2 border-gray-900' :
                ''
            }}"
    >
        Blog
    </a>

    <a
        title="{{ $page->siteName }} Contact"
        href="/contact"
        class="
            ml-6
            {{
                $page->belongsTo('/contact') ?
                'active text-gray-900 border-b-2 border-gray-900' :
                ''
            }}"
    >
        Contact
    </a>
</nav>
