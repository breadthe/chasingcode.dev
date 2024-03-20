---
extends: _layouts.post
section: content
title: Delete the blog or refresh it?
date: 2024-01-12
updated: 2024-04-19
description: Should I delete the blog or refresh it in 2024?
tags: [general, jigsaw]
featured: true
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/111747057739543220
---

At the end of 2023 I found myself burnt out on side projects and coding as a hobby. One particularly bad day I decided that I would **delete this blog** and website in 2024. I was tired of the endless blogging procrastination, and that the underlying engine had been falling behind on maintenance for a long time.

I've been operating this blog since 2019 but I wish I had started one much sooner in my career. Nevertheless, it's 4+ years old now and I've managed to post several times a year on various developer-adjacent topics, though infrequently.

2023 has been the worst year for growing my audience, for several reasons –

**Twitter's death** brought a lack of desire and motivation to post anything constructive. It meant no more tweeting carefully-crafted tips or high-quality engagements. As a side-effect, there's less incentive to write blog posts as a way to grow an audience (though I still write when I feel like it). Why would Twitter be the catalyst for my blogging? Simply because it used to be an amazing conduit to audience-building before the unfortunate change of ownership.

**Moving to Mastodon** was cool - I think everyone should embrace it at this point - but it came with its own downsides. First, the community is a lot smaller and less focused on dev topics. I use social media strictly for the developer community (with a focus on Laravel, PHP, Svelte, JS-adjacent). Second, I barely receive any reactions to my posts (and yes, I still cross-post on Xitter sometimes). Third, I follow a lot of devs but people on Mastodon seem to be less filtered so they post a variety of things that have nothing to do with software development. This creates a lot of noise that is hard to filter out. End result is that I don't have much desire to post or interact there either.

**Joining BlueSky** took a while but that place feels like an empty tomb. I can almost hear the wind blowing through the empty hallways when I open the app. At least the devs I follow are pretty focused.

I felt **burnt-out on side projects**. Having a whole bunch of WIP projects can get to you. At least I managed to [fully release a 1.0 product](/blog/seismic-desktop-taskbar-app-usgs-earthquake-tracking/) in 2023, but for the most part I'm continuously iterating on multiple projects with no end in sight.

**Writing blog articles can be a full-time job**. I get article ideas quite frequently, but there's a long way from idea to a finished blog post. Depending on complexity (are there code snippets? - make sure the code is formatted properly and it works! pictures? - process, crop, resize, add annotations, make thumbnails, etc!) it can take many hours to publish a complete piece. Hours that I would rather use on a side project.

**Losing analytics**. In 2023 Google Analytics switched to a new version, which made my existing setup redundant. Good riddance. On the other hand I don't have any intelligence on whether people visit this blog or what articles are popular. It makes me feel like I am talking to the void. In 2024 I hope to add a more basic form of analytics with better privacy.

**No comments**. One of the best ways to track engagement and feel motivated is to have a commenting system. This blog hasn't had one, with the exception of Mastodon webmentions which apparently have privacy issues in the form of a lack of consent (if someone replies to your Mastodon thread, the reply appears automatically on your blog without their consent). In 2024 I hope to finally implement GitHub comments with [utterances](https://github.com/utterance/utterances) but I've been saying that for a long time so who knows if I'll ever get to it.

**Blog engine became outdated**. This blog is built on [Jigsaw](https://jigsaw.tighten.com/), a static site generator based on Laravel. I neglected to update it for a very long time and it became increasingly harder to implement new features or even deploy it properly due to failing builds and what-not.

## Blog refresh it is

I remembered the **original mission** of this blog - to keep track of interesting dev topics, to keep a record of various techniques, and to share solutions to vexing problems I solved.

After the new year I got over some of the angst and started looking at this problem with new eyes. I decided that, instead of purging all the work that went into it, I could turn it into a fun side project by upgrading the blog engine and refreshing the design.

As you're reading this, I've already accomplished the first part. The blog is now running on **Jigsaw 1.3.45**. Yet this is not the latest version of Jigsaw (1.7.1). Why? Because it's deployed on Netlify which supports a maximum build version of Ubuntu 20.04, which in turn is limited to PHP 8.1. Jigsaw 1.3.45 is the highest version that runs on PHP 8.1, with higher versions requiring 8.2 (but those don't run on Ubuntu 20.04).

**At this point a retraction is in order**. 3 months later I realized that I could upgrade to Jigsaw 1.7.1 and PHP 8.2 after all. It wasn't Netlify's fault at all, but my own for completely missing out that the `PHP_VERSION` can be set in `netlify.toml`. Simply changing it from 8.1 to 8.2 allowed the latest Jigsaw to build and deploy successfully. A doh moment if there ever was one 🤦‍♂️.

The latest Jigsaw version is a lot better than what I was running before, chiefly for three reasons –

First, it uses Tailwind 3.x. This will make styling more flexible and convenient. Second, the front-end build process is streamlined and easier to use. Third, it uses [league/commonmark](https://commonmark.thephpleague.com/) for markdown parsing, which is a lot more powerful than the Jigsaw parser.

Nothing has changed at this point in the site design except for the fact that the updated Tailwind colors are now either more saturated, or slightly darker than before. I'm fine with this. The other thing is that the [library](https://www.fusejs.io/) behind the search is updated and it feels to me that it returns more relevant results.

## Planning a fresh coat of paint

- **typography** - I'm tired of the current font (Lato), as well as the 20px pixel size. I want a different font that is easier to read, as well as 16px for the main body. I have a few font candidates in mind.
- **headings** - I want to continue using a different font for headings, but I'm still searching for a suitable one. I also want to make headings smaller and perhaps a different color.
- **color theme** - currently I'm using Tailwind's teal palette for the main theme. It's been great, but it's starting to feel a bit sterile. I'd like something more cheerful.
- **anchors** - different styling which might include color, font weight, background, underline, etc.
- **inline code snippets** - another bit of styling that I'm tired of. I don't have any ideas yet but will try different things.
- **tags** - similar to anchors, I want something new.
- **tighter main article column** - in the desktop view I feel like the main column is too wide. With smaller text it will be necessary to make it narrower.
- **landing page** - this currently acts as a pseudo-portfolio but I would like to make it an entry-point to the blog itself. The portfolio and resume stuff can move to its own section.
- **better code highlighting** - I would very much like to use [Torchlight](https://torchlight.dev/) for code highlighting but Jigsaw uses highlight.js and I'm not sure how difficult it would be to convert. One downside of Torchlight is that it's a service, which means there's no guarantee it will be around forever.

I will make no secret of the fact that I am getting inspiration from a lot of different developer blogs. I've been bookmarking awesome blog designs for years and now's a good time to borrow some of those great ideas.

There's a lot more that I would like to achieve, but I'll take it a step at a time. Since I don't have a clear vision for the end-result, I'll go by feel and experiment until I land on something that I like.

Stay tuned!
