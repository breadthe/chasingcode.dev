---
extends: _layouts.post
section: content
title: My First Side Project - BankAlt.com
date: 2020-11-03
description: 
categories: [Career, SideProject, PHP]
featured: false
image: /assets/img/2020-11-03-bankalt.jpg
image_thumb: /assets/img/2020-11-03-bankalt-thumb.jpg 
image_author: 
image_author_url: 
image_unsplash: 
---

I found myself strolling down memory lane recently when I recalled my first big side project from over 10 years ago, and dug it up on the [Wayback Machine](http://web.archive.org/). The nostalgia hit hard, and I decided to write this piece as a tribute to my past self for making it, and the fun times that were had in the process. 

## What ~~is~~ was BankAlt?

BankAlt was a website hosted at **bankalt.com**, and its primary raison d'être was to facilitate the crafting process in World of Warcraft. 10+ years ago I used to be very involved in the game, and one of my trademarks was making lots of gold from gathering, crafting, and trading. 

BankAlt is beautifully (but not entirely, for reasons I'll mention below) [preserved](http://web.archive.org/web/20130716130923/http://bankalt.com/) at the Web Archive (aka Wayback Machine).

## The tech behind BankAlt

I have always been a PHP dev, so it stands to reason that the LAMP stack would power my first big side project.
 
- vanilla PHP 5.x (no framework)
- MySQL
- [jQuery datatables](https://www.datatables.net/) with server-side fetching
- vanilla CSS (no framework)

## Analysis and thoughts

First, a quick word on BankAlt's state of preservation at the Wayback Machine. The static pages are all there, but the dynamic parts are not. The back-end powering the dynamic data tables is now defunct.

### Purpose & motivation

My initial purpose of BankAlt was - as it often is - to scratch an itch, and make my life in WoW easier. WoW had, and most likely still does, a complex crafting tree. To craft a high-end item you would have to craft a lot of intermediary items, parts, and materials. But in order to juggle trading, the auction house, crafting, gathering, and make lots of profit in the process, I needed a tool that could automatically calculate the raw materials for any recipe or pattern, as well as the cost of those materials.

I could then use this information to find the best source of raw materials, and then sell the finished product for a hefty profit.

I can't pinpoint what made me build an actual site for this tool, but it must have been a love for World of Warcraft, combined with the desire to create, coupled with the excitement for solving a problem. By that point I had been a web developer for several years, but I had never attempted something of this magnitude.

### Business model

Making money with BankAlt was definitely not the driving factor, nor was it a big priority later. Back at the time, banner ads were popular, and I thought I could fund the site with ads. That might have worked, had I spent time marketing it and spreading the word. Marketing has always been distasteful to me, so I kept sweeping it under the rug until the very end.

To me, ads are not the most ethical way to monetize a site, but if the product is useful and popular, and enough people are using it, ads can be worthwhile. A very good example is [Photopea](https://www.photopea.com/), which generates impressive revenue for its sole creator.

If I were to do it again today, I would probably use a mix of ads and ad-free premium subscription (with extra perks, of course). I would hold off on ads, though, until the trafic and usage were high enough. Putting ads on an emerging service helps only to drive away potential users. 

### RIP BankAlt.com (2010-2013)

The site ran for approximately 3 years, 2010 - 2013. I'm not even sure if I terminated it in 2013 or 2014. As my interest in WoW waned, I decided to shut it down, since I was barely covering my hosting costs with the small amount of advertising revenue that was coming in.

### Was it worth it?

BankAlt made very little money, certainly not enough to offset the amount of work I put into it. I don't have any regrets - in fact I'm glad to have stuck with the project for so long. But to me, money is not the driving factor behind a side project, and maybe that's failure on my part. On the other hand, a revenue-generating project could ensure its long term viability, as well as providing motivation to keep hacking on it.

The true worth of this project comes from the fact that it allowed me to sharpen skills on a fun endeavor outside of work. A project like this boosts your confidence as a developer to an immeasurable degree. As BankAlt traffic and active users grew, I would get lots of warm fuzzies inside. This feeling persists even today to an extent.

Looking back, I am very proud to have built BankAlt. Frankly, I am impressed at past me for crafting it to such a high level of care and detail.

Sometimes I regret shutting it down, and I can't help wondering what might have been if I had continued to maintain the project. Realistically, my motivation collapsed soon after I stopped playing WoW, and I don't think I could have forced myself to run a tool I had very little interest in.

## A resurrection?

While browsing the Web Archive under the influence of nostalgia, a wild thought occurred. Wouldn't it be cool if I could resurrect the site for fun? It would be virtually useless to myself or current World of Warcraft players, but I would be proud to feature it under my portfolio.

The **bankalt.com** domain has long expired, and I do not plan on buying it back. For curiosity, I checked to see if it's available, and I was a little dismayed to find out that it is currently listed for $2900.

![Cost of the bankalt.com domain](/assets/img/2020-11-03-bankalt-com-domain.png)

Consequently, buying the original domain is out of the question. If I do manage to restore the site to a working state, I will host it on one of my other domains. But if you, dear reader, have money burning a hole in your pocket, feel free to buy it back for me 🤑.

So, resurrection. How feasible is it? Until I dig deeper, I would say chances are pretty good. When I shuttered the site, I had the foresight to make multiple backups of the source code and the database.

All I have to do is to restore the database, put the source code in a folder on one of my VPS instances, and point Nginx to `index.php`. The old site ran on an Apache server, but that shouldn't matter. Hopefully backward compatibility will handle most of the issues.

*But wait, there's more!* I had another wild idea. What if, in addition to resurrecting the original site, I were to rebuild it separately as a modern Laravel app? I think that would be pretty awesome too, just for the learning experience of porting such an old codebase.

This mini-project entails 2 phases:

- **phase 1** - restore the original site to its former glory; host it on a vanity sub-domain
- **phase 2** - rebuild it in Laravel + Livewire or Inertia

Both phases are great candidates for how-to articles: "How to revive a legacy PHP application", and "How to rebuild a legacy PHP application in Laravel". Actual titles TBD.

Before I start any of this, I need to work through my side-project backlog and clear a couple of higher priority tasks. Expect phase 1 to commence in the first half of 2021, so stay tuned! 

## Screenshots

While the Wayback Machine keeps archives of all the pages, I wanted to capture those as screenshots and bring them closer to my heart, until - and if - I am able to resurrect BankAlt.

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-home.jpg" title="bankalt.com - Landing page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-home-thumb.jpg" alt="bankalt.com - Landing page"/>
        </a>    
        <div class="text-sm">
            <strong>Landing page</strong>
            <br>
            Cute, in a late-2000s kinda way.
        </div>
    </div>
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-news.jpg" title="bankalt.com - News page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-news-thumb.jpg" alt="bankalt.com - News page"/>
        </a>    
        <div class="text-sm">
            <strong>News page</strong>
            <br>
            Not talking international news here, just BankAlt-related updates.
        </div>
    </div>
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-about.jpg" title="bankalt.com - About page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-about-thumb.jpg" alt="bankalt.com - About page"/>
        </a>    
        <div class="text-sm">
            <strong>About page</strong>
            <br>
            Yada yada TLDR
        </div>
    </div>
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-contact.jpg" title="bankalt.com - Contact page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-contact-thumb.jpg" alt="bankalt.com - Contact page"/>
        </a>    
        <div class="text-sm">
            <strong>Contact page</strong>
            <br>
            Old-shool captcha...
        </div>
    </div>
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-help.jpg" title="bankalt.com - Help page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-help-thumb.jpg" alt="bankalt.com - Help page"/>
        </a>    
        <div class="text-sm">
            <strong>Help page</strong>
            <br>
            I'm astounded at the amount of work I put in creating the graphics. Also, wtf did I mean by "Rapture day"?
        </div>
    </div>
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-faq.jpg" title="bankalt.com - FAQ page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-faq-thumb.jpg" alt="bankalt.com - FAQ page"/>
        </a>    
        <div class="text-sm">
            <strong>FAQ page</strong>
            <br>
            Funny how a lot of FAQs are not actually questions most people would ask.
        </div>
    </div>
    <div class="space-y-2">
        <a href="/assets/img/2020-11-03-bankalt-profession.jpg" title="bankalt.com - Profession page" target="blank">
            <img src="/assets/img/2020-11-03-bankalt-profession-thumb.jpg" alt="bankalt.com - Profession page"/>
        </a>    
        <div class="text-sm">
            <strong>Profession page</strong>
            <br>
            The back-end has long since gone away, so WebArchive preserved only the loading state.
        </div>
    </div>
</div>
