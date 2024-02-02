<footer class="flex flex-col gap-4 max-w-2xl m-8 sm:mx-auto text-center">
    <div class="w-full flex flex-row justify-center gap-4">
        <a href="/blog/feed.atom" class="group w-full flex flex-col items-center justify-center gap-2">
            <span class="group-hover:text-teal-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 19.5v-.75a7.5 7.5 0 0 0-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </span>
            <span class="group-hover:text-teal-400">RSS</span>
        </a>

        <a href="https://indieweb.social/@brbcoding" class="group w-full flex flex-col items-center justify-center gap-2">
            <span class="group-hover:text-teal-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M11.19 12.195c2.016-.24 3.77-1.475 3.99-2.603.348-1.778.32-4.339.32-4.339 0-3.47-2.286-4.488-2.286-4.488C12.062.238 10.083.017 8.027 0h-.05C5.92.017 3.942.238 2.79.765c0 0-2.285 1.017-2.285 4.488l-.002.662c-.004.64-.007 1.35.011 2.091.083 3.394.626 6.74 3.78 7.57 1.454.383 2.703.463 3.709.408 1.823-.1 2.847-.647 2.847-.647l-.06-1.317s-1.303.41-2.767.36c-1.45-.05-2.98-.156-3.215-1.928a4 4 0 0 1-.033-.496s1.424.346 3.228.428c1.103.05 2.137-.064 3.188-.189zm1.613-2.47H11.13v-4.08c0-.859-.364-1.295-1.091-1.295-.804 0-1.207.517-1.207 1.541v2.233H7.168V5.89c0-1.024-.403-1.541-1.207-1.541-.727 0-1.091.436-1.091 1.296v4.079H3.197V5.522q0-1.288.66-2.046c.456-.505 1.052-.764 1.793-.764.856 0 1.504.328 1.933.983L8 4.39l.417-.695c.429-.655 1.077-.983 1.934-.983.74 0 1.336.259 1.791.764q.662.757.661 2.046z"/>
                </svg>
            </span>
            <span class="group-hover:text-teal-400">Mastodon</span>
        </a>

        <a href="https://twitter.com/brbcoding" class="group w-full flex flex-col items-center justify-center gap-2">
            <span class="group-hover:text-teal-400">
                @include('_partials.icons._svg', ['icon' => 'twitter', 'width' => 24, 'height' => 24])
            </span>
            <span class="group-hover:text-teal-400">Twitter</span>
        </a>

        <a href="https://github.com/breadthe" class="group w-full flex flex-col items-center justify-center gap-2">
            <span class="group-hover:text-teal-400">
                @include('_partials.icons._svg', ['icon' => 'github', 'width' => 24, 'height' => 24])
            </span>
            <span class="group-hover:text-teal-400">Github</span>
        </a>
    </div>
    <small class="italic opacity-60">
        2018-{{ date('Y') }} 🦄&nbsp; All content & opinions my own
    </small>
</footer>
