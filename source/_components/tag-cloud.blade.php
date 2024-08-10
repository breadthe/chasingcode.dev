@props(['tags', 'posts'])

<div class="flex flex-wrap gap-2">
    @foreach ($tags->sortByDesc(function ($tag) use ($posts) { return $tag->posts($posts)->count(); }) as $tag_name => $tag)
        @php
            $count = $tag->posts($posts)->count();
        @endphp

        <x-tag href="/blog/tags/{{ $tag_name }}" title="View {{ $count }} posts {{ \Illuminate\Support\Str::plural('post', $count) }} in #{{ $tag_name }}" count="{{ $count }}" isTagCloud>
            #{{ $tag_name }}
        </x-tag>
    @endforeach
</div>
