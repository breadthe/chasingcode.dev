@props(['pagination'])

@if ($pagination->pages->count() > 1)
    <nav class="flex flex-wrap text-base">
        @if ($previous = $pagination->previous)
            <a
                    href="{{ $previous }}"
                    title="Previous Page"
                    class="hover:bg-teal-400 text-teal-400 hover:text-white font-semibold rounded mr-3 px-5 py-3 leading-loose"
            >&LeftArrow;</a>
        @endif

        @foreach ($pagination->pages as $pageNumber => $path)
            @if($pagination->currentPage == $pageNumber)
                <span
                        title="Page {{ $pageNumber }}"
                        class="text-teal-700 font-semibold rounded mr-3 px-5 py-3 leading-loose"
                        style="background-image: linear-gradient(to bottom, transparent 70%, #4FD1C5 70%);"
                >{{ $pageNumber }}</span>
            @else
                <a
                        href="{{ $path }}"
                        title="Go to Page {{ $pageNumber }}"
                        class="hover:bg-teal-400 text-teal-400 hover:text-white font-semibold rounded mr-3 px-5 py-3 leading-loose"
                >{{ $pageNumber }}</a>
            @endif
        @endforeach

        @if ($next = $pagination->next)
            <a
                    href="{{ $next }}"
                    title="Next Page"
                    class="hover:bg-teal-400 text-teal-400 hover:text-white font-semibold rounded mr-3 px-5 py-3 leading-loose"
            >&RightArrow;</a>
        @endif
    </nav>
@endif
