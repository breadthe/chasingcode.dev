@props(['title', 'description', 'tech' => []])

<h3>{{ $title }}</h3>

<p>{{ $description }}</p>

@if($tech)
    <p>
        <strong>Tech</strong>:
        @foreach ($tech as $tag => $url)
            @if($url)
                <a href="{{ $url }}" class="font-semibold border-b border-solid border-teal-400 hover:text-black">{{ $tag }}</a>
            @else
                {{ $tag }}
            @endif

            @if(!$loop->last)
                &bull;
            @endif
        @endforeach
    </p>
@endif