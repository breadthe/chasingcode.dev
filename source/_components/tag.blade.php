@props(['href', 'title', 'count' => null])

<a
        href="{{ $href }}"
        title="{{ $title }}"
        class="category--tag group inline-flex items-center gap-2 font-mono bg-teal-400 hover:shadow-md no-underline rounded"
>
    <span @class([
        'px-2',
        'rounded',
        'rounded-r-none' => $count,
        'bg-teal-100',
        'group-hover:bg-teal-400',
        'text-teal-700',
        'group-hover:text-white',
        'font-light',
        'shadow-inner',
    ])>
        {{ $slot }}
    </span>

    @if($count)
        <small class="font-light text-right pr-2 bg-teal-400 text-white rounded-r">
            {{ $count }}
        </small>
    @endif
</a>
