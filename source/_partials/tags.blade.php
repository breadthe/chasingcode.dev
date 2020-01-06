@if ($page->categories)
    @foreach ($page->categories as $i => $category)
        <a
                href="{{ '/blog/categories/' . $category }}"
                title="View posts in {{ $category }}"
                class="category--tag px-2 border border-dashed border-teal-700 hover:border-teal-100 bg-teal-100 hover:bg-teal-400 text-teal-700 hover:text-teal-100 font-semibold rounded px-1"
                style="background-image: none;"
        >{{ $category }}</a>
    @endforeach
@endif
