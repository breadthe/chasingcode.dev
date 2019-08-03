<nav class="hidden lg:flex items-center justify-end text-lg">
    <a
        title="{{ $page->siteName }} Blog"
        href="/blog"
        class="
            ml-6
            {{
                $page->belongsTo('/blog') ?
                'active text-grey-darkest hover:text-grey-darkest border-b-2 border-grey-darkest' :
                'text-pink-lightest hover:text-white'
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
                'active text-white hover:text-white border-b-2 border-white' :
                ($page->belongsTo('/blog') ? 'text-grey-dark hover:text-grey-darkest': 'text-pink-lightest hover:text-white')
            }}"
    >
        Contact
    </a>
</nav>
