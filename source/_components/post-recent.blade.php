@props(['post', 'displayUpdatedDate' => false])

<div @class([
    // 'row-span-2' => $loop->first,
    'flex',
    'flex-col',
])>
    <small class="opacity-60">
        @if($displayUpdatedDate && $post->updated)
            {{ $post->getUpdatedDate()->format('F j, Y') }}
        @else
            {{ $post->getDate()->format('F j, Y') }}
        @endunless
    </small>

    <h3 class="text-base font-semibold font-serif leading-snug mt-0">
        <a href="{{ $post->getUrl() }}" title="Read {{ $post->title }}" class="text-teal-700 hover:text-teal-900">
            {{ $post->title }}
        </a>
    </h3>

    {{--<p class="mt-2">{!! $post->getExcerpt() !!}</p>--}}
</div>