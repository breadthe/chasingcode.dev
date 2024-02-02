---
extends: _layouts.post
section: content
title: How to Export Environment Variables on Mac and Windows
date: 2020-09-25
description: 
tags: [electron, terminal]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

I'm building a desktop app for managing SVG icon libraries called [SVGX.app](https://svgx.app/).

It uses Electron and Svelte, as well as [Forge](https://www.electronforge.io/) which is a helpful tool for creating and publishing such apps. I'm also using [this template](https://github.com/breadthe/electron-forge-svelte) as a starter.
 
My plan was to offer two versions of the app: *paid* and *demo*. Notice I said "was" - I'm still debating the details. Anyway, I thought the demo would be a stripped edition of the full app, lacking certain features. 

I decided that one way to accomplish this in an Electron app would be to create a couple of extra build tasks in `package.json`, and then run the commands like so:

- `npm run start` or `yarn start` - builds the full Mac version
- `npm run start-demo` or `yarn start-demo` - builds the demo Mac version
- `npm run start-win` or `yarn start-win` - builds the full Windows version
- `npm run start-win-demo` or `yarn start-win-demo` - builds the demo Windows version

Each of these tasks would export a `DEMO` flag as an environment variable, that my app could use to conditionally "guard" features when the flag is `false`.

Well, on Mac it's simple: just add `export \"DEMO=yes\"` in the script (notice the escaped quotes), and call it a day. The Electron app would read the `DEMO` variable with `process.env.DEMO`. Simple, right?

Not so fast. It turns out you can't use this syntax to export environment variables in Windows (I use Git Bash for my terminal). The build process will fail with an error:

```bash
'export' is not recognized as an internal or external command, operable program or batch file.
```

I feel I should have known this, but I code almost exclusively on a Mac, so I never ran into this situation before. What does work is to use `set \"DEMO=yes\"` instead.

So my script becomes what you see below:

```json
{
  "name": "...",
  "productName": "...",
  "version": "...",
  "description": "...",
  "main": "...",
  "scripts": {
    "start": "export \"DEMO=no\" && concurrently \"npm:svelte-dev\" \"electron-forge start\"",
    "start-demo": "export \"DEMO=yes\" && concurrently \"npm:svelte-dev\" \"electron-forge start\"",
    "start-win": "set \"DEMO=no\" && concurrently \"npm:svelte-dev\" \"electron-forge start\"",
    "start-win-demo": "set \"DEMO=yes\" && concurrently \"npm:svelte-dev\" \"electron-forge start\"",
  },
  ...
}
```

In summary:

- use `export` on Mac
- use `set` on Windows
