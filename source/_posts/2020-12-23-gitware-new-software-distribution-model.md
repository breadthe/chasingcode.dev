---
extends: _layouts.post
section: content
title: Gitware - A New Software Distribution Model
date: 2020-12-23
description: Give away the software product, but charge for the source code
categories: [Opinion]
featured: false
image: https://source.unsplash.com/DuHKoV44prg/?fit=max&w=1350
image_thumb: https://source.unsplash.com/DuHKoV44prg/?fit=max&w=200&q=75
image_author: Fotis Fotopoulos
image_author_url: https://unsplash.com/@ffstop
image_unsplash: true
---

As I approach the official release of [SVGX](https://svgx.app/), a desktop app I made in 2020, I'm wrestling with the question of how to price it. It's never an easy question, especially for a first attempt at a commercial software product. 

This is not about the merits of SVGX. No, it's about the impostor syndrome that haunts many a developer, even after the product is done. I feel a little dirty and bothered by the idea of charging for something I made in my spare time, for my own use, that many would expect to be released as open source.

At the same time, I put lots of passion and many hours into building it. Surely it's worth *something*, right? Well, it might be worth a lot to a few people, and nothing to lots of people, but there's a good chance I'll never run into those few who find it valuable enough that they would pay for it.

Then there's also the psychological aspect of earning money from something I created. Knowing there are people who value my work to this extent, does a lot for my self-esteem.

The danger with any kind of software that you build for yourself, and then want to sell, is the possibility that you're the only one with that problem. Or, granted, part of a tiny minority. Which means the market for your thing might as well not exist. So why even bother charging for it?

Another school of thought says you should charge a lot more than you were going to initially. I tend to agree with some of the reasons, but this strategy works best when you already have a large audience, or when your product is already awaited with anticipation. None of this applies to me.

My audience, though growing, is still tiny, and mostly restricted to Twitter. So how do I grow an audience? I know some theory, but frankly I'm not a marketer, and self-promotion is somewhat distasteful to me. I dislike heavy marketing tactics, so I'm growing my "brand" the only way I know how: article by article, tweet by tweet. 

From previous experience, the highest quality audience is built organically, albeit slowly. That's why I try to post good quality content, and refrain from noise and non-developer related stuff. If you're following my work, you're probably a developer like me, facing similar problems, and searching for similar solutions.

All this to say that I've decided to offer SVGX for the price of **pay what you want**, starting at $0. You can try it for free, for as long as you want, but if you find it useful, I wouldn't mind a "buy me a beer" kind of tip.

At the same time, I'm selling [access to the SVGX source code on GitHub](https://gumroad.com/l/svgx-source) for a reasonable amount ($20 at the time of writing). For those interested in how a fairly complex Electron + Svelte app is built, I'm sure this will provide good value.

In summary:

* Offer the product for free/tips
* Sell access to the source code

I call this new software distribution model **Gitware**. Not the most inspiring term, but that's what I could come up with on short notice.

While **Gitware** may seem antithetical to the idea of open source, that's because it's not open source. It's not traditional closed source commercial software either. If you can imagine the Mercedes-Benz logo, with open source and closed source forming two of the points, then Gitware would be the third point. 

<div class="flex justify-center text-center">
    <svg width="100px" height="100px" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Mercedes icon</title><path d="M12.005 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zM3.25 17.539a10.357 10.357 0 0 0 8.755 4.821c3.681 0 6.917-1.924 8.755-4.821l-8.755-3.336-8.755 3.336zm10.663-6.641l7.267 5.915A10.306 10.306 0 0 0 22.365 12c0-5.577-4.417-10.131-9.94-10.352l1.488 9.25zm-2.328-9.25C6.062 1.869 1.645 6.423 1.645 12c0 1.737.428 3.374 1.185 4.813l7.267-5.915 1.488-9.25z"/></svg>
</div>

**Intermission**

See the Mercedes logo above? It's plain SVG code that I pasted into the markdown of this article.

Incidentally, this is one of the things SVGX does really well. It can search across all your offline SVG icon libraries and quickly find what you're looking for. For this example, I searched for "mercedes", not even knowing if I had an icon for it. Sure enough, there's 1 result coming from a free library called [Simpleicons](https://simpleicons.org/), which I've downloaded to my local icon archive.

![Mercedes logo discovered with SVGX](/assets/img/2020-12-23-svgx-mercedes-logo.png)

**Now back to our regular programming**

**Gitware** is my way of creating exposure and shining a light on my work. It may very well prove to be a flop. In fact, I suspect it's a very naive (to say the least) way to sell software. And that's ok, because building an audience is a lot more important for me at this stage than a few bucks.

Generating goodwill requires a lot of consistent work creating great software products, some of it free or open source, some paid. But there's a long windy road to get to the point where people are clamoring to give you their money, and trust is earned the hard way. Thankfully, I can gladly give SVGX - the app - away for free. I want it to be one of many more to come, as my repository of ideas is perpetually growing.
