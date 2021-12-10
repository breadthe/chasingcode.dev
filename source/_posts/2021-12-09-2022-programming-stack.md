---
extends: _layouts.post
section: content
title: My 2022 Programming Stack
date: 2021-12-09
description: A summary of my programming/tech stack moving into 2022.
categories: [Laravel, Livewire, AlpineJS, TailwindCSS, Svelte, Electron]
featured: false
image: https://source.unsplash.com/2OzdX7F9XPs/?fit=max&w=1350
image_thumb: https://source.unsplash.com/2OzdX7F9XPs/?fit=max&w=200&q=75
image_author: Andrik Langfield
image_author_url: https://unsplash.com/@andriklangfield
image_unsplash: true
---

As we slowly roll into 2022, I decided to take a step back and have an objective look at my coding stack for the near future. It's a short one - I'll keep it focused strictly on my programming languages of choice, ignoring other tools and services.

TL;DR - TALL stack (**Laravel** + **Livewire** + **AlpineJS** + **TailwindCSS**), **Svelte**, **Electron**.

## Back-end

[Laravel](https://laravel.com/) is my solution for anything requiring a database. Together with [Livewire](https://laravel-livewire.com/), [AlpineJS](https://alpinejs.dev/), and [TailwindCSS](https://tailwindcss.com/) I can quickly build complex functionality and appealing UI.

With [8.1](https://www.php.net/releases/8.1/en.php) PHP has never been better, and in recent years has risen from its slumber to make web development exciting again.

Built on top of PHP, **Laravel** is the best web framework that ever was (I'm biased, sue me) and continues to improve by leaps and bounds. Every time I ask myself what more is there to improve, along come a host of new features that make it even quicker to ship stuff.

**Livewire** is the logical companion to Laravel for building interactive UI without much JavaScript. It goes hand-in-hand with **AlpineJS** for those times when you need fancier UI behavior.

**MySQL** is the one and only server-side database I will be using in the near future, simply because I've been using it forever and I don't need anything more capable.

## Front-end

I can't live without **Tailwind** since v0.7. As a full stack dev, it's a very reliable tool for building any kind of user-facing interface, quickly.

For static sites I will absolutely reach for [Svelte](https://svelte.dev/) and [SvelteKit](https://kit.svelte.dev/). I get a lot of joy building front-end heavy web apps with this fast, lightweight, minimalistic framework (sorry, compiler).

Philosophically, I've abandoned the concept of a backend-driven SPA (Single Page App). With Laravel and Livewire there's just no need for it. However, if I ever needed something along the lines, I would choose Laravel with [Inertia.js](https://inertiajs.com/) and Svelte.

## Desktop

Occasionally I build cross-platform desktop apps, such as [SVGX](https://svgx.app/). The easy choice is to use [Electron](https://www.electronjs.org/) in tandem with a preferred JS framework, and that would be Svelte in my case.

I am also exploring the possibility of integrating **SQLite** in a future Electron app.

## Summary

I don't see my coding stack changing much over 2022. I've narrowed it down to an ecosystem centered around **Laravel** for *back-end* apps, with an offshoot around **Svelte** for *front-end* apps. Simple, fun, and super-productive.