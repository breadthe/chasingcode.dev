@props(['href', 'title', 'count' => null])

<a
        href="{{ $href }}"
        title="{{ $title }}"
        class="category--tag group inline-flex items-center gap-2 font-mono bg-teal-400 hover:shadow-md rounded"
>
    <small @class([
        'rounded-r-none' => $count,
        'bg-teal-100',
        'group-hover:bg-teal-400',
        'text-teal-700',
        'group-hover:text-white',
        'px-2',
        'shadow-inner',
        'rounded',
    ])>
        {{ $slot }}
    </small>

    @if($count)
        <small class="font-light text-right pr-2 bg-teal-400 text-white rounded-r">
            {{ $count }}
        </small>
    @endif
</a>
