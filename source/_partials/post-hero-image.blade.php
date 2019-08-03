<section class="w-full text-center">
    @if($image = $page->image)
        <img src="{{ $image }}" alt="{{ $page->imageAttribution() }}" title="{{ $page->imageAttribution() }}">

        <small class="block text-center text-xs">
            {!! $page->imageAttribution(true) !!}
        </small>
    @endif
</section>
