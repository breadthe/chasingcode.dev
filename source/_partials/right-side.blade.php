<aside class="w-full sm:w-1/3 p-4 sm:p-8 bg-gray-200 text-gray-700">
    <div class="flex flex-col items-center justify-center mt-4 sm:mt-0">
        <img src="assets/images/me.jpg" alt="Picture of me" title="Picture of me" class="rounded-full border-8 border-double border-teal-700 w-64 h-64">

        <div class="flex mt-8">
            <a href="https://twitter.com/brbcoding" class="mx-2 text-blue-500 hover:text-blue-700" title="@brbcoding on Twitter">
                @include('_partials.icons._svg', ['icon' => 'twitter', 'width' => 32, 'height' => 32])
            </a>
            <a href="https://github.com/breadthe" class="mx-2 text-green-500 hover:text-green-700" title="@breadthe on Github">
                @include('_partials.icons._svg', ['icon' => 'github', 'width' => 32, 'height' => 32])
            </a>
        </div>

    </div>

    <div class="mt-8 first:mt-0">
        <h3 class="text-2xl font-black leading-none text-teal-700 font-sans mb-2">
            Stats/Bio
        </h3>

        <hr class="m-0 mb-4 border-b-2 border-gray-400 w-16 text-left">

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
                <dt class="inline font-black uppercase">Interests</dt> <dd class="inline ml-2">⌨️ Coding &bull; 🛠 Making things &bull; 💪 Lifting &bull; 🚲 Cycling &bull; ⛷ Skiing &bull; 🐠 Freediving &bull; 📖 Reading &bull; 🕹 Gaming</dd>
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
