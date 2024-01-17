@props(['categories', 'posts'])

<aside class="flex flex-col gap-4 sm:flex-1 px-4 mb-8">
    <h2 class="flex items-center justify-between text-teal-700">
        Categories
    </h2>
    <div class="flex flex-wrap gap-2">
        @foreach ($categories->sortByDesc(function ($category) use ($posts) { return $category->posts($posts)->count(); }) as $tag => $category)
            <x-tag href="{{ '/blog/categories/' . $tag }}" title="View posts in {{ $tag }}" count="{{$category->posts($posts)->count()}}">
                {{ $tag }}
            </x-tag>
        @endforeach
    </div>
</aside>
