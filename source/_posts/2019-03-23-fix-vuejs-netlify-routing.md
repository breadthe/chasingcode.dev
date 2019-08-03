---
extends: _layouts.post
section: content
title: Fix Routing Issues for a VueJS App Deployed to Netlify
date: 2019-03-23
description: Had a WTF moment when I deployed a new Vue project to Netlify, only to be confronted with this message when I refreshed any route that wasn't root. It worked just fine locally! Here's how to fix this.
categories: [VueJS, Netlify]
featured: false
image: /assets/img/2019-03-23-fix-vuejs-netlify-routing.png
image_thumb: /assets/img/2019-03-23-fix-vuejs-netlify-routing.png
image_author:
image_author_url:
image_unsplash:
---

Had a WTF moment when I deployed a new Vue project to Netlify, only to be confronted with this message when refreshing any route that's not root. It worked just fine locally! Here's how to fix this.

I'm working on a new, fun project called [Craftnautica](https://craftnautica.netlify.com/). In short, it's a fansite (crafting helper) for the game [Subnautica](https://unknownworlds.com/subnautica/). 

The entire app is a Vue SPA (Single Page App) and because it doesn't require a back-end, I'm hosting it statically on [Netlify](https://https://www.netlify.com//).

I use [Vue Router](https://router.vuejs.org/) to build nested routes. A very basic nested route would be `https://craftnautica.netlify.com/sn`. Navigating to it via a link worked just fine after I deployed the code to Netlify, however, refreshing the page after the fact, produced the error message you see above. And that went on for every nested route in the app.

To make a long story short, I discovered that an easy fix is to inclide a `netlify.toml` file in the root folder of your app, with the following:

```yaml
[[redirects]]
  from = "/*"
  to = "/"
  status = 200
```

Redeploy and all the nested routes and permalinks can be refreshed and accessed individually!

You can read more about Netlify's [toml.xml](https://www.netlify.com/docs/netlify-toml-reference/) file and how [redirects](https://www.netlify.com/docs/redirects/) work.
