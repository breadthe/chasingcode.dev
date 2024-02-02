<nav>
    <ul class="mx-4 flex flex-row justify-between sm:justify-start gap-2 sm:gap-4">
        <li>
            @if($page->getPath() === '/about')
                <strong>Me</strong>
            @else
                <a href="/about" class="font-light">Me</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/site'))
                <strong>Site</strong>
            @else
                <a href="/about/site" class="font-light">Site</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/resume'))
                <strong>Resume</strong>
            @else
                <a href="/about/resume" class="font-light">Resume</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/hobbies'))
                <strong>Hobbies</strong>
            @else
                <a href="/about/hobbies" class="font-light">Hobbies</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/projects'))
                <strong>Projects</strong>
            @else
                <a href="/about/projects" class="font-light">Projects</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/packages'))
                <strong>Packages</strong>
            @else
                <a href="/about/packages" class="font-light">Packages</a>
            @endif
        </li>
    </ul>
</nav>
