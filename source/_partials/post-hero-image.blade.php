@if($image = $page->image)
        <section class="w-full text-center">
                <img src="{{ $image }}" alt="{{ $page->imageAttribution() }}" title="{{ $page->imageAttribution() }}">

                <small class="block text-center text-xs">
                    {!! $page->imageAttribution(true) !!}
                </small>
        </section>
@endif
