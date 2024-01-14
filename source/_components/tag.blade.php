@props(['href', 'title'])

<a
        href="{{ $href }}"
        title="{{ $title }}"
        class="category--tag font-mono shadow-inner hover:shadow-md bg-teal-100 hover:bg-teal-400 text-teal-700 hover:text-teal-50 rounded px-2"
>
    {{ $slot }}
</a>
