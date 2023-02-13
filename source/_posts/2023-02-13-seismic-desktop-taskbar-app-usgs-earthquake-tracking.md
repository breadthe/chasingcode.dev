---
extends: _layouts.post
section: content
title: Seismic - Desktop Taskbar App for USGS Earthquake Tracking
date: 2023-02-13
description: A taskbar app for tracking earthquakes from the USGS feed.
categories: [Tauri, Svelte, GeoJSON]
featured: false
image: /assets/img/2023-02-13-seismic-v0.6.0-light-dark.jpg
image_thumb: /assets/img/2023-02-13-seismic-v0.6.0-light-dark.jpg
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/109859297313321456
---

After the devastating [2023 Turkey/Syria earthquakes](https://en.wikipedia.org/wiki/2023_Turkey%E2%80%93Syria_earthquake) I was looking at earthquake-related stuff on the interwebs and found this nice [USGS magnitude 2.5+ earthquakes in the past day](https://earthquake.usgs.gov/earthquakes/map/?extent=-89.76681,-400.78125&extent=89.76681,210.23438&map=false) website. 

I liked how simple it looked, and noticed that it refreshed periodically. Poking at it in the browser dev tools revealed that it was polling a [public GeoJSON feed](https://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_day.geojson).

This inspired me to make a free/open-source desktop taskbar app that would replicate the functionality of the website, since I was visiting it quite often at that time. I thought it would also be cool if the app could notify me when a new earthquake past a certain magnitude threshold happened.

I called the app **Seismic** and released v1.0 in less than a week, which is a new record for me. I'm pretty happy with the result, and now it's living in my taskbar 24/7.

Download the latest release for your platform [here](https://github.com/breadthe/seismic/releases), or check out the [source code](https://github.com/breadthe/seismic).

## Stack

From my [2023 toolbox](/blog/2023-programming-stack/):

* [Tauri](https://tauri.app/) - for building the app
* [Svelte](https://svelte.dev/) - for the UI
* [Vite](https://vitejs.dev/) - for the build tooling
* [Tailwind CSS](https://tailwindcss.com/) - for the styling

## v1.0 Features

* Data: magnitude, location, time (client-side), depth
* Open the location in [geojson.io](https://geojson.io/#map=2/0/20)
* Polls the USGS feed every 60 seconds (default)
* Configurable refresh interval
* Notifies you when a new earthquake happens (by default all earthquakes are notified)
* Configurable notification threshold
* Light/dark mode

**Note** that the app is not signed, so you might get a warning when you run it for the first time. This is because I'm not paying for a code signing certificate.

**Note**, also, that I've only tested it on Mac. It's very possible that it may not work as nicely on Windows or Linux. Unfortunately I don't have machines for those platforms to test it on (particularly the taskbar integration and desktop notifications).

## Screenshots

![Seismic light mode screenshot](/assets/img/2023-02-13-seismic-v0.6.0-light.jpg)

![Seismic dark mode screenshot](/assets/img/2023-02-13-seismic-v0.6.0-dark.jpg)

![Seismic settings screenshot](/assets/img/2023-02-13-seismic-v0.6.0-settings.jpg)

![Seismic desktop notifications](/assets/img/2023-02-13-seismic-v0.5.0-notifications.jpg)

## What's next?

Seismic is feature-complete for now, but I've already prepared v1.1 with optional color-coded events based on magnitude. Before that, I'm working on setting up an automatic updater, so you should be able to receive the next version without having to download it manually.

The USGS feed has a lot of metadata that I could display, so perhaps I'll add a details view for each event (if I can figure out what it all means). At the very least, I want to mark events that come with a tsunami warning.

A built-in map view would be interesting, though I'm not sure if it's worth the effort since you can already open the event location in geojson.io.

## Conclusion

I'm very happy with how quickly I was able to reach v1.0 on this project. The reason for it is that it was a simple concept to start with, and I made sure to limit the scope to the bare minimum. I also had a lot of the tooling already in place, so it was just a matter of putting it all together.

Another positive side effect is that now I have a pretty solid taskbar app template that I can use for future projects. In fact, I have an older, unfinished app will benefit from the same treatment, as it makes for a perfect taskbar candidate. Stay tuned!