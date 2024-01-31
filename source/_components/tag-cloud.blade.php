@props(['tags', 'posts'])

<div class="flex flex-wrap gap-2">
    @foreach ($tags->sortByDesc(function ($tag) use ($posts) { return $tag->posts($posts)->count(); }) as $tag_name => $tag)
        <x-tag href="/blog/tags/{{ $tag_name }}" title="View posts in {{ $tag_name }}" count="{{$tag->posts($posts)->count()}}" isTagCloud>
            #{{ $tag_name }}
        </x-tag>
    @endforeach
</div>
