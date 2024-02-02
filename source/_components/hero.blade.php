@props(['title', 'description' => null])

<section class="hero flex items-center flex-col gap-6 py-8 px-6 sm:px-0">
        <h1 class="border-2 border-teal-900 px-4 uppercase text-white bg-teal-900 rounded" style="box-shadow: var(--hero-title-shadow)">
            {{ $title }}
        </h1>

        @if($description)
            <div class="text-center max-w-2xl">
                <h2 class="text-xl font-thin">
                    {{ $description }}
                </h2>
            </div>
        @endif
</section>
