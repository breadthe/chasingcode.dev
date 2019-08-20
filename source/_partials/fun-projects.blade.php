<article class="m-4 mt-8 flex items-center">

    <div class="container mx-auto max-w-4xl p-4 bg-white border border-gray-200 shadow-xl">

        <div class="text-center mb-8 sm:mb-4">
            <h1 class="inline pb-2 border-b-2 border-gray-400 text-gray-900 text-5xl font-sans font-thin">Fun projects</h1>
        </div>

        <div class="mx-auto sm:max-w-lg text-center mb-8 sm:mb-4 text-lg text-teal-700">
            Casual little projects that I built mostly for fun, and to explore new technologies. Open source and free to use by anyone.
        </div>

        <div class="mt-1 flex flex-wrap items-start justify-around">
            <div class="w-full sm:w-1/4 p-2 text-lg text-center text-grey-darkest mt-8 sm:mt-0">
                <div class="flex flex-col items-center justify-center">
                    <span class="font-bold">Craftnautica</span>
                    <a href="https://craftnautica.netlify.com" class="flex items-center justify-center" target="_blank">
                        craftnautica.netlify.com
                    </a>
                    <a href="https://github.com/breadthe/craftnautica" class="inline-flex items-center mx-2" title="Craftnautica on Github">
                        @include('_partials.icons._svg', ['icon' => 'github']) <span class="ml-1">Github</span>
                    </a>
                </div>
                {{--<div class="bg-green-800 text-green-100 border-green-200 font-light mt-4 border-2 border-dashed p-2 shadow">--}}
                    <img src="/assets/images/craftnautica.png" class="mt-4" title="craftnautica.netlify.com" alt="craftnautica.netlify.com">
                {{--</div>--}}
                <div class="bg-blue-900 text-blue-400 border-blue-200 font-light mt-4 border-2 border-dashed p-2 shadow">
                    Crafting and inventory management tool for Subnautica and Subnautica: Below Zero.
                </div>
            </div>
            <div class="w-full sm:w-1/4 p-2 text-lg text-center">
                <div class="flex flex-col items-center justify-center">
                    <span class="font-bold">Folio</span>
                    &nbsp;
                    <a href="https://github.com/breadthe/folio" class="inline-flex items-center mx-2" title="Folio on Github">
                        @include('_partials.icons._svg', ['icon' => 'github']) <span class="ml-1">Github</span>
                    </a>
                </div>
                <div class="p-0">
                    <img src="/assets/images/folio.png" class="mt-4" title="Crypto coin portfolio" alt="Crypto coin portfolio">
                </div>
                <div class="bg-gray-900 text-gray-400 border-gray-400 font-light mt-4 border-2 border-dashed p-2 shadow">
                    Crypto coin portfolio and price tracker desktop app.
                </div>
            </div>
            <div class="w-full sm:w-1/4 p-2 text-lg text-center">
                <div class="flex flex-col items-center justify-center">
                    <span class="font-bold">Moviebuff</span>
                    <a href="https://moviebuff.surge.sh" class="flex items-center justify-center" target="_blank">
                        moviebuff.surge.sh
                    </a>
                    <a href="https://github.com/breadthe/moviebuff" class="inline-flex items-center mx-2" title="Moviebuff on Github">
                        @include('_partials.icons._svg', ['icon' => 'github']) <span class="ml-1">Github</span>
                    </a>
                </div>
                <img src="/assets/images/moviebuff.png" class="mt-4" title="moviebuff.surge.sh" alt="moviebuff.surge.sh">
                <div class="bg-yellow-500 text-yellow-100 border-yellow-200 font-light mt-4 border-2 border-dashed p-2 shadow">
                    Simple movie watch- and seen-list.
                </div>
            </div>
        </div>

    </div>

</article>
