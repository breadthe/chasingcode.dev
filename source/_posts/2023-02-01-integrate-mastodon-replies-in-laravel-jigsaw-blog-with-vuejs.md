---
extends: _layouts.post
section: content
title: How to Integrate Mastodon Replies in a Laravel Jigsaw Blog With VueJS
date: 2023-02-01
description: A solution for integrating Mastodon replies in a Laravel Jigsaw blog with VueJS.
categories: [Laravel, Jigsaw, VueJS, Mastodon]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/109790916876534199
---

🎉 After many years this blog finally has a comments section of sorts! I have recently added Mastodon replies to blog posts.

Granted, the audience is small for now, but I'm hoping to grow it over time. I'm also hoping that this will encourage me to write more often. Eventually I hope to add GitHub issues as comments as well.

## How to

Figuring out how to do this from scratch on my own would have been a massive undertaking. Thankfully, I found [this article](https://www.codingwithjesse.com/blog/add-mastodon-replies-to-your-blog/) by [Jesse Skinner](https://toot.cafe/@JesseSkinner) that explains in great detail how to do this.

If your blog doesn't use VueJS, you can probably stop here, although you can apply the same principles to components written in other JS frameworks. Otherwise, read on.

## Laravel Jigsaw with VueJS

Jesse's solution is great, until I reached the JS part. Since this blog is not made with a JavaScript framework, I couldn't just copy/paste his front-end code and expect it to work.

I'm using [Laravel Jigsaw](https://jigsaw.tighten.co/) to build this blog. The code is [open source](https://github.com/breadthe/chasingcode.dev), so feel free to check it out.

I considered several solutions, but in the end I decided to go with VueJS. There was already a VueJS component previously, for the search functionality. It made sense to follow the same pattern and add a new component for the Mastodon replies. 

## The Blade wrapper partial

To start, I created a new Blade partial in `source/_partials/mastodon-webmention.blade.php` that I included at the bottom of `source/_layouts/post.blade.php` (the template for a single blog post).

This Blade partial is just a wrapper around the VueJS component, and provides an id for the component to hook on to.

```html
<section id="mastodon-webmention">
    <mastodon-webmention page-url="{{ $page->getUrl() }}" mastodon-toot-url="{{ $page->mastodon_toot_url }}"></mastodon-webmention>
</section>
```

It takes two props:

- `page-url`: the URL of the current page (the blog post)
- `mastodon-toot-url`: the URL of the Mastodon toot

Note that `$page->getUrl()` is a Jigsaw helper function that returns the URL of the current page.

The Mastodon toot url is empty initially, until I announce the published article in a Mastodon toot. Then I grab the URL and update the front matter of the blog post. The reason I need this is to be able to provide a "Discuss this article on Mastodon" link at the bottom of the blog post.

## Configuring the VueJS component

Before being able to use the VueJS component, I needed to configure it. I created a new file `source/_assets/js/components/MastodonWebmention.vue` and then registered the component in `source/_assets/js/main.js`:

```js
import MastodonWebmention from './components/MastodonWebmention.vue';

if (document.getElementById('mastodon-webmention')) {
    new Vue({
        components: {
            MastodonWebmention
        },
    }).$mount('#mastodon-webmention');
}
```

I am mounting the component to the `#mastodon-webmention` element, which is the wrapper I created in the Blade partial. I'm also checking if the element exists before mounting the component, to avoid JS errors on pages that are not blog posts (they won't have this element).

## The Mastodon replies VueJS component

Now that the component is registered, it's time to copy the code from Jesse's article and paste it in the `MastodonWebmention.vue` file under the `methods` section. Note that this is Vue 2.5 code so it doesn't use the composition API.

I massaged it into a VueJS-friendly format, and added some additional helper methods.

I'm rendering replies, boosts, and favorites in the same component, much in the same way Jesse's doing it, but in a slightly different order. I'm also rendering a "Discuss this article on Mastodon" link at the bottom of the component, if the Mastodon toot URL is set.

Here's the full code for the component, but you can also check it out on [GitHub](https://github.com/breadthe/chasingcode.dev/blob/master/source/_assets/js/components/MastodonWebmention.vue).

