---
extends: _layouts.post
section: content
title: Namecheap ain't so cheap
date: 2024-07-22
# updated:
description: I moved my domains from Namecheap and saved a bunch of cash
tags: [general]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url:
---

Look, Namecheap has been good to me over the years, I won't deny it. But I've stood by, lazily watching domain prices slowly creeping upwards, until I decided it was high time to consolidate them all under Cloudflare's roof.

You know, the fresh darling of domain peddling, that [Cloudflare](https://developers.cloudflare.com/registrar/). After much hemming and hawing - with a dash of procrastination - on my part, the deed was done. All two of my Namecheap domains were now safely under the banner of the Flare In The Cloud.

Wait - I hear you cry - are you seriously waxing poetic *about two measly domains*? Why yes I am, my dude(tte)! You see, while you may regard yourself as a professional domain wrangler, for me this is as rare an occurrence as Haley's comet making an appearance.

Enough hyperbole! To get down to brass tacks, I moved a `.dev` (this very site in fact) and a `.app`. Here are some numbers:

|      | Namecheap                     | Cloudflare |
| ---- | ----------------------------- | ---------- |
| `.dev` | $16.98 / y + $0.18 ICANN fee  | $10.18 / y |
| `.app` | $16.98 / y + $0.18 ICANN fee  | $12.18 / y |
| `.com` | $13.98 / y ($8.98 first year) | $9.77 / y  |

Cloudflare prices include the ICANN fee.

As you can see, I'm saving almost $7 / year for a `.dev` domain, and almost $5 / year for a `.app` domain. Obviously it's an insignificant amount for 2 domains, but it adds up when you have many. Besides, it really grinds my gears to pay money for nothing - in fact less than nothing, because Cloudflare comes with some free added perks.

Right off the bat, you'll notice that Cloudflare sells domains **at cost**, and it doesn't pull a *first year so cheap* bait & switch like other registrars.

Arguably, Cloudflare's **DNS** is better than average, though it's all the same to me as I don't do any complex stuff with my domains.

While most registrars worth giving a damn offer free **WHOIS redaction**, it's worth pointing out that so does Cloudflare.

But wait, there's more! The bee's knees - nay, the cat's pajamas - of bundled features is the **free traffic analytics** for every domain you own on Cloudflare. That's right, for small websites (like this blog) you no longer need the awkwardly bloated baggage of Google Analytics or some other paid service. Just turn on the built-in analytics and you're off to the races. Granted, the free tier is pretty basic, but it makes me super happy that I can see the stats I care about: daily visits and page views, countries of origin, referrers, browsers/operating systems/device types, most popular pages, and even web vitals (page load times, etc).

Finally - and very subjectively - I prefer Cloudflare's **domain management UI** and the overall functional/brutalist design aesthetics.

If this is starting to smell like a big fat ad, I can assure you it's not, though I will happily take Cloudflare's money if they send some my way. We are, however, fortunate to live in an era of broad choice in domain registrars, as well as solid price and feature competition.

## Takeaway

Cloudflare's core business is not domain registration, but this makes it possible for them to sell domains at cost, while also bundling a lot of related features that would cost quite a few buckaroos with other companies, aside from the inflated price of the domain itself. But just as the universe is in a state of increasing entropy, so is the eventual [enshittification](https://en.wikipedia.org/wiki/Enshittification) of every good product or service. Until then, I'll enjoy the superior experience and save a chunk of cash with the Flare In The Cloud.
