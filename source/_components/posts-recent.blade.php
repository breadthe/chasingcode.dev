@props(['posts', 'seeAll' => false, 'displayUpdatedDate' => false])

<div class="sm:w-1/2">
    <div class="flex items-center justify-between">
        <h2 class="mb-2">{{ $slot }}</h2>

        @if($seeAll)
            <a href="/blog" class="text-sm tracking-wide no-underline opacity-60 hover:opacity-100 text-right font-semibold">see all</a>
        @else
            &nbsp;
        @endif
    </div>

    <div class="flex flex-col gap-4">
        @foreach ($posts as $post)
            <x-post-recent :post="$post" displayUpdatedDate />
        @endforeach
    </div>
</div>