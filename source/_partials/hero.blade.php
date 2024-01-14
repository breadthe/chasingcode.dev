<section class="hero bg-gray-100 flex items-center flex-col py-8 sm:py-16 px-6 sm:px-0">
        <h1 class="font-light uppercase flex items-center m-0">
            {{ $title }}
        </h1>

        @if($description)
            <div class="text-center max-w-2xl">
                <h2 class="text-2xl sm:text-3xl text-gray-600 leading-normal font-sans font-light m-0 pt-4">
                    {{ $description }}
                </h2>
            </div>
        @endif
</section>
