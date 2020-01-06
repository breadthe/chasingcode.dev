<section class="mt-4">
    <div>
        Liked this article? Share it on your favorite platform.
    </div>

    <a href="https://twitter.com/share?url={{ $page->getUrl() }}&text={{ $page->description }}&via={{ $page->twitterHandle }}"
       style="background: #55acee;"
       class="social--share--icon text-lg text-white hover:text-white rounded font-mono px-2 py-1"
    >Twitter</a>

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $page->getUrl() }}"
       style="background: #3B5998;"
       class="social--share--icon text-lg text-white hover:text-white rounded font-mono px-2 py-1"
    >Facebook</a>

    <a href="https://reddit.com/submit?url={{ $page->getUrl() }}&title={{ $page->title }}"
       style="background: #ff5700;"
       class="social--share--icon text-lg text-white hover:text-white rounded font-mono px-2 py-1"
    >Reddit</a>

    <a href="https://news.ycombinator.com/submitlink?u={{ $page->getUrl() }}&t={{ $page->title }}"
       style="background: #ff6600;"
       class="social--share--icon text-lg text-white hover:text-white rounded font-mono px-2 py-1"
    >Hacker News</a>

    <a href="https://www.linkedin.com/shareArticle?url={{ $page->getUrl() }}&title={{ $page->title }}&summary={{ $page->description }}&source={{ $page->baseUrl }}"
       style="background: #4875B4;"
       class="social--share--icon text-lg text-white hover:text-white rounded font-mono px-2 py-1"
    >LinkedIn</a>

    <a href="mailto:?subject={{ $page->title }}&body={{ $page->getUrl() }}"
       style="background: #444444;"
       class="social--share--icon text-lg text-white hover:text-white rounded font-mono px-2 py-1"
    >Email</a>
</section>

