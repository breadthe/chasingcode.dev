---
extends: _layouts.post
section: content
title: How to Generate Mac and Windows Icons for an Electron Forge App
date: 2020-10-09
description: 
tags: [electron]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

As I'm wrapping things up on [SVGX.app](https://svgx.app/), a desktop app for managing SVG icon libraries, I find myself slogging through the most tedious 10% of the work. Part of that is building platform-specific executables.

The application icon may seem like a minor detail, yet I consider it very important, not just for branding, but also as a sign that the app is complete.

Unfortunately there don't seem to be a lot of resources out there for how to actually create proper Mac and Windows (and Linux) icons for the final build. It took me a while to figure out, but eventually I got it.

SVGX is an Electron app built with [Svelte](https://svelte.dev/), as well as [Forge](https://www.electronforge.io/) which is a helpful tool for creating and publishing such apps. I'm also using [this template](https://github.com/breadthe/electron-forge-svelte) as a starter.
 
## Step 1

First, install the [electron-icon-builder](https://github.com/safu9/electron-icon-builder) utility which generates the icons for you. Follow the instructions in the repo.

## Step 2

Next you'll run the command to generate a set of Mac/Windows/Linux icons from a single `png` image. The source image should be at least 1024x1024 in size. 

In my case, I ran this in the folder where my source image `svgx-logo-v3-1024.png` is located, and outputted it to another folder called `appicons`.

```bash
electron-icon-maker --input=svgx-logo-v3-1024.png --output=./appicons
```

## Step 3

Back in the Electron app directory, add the appropriate icon path to `package.json`, before running the build command.

- Mac: `./src/icons/mac/icon.icns`
- Windows: `./src/icons/win/icon.ico`
- Linux: `./src/icons/png/1024x1024.png`

```json
{
  "name": "...",
  "productName": "...",
  "version": "...",
  "description": "...",
  "main": "...",
  "scripts": {
    ...
  },
  "keywords": [],
  "author": "...",
  "license": "MIT",
  "config": {
    "forge": {
      "packagerConfig": {
        "icon": "./src/icons/mac/icon.icns"
      },
      "makers": [
        ...
      ]
    }
  },
  "dependencies": {
    ...
  },
  "devDependencies": {
    ...
  }
}
```

I haven't figured out if there's a way to do this across platforms without modifying `package.json` manually before building, but this works well enough and barely adds any overhead.

## Step 4

Run the command to generate the appropriate build for your OS. For Electron Forge, the command is `npm run make` or `yarn make`.

## Step 5

Profit!
