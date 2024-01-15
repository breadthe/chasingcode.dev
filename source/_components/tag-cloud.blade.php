@props(['categories', 'posts'])

<aside class="sm:flex-1 p-4 sm:p-6 mb-8">
    <h2 class="flex items-center justify-between text-teal-700">
        Categories
    </h2>
    <div class="grid grid-cols-2 sm:grid-cols-1 gap-2">
        @foreach ($categories->sortByDesc(function ($category) use ($posts) { return $category->posts($posts)->count(); }) as $tag => $category)
            <div class="flex items-center text-center">
                <a
                        href="{{ '/blog/categories/' . $tag }}"
                        title="View posts in {{ $tag }}"
                        class="px-2 border border-dashed rounded bg-teal-100 hover:bg-teal-400 text-teal-700 hover:text-teal-100"
                >{{ $tag }}</a>
                <span class="text-base font-light text-right ml-4">
                            {{ $category->posts($posts)->count() }}
                        </span>
            </div>
        @endforeach
    </div>
</aside>
