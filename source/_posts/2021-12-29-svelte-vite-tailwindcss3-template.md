---
extends: _layouts.post
section: content
title: Creating a Svelte, Vite, and TailwindCSS 3 Template
date: 2021-12-29
description: Documenting how to create a Svelte, Vite, and TailwindCSS 3 template in late 2021
categories: [Svelte,TailwindCSS,Vite]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
---

At the end of 2021 I decided to create a very basic Svelte/Vite/TailwindCSS 3 template that would provide a starting point for future projects. Thanks to modern tooling and automation, the procedure is pretty simple, but I am documenting it here nonetheless.

Why not SvelteKit? Two reasons.

First, I already wrote instructions for scaffolding a [SvelteKit/Vite/Tailwind](https://chasingcode.dev/blog/svelte-kit-tailwind/) site.

Second, I intend to use this as an Electron starter, for which I don't need SvelteKit.

## Create a new Vite project with Svelte template

[Scaffold a new Vite project](https://vitejs.dev/guide/#scaffolding-your-first-vite-project) with the `svelte` (or `svelte-ts` for TypeScript) template:

```bash
# for TypeScript use --template svelte-ts
npm init vite@latest my-svelte-app -- --template svelte

cd my-svelte-app
npm install
```

## Add TailwindCSS 3

```bash
npx svelte-add@latest tailwindcss
npm install
```

This step automates most of Tailwind's configuration, by creating pre-populated configs for `postcss.config.cjs`, `tailwind.config.cjs`, and filling in the required PostCSS config in `svelte.config.cjs`.

Finally open `app.css` and verify that it looks like this:

```css
/* Write your global styles here, in PostCSS syntax */
@tailwind base;
@tailwind components;

/* Custom classes go here */
/* This will always be included in your compiled CSS */

@tailwind utilities;
```

That's it! Now run the site in dev mode with `npm run dev`.
