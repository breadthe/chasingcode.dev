@props(['href', 'title', 'count' => null, 'isTagCloud' => false])

@php
    use function App\helpers\tagSize;
    use Illuminate\Support\Str;
@endphp

<a
        href="{{ $href }}"
        title="{{ $count }} {{ Str::plural('post', $count) }} in {{ $title }}"
        class="category--tag font-mono font-light text-teal-700"
        @if($isTagCloud)
        style="font-size: {{ tagSize($count) }}px;"
        @endif
>
    {{ $slot }}
</a>
