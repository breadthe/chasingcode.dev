<header class="flex items-center h-24 py-4 {{ $page->belongsTo('/blog') ? '' : 'bg-red-dark' }}" role="banner">
    <div class="container flex items-center max-w-xl mx-auto px-4 lg:px-8">
        <div class="flex items-center">
            <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                {{--<img class="h-8 md:h-10 mr-3" src="/assets/img/logo.svg" alt="{{ $page->siteName }} logo" />--}}

                <h1 class="site-logo no-underline text-lg md:text-xl tracking-wide my-0 {{ $page->belongsTo('/blog') ? 'text-grey-dark' : 'text-white' }}">
                    {{ $page->siteName }}
                </h1>
            </a>
        </div>

        <div id="vue-search" class="flex flex-1 justify-end items-center">
            <search
                data-belongs-to-blog="{{ $page->belongsTo('/blog') }}"
            ></search>

            @include('_nav.menu')

            @include('_nav.menu-toggle')
        </div>
    </div>
</header>

@include('_nav.menu-responsive')
