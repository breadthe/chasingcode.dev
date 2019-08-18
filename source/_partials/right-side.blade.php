<aside class="w-full sm:w-1/3 p-4 sm:p-8 bg-gray-200 text-gray-700">
    <div class="relative flex items-center justify-center mt-4 sm:mt-0">
        {{--<img src="assets/images/portrait-bg.svg" class="absolute">--}}
        {{--<svg viewBox="0 0 20 20" width="20pt" height="20pt">
            <defs>
                <clipPath id="_clipPath_VoHTx5yeRPIGAT9ootC4b0BzP8PZ1rJ2"><rect width="20" height="20"/></clipPath>
            </defs>
            <g clip-path="url(#_clipPath_VoHTx5yeRPIGAT9ootC4b0BzP8PZ1rJ2)"><path d=" M 17.755 4.178 Q 17.86 5.105 17.231 6.121 C 16.602 7.138 16.648 7.218 16.85 8.236 C 17.052 9.253 20.109 11.087 18.567 12.801 C 17.026 14.515 15.687 16.802 15.439 18.202 Q 15.191 19.601 11.363 19.408 C 10.876 19.383 10.121 19.196 9.679 18.991 L 7.429 17.946 C 5.855 17.242 5.705 16.792 3.462 16.932 C 1.219 17.071 0.798 13.577 1.802 12.095 C 2.805 10.612 1.93 8.994 1.033 7.191 C 0.816 6.754 1.026 6.316 1.503 6.212 Q 4.015 5.666 5.569 4.614 Q 7.124 3.562 8.435 1.72 C 8.718 1.323 9.29 1.198 9.713 1.442 C 9.852 1.522 11.155 3.234 13.371 2.65 Q 15.587 2.066 16.896 2.847 C 17.315 3.097 17.7 3.693 17.755 4.178 Z " fill="rgb(0,0,0)"/></g>
        </svg>--}}
        <img src="assets/images/me.jpg" alt="Picture of me" title="Picture of me" class="rounded-full border-8 border-double border-teal-700 w-64 h-64">
    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            Stats/Bio
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

        <div class="mb-4 flex -mx-2">
            <a href="https://twitter.com/brbcoding" class="mx-2" title="@brbcoding on Twitter">
                @include('_partials.icons._svg', ['icon' => 'twitter'])
            </a>
            <a href="https://github.com/breadthe" class="mx-2" title="@breadthe on Github">
                @include('_partials.icons._svg', ['icon' => 'github'])
            </a>
        </div>

        <dl>
            <div class="mb-4">
                <dt class="inline font-black uppercase">Background</dt>
                <dd class="inline-flex items-center ml-2">
                    <a href="https://en.wikipedia.org/wiki/Romania" title="Romania" class="inline-flex items-center text-gray-700">
                        🇷🇴 Romanian
                        <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                    </a>
                </dd>
            </div>

            <div class="mb-4">
                <dt class="inline font-black uppercase">Living in</dt> <dd class="inline ml-2">Illinois, USA</dd>
            </div>

            <div class="mb-4">
                <dt class="inline font-black uppercase">Age</dt> <dd class="inline ml-2">Old enough to enjoy a nice, cold hefeweizen 🍺.</dd>
            </div>

            <div class="mb-4">
                <dt class="inline font-black uppercase">Interests</dt> <dd class="inline ml-2">⌨️ Coding &bull; 🛠 Making things &bull; 💪 Lifting &bull; 🚲 Cycling &bull; ⛷ Skiing &bull; 📖 Reading</dd>
            </div>

            <div class="mb-4">
                <dt class="inline font-black uppercase">Trivia</dt> <dd class="inline ml-2">Lived > 50% of my life outside my country of birth.</dd>
            </div>
        </dl>
    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            My {{ date('Y') }} tech stack
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

        <dl>
            <div class="mb-4">
                <dd class="font-black uppercase">Laravel</dd>
            </div>

            <div class="mb-4">
                <dd class="font-black uppercase">Vue.js</dd>
            </div>

            <div class="mb-4">
                <dd class="font-black uppercase">TailwindCSS</dd>
            </div>
        </dl>
    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            This website
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

        <dl class="flex flex-col">
            <div class="mb-4">
                Built with ❤️ and...
            </div>

            <div class="mb-4">
                <dd class="inline font-black uppercase">
                    <a href="https://jigsaw.tighten.co/" title="Jigsaw by Tighten.co" class="inline-flex items-center">
                        Jigsaw <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                    </a>
                </dd>
            </div>

            <div class="mb-4">
                <dd class="inline font-black uppercase">
                    <a href="https://tailwindcss.com/" title="TailwindCSS" class="inline-flex items-center">
                        TailwindCSS <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                    </a>
                </dd>
            </div>

            <div class="mb-4">
                Hosted on <dd class="inline font-black uppercase">
                    <a href="https://www.netlify.com/" title="Hosted on Netlify" class="inline-flex items-center">
                        Netlify <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                    </a>
                </dd>
            </div>
        </dl>
    </div>
</aside>
