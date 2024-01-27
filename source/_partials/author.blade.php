<section class="flex items-center max-w-xl mx-auto mt-8 mb-4 shadow bg-gray-100 p-4 rounded">
    <img
        src="/assets/images/me-sm.jpg"
        alt="Picture of me"
        title="Picture of me"
        class="border border-black rounded-full w-24 h-24"
    >
    <aside class="flex flex-1 flex-wrap sm:flex-col sm:h-24 justify-center ml-4">
        <h4 class="flex flex-wrap items-center m-0 mb-1">
            <span class="font-sans font-light mr-1">by</span>{{ $page->author }}
            <a
                    href="https://twitter.com/brbcoding"
                    class="author--section sm:ml-1 text-blue-500 hover:text-blue-700 font-sans font-light"
                    title="Follow me on Twitter - @brbcoding"
                    aria-label="Follow me on Twitter - @brbcoding"
            >@brbcoding</a>
        </h4>

        <p class="m-0 mt-1">
            Comments? Hit me up on Twitter.
        </p>
    </aside>
</section>
