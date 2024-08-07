@if($image = $page->image)
    <section class="w-full flex flex-col items-center justify-center relative mt-4">
        @if($imageOverlayText = $page->image_overlay_text)
            <div
                    class="absolute font-black p-12 text-6xl rounded-full"
                    style="
                    color: #ff0a5c;
                    background-color: #ffeb3b;
                    filter: invert(1);
                    mix-blend-mode: exclusion;
                    transform: rotate(-5deg);
                    box-shadow: 15px 15px #ff0a5c;
                    text-shadow: 5px 5px 1px #05e2ff;
                "
            >
                    {{ $imageOverlayText }}
            </div>
        @endif

        <img src="{{ $image }}" alt="{{ $page->imageAttribution() ?: $page->title }}" class="rounded">

        @if($imageAttribution = $page->imageAttribution(true))
            <em class="block text-center text-xs opacity-60 mt-1">
                {!! $imageAttribution !!}
            </em>
        @endif
    </section>
@endif
