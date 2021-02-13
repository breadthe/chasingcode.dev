---
extends: _layouts.post
section: content
title: How to Toggle a Menu Item Dynamically in Electron
date: 2021-02-12
description: How to enable or disable a menu item in Electron from events in the renderer process
categories: [Electron,Svelte]
featured: false
image: /assets/img/electron-logo.jpg
image_thumb: /assets/img/electron-logo.jpg
image_author: 
image_author_url: 
image_unsplash: 
---

Toggling an Electron menu item dynamically is quite simple, though not immediately clear from the official documentation.

In an Electron app, the application menu consists of items such as File, Edit, View, and so on. Beside the standard menus found in most applications, you can also create your own menu entries with custom functionality.

Sometimes you want these entries to be enabled or disabled dynamically based on data in the application state. Here's how to toggle menu item visibility programmatically, from the application code - or Renderer process.

## TL;DR

If you want to skip the bla bla, here's a simplified version of the workflow, which assumes the menu is built in `index.js`.

```js
// Main process (index.js)
const { Menu, ipcMain } = require('electron');

let mainWindow; // Main application window, created with new BrowserWindow({...}), code omitted for brevity 

// Build the application menu
const menu = Menu.buildFromTemplate([
    {
        label: 'Edit',
        submenu: [
            {
                id: 'revert-changes',
                label: 'Revert Changes',
                click: revertChanges,
                enabled: false
            }
        ]
    },
]);
Menu.setApplicationMenu(menu);

// Forward the 'revertChanges' event to the Renderer process
function revertChanges() {
    mainWindow.webContents.send('revertChanges'); // Discard the code changes
}

ipcMain
    // Listen for an event from the Renderer process, and toggle the menu item accordingly
    .on('originalFileModified', (events, args) => {
        Menu.getApplicationMenu().getMenuItemById('revert-changes').enabled = args.originalFileModified;
    });
```

## Case study

I'm building [SVGX](https://svgx.app/), an Electron + Svelte app. I have a code area that I can edit. When the original code is modified, an 🟠 orange dot appears along with a revert icon. Clicking the icon reverts the code to the original state.

![SVGX, file modified indicator](/assets/img/2021-02-12-svgx-file-modified.jpg)

I wanted to have an option to Revert Changes under the Edit menu. As a UX improvement, I also wanted this entry to be disabled by default, until the code is modified, whereupon it would become enabled.

## Main vs Renderer process

You can read more about the [Main](https://www.electronjs.org/docs/api/ipc-main) and [Renderer](https://www.electronjs.org/docs/api/ipc-renderer) processes in the official documentation, but here's how they fit into this scenario.

**Main** is responsible for *creating the application menu* and *listening for events from the Renderer process*.

**Renderer** *emits events* to the Main process.

## The logic flow

I'm aiming for the following:

* Code is unmodified (initial state) - Edit > Revert Changes is *disabled*
* Code is modified - Edit > Revert Changes is *enabled*
* Edit > Revert Changes is clicked - it becomes *disabled*, and the code is reverted
* Same happens if the revert icon is clicked

## The solution

For simplicity, I will show only 3 of the modules involved in this process: `index.js`, `menu.js`, `CodePane.svelte`, and will strip out most of the code, except for the relevant bits.

* `index.js` (Main process) is the entry point to the Electron app, responsible for creating the `BrowserWindow` and the menu, among other things.
* `menu.js` (Main process) is the array of custom menu entries that could just as well have been part of `index.js` but I extracted here for readability
* `CodePane.svelte` (Renderer process) is the Svelte component that displays the code/markup, and allows editing

The more fleshed-out solution is shown below, with comments for clarification.

**index.js**

```js
const { app, Menu, ipcMain } = require('electron');
const { menuTemplate } = require('./lib/menu.js');

// ...
let mainWindow;
// ...

const createWindow = () => {
    // Create the browser window
    mainWindow = new BrowserWindow({
        // ...
    });
};

function createAppMenu() {
    const menu = Menu.buildFromTemplate(menuTemplate);
    Menu.setApplicationMenu(menu);
}

app.whenReady().then(() => {
    createWindow();
    createAppMenu();
});

ipcMain
    // Forward the 'revertChanges' event to the Renderer process
    .on('revertChanges', () => {
        mainWindow.webContents.send('revertChanges'); // Discard the code changes
    })

    // Toggle the Edit > Revert menu option depending if the file was modified
    // The "originalFileModified" event is emitted from the Renderer process (the Svelte component)
    .on('originalFileModified', (events, args) => {
        Menu.getApplicationMenu().getMenuItemById('revert-changes').enabled = args.originalFileModified;
    });
```

**menu.js**

```js
const { ipcMain } = require('electron')

module.exports = {
    menuTemplate: [
        // ...
        {
            label: 'Edit',
            submenu: [
                { role: 'undo' },
                { role: 'redo' },
                { type: 'separator' },
                {
                    id: 'revert-changes', // Needs an id so I can reference it easily
                    label: 'Revert Changes',
                    click: revertChanges,
                    enabled: false
                },
                { type: 'separator' },
                { role: 'cut' },
                { role: 'copy' },
                { role: 'paste' },
                // ...
        },
        // ...
    ]
}

// Emitting to index.js
function revertChanges() {
    ipcMain.emit('revertChanges');
}
```

**CodePane.svelte**

```js
<script>
const ipcRenderer = require("electron").ipcRenderer;
import { onMount } from "svelte";
import { originalFileModified } from "../store/svg";

// Watch the originalFileModified store value for changes...
// ... and fire an event to the Main process when a change occurs
$: {
    ipcRenderer.send("originalFileModified", {
      originalFileModified: $originalFileModified
    });
}

onMount(() => {
    ipcRenderer.on("revertChanges", (event, args) => {
        // Logic for discarding the changes to the markup
        // ...
    });
});
</script>
```

## Conclusion

I was stumped initially by how to enable and disable an Electron menu dynamically, but was certain there had to be a way. Sure enough, the key to the solution is this piece of code `Menu.getApplicationMenu().getMenuItemById('revert-changes').enabled` in the Main process, which gets a reference to the menu item I'm targeting, then toggles it based on an event that was emitted from the Renderer process.
