<aside class="sm:w-1/2 lg:w-1/3 p-4 sm:p-8 bg-gray-200 text-gray-700">
    <div class="flex flex-col items-center justify-center mt-4 sm:mt-0">
        <img src="assets/images/me.jpg" alt="Picture of me" title="Picture of me" class="rounded-full border-8 border-double border-teal-700 w-64 h-64">

        <div class="flex mt-8">
            <a href="https://twitter.com/brbcoding" class="mx-2 text-blue-500 hover:text-blue-700" title="Follow me on Twitter - @brbcoding" aria-label="Follow me on Twitter - @brbcoding">
                @include('_partials.icons._svg', ['icon' => 'twitter', 'width' => 32, 'height' => 32])
            </a>
            <a href="https://github.com/breadthe" class="mx-2 text-green-500 hover:text-green-700" title="Find my projects on Github - @breadthe" aria-label="Find my projects on Github - @breadthe">
                @include('_partials.icons._svg', ['icon' => 'github', 'width' => 32, 'height' => 32])
            </a>
        </div>
    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            Stats/Bio
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

        <dl class="flex flex-wrap">
            <dt class="w-full inline font-black uppercase">Background</dt>
            <dd class="inline-flex items-center mb-4">
                <a href="https://en.wikipedia.org/wiki/Romania" title="Romania" class="inline-flex items-center text-gray-700">
                    🇷🇴 Romanian
                    <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                </a>
            </dd>

            <dt class="w-full inline font-black uppercase">Living in</dt> <dd class="inline mb-4">Illinois, USA</dd>

            <dt class="w-full inline font-black uppercase">Age</dt> <dd class="inline mb-4">Old enough to enjoy a nice, cold hefeweizen 🍺.</dd>

            <dt class="w-full inline font-black uppercase">Interests</dt> <dd class="inline mb-4">⌨️ Coding &bull; 🛠 Making software &bull; 🚲 Cycling &bull; ⛷ Skiing &bull; 🐠 Freediving &bull; 📖 Reading &bull; 🕹 Gaming</dd>

            <dt class="w-full inline font-black uppercase">Trivia</dt> <dd class="inline mb-4">Lived > 50% of my life outside my country of birth.</dd>
        </dl>
    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            My {{ date('Y') }} tech stack
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

        <ul>
            <li class="mb-4 font-black uppercase">Laravel</li>

            <li class="mb-4 font-black uppercase">Livewire</li>

            <li class="mb-4 font-black uppercase">TailwindCSS</li>

            <li class="mb-4 font-black uppercase">Svelte</li>

            <li class="mb-4 font-black uppercase">Electron</li>
        </ul>
    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            This website
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

        <ul class="flex flex-col">
            <li class="mb-4">
                Built with ❤️ and...
            </li>

            <li class="mb-4">
                <a href="https://jigsaw.tighten.co/" title="Jigsaw by Tighten.co" class="inline-flex items-center font-black uppercase">
                    Jigsaw <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="https://tailwindcss.com/" title="TailwindCSS" class="inline-flex items-center font-black uppercase">
                    TailwindCSS <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                </a>
            </li>

            <li class="mb-4">
                Hosted on
                <a href="https://www.netlify.com/" title="Hosted on Netlify" class="inline-flex items-center font-black uppercase">
                    Netlify <span class="ml-1 text-gray-500">@include('_partials.icons._svg', ['icon' => 'external-link', 'width' => 20, 'height' => 20])</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
