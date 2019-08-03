---
extends: _layouts.post
section: content
title: Simplified Dynamic SVG Icon Component
date: 2019-02-08
description: An even simpler, reusable Vue component wrapper for a SVG icon library.
categories: [VueJS, SVG, TailwindCSS]
featured: false
image: /assets/img/2019-02-08-simplified-dynamic-svg-icon-component.png
image_thumb: /assets/img/2019-02-08-simplified-dynamic-svg-icon-component.png
image_author:
image_author_url:
image_unsplash:
---

Well this is embarrassing. One of my flaws is that sometimes I tend to jump to a conclusion before I have all the facts. I guess a strength is recognizing this flaw. Do they cancel each other out? Maybe. No one likes egg on their face but I'll admit that my [previous article](/blog/supercharged-dynamic-vue-svg-icon-component) was flawed. I will leave it intact for posterity though, both to show the errata and to provide an alternative way of doing things.

Massive mea culpa: I didn't read the [TailwindCSS documentation](https://tailwindcss.com/docs/svg) carefully, or I just didn't pay enough attention, but the framework _does_ contain support for SVG fill and stroke. Basically you can apply `.fill-current` and/or `.stroke-current` to an `svg` element and presto, your icon is colored based on the `.text-<color>` class that is also applied to it.

What's even funnier is that Adam specifically mentions in the documentation the two SVG icon libraries I love the most: [Zondicons](http://www.zondicons.com/) and [Feathericons](https://feathericons.com/). Since one is fill-based, while the other is stroke-based, this new and improved dynamic component wrapper should work equally well for both libraries.

As a result, the API for my dynamic icon component can be simplified a lot.

This

```html
<v-icon icon="menu" fill="red"></v-icon>
```

becomes

```html
<v-icon icon="menu" class="text-red fill-current stroke-current"></v-icon>
```

But I can simplify it even more by always applying `fill-current` and `stroke-current` inside the scoped CSS of the `VIcon.vue` component:

```html
<style>
svg {
    @apply cursor-pointer;
    @apply inline-block;
    @apply stroke-current;
    @apply fill-current;
}
</style>
```

I no longer need the `fill` prop, nor the `dynamicFill` computed props.

Another thing that is no longer required is the `size` prop. It turns out that you can simply apply Tailwind `w-` and `h-` classes to the `svg` element. However, I decided to keep the `size` prop in order to offer finer control over icon sizing, in pixels. However, to keep the UI consistent, I would strive to use Tailwind's classes instead.

In summary, to generate a blue 12px menu icon I would do this:

```html
<v-icon icon="menu" class="text-blue h-3 w-3"></v-icon>
```

**Note** The above computes to 12px in my case because I have the font size on the root `body` element set to 16px. Hence, `h-3` and `w-3` are defined as 0.75rem in Tailwind's default config, which evaluates to 0.75 * 16px = 12px.

There you go, while the previous version works just as well, this updated one - I think - is simpler and overall better.