```html
<template>
  <div :class="mastodonTootUrl.length || replies.length || boosts.length || favorites.length ? 'my-4 flex flex-col gap-4' : ''">
    <a
        v-if="mastodonTootUrl.length"
        :href="mastodonTootUrl"
        class="w-full p-2 text-center text-xl text-mastodon-purple hover:text-white bg-indigo-100 hover:bg-mastodon-purple rounded font-bold"
        target="_blank"
    >
      Discuss this article on Mastodon
    </a>

    <div v-if="replies.length">
      <h6 class="mb-2 text-xl text-mastodon-purple font-bold">Replies</h6>

      <div class="flex flex-col gap-2">
        <div v-for="reply in replies" :key="reply.url" class="p-2 border-2 border-mastodon-purple rounded">
          <a :href="reply.author.url" class="flex gap-2 items-center text-base text-mastodon-purple font-bold group" target="_blank">
            <img :src="reply.author.photo" :alt="reply.author.name" class="w-16 rounded-lg">

            <div class="flex flex-col">
              <span class="font-normal group-hover:text-mastodon-purple group-hover:underline">{{ reply.author.name }}</span>
              <span class="text-sm text-gray-600 font-light">{{ authorUrlToMastodonUrl(reply.author.url) }}</span>
            </div>
          </a>

          <div class="mt-2 text-gray-900 text-sm font-light">
            <p class="text-black">{{ reply.content.text }}</p>

            <a :href="reply.url" target="_blank" class="block -mt-4 text-right text-mastodon-purple hover:text-mastodon-purple hover:underline">Reply</a>
          </div>
        </div>
      </div>
    </div>

    <div v-if="boosts.length">
      <h6 class="mb-2 text-xl text-mastodon-purple font-bold">Boosted</h6>

      <div class="flex flex-wrap gap-2">
        <a v-for="boost in boosts" :key="boost.url" :href="boost.author.url" target="_blank">
          <img :src="boost.author.photo" :alt="boost.author.name" class="w-16 rounded-lg">
        </a>
      </div>
    </div>

    <div v-if="favorites.length">
      <h6 class="mb-2 text-xl text-mastodon-purple font-bold">Favorited</h6>

      <div class="flex flex-wrap gap-2">
        <a v-for="favorite in favorites" :key="favorite.url" :href="favorite.author.url" target="_blank">
          <img :src="favorite.author.photo" :alt="favorite.author.name" class="w-16 rounded-lg">
        </a>
      </div>
    </div>

  </div>
</template>

<script>
export default {
    props: {
        pageUrl: {
            type: String,
            required: true,
            default: '/blog',
        },
        mastodonTootUrl: {
            type: String,
            required: true,
            default: '',
        },
    },
    data() {
        return {
          // https://webmention.io/api/mentions.jf2?target=https://yourblog.com/blog/blog-post-slug/&per-page=100&page=0}
          webmentionIoUrl: 'https://webmention.io/api/mentions.jf2',
          link: '',
          favorites: [],
          boosts: [],
          replies: [],
        };
    },
    computed: {

    },
    methods: {
      async loadWebmentions() {
        let mentions = await this.getMentions(this.pageUrl);

        if (mentions.length) {
          this.link = mentions
              // find mentions that contain my Mastodon URL
              .filter((m) => m.url.startsWith('https://indieweb.social/@brbcoding'))
              // take the part before the hash
              .map(({ url }) => url.split('#')[0])
              // take the first one
              .shift();

          // use the wm-property to make lists of favourites, boosts & replies
          this.favorites = mentions.filter((m) => m['wm-property'] === 'like-of');
          this.boosts = mentions.filter((m) => m['wm-property'] === 'repost-of');
          this.replies = mentions.filter((m) => m['wm-property'] === 'in-reply-to');
        }
      },
      async getMentions(pageUrl) {
        let mentions = [];
        let page = 0;
        const perPage = 100;

        while (true) {
          const results = await fetch(
              `${this.webmentionIoUrl}?target=${pageUrl}/&per-page=${perPage}&page=${page}`
          ).then((r) => r.json());

          mentions = mentions.concat(results.children);

          if (results.children.length < perPage) {
            break;
          }

          page++;
        }

        return mentions.sort((a, b) => ((a.published || a['wm-received']) < (b.published || b['wm-received']) ? -1 : 1));
      },

      // Transforms "https://mastodon.social/@authorname" to "@authorname@mastodon.social"
      authorUrlToMastodonUrl(url) {
        const parts = url.split('/');
        return `${parts[3]}@${parts[2]}`;
      },
    },
  created() {
      this.loadWebmentions();
  },
};
</script>
```

And that's about it! It's worth mentioning that I haven't touched Vue in a few years, but it felt familiar like riding a bike.

Here's what it looks like:

![Screenshot of the Mastodon webmentions component](/assets/img/2023-02-01-mastodon-replies-jigsaw-blog.jpg)
