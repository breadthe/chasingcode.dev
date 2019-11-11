@if($image = $page->image)
        <section class="w-full flex flex-col items-center">
                <img src="{{ $image }}" alt="{{ $page->imageAttribution() }}" title="{{ $page->imageAttribution() }}">

                @if($imageAttribution = $page->imageAttribution(true))
                        <small class="block text-center text-xs">
                            {!! $imageAttribution !!}
                        </small>
                @endif
        </section>
@endif
