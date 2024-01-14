@props(['post'])

<article class="flex flex-col mb-4">
    <h2 class="text-xl font-serif leading-snug mb-2">
        <a
                href="{{ $post->getUrl() }}"
                title="Read more - {{ $post->title }}"
                class="text-teal-700 hover:text-teal-900"
        >{{ $post->title }}</a>
    </h2>

    <div class="flex flex-col md:flex-row gap-2 opacity-60 hover:opacity-100 mb-2">
        <small class="font-mono">
            {{ date('F j, Y', $post->date) }}
        </small>

        <small class="hidden md:block">&bull;</small>

        <x-tags :tags="$post->categories" />
    </div>

    <section class="flex flex-col md:flex-row justify-start">
        @if($image = $post->image_thumb)
            <div
                    class="md:w-1/4 md:mr-4 mt-1 mb-2 md:mb-0 md:max-h-[150px]"
            >
                <a
                        href="{{ $post->getUrl() }}"
                        title="Read more - {{ $post->title }}"
                        aria-label="Read more - {{ $post->title }}"
                >
                    <img
                            src="{{ $image }}"
                            alt="{{ $post->imageAttribution() }}"
                            title="{{ $post->imageAttribution() }}"
                            class="rounded shadow-lg"
                    >
                </a>
            </div>
        @endif

        <div class="flex-1">
            {!! $post->getExcerpt(200) !!}
        </div>
    </section>

    <a
        href="{{ $post->getUrl() }}"
        title="Read more - {{ $post->title }}"
        class="text-sm tracking-wide hover:no-underline opacity-60 hover:opacity-100 text-right font-semibold"
    >Read more →</a>
</article>
