---
extends: _layouts.post
section: content
title: Svelte - Persist State to localStorage
date: 2020-04-19
description: A guide for installing a Windows 10 virtual machine on a Mac, for cross-platform testing.
categories: [Svelte]
featured: false
image: https://svelte.dev/svelte-logo-horizontal.svg
image_thumb: https://svelte.dev/svelte-logo-horizontal.svg
image_author: 
image_author_url: 
image_unsplash: false 
image_overlay_text:
---

[Svelte](https://svelte.dev/) has quickly become my favorite framework for building SPAs, even surpassing [Vue](/blog/categories/VueJS/).

Recently I've been working on a new desktop app using Svelte and [Electron](https://www.electronjs.org/).

Electron uses Chromium as the browser engine, which means modern APIs are fully supported. In turn, this allows developers to build cross-platform apps with consistent and predictable behavior.

I made a [Svelte-Electron-TailwindCSS starter template](https://github.com/breadthe/electron-forge-svelte) which should provide some insight into how a typical Svelte project is structured.

## The Svelte store

Application state can be kept in a store that looks like this. Mine consists of a single file named `src/store.js`.

For this example, I'll store the state for the current theme (light/dark). 

```js
import { writable } from "svelte/store";

export const theme = writable('light');
```

The above translates to:

"Create a writeable (there are also read-only stores, not subject of this discussion) store called `theme`, and initialize it with a default value of `light`."

To use the store data, import the store in a component such as `App.svelte`:

```html
<script>
	import {theme} from './store.js';
</script>

<h1>Theme: {$theme}</h1>

<button on:click={() => theme.set('light')}>
    light
</button>
<button on:click={() => theme.set('dark')}>
    dark
</button>
```

Initially, the app loads with a heading of "Theme: light". Additionally, there are two buttons that, when clicked, will change the stored `theme` to either "light" or "dark".

You'll access the value of the `theme` store using the `$` symbol. You can change the value with `.set(value)`.

Try out the example in the [Svelte REPL](https://svelte.dev/repl/90a36296ae784d87adc820b64f10d33c?version=3.20.1)

## Persisting to localStorage

The above is cool, and it works well for cross-component communication, but refreshing the page will reset the state to the default 'light'.

For the app I'm building, I need to persist certain store values across refreshes and restarts. A simple solution is to save these variables to the underlying browser's `localStorage`.

Let's modify the store to retrieve the default value from `localStorage`.

```js
import { writable } from "svelte/store";

const storedTheme = localStorage.getItem("theme");
export const theme = writable(storedTheme);
```

This alone won't work, because `storedTheme` will evaluate to `null` when there's nothing yet  in `localStorage` (for example when the app is first initialized).

Let's fix this by registering a subscriber:

```js
import { writable } from "svelte/store";

const storedTheme = localStorage.getItem("theme");
export const theme = writable(storedTheme);
theme.subscribe(value => {
    localStorage.setItem("theme", value === 'dark' ? 'dark' : 'light');
});
``` 

It took me a while to wrap by brain around this but essentially it creates a watcher of sorts that updates the value of `layout` in the store, when it changes.

The cool thing is that it also saves the default value `light` to `localStorage` when it doesn't exist. You can test this by going into the browser's dev tools, deleting the key and refreshing the page. You'll notice that they key gets recreated and set to `light`.

Now when you call `theme.set('dark')` in your app, the subscriber will get triggered and set the value of `theme` to `dark` in `localStorage`.

From now on, refreshing the page, or closing and opening it will persist whatever value got saved last.

## A side-note on `localStorage` and security

The [complete example](https://svelte.dev/repl/329d9ab4b27543afaf735acfbc6bbec7?version=3.20.1) does not work in the Svelte REPL unfortunately, due to security issues related to `localStorage`.

The problem with `localStorage` is that it relies on the *client's browser* to handle values used by the web app. You can imagine how this could cause issues if the developer uses those values without validation or other measures to ensure the integrity of the data. So, for example, if the front-end passes some values from `localStorage` to the back-end for processing and storing to a database, that data needs to be sanitized and validated properly, and definitely *not trusted implicitly*.

Then again, these problems *should not* be relevant, as long as the app runs strictly on the client side. For this example, `theme` is used only for presentation purposes. Even if the client decides to "hack" the value of localStorage, what this will accomplish at most is to scramble the UI colors a bit.
