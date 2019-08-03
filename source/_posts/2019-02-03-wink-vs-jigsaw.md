---
extends: _layouts.post
section: content
title: Wink vs Jigsaw
date: 2019-02-03
description: Wink and Jigsaw blogging engines, compared.
categories: [Jigsaw, Laravel, Wink]
featured: false
image: /assets/img/2019-02-03-wink-vs-jigsaw-1200.jpg
image_thumb: /assets/img/2019-02-03-wink-vs-jigsaw-200.jpg
image_author:
image_author_url:
image_unsplash:
---

In my [previous post](/blog/welcome-new-new-blog/) I said I would give my reasons for switching from Wink to Jigsaw and also explain what my needs are in relation to a blogging platform.

## Intro

[Wink](https://wink.themsaid.com/) is a new open-source blogging platform from [Mohamed Said](https://themsaid.com/) (a core Laravel contributor) that was released in late 2018. I follow Mohamed's work with a lot of interest and I was stoked when he announced this project. At the time I was actively searching for an engine to drive my future (and current) blog but nothing felt right. Wordpress was out of the question, for many reasons. Wink seemed just right, because it was built on top of Laravel, my favorite (and day-to-day) PHP framework. Match made in heaven, right?

To make a long story short, I installed Wink as soon as it came out, and integrated it into Omigo.sh. It worked really well, but at the time I had just launched the site and deployed it to Linode. The site itself was also built on Laravel. Soon after, I realized that what I had done was overkill. I needed a much simpler solution.

You see, my plan for Omigo.sh is to have it serve as a central hub that will showcase my personal projects, with a dev blog attached. Realistically I would never need the full power of a Laravel/MySQL server. Static pages would be just what the doctor ordered. This meant Wink was not really a good match, despite its ease of integration.

Enter [Jigsaw](https://jigsaw.tighten.co/), an open-source static site framework also built on Laravel, from the good people at Tighten.co. I'd heard about it before but never really gave it much thought, not really sure why. I had a vague feeling that Jigsaw was a static site generator which was in line with my needs, but I was afraid it didn't come with all the other features I would require for a blog. Boy was I wrong.

One day I had a little extra time on my hands and decided to give Jigsaw a whirl. An hour was enough to convince me to switch to it.

## Engine

**Wink** is built on Laravel, as I mentioned, but it requires a PHP server to run, as well as a database (MySQL). In that respect it is similar to Wordpress (though a great deal less complex).

**Jigsaw** also uses Laravel but mostly under the hood, to build the static site bundle. It also lets you use Laravel's familiar templating system to customize the generated output in almost any way you want. Jigsaw is also more flexible than Wink in that it can generate a full site (with various pages and content), not just a blog. 

I really wanted a static blogging platform, one that saves posts and blog settings as simple text files that you can version control in a Git repository instead of saving them in a database.

+1 for Jigsaw.

## Content Authoring

**Wink's** bread and butter is the back-end used to author blog posts. It has a rich-text editor that allows you to apply formatting, insert images, etc. Love it, except for the fact that I very much prefer to write technical posts and articles in [Markdown](https://daringfireball.net/projects/markdown/). For that, I don't need a back-end, just a text editor.

**Jigsaw** on the other hand uses Markdown as the default way to author content.

+1 for Jigsaw.

## Content Rendering and Templating

**Wink** does not (at the time of this writing) come with any front-end templates. It's up to you to render the blog content in any way you want, preferably with Laravel. And this is just what I did for the first iteration of this blog. It's a fairly trivial process, for a Laravel dev, but at the same time it would be nice to have a starter template that you can customize.

**Jigsaw** has 2 starter templates that you can pull in optionally when you install it the first time. One is a blog, the other is a documentation site (I already have a few good uses in mind for the latter). The blog template basically scaffolds the entire blog so you can go ahead and use it right out of the box if you want.

What I really liked about Jigsaw is that the front-end is all built on [TailwindCSS](https://tailwindcss.com/), my all-time favorite CSS framework. And this makes it super-easy to customize.

+1 for Jigsaw.

## Extra Features ##

There are a few critical features that I need in a tech blog. **Wink** doesn't render any content out of the box so I would have to build all that myself. Not really something I looked forward to.

**Jigsaw** comes with all these configured and ready to go:

- _Search_ - some sort of JS black magic indexes your content (pages and posts) when you build the static bundle and then lets you search it using the built-in search bar.
- _Sitemap_ - automatically generated on build.
- _Atom feed_ - once again, generated automatically.
- _Responsive nav_ - yet another thing I don't have to worry about.

+1 for Jigsaw.

## Hosting and Deployment ##

There's another, very important, area where Jigsaw shines over a classic DB-driven engine like Wink or Wordpress. It's the tiny matter of hosting the site/blog and storing the content. A static site generator means that I don't need a PHP server, nor a database to store my content. It also provides the added benefit of being able to host the entire site with a free service such as [Netlify](https://www.netlify.com/) or [Surge](https://surge.sh/).

+1 for Jigsaw.

## Jigsaw's Drawbacks ##

OK, I'll hand it to you. A solution such as **Jigsaw** is not perfect for every use-case. There are more complex features that would be very hard, if not impossible, to implement without a server-side language and a database. One of them (correct me if I'm wrong) is a custom commenting system. Yes, you can easily integrate third-party systems (which I will very likely do in the future) but if you want to have full control over users and comments, then you'll need a fully-fledged blogging framework. And this is where **Wink** has the potential to beat Jigsaw.

+1 for Wink. 

## Maturity ##

While this is not necessarily a critical point, **Jigsaw** does happen to be more mature than **Wink**. Which means that a lot of the kinks have been ironed out by a wider range of contributors, and less breaking changes can be expected going forward. I'll give Jigsaw the advantage here again.

+1 for Jigsaw.

## Conclusion ##

Once I found out Jigsaw supported all the features that I wanted in a blogging platform, I was all over it. While custom-building these features is entirely doable, my end-goal in this case was to be able to blog as soon as possible, not to engage in endless coding exercises, regardless how educational they might be. 

The Omigo.sh blog is in its very early stages but I very much doubt I'll be changing the engine again anytime soon.

The reality is that platforms like Wink and Jigsaw are very developer-, language-, and framework-centric. If you're not a developer, or don't like tinkering with code, or not a PHP developer, or not even a Laravel developer, neither of these might be the right solution for you. It so happens that Jigsaw checks all the tech boxes for me: static, markdown, Laravel, Vue, TailwindCSS. Which just happens to be the entire focus of this blog.