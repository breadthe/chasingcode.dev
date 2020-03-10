---
extends: _layouts.post
section: content
title: How to Add an Unsplash or Custom Hero Image to a Jigsaw Article
date: 2020-03-10
description: A guide for adding a custom hero image programatically to a Jigsaw blog post.
categories: [Jigsaw, Laravel]
featured: false
image: https://source.unsplash.com/6yjAC0-OwkA/?fit=max&w=1350
image_thumb: https://source.unsplash.com/6yjAC0-OwkA/?fit=max&w=200&q=75
image_author: Esteban Lopez
image_author_url: https://unsplash.com/@exxteban
image_unsplash: true
image_overlay_text:
---

The fashion these days dictates that every developer blog post come with a hero image. While not entirely true, I started this pattern with the blog and I'll be damned if I end it.

The blog engine itself is Tighten's [Jigsaw](https://jigsaw.tighten.co/), a Laravel static site builder that is perfect for my needs. Because it is Laravel/PHP based, the base template can be customized to a high extent, something that I have done here with some success.

Today I'll go into more detail about one customization in particular: the hero image featured at the top of every article.

## Image types

Whether you've read my articles before or not, there are two types of hero images I typically use at the top of a blog post. There's the generic [Unsplash](https://unsplash.com/) image that bears a resemblance to the subject matter, like this very article for example. Then there's the more technical image that I create myself, such as this article about having [Fun at the Laravel Console](/blog/laravel-console-fun/).

This boils down to either self-hosted or Unsplash images. The way each of these is generated differs slightly.

## The blog post metadata

**Disclaimer** I write all articles in Markdown and I'm not sure how (and if) this would work in other formats.

Each Jigsaw Markdown post (located in `{project}/source/_posts`) has a metadata section at the top, written in [YAML front-matter](https://hexo.io/docs/front-matter.html). This defines various article-specific parameters.

The current article, for example, would have the following as built-in defaults:

```yaml
---
extends: _layouts.post
section: content
title: How to Add an Unsplash or Custom Hero Image to a Jigsaw Article
date: 2020-03-10
description: A guide for adding a custom hero image programatically to a Jigsaw blog post.
categories: [Jigsaw, Laravel]
featured: false
---
```

It's a very clean and simple format that is self-explanatory in what it accomplishes, so I won't go into further detail here, but you can read more on the [official documentation page](https://jigsaw.tighten.co/docs/content-markdown/). 

The cool thing is that you can extend this metadata to the limits of your imagination. This is exactly what I did in order to automate displaying custom hero images at the top of each article. Let's find out how.

## Unsplash images

For Unsplash images, such as the current article, I've added these extra parameters:

```yaml
---
# defaults
image: https://source.unsplash.com/6yjAC0-OwkA/?fit=max&w=1350
image_thumb: https://source.unsplash.com/6yjAC0-OwkA/?fit=max&w=200&q=75
image_author: Esteban Lopez
image_author_url: https://unsplash.com/@exxteban
image_unsplash: true
image_overlay_text:
---
```

The above will render the image along with the attribution right below it: *Photo by Esteban Lopez on Unsplash*. Both the site and the author are linked.

## Custom, self-hosted images

My article on the [Laravel Console](/blog/laravel-console-fun/) features a custom image that is self-hosted and saved in the `/assets/img/` project directory. This is how the metadata looks:

```yaml
# defaults
image: /assets/img/2020-02-10-laravel-console-fun.png
image_thumb: /assets/img/2020-02-10-laravel-console-fun.png
image_author: 
image_author_url: 
image_unsplash: 
image_overlay_text:
```

> You can omit the empty keys, of course. I choose to keep them around to remind myself they exist.

## Modifying the post Blade template

Simply adding the additional metadata won't magically cause the image to be rendered. The first thing to make that happen is to include a Blade partial at the top of the `source/_layouts/post.blade.php` file.

```html
@include('_partials.post-hero-image')
```

Then in `source/_partials/post-hero-image.blade.php` I have the following:

```html
@if($image = $page->image)
    <section class="w-full flex flex-col items-center justify-center relative">
        @if($imageOverlayText = $page->image_overlay_text)
            <div
                class="absolute font-black p-12 text-6xl rounded-full"
                style="
                    color: #ff0a5c;
                    background-color: #ffeb3b;
                    filter: invert(1);
                    mix-blend-mode: exclusion;
                    transform: rotate(-5deg);
                    box-shadow: 15px 15px #ff0a5c;
                    text-shadow: 5px 5px 1px #05e2ff;
                "
            >
                {{ $imageOverlayText }}
            </div>
        @endif

        <img src="{{ $image }}" alt="{{ $page->imageAttribution() ?: $page->title }}">

        @if($imageAttribution = $page->imageAttribution(true))
            <small class="block text-center text-xs">
                {!! $imageAttribution !!}
            </small>
        @endif
    </section>
@endif
```

This part `@if($imageOverlayText = $page->image_overlay_text)` is recent, and I'll circle back to it in a shortly.

Starting at the top, the entire block is wrapped in a check for the existence of an image source `@if($image = $page->image)`. For Unsplash images it's a absolute URL, while for local images it's a relative path.

Next, the image is displayed `<img src="{{ $image }}" alt="{{ $page->imageAttribution() ?: $page->title }}">`. The `alt` text will be either the Unsplash author attribution, or the title of the page if the former is missing.

Finally, if there's an attribution (in other words an Unsplash image), I'll show the `Photo by X on Unsplash` snippet below the image:

```html
@if($imageAttribution = $page->imageAttribution(true))
    <small class="block text-center text-xs">
        {!! $imageAttribution !!}
    </small>
@endif
```

The final piece of the puzzle is the custom `$page->imageAttribution()` method, which I will explain next.

## The image attribution method

In Jigsaw, you can define your own global helper methods in `/config.php`, inside the main array. Here's what `imageAttribution()` looks like:

```php
return [
    // ...

    'imageAttribution' => function ($page, $html = false) {
        $str = '';

        $image_author = $page->image_author;
        $image_author_url = $page->image_author_url;

        if ($image_author) {
            $str .=  "Photo by ";

            if ($html) {
                if ($image_author_url) {
                    $str .= '<a href="' . $image_author_url . '" title="' . $image_author . '">' . $image_author . '</a>';
                } else {
                    $str .=  "$image_author ($image_author_url)";
                }
            } else {
                $str .= "$image_author";
            }
        }

        if ($page->image_unsplash) {
            if ($html) {
                $str .= ' on <a href="https://unsplash.com" title="Unsplash">Unsplash</a>';
            } else {
                $str .= ' on Unsplash (https://unsplash.com)';
            }
        }

        return $str;
    },
];
```

I hope the above is self-documenting, but in a nutshell it's sole purpose is to render the `Photo by X on Unsplash` snippet, with the choice of plain text or HTML (pass the `true` argument). I use the HTML version for displaying below the image, while the plain text goes in the image `alt` text.

## Custom image overlay text

My [2020 Tech Radar](/blog/2020-tech-radar/) article features some funky text overlayed on top of an Unsplash image. This text is controlled by this post meta:

```yaml
---
# ...
image_overlay_text: 2020 Tech Radar
---
```

Going back to `source/_partials/post-hero-image.blade.php`, the following block controls whether this text is displayed:

```html
@if($imageOverlayText = $page->image_overlay_text)
    <div
        class="absolute font-black p-12 text-6xl rounded-full"
        style="
            color: #ff0a5c;
            background-color: #ffeb3b;
            filter: invert(1);
            mix-blend-mode: exclusion;
            transform: rotate(-5deg);
            box-shadow: 15px 15px #ff0a5c;
            text-shadow: 5px 5px 1px #05e2ff;
        "
    >
        {{ $imageOverlayText }}
    </div>
@endif
```

There is an obvious issue with this approach: it is quite inflexible. I tweaked the text styling to work well with that particular image, but if I try to apply it to other images, it will likely look out of place.

I'm a fan of the [Rule of three](https://en.wikipedia.org/wiki/Rule_of_three_(computer_programming)) refactoring principle, so if I reach the point where I'm doing this 2-3 more times (each would have to be individually tweaked), one solution I could reach for is to add another meta parameter that points to a CSS class. I'd then move the styling to one of my SCSS files and simply apply the corresponding class to the snippet above. 


## Conclusion

I ❤️ how flexible Jigsaw is, and the extreme degree to which it can be customized. This is a relatively simple example of what can be done within this platform, but [the world is your oyster](https://www.collinsdictionary.com/dictionary/english/the-world-is-your-oyster), as they say.
