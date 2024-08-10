@props(['href', 'title', 'count' => null, 'isTagCloud' => false])

<a
        href="{{ $href }}"
        title="{{ $title }}"
        class="category--tag font-mono font-light text-teal-700"
        @if($isTagCloud)
            style="font-size: {{ \App\helpers\tagSize($count) }}px;"
        @endif
>
    {{ $slot }}
</a>
