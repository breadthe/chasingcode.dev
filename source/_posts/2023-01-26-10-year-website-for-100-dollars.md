---
extends: _layouts.post
section: content
title: 10-Year Website for Less Than $100
date: 2023-01-26
description: How I made a 10-year website (including domain and hosting) for less than $100.
tags: [general]
featured: false
image: /assets/img/2023-01-26-10-year-100-dollar-website.png
image_thumb: /assets/img/2023-01-26-10-year-100-dollar-website.png
image_author: 
image_author_url: 
image_unsplash: 
mastodon_toot_url: https://indieweb.social/@brbcoding/109757724306432082
---

Someone near and dear to me recently opened a business (let's call it Generic Company) that runs entirely offline and is pretty low-tech. The owner does not need or want an online presence.

It so happens that I was curious if the domain GenericCompany.com was available. Lo and behold, it was! So I told them it would be a good idea to buy the domain right away, even if they didn't plan to use it.

My reasoning was twofold. First, they may *think* they don't need an internet presence now, but you never know how things change in a few years. Second, these days very few companies are so lucky anymore to find the exact CompanyName.com domain available for purchase.

When I explained it like that, my "client" was immediately on board with the idea. So, less than $100 and 15 minutes of my time later they had a brand-new 10-year domain with a generic (and super basic) landing page. Now they have a web presence, and no one else can claim GenericCompany.com. Win-win!

Here's what I did.

## Domain registration and hosting provider

**Domain registrar**: [Cloudflare](https://www.cloudflare.com/)

Cloudflare has recently begun to sell domains. I love them because they don't charge any extra fees so their domains are even cheaper than Google. They've also been around for a long time, protecting the web from bad actors, which builds a lot of trust in the online community. To top it off, the domain management UI is very easy to use. 

**Hosting**: [Vercel](https://vercel.com/)

Vercel makes it super easy to deploy static websites. The free tier is more than enough for this application.

## The "stack"

The requirement for this "website" was to have just a landing page with the company name front-and-center, and a tagline below. Any form of dynamic content, design, mobile responsiveness, or SEO are not needed.

Initially I thought about doing it in [SvelteKit](https://kit.svelte.dev/) with TailwindCSS for basic styling, but then I laughed out loud when I realized what a massive overkill that would be.

So I went back to most basic thing you can imagine: an `index.html` file with rudimentary HTML and 1 line of JS to make the date in the footer dynamic.

Here's the code in all its majestic glory:

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Generic Company</title>
    <style>
        main {
            height: 95vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 0 2em;
        }

        h1 {
            font-size: 3em;
        }

        footer {
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <h1>Generic Company</h1>
        <h2>Company tagline bla bla.</h2>
        <em>coming soon</em>
    </main>

    <footer>&copy; <span id="year">2023</span> Generic Company</footer>
</body>
<script>
    document.getElementById('year').innerText = (new Date).getFullYear()
</script>
</html>
```

Feel free to use it :)

## Deployment

First I bought the domain on Cloudflare: $91.50 for 10 years (`.com` domains are $9.15).

Next, I made a private GitHub repository where I pushed the `index.html`.

In Vercel I created a new project for this website, and linked the GitHub repo to it. I had to give explicit permissions to allow Vercel to access the repo. That was all the configuration I needed, since Vercel knows what to do if it encounters an `index.html` in the root.

I then added a Domain to my project. I assigned `genericcompany.com` to it, and it provided me with an **A record** and a **CNAME record** to configure in Cloudflare for the domain. In Cloudflare I did just that.

SSL is handled automatically, though keep reading for a little gotcha.

## Redirects

When you add a custom domain Vercel suggests serving the main domain on `www.genericcompany.com` and redirecting `genericcompany.com` requests to it. They claim that their edge network can optimize things better doing it this way. I accepted their suggestion even though I prefer the opposite. It's your call, either is fine.

The default suggested redirect is `308 Permanent Redirect`, which I also kept.

**The gotcha**: if you don't do anything else at this point, you might be baffled by a `err_too_many_redirects` error when you load the webpage from your new domain.

[Vercel provides an answer to this problem](https://vercel.com/guides/resolve-err-too-many-redirects-when-using-cloudflare-proxy-with-vercel). Essentially you need to go to Cloudflare and set the SSL/TLS encryption to "Full" or "Full (strict)". I set mine to *Full* but Cloudflare offers a helpful analysis which recommends setting it to *Full (strict)* for even better performance, which is what I did.

## Conclusion

I'm glad I had the foresight to check for my "client's" company domain availability. For negligible cost, and a trivial amount of work on my part (I didn't charge them, obviously), they now have a web presence for the next 10 years. More importantly, no one else can claim that domain in the meantime, and the client can always decide to build an actual web presence at their own convenience, with the peace of mind that their company trademark has a secure online presence.