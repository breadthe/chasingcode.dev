<nav class="hidden sm:flex items-center justify-end text-lg">
    <a
        title="{{ $page->siteName }} Blog"
        href="/blog"
        class="
            ml-6 text-teal-200 hover:text-teal-400
            {{
                $page->belongsTo('/blog') ?
                'active border-b-2 border-teal-400' :
                ''
            }}"
    >
        Blog
    </a>

    <a
        title="Uses"
        href="/uses"
        class="
            ml-6 text-teal-200 hover:text-teal-400
            {{
                $page->belongsTo('/uses') ?
                'active border-b-2 border-teal-400' :
                ''
            }}"
    >
        Uses
    </a>

    <a
        title="{{ $page->siteName }} Contact"
        href="/contact"
        class="
            ml-6 text-teal-200 hover:text-teal-400
            {{
                $page->belongsTo('/contact') ?
                'active border-b-2 border-teal-400' :
                ''
            }}"
    >
        Contact
    </a>
</nav>
