---
extends: _layouts.post
section: content
title: SvelteKit with TailwindCSS and JIT
date: 2021-04-12
description: A guide on how to quickly create a SvelteKit static site with TailwindCSS and JIT
tags: [svelte,tailwind]
featured: false
image: /assets/img/svelte-kit-tailwind.jpg
image_thumb: /assets/img/svelte-kit-tailwind.jpg
image_author:
image_author_url:
image_unsplash:
---

[Svelte](https://svelte.dev/) is my all-time favorite JS framework. Fresh on its heels comes [SvelteKit](https://kit.svelte.dev/), a framework for generating static sites with Svelte. Just what the doctor ordered.

SvelteKit is currently in public beta, but it's caused a lot of chatter over the interwebs, and that made me give it a spin.

Here's a super simple setup to scaffold a SvelteKit static site. Since I also ❤️ TailwindCSS, I have instructions for that as well. And to make it a complete package, it all runs on [Vite](https://vitejs.dev/), for a super fast ⚡️ development environment.

Check out my newer [Svelte, Vite, TailwindCSS 3](/blog/svelte-vite-tailwindcss3-template/) article if all you need is the base Svelte framework.

```bash
# 1. Create a new Svelte Kit site
# My choices: no TypeScript, ESLint, Prettier
npm init svelte@next my-app

cd my-app

# 2. Install packages
npm install

# 3. Add TailwindCSS
# @see https://github.com/svelte-add/tailwindcss
npx svelte-add@latest tailwindcss
```

Step 3 automates most of Tailwind's configuration, by creating pre-populated configs for `postcss.config.cjs`, `tailwind.config.cjs`, and filling in the required PostCSS config in `svelte.config.cjs`.

To finalize installing Tailwind, open `app.css` and add the base Tailwind styles right at the top:

```scss
@tailwind base;

// Custom CSS goes here

@tailwind components;
@tailwind utilities;
...
```

Finally start it in dev mode, and open it in the browser.

```bash
# Run in development mode, and open the site in the browser
npm run dev -- --open
```
