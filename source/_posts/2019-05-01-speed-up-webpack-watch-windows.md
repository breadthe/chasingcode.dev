---
extends: _layouts.post
section: content
title: Speed Up Webpack Watch in Windows
date: 2019-05-01
description: A technique to massively improve the speed of Webpack's watch command in Windows.
categories: [Laravel, Vue, Webpack]
featured: false
image: https://source.unsplash.com/L9VXW4A9QZM/?fit=max&w=1350
image_thumb: https://source.unsplash.com/L9VXW4A9QZM/?fit=max&w=200&q=75
image_author: Charlotte Coneybeer
image_author_url: https://unsplash.com/photos/L9VXW4A9QZM
image_unsplash: true
---

One annoyance of working in Windows in an open-source tech stack is that a lot of the dev tooling isn't as good as on a Mac. The problem rears its ugly head whenever I have to use `composer` or `npm`/`yarn`. Which is pretty much a gazillion times a day. Despite my job laptop having more horsepower than my personal MacBook Pro, the former takes a lot longer to perform any `composer` or `npm` task in the terminal.

Don't get me wrong, I'm not a Mac snob. I've used Windows PCs for most of my career, only switching to Mac a few years ago for development and, oh boy, I would never go back to a PC for any kind of PHP/JS or any kind of open-source work in general. Sometimes, though, an employer can insist on a specific platform, hence the subject of this article.

As a quick recap, the Windows 10 Pro environment in question runs from an SSD on an 8th-gen i7 machine with 16GB RAM. I typically use GitBash as my terminal of choice. I've tried the built-in Ubuntu shell as well as ConEmu which does a somewhat reasonable job of allowing multiple tabs, though it's buggy and I gave up on it. Instead, I just open multiple GitBash windows which is less than ideal but is mitigated by the fact that I have 3 screens at my disposal.

The main project I'm building and maintaining is a Laravel app with lots of Vue sprinkled in, in the form of single-file components.

Whenever I work in Vue, I fire up `yarn watch` <-- Yarn master race 🙂. Well, here's what used to happen every time I saved my work. Webpack went through it's build process, but got stuck for a very long time at 91% with this message: 

```
WAIT Compiling... 10:49:04 AM

91% additional asset processing
```

The whole process took close to 30 seconds. You can imagine this adds up throughout the day. It's long enough to be frustrating but short enough that I can't do anything else in the meantime but twiddle my thumbs.

Having chalked it down to Windows being... Windows, I just about gave up on a good dev experience, until I decided to seek a possible solution.

Well, despair no more fellow Windows hostages. This quick setting will speed up Webpack while it's watching for changes. Just add `devtool: 'eval'` to your Webpack config as shown:

```javascript
mix.webpackConfig({ 
    devtool: 'eval',
    plugins: [],
    ...
})
.extract()
...
```

Keep in mind that the Webpack configuration above is taken from a Laravel 5.8 project, meaning it's wrapped inside [Laravel Mix](https://laravel-mix.com/) but in a regular Webpack project you can use the same method. 

You'll need to restart `yarn watch` after adding this setting, but the watch build time drops down to 1.5-10 seconds, a 2x - 15x speed increase 🚀!

## Digging deeper

What I failed to mention (and it's an important one!) is that I don't use this technique in production, but merely in my local dev environment. In fact Webpack mentions just that in the `devtool` [documentation](https://webpack.js.org/configuration/devtool/).

If you are curious if there's any different in the **production** bundle size without this option and after applying it, yes there is. Using `devtool: 'eval'` produces a larger bundle. Here's a comparison (the CSS bundles are omitted because their size is not affected). The biggest difference is in the vendor bundle

**With** `devtool: 'eval'`:

```
DONE Compiled successfully in 32631ms 10:12:56 AM

      Asset           Size       Chunks               Chunk Names
/js/app.js           656 kB        1         [emitted] [big] /js/app 
/js/vendor.js       1.25 MB        3         [emitted] [big] /js/vendor

Done in 37.33s.
```

**Without** `devtool: 'eval'`:

```
DONE Compiled successfully in 78692ms 10:23:16 AM

      Asset          Size        Chunks                Chunk Names
/js/app.js          407 kB         1          [emitted] [big] /js/app 
/js/vendor.js       345 kB         3          [emitted] [big] /js/vendor

Done in 83.60s. 
```

Happy Webpacking!
