@props(['tags'])

@if ($tags)
    <small class="flex flex-wrap gap-2">
        @foreach ($tags as $tag)
            <x-tag href="/blog/tags/{{ $tag }}" title="View posts in #{{ $tag }}">
                #{{ $tag }}
            </x-tag>
        @endforeach
    </small>
@endif
