<nav>
    <ul class="mx-4 flex flex-row justify-between sm:justify-start gap-2 sm:gap-4">
        <li>
            @if($page->getPath() === '/about')
                <strong>Me</strong>
            @else
                <a href="/about" class="border-b border-solid border-teal-400 hover:text-black">Me</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/site'))
                <strong>Site</strong>
            @else
                <a href="/about/site" class="border-b border-solid border-teal-400 hover:text-black">Site</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/resume'))
                <strong>Resume</strong>
            @else
                <a href="/about/resume" class="border-b border-solid border-teal-400 hover:text-black">Resume</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/hobbies'))
                <strong>Hobbies</strong>
            @else
                <a href="/about/hobbies" class="border-b border-solid border-teal-400 hover:text-black">Hobbies</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/projects'))
                <strong>Projects</strong>
            @else
                <a href="/about/projects" class="border-b border-solid border-teal-400 hover:text-black">Projects</a>
            @endif
        </li>
        <li>
            @if($page->belongsTo('/about/packages'))
                <strong>Packages</strong>
            @else
                <a href="/about/packages" class="border-b border-solid border-teal-400 hover:text-black">Packages</a>
            @endif
        </li>
    </ul>
</nav>
