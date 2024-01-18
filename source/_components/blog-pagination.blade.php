@props(['pagination'])

@if ($pagination->pages->count() > 1)
    <nav class="w-full mt-4 flex flex-wrap justify-between text-base">
        @if ($previous = $pagination->previous)
            <a
                    href="{{ $previous }}"
                    title="Previous Page"
                    class="text-teal-400 pr-2"
            >&larr;</a>
        @endif

        @foreach ($pagination->pages as $pageNumber => $path)
            @if($pagination->currentPage == $pageNumber)
                <span
                        title="Page {{ $pageNumber }}"
                        class="text-black font-semibold px-2 border-b-2 border-black"
                >{{ $pageNumber }}</span>
            @else
                <a
                        href="{{ $path }}"
                        title="Go to Page {{ $pageNumber }}"
                        class="text-teal-400 px-2"
                >{{ $pageNumber }}</a>
            @endif
        @endforeach

        @if ($next = $pagination->next)
            <a
                    href="{{ $next }}"
                    title="Next Page"
                    class="text-teal-400 pl-2"
            >&rarr;</a>
        @endif
    </nav>
@endif
