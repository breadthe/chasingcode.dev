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

**UPDATED February 4, 2023**

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

Finally open `app.postcss` and verify that it looks like this:

```css
/* Write your global styles here, in PostCSS syntax */
@tailwind base;

/* Custom classes go here */
/* This will always be included in your compiled CSS */

@tailwind components;

@tailwind utilities;
```

That's it! Now run the site in dev mode with `npm run dev`, or build for production with `npm run build`.

If you want additional customizations, read on.

## Add Prettier

I'm not big on super-detailed customizations, but there are two things that annoy me right off the bat in a new Svelte project: the default line length (80 is too short), and having semicolons at the end of statements.

In addition, I favor single quotes, as well as trailing commas in objects and arrays.

So I like to add Prettier to fix those.

```bash
npm install --save-dev prettier
```

Then create a `.prettierrc.json` file in the root of the project with the following contents:

```json
{
  "semi": false,
  "singleQuote": true,
  "trailingComma": "es5",
  "printWidth": 120
}
```

Finally, add a `.prettierignore` in the root file with the following contents, to ignore the build directory:

```text
dist
```

Now if you hit OPT-CMD-L (on the Mac) in VS Code, it will format the code according to the Prettier rules. If you want the formatting to be automatic, toggle Text Editor > Formatting > Format On Save.