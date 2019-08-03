---
extends: _layouts.post
section: content
title: How to Fix Laravel Public Storage
date: 2018-12-04
description: How to fix public storage visibility in Homestead
categories: [Laravel]
featured: false
---

When I ran into this particular problem with Laravel's [filesystem](https://laravel.com/docs/5.7/filesystem), I had less experience with it than I do today (relatively speaking).

To give a little background, for my Laravel development environment I use Homestead on Mac and Windows both.

In one project I wanted to upload some images to the public folder. The Laravel documentation says that you should run the `php artisan storage:link` command in order to symlink the public folder (it maps `storage/app/public` to `public/storage`). By default, uploaded files are private.

In my case, the command seemed to succeed locally but in the browser I couldn't load the images even though they appeared to be in the correct folder. Eventually I determined that the symlink in the Homestead environment was incorrect.

Digging deeper, the problem is that the artisan command seems to create an absolute link to the storage folder, which (if you run the command locally) propagates to the synced environment (Homestead) which has an entirely different project structure for your website. As a result, if you check where the created symbolic link on the server (`storage/app/public`) is pointing to, you will see something to the effect of:

```bash
/Users/LocalUserName/code/MyProjectName
```

Which, of course, is not the same as `public/storage`.

```bash
symlink(): No such file or directory
```

The solution proved simple:

First, ssh to the server, navigate to your project folder, then delete the symlink from the public folder:

```bash
cd public
unlink storage
```

Finally, run the command to create the symlink manually (assuming we are still in public/):

```bash
ln -s ../storage/app/public storage
```

Voila, now your images should work correctly.