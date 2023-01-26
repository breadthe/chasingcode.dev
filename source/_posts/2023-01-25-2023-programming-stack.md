---
extends: _layouts.post
section: content
title: My 2023 Programming Stack
date: 2023-01-25
description: A summary of my programming/tech stack moving into 2023.
categories: [Laravel, Livewire, AlpineJS, TailwindCSS, Svelte, SvelteKit, Tauri]
featured: false
image: https://source.unsplash.com/feLC4ZCxGqk/?fit=max&w=1350
image_thumb: https://source.unsplash.com/feLC4ZCxGqk/?fit=max&w=200&q=75
image_author: Amanda Jones
image_author_url: https://unsplash.com/@amandagraphc
image_unsplash: true
---

If you've read my [2022 Programming Stack](/blog/2022-programming-stack) article, then it shouldn't be much of a surprise to hear that it hasn't changed much for 2023, with one notable exception: I've replaced Electron with Tauri.

TL;DR
- TALL stack (**Laravel** + **Livewire** + **AlpineJS** + **TailwindCSS**), **Svelte** + **SvelteKit**, **Tauri**.
- database: **MySQL**, **SQLite**
- situational: **PostgreSQL**, **Inertia**, **Rust**
- blog: **Writefreely**

Read on for details.

## Back-end

[Laravel](https://laravel.com/) is my solution for anything requiring a database. Together with [Livewire](https://laravel-livewire.com/), [AlpineJS](https://alpinejs.dev/), and [TailwindCSS](https://tailwindcss.com/) I can quickly build complex functionality and appealing UI.

With [8.2](https://www.php.net/releases/8.2/en.php), PHP has continued to evolve and stay relevant, driving a majority of the world's websites. PHP 8.3 is probably going to launch in 2023.

**Laravel** remains the best web framework (in my biased view) and continues to improve steadily. Version 10 is coming out in early 2023, but with new features added to the framework every week, major versions don't feel as the huge stepping stones they once were, which speaks to Laravel's maturity.

**Livewire** is the logical companion to Laravel for building interactive UI without much JavaScript. It goes hand-in-hand with **AlpineJS** for those times when you need fancier UI behavior. Livewire v3 is expected this year, but I'll admit I'm a little apprehensive because it heralds a lot of changes and deprecations, though compensating with better performance and new APIs.

## Database

**MySQL 8.x** is my go-to server-side database, mostly because I've been using it forever and it satisfies most of my requirements.

**PostgreSQL** brings powerful features that MySQL does not yet have, so I am waiting for a chance to use it for the right application.

**SQLite** is becoming more fashionable lately, after developers realized that a simple flat-file database can handle most simple applications (and even some complex ones), and it's very portable which makes it easy to maintain and back up.

Another thing that makes SQLite desirable is that it's a very good option for desktop apps where you need to persist data in a more permanent way.

I have already started to use SQLite on a very early-stage prototype for a side-project I'm working on, and I have plans to use it in various desktop apps.

## Front-end

**Tailwind** has been my bread-and-butter for styling the front-end since v0.7. As a full-stack dev, nothing makes me more efficient at building good-looking UI. Tailwind continues to gain new features, and I can't imagine another CSS framework overthrowing it.

For JS apps, [Svelte](https://svelte.dev/) is my jam. It's such a joy to work with, that I literally miss if after spending too much time in PHP-land.

[SvelteKit](https://kit.svelte.dev/) is my tool for building static sites that require any kind of routing. Add one more to the list of frameworks that have finally reached v1.0 after a long beta.

Philosophically, I've abandoned the concept of a backend-driven SPA (Single Page App). With Laravel and Livewire there's just no need for it. However, if I ever needed something along the lines, I would choose Laravel with [Inertia.js](https://inertiajs.com/) and Svelte, though I am open to using Vue if my employer or client required it.

Inertia has been on my radar for a very long time, and I'm itching for a reason to use it. There has never been a better time to add Inertia to the Laravel stack than now, with v1.0 officially released after a very long beta period.

I don't think much about **AlpineJS**. It's there when I need it, usually in tandem with Livewire. Works very well for adding small bits of dynamic functionality to an otherwise static page or site.

## Desktop

Sometimes I build desktop apps, usually when I feel that the app doesn't need internet access or a user account. One of the most complex apps I built with Electron is [SVGX](https://svgx.app/).

In 2022 I discovered [Tauri](https://tauri.app/) and my world was flipped upside down. Right out of the box, Tauri provides a much better developer experience than Electron. It allows me to scaffold a desktop app a lot quicker (with Svelte and Tailwind cause that's what I like), and comes with batteries included.

With Tauri, I made the most complex desktop app to date, a [UI client for Stable Diffusion on the Mac](https://github.com/breadthe/sd-buddy). The open-source Svelte-powered codebase has collected 237 stars on GitHub to date (it may not sound like much, but it's a lot to me). In addition, I made a few other small apps that remained in the prototype stage.

## Systems

I never had a chance to get into systems programming, but Tauri nudged me to use **Rust** to an extent (Tauri uses Rust under the hood). I'll admit that it feels alien compared to the PHP/JS stack I've been using all my career, but it's interesting at the same time because it can build some seriously fast and efficient low-level programs.

I'll continue to dabble in Rust as required by Tauri, probably at an early amateur level.

## Blog engine

In 2022 I've been thinking more seriously about starting another blog on fitness (cycling, swimming, running, nutrition, etc). The main difficulty was picking the right blog engine (ain't it always?). I *think* I've found the solution in [Writefreely](https://writefreely.org/).

Writefreely is a minimalistic blog engine that can be self-hosted on a Linux box. Both of these are things that I'm looking for, so I'll give it a spin and see how it goes.

## Summary

That just about wraps it up. Since I'm always learning something new, there's a good chance this list will change by the end of the year, but that's part of the fun!