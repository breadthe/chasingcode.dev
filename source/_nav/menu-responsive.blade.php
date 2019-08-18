<nav id="js-nav-menu" class="nav-menu hidden sm:hidden bg-gray-800">
    <ul class="my-0">
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} Blog"
                href="/blog"
                class="
                    nav-menu__item inline-block text-teal-200 text-2xl
                    {{
                        $page->belongsTo('/blog') ?
                        'active hover:text-teal-400 border-b-2 border-teal-400' :
                        ''
                    }}
                "

            >Blog</a>
        </li>
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} Contact"
                href="/contact"
                class="
                    nav-menu__item inline-block text-teal-200 text-2xl
                    {{
                        $page->belongsTo('/contact') ?
                        'active hover:text-teal-400 border-b-2 border-teal-400' :
                        ''
                    }}
                "
            >Contact</a>
        </li>
    </ul>
</nav>
