---
extends: _layouts.post
section: content
title: How to Permanently Store Settings in a Svelte + Electron App 
date: 2021-03-24
description: A guide on how to deploy a Svelte static site to Netlify
categories: [Svelte,Electron]
featured: false
image: /assets/img/svelte-electron.jpg
image_thumb: /assets/img/svelte-electron.jpg
image_author:
image_author_url:
image_unsplash:
---

A very common scenario when building an Electron app is storing user settings/preferences permanently. This can be done in a number of ways, but one of the most robust is to store the settings on disk, usually as a JSON object.

I've been using Svelte for my Electron apps, because it's a joy to work on, so this guide is focused on Svelte, but could be adapted for other frameworks.

I'll use a simple (and very common) example: storing the user's theme (dark/light) preference, and I'll show a few ways in which this can be accomplished using Svelte's store.

The end goal is to be able to style elements depending on how the theme changes. A button toggles the theme. Here's a snippet, using TailwindCSS to apply classes:

```js
import { dark } from "./store";

<header
  class="flex"
  class:bg-gray-100={!$dark}
  class:bg-gray-900={$dark}
  class:text-gray-900={!$dark}
  class:text-gray-100={$dark}
>
</header>

<button
    on:click={() => ($dark = !$dark)}
>
    Switch to { $dark ? 'light' : 'dark' }
</button>
```

When the theme is `dark`, the background and text are `bg-gray-900` and `text-gray-100`, respectively. Basically light text on dark background. When the theme is not `dark` (i.e. light), the opposite is applied.

Let's implement a store in Svelte. Stores are used to persist application state.

## A basic store

The most basic Svelte store will persist a setting only while the app is running, as long as it wasn't refreshed. Here's how it looks:

```js
// store.js
import { writable } from "svelte/store";

export const dark = writable(false);
```

The default in this case is the light theme (not `dark`). The obvious problem is that our preference goes away if we close or refresh the app.

## Persistent store with localStorage

A simple and native way to permanently store settings is using the browser's `localStorage` API. It's super simple, the only downside being that you can only store key-value pairs, meaning you can't have complex objects. Fortunately you can use `JSON.stringify()` when setting a key, and `JSON.parse()` when reading it. For this simple example, this won't be needed, as we're just storing the boolean value.

```js
// store.js
import { writable } from "svelte/store";

const storedDark = localStorage.getItem("currentFolder") || false;
export const dark = writable(storedDark);
dark.subscribe(value => {
    localStorage.setItem('dark', value);
});
```

The code gets slightly longer, but it does its job of persisting our preferences between app sessions. 

## Persistent store/settings on disk

The next step up is to store the settings on disk. In general this is perceived as being more robust than `localStorage` (which can lose data in rare cases when there's an error), and you can also retrieve and/or backup the settings file if you need to.

We'll need a 3rd party library, and there are many to choose from. I used [electron-settings](https://github.com/nathanbuchar/electron-settings). This library offers a more powerful API, with the ability to store deeply nested objects, and retrieve specific keys using dot notation (`setting1.setting2.setting3`).

Find the full documentation [here](https://electron-settings.js.org/index.html).

Install it:

```bash
npm install electron-settings
```

If using Electron 10+, and you need to use `electron-settings` in the browser window, configure Electron like so:

```js
new BrowserWindow({
  webPreferences: {
    enableRemoteModule: true // <-- Add me
  }
});
```

Implementing the store is easy. It looks just like the `localStorage` store, except we're swapping out some functions. I prefer to use the `*Sync` functions here, but there are async equivalents.

```js
// store.js
import { writable } from "svelte/store";
const settings = require('electron-settings');

const storedDark = settings.getSync('dark') || false;
export const dark = writable(storedDark);
dark.subscribe(value => {
    settings.setSync('dark', value);
});
```

By default `electron-settings` will save the settings file under the `userData` folder. On Mac, this would be under `/Users/YourUser/Library/Application Support/YourApp/settings.json`.


## Conclusion

That's it! I showed you 3 ways to store settings in a Svelte + Electron app, with two of them permanent. 