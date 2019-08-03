<div class="flex flex-col mb-4">
    <p class="text-sm text-grey-dark my-2">
        {{ $post->getDate()->format('F j, Y') }}

        @if ($post->categories)
            &nbsp;|&nbsp;
            @foreach ($post->categories as $i => $category)
                <a
                        href="{{ '/blog/categories/' . $category }}"
                        title="View posts in {{ $category }}"
                        class="bg-grey hover:bg-pink-lighter text-white hover:text-white text-xs capitalize rounded px-1"
                >{{ $category }}</a>
            @endforeach
        @endif
    </p>

    <h2 class="text-3xl font-serif mt-0">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="text-pink-dark hover:text-pink-darker font-extrabold leading-normal"
        >{{ $post->title }}</a>
    </h2>

    <section class="flex flex-col sm:flex-row justify-start mb-4 mt-0">
        @if($image = $post->image_thumb)
            <div
                    class="overflow-hidden sm:mr-4 mb-4 sm:w-1/4 text-center"
            >
                <a
                        href="{{ $post->getUrl() }}"
                        title="Read more - {{ $post->title }}"
                        class="text-pink-dark hover:text-pink-darker font-extrabold"
                >
                    <img
                            src="{{ $image }}"
                            alt="{{ $post->imageAttribution() }}"
                            title="{{ $post->imageAttribution() }}"
                            class="rounded shadow-md"
                    >
                </a>
            </div>
        @endif

        <div class="flex-1 text-xl font-light">
            {!! $post->getExcerpt(200) !!}
        </div>
    </section>

    <a
        href="{{ $post->getUrl() }}"
        title="Read more - {{ $post->title }}"
        class="uppercase text-sm tracking-wide mb-2 hover:no-underline text-pink-dark hover:text-pink-darker text-right"
    >Read Full Post</a>
</div>
