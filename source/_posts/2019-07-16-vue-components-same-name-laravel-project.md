---
extends: _layouts.post
section: content
title: Beware of Vue Components with the Same Name in a Laravel Project
date: 2019-07-16
description: The technologies on my personal radar for 2019.
categories: [Laravel, VueJS]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

While working on my SaaS app [Sikrt.com](https://sikrt.com/) I ran into what I thought was a bug, which caused me to waste almost 2 hours tracking it down. In the end it turned out to be something trivial.

**TL;DR** An important piece of functionality broke because I added a new Vue component that happened to have the same name as an existing component, even though both were located in different directories.

## To make a short story long...

[Sikrt.com](https://sikrt.com/) is built on Laravel, with a sprinkling of Vue here and there. These days, Laravel projects make it incredibly easy to embed Vue components by allowing you to register each and every component globally in `resources/js/app.js`.

The relevant piece of code that does that is the following:

```javascript
const files = require.context('./components', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
```

Basically this loops through all the Vue single file components (`.vue` extension), including sub-folders, and registers them. That way you can just refer to the component anywhere in your Blade templates and won't need to import them explicitly. Furthermore, inside each component you can include any other component without importing it or registering it in the parent component. So it makes it really convenient to work with Vue.

One obvious downside is that it makes it much harder to split your code. Personally I've done it on another project (separate bundles for admin and regular users) but it's not provided out of the box. What this means is that you're essentially loading your entire bundle on every page of your Laravel app. At the end of the day it's not a huge deal if you are mindful of your bundle size.

The other downside that I just encountered is that apparently you can't have two components with the same name, even if they're in different folders. The code snippet above, which performs the registration, basically flattens out the entire folder hierarchy inside the `components` folder.

In my specific case, I initially had the following component, which provided the important piece of functionality that I mentioned: `components/VMenu.vue`.

During the changes (mostly front-end) that I made, I added another component with the same name, located at `components/icons/svg/VMenu.vue`. This component was a new SVG icon that I added to the project, following [the pattern I discussed a while back](https://omigo.sh/blog/simplified-dynamic-svg-icon-component/).

The name of this new component is important because I follow a very strict naming convention for SVG icon components: "V", followed by the file name of the original icon in PascalCase. I am partial to [Feather Icons](https://feathericons.com/) these days. So for example, their `arrow-right` icon becomes `VArrowRight.vue` when I import it into my Laravel/Vue project. 

Just like that, my very important functionality no longer worked. And I had no idea why, since Yarn didn't throw any errors upon compiling, nor were there errors in the console.

After trying out different things, I thought I would build the original `VMenu.vue` component (and its parent) from scratch, bit by bit. Eventually I discovered that if I renamed it to something else, it worked. And then the 💡 went off. My feelings were very confused: on the one hand I felt like a dumbass, on the other I felt victorious that I restored that important functionality (which incidentally I spent many hours perfecting it).

There you go: make sure you don't name the Vue components in your Laravel project the same, if you're using the global import technique. But then again, you can always import each component individually. 
