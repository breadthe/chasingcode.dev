@props(['label', 'href', 'page'])

<li>
    <a
        href={{ $href }}
        @class([
            'text-teal-700 hover:text-teal-900',
            'text-teal-900 underline underline-offset-4 decoration-4 decoration-teal-400' => $page->belongsTo($href),
        ])
    >{{ $label }}</a>
</li>
