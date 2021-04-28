---
extends: _layouts.post
section: content
title: The Dynamic Svelte Component Router Pattern
date: 2021-04-27
description: Build a pseudo-router in Svelte using dynamic components
categories: [Svelte,Electron]
featured: false
image: /assets/img/svelte.jpg
image_thumb: /assets/img/svelte.jpg
image_author:
image_author_url:
image_unsplash:
---

[Svelte](https://svelte.dev/) does not come with a built-in router, and there are good reasons for that. One is to keep the framework lean. Another might be to defer the choice of router to the individual developer. There are situation where you might need some form of routing, but may not want to deal with a third party library.

Electron apps built with Svelte are a common scenario for this. Since I haven't found any opinions on how one might handle navigation between different app sections (or pages), I created my own pattern. I call it the **Dynamic Svelte Component Router Pattern**. It sounds pretentious, and I'm sure others are using the exact same thing, but here it is nonetheless.

My interpretation of this assumes there won't be any URL or query parameters passed to the "route". There is no need for it - in the Electron apps (or any SPA) I build, I prefer to pass variables using props, events, or state.

## Dynamic components with &lt;svelte:component&gt;

The basic premise behind this pattern is Svelte's built-in [dynamic components](https://svelte.dev/docs#svelte_component) using this syntax:

```html
<svelte:component this={expression}/>
```

To keep things simple, let's assume my app has 2 sections: a *Dashboard*, and a *Settings* page. There's also a menu with links to each. I will keep the current page in a very simple store.

**TL;DR** You can see the final example in the [Svelte REPL](https://svelte.dev/repl/340dac4861e8499ca4d4092214649c3c?version=3.37.0). Keep reading for more details.

## Explainer

<!-- The 5 files in this example are: -->

* `App.svelte` - The "wrapper" which handles the dynamic component rendering.

It imports the page store, the menu component, and the two page components.

Next, it defines an array of pages. I use this to get a reference to the component that should be loaded dynamically.
This part feels a bit messy, and I have a feeling there might be a better way to handle this, but this is what I came up with.

Finally, the dynamic component matches the store value (`$page`) with an id in the `pages` array, and then returns the `component` property which then gets loaded.

The issue here is that you can't just do `const pages = ['Dashboard', 'Settings'];`, and then `pages.find((p) => p === $page)`, because it will try to pass a string instead of the actual component object to `this={expression}`. In other words, it will do this `<svelte:component this={"Dashboard"}/>` instead of this `<svelte:component this={Dashboard}/>`, and that will throw an error.

Thus, the workaround is to use the array I just mentioned. It may not be pretty but it does the job.

```html
<script>
  import { page } from "./store";
  import Menu from "./Menu.svelte";
  import Dashboard from "./Dashboard.svelte";
  import Settings from "./Settings.svelte";

  const pages = [
    { id: "Dashboard", component: Dashboard },
    { id: "Settings", component: Settings },
  ];
</script>

<main>
	<Menu />

	<svelte:component this={pages.find((p) => p.id === $page).component} />
</main>
```

* `Menu.svelte` - Renders the menu links and saves the selected page to the store.

Clicking a link saves a string value of the desired page to the store.

```html
<script>
	import { page } from "./store";
</script>

<nav>
	<ul>
		<li>
			<a href="/" on:click|preventDefault={() => $page = 'Dashboard'}>Dashboard</a>
		</li>
		<li>
			<a href="/" on:click|preventDefault={() => $page = 'Settings'}>Settings</a>
		</li>
		<li>
			<a href="/" on:click|preventDefault={() => $page = 'Foo'}>Foo</a>
		</li>
	</ul>
</nav>

<style>
	ul { margin:0; padding: 1rem; background-color: cornsilk; }
	li { display: inline; padding: 1rem; }
</style>
```

* `Dashboard.svelte` + `Settings.svelte` - The two pages that will ultimately hold whatever you need them to.

* `store.js` - Stores the current page.

The simplest possible writable store is initialized with the *Dashboard* as default.

```js
import { writable } from "svelte/store";

export const page = writable('Dashboard');
```

And that's it! Clicking the links loads the appropriate component.

## But wait, what about invalid pages?

In my apps so far, all the pages/sections have been static and well defined, so I didn't bother checking if the clicked page actually exists.

`<svelte:component this={expression}/>` will simple fail to render if `expression` is falsy. In this example, the result of `pages.find((p) => p.id === $page).component` is *undefined*, not *false*. So clicking a page that is not defined in the `pages` array (such as *Foo*) will throw an ugly error to the console and block the app.

To handle this more gracefully, I made some changes.

First, I wrapped the component finder in a try/catch, returning *false* if it's not found.

```js
const getComponent = function () {
    try {
        return pages.find((p) => p.id === $page).component;
    } catch (e) {
        return false;
    }
}
```
Then the dynamic component tag becomes:

```html
<svelte:component this={getComponent()} />
```

Now, clicking the invalid *Foo* link will render empty content, but won't break the page anymore, so we can continue navigating to the other pages.

## Add a 404 page

This last step is probably not needed, unless you are generating component names dynamically based on user input.

As a further enhancement, instead of returning *false*, it's trivial to return a custom 404 page.

So I created an error component called `404.svelte`, cloned from `Dashboard.svelte`. Here's how the final `App.svelte` looks, after importing the error component:

```html
<script>
  import { page } from "./store";
  import Menu from "./Menu.svelte";
  import Dashboard from "./Dashboard.svelte";
  import Settings from "./Settings.svelte";
  import NotFound from "./404.svelte";

  const pages = [
    { id: "Dashboard", component: Dashboard },
    { id: "Settings", component: Settings },
  ];

	const getComponent = function () {
		try {
			return pages.find((p) => p.id === $page).component;
		} catch (e) {
			return NotFound;
		}
	}
</script>

<main>
	<Menu />

	<svelte:component this={getComponent()} />
</main>
```

And that's all there is to it!
