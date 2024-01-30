@props(['categories', 'posts'])

<div class="flex flex-wrap gap-2">
    @foreach ($categories->sortByDesc(function ($category) use ($posts) { return $category->posts($posts)->count(); }) as $tag => $category)
        <x-tag href="{{ '/blog/categories/' . $tag }}" title="View posts in {{ $tag }}" count="{{$category->posts($posts)->count()}}" isTagCloud>
            {{ $tag }}
        </x-tag>
    @endforeach
</div>
