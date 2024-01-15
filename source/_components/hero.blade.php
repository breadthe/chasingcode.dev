@props(['title', 'description' => null])

<section class="hero bg-gray-100 flex items-center flex-col gap-6 py-8 px-6 sm:px-0">
        <h1 class="flex items-center m-0 relative">
            <span class="z-10 bg-white uppercase border border-black px-2">{{ $title }}</span>
            <span class="w-full absolute top-2 left-2 bg-teal-400">&nbsp;</span>
        </h1>

        @if($description)
            <div class="text-center max-w-2xl">
                <h2 class="text-xl font-thin">
                    {{ $description }}
                </h2>
            </div>
        @endif
</section>
