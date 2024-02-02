---
extends: _layouts.post
section: content
title: Enable Experimental JS and CSS Features in Electron
date: 2022-05-21
description: How to enable experimental Chromium JS and CSS features in Electron versions that don't support them
tags: [electron]
featured: false
image: /assets/img/electron-logo.jpg
image_thumb: /assets/img/electron-logo.jpg
image_author:
image_author_url:
image_unsplash:
---

Electron uses the [Chromium](https://www.chromium.org/chromium-projects/) engine for rendering. This is the same engine that powers the Chrome browser.

Sometimes you might run into a situation where a certain JavaScript or CSS feature that your browser clearly supports does not seem to work with Electron.

A good example is `aspect-ratio` which is not supported by Electron 11 which runs a version of Chromium < v88. [Chrome added this feature in v88](https://caniuse.com/?search=aspect-ratio).

You can use this technique for any such feature. Here's how I enabled `aspect-ratio` for an Electron 11 project.

In the Electron main process entry file (`src/index.js` in my case) add this line before `app.whenReady()`.

```js
app.commandLine.appendSwitch('enable-experimental-web-platform-features');

app.whenReady().then(() => {
...
```