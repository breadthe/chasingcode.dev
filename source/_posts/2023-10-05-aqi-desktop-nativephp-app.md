---
extends: _layouts.post
section: content
title: AQI Desktop - a NativePHP app
date: 2023-10-05
description: Building a desktop app with NativePHP, Laravel Folio, and Laravel Volt.
categories: [Laravel, NativePHP]
featured: false
image: https://user-images.githubusercontent.com/17433578/258668015-9a4d0188-bff7-4dfb-b88e-77f1a2ea3c55.png
image_thumb: https://user-images.githubusercontent.com/17433578/258668015-9a4d0188-bff7-4dfb-b88e-77f1a2ea3c55.png
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: 
---

Having worked with Electron and Tauri to build desktop apps, I always thought it would be super cool if someone figured a way to build desktop apps with PHP. Well, that dream came true - in a way - when [NativePHP](https://nativephp.com/) was announced at Laracon US 2023.

Along with that, [Laravel Folio](https://github.com/laravel/folio) and [Laravel Volt](https://livewire.laravel.com/docs/volt) were also released. I won't rehash what they are, just follow the links if you don't know already.

Suffice to say, a lot of people started experimenting with these three right away. I was one of them. You can find other NativePHP experiments at [Awesome NativePHP](https://github.com/breadthe/awesome-nativephp).

**NB**: I made this a while back, but I'm just now getting around to writing about it.

## AQI Desktop

During that time, the air quality in my area of the United States got really bad from the wildfires in Canada. What better way to experiment with NativePHP (and Folio, and Volt) than to build a simple desktop taskbar app that would show me the AQI (Air Quality Index) for my zipcode, at a glance?

So was born AQI Desktop. Find the source code on [GitHub](https://github.com/breadthe/aqi-desktop).

## v1.0 wham bam done!

I wanted to limit the scope of this mini project in order to release v1 quickly. I am notorious for dragging on a release version until it reaches an unspecified amount of polish.

I used the [AirNow API](https://docs.airnowapi.org/) to get the AQI data. It requires registering at the [AirNow portal](https://docs.airnowapi.org/login?index=) for an API key.

The main requirements for v1 were:

- Taskbar app - NativePHP makes this very easy.
- Enter a zipcode to display the AQI for that area.
- Refresh the AQI every hour.
- Keep a history of past AQI values.

The **History** tab.

![AQI Desktop history](https://user-images.githubusercontent.com/17433578/258668018-4195a45c-97ab-43c9-8116-f2523a26a36c.png)

I added some visual tweaks to make it look nice and called it a day.

It's not perfect - I could continue hacking on this, but I moved on. It's good enough as a v1, for what it is.

## NativePHP - aye or nay?

I think that building desktop apps with PHP is absolutely sick! The cool thing is that it's framework-agnostic, so you can install NativePHP in any PHP project, and it will transform it into a desktop app.

Currently, though, it is not even half-baked. The developers have taken a break from it, and I don't blame them. It's not easy to build something like this. The project hasn't been updated since Laracon, and there are a lot of issues and pull requests that have been sitting there for months.

I wouldn't recommend it for anything serious, but it's a fun experiment, and it can definitely be used to make all kinds of small utilities for personal use, even in its current state.

I am really happy NativePHP exists and I do hope development will continue, because I think it has a lot of potential, and a lot of PHP developers would prefer using it over Electron or Tauri.