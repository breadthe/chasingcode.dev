<nav id="js-nav-menu" class="nav-menu hidden lg:hidden">
    <ul class="my-0">
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} Blog"
                href="/blog"
                class="
                    nav-menu__item
                    {{
                        $page->belongsTo('/blog') ?
                        'active text-gray-600 hover:text-gray-900 font-bold' :
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
                    nav-menu__item
                    {{
                        $page->belongsTo('/contact') ?
                        'active text-gray-600 hover:text-gray-900 font-bold' :
                        'text-gray-600 hover:text-gray-900'
                    }}
                "
            >Contact</a>
        </li>
    </ul>
</nav>
