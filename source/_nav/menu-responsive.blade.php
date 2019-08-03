<nav id="js-nav-menu" class="nav-menu hidden lg:hidden {{ $page->belongsTo('/blog') ? 'bg-grey-lighter' : 'bg-red' }}">
    <ul class="list-reset my-0">
        <li class="pl-4">
            <a
                title="{{ $page->siteName }} Blog"
                href="/blog"
                class="
                    nav-menu__item
                    {{
                        $page->belongsTo('/blog') ?
                        'active text-grey-darkest hover:text-grey-darkest font-bold' :
                        'text-pink-lightest hover:text-white'
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
                        'active text-white hover:text-white font-bold' :
                        ($page->belongsTo('/blog') ? 'text-grey-dark hover:text-grey-darkest': 'text-pink-lightest hover:text-white')
                    }}
                "
            >Contact</a>
        </li>
    </ul>
</nav>
