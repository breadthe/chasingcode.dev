---
extends: _layouts.post
section: content
title: How to restore a corrupted PHP environment on M1 Mac
date: 2021-07-05
description: Steps I took to restore a corrupted PHP/composer local development environment on an M1 Mac Air
tags: [mac,php,laravel,dev-tools]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
---

## The problem

Recently the local PHP 8 + Composer 2 + Laravel Valet dev environment on my M1 Mac Air got trashed for no discernable reason.
This might well be an obscure problem that no one else but me encounters, but I'm documenting it nonetheless.

The rough chain of events happened as follows (I don't remember the exact details):

- I left on vacation for 2 weeks
- I turned off the Air using the Shut Down command
- I must have lifted the lid at some point and closed it back up, which turned it on (?)... woke it from sleep (?). I can never tell.
- I took it with me, but over the 2 weeks the entire battery was drained (I didn't have time to use it)
- When I got back and turned it back on (had to recharge it fully), I noticed that [Laravel Valet](https://laravel.com/docs/8.x/valet) was down
- Attempting to run any `php` or `composer` command resulted in the process being automatically killed:

```bash
php -v
[1]    27499 killed     php -v

composer -v
[1]    27590 killed     composer -v
```

Check program location:

```bash
which php
/opt/homebrew/bin/php

which composer
/opt/homebrew/bin/composer
```

This hinted it might be a [Homebrew](https://brew.sh/) issue.

# The solution

*First* I uninstalled PHP (8) with `brew uninstall --force php`:

```bash
php -v
WARNING: PHP is not recommended
PHP is included in macOS for compatibility with legacy software.
Future versions of macOS will not include PHP.
PHP 7.3.24-(to be removed in future macOS) (cli) (built: May  8 2021 09:40:34) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.24, Copyright (c) 1998-2018 Zend Technologies

which php
/usr/bin/php
```

**Note** uninstalling PHP 8 might not be strictly necessary, since it will probably get overwritten later down the line when I reinstall, but might as well for good measure.

*Next*, uninstall Homebrew:

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/uninstall.sh)"
```

*Finally*, install the whole Laravel Valet environment, including a new version of Homebrew following this [helpful M1-specific guide](https://austencam.com/posts/setting-up-an-m1-mac-for-laravel-development-with-homebrew-php-mysql-valet-and-redis) exactly.

The key is to use the `arm` Rosetta prefix (as specified in the article), which is something I might have omitted when I first set up this environment many months ago.

Check program locations again:

```bash
which php
/usr/local/bin/php

which composer
/usr/local/bin/composer
```

Locations look good, and the environment should be working at this point.

## Error installing yarn

One more issue, turns out [yarn](https://yarnpkg.com/) also got messed up somehow. Yeah, I could switch to `npm` for my Laravel projects but I don't feel like adding a `package.lock` file, so I prefer to stick with yarn.

Unfortunately, attempting to install yarn produced another obscure error that took a while to research:

```bash
npm install -g yarn

npm ERR! code EACCES
npm ERR! syscall mkdir
npm ERR! path /usr/local/lib/node_modules/yarn
npm ERR! errno -13
npm ERR! Error: EACCES: permission denied, mkdir '/usr/local/lib/node_modules/yarn'
npm ERR!  [Error: EACCES: permission denied, mkdir '/usr/local/lib/node_modules/yarn'] {
npm ERR!   errno: -13,
npm ERR!   code: 'EACCES',
npm ERR!   syscall: 'mkdir',
npm ERR!   path: '/usr/local/lib/node_modules/yarn'
npm ERR! }
npm ERR!
npm ERR! The operation was rejected by your operating system.
npm ERR! It is likely you do not have the permissions to access this file as the current user
npm ERR!
npm ERR! If you believe this might be a permissions issue, please double-check the
npm ERR! permissions of the file and its containing directories, or try running
npm ERR! the command again as root/Administrator.
```

The solution involved changing ownership on a couple folders, and this allowed the installation to proceed.

```bash
sudo chown -R $USER /usr/lib/node_modules
sudo chown -R $USER /usr/local/lib/node_modules
npm install -g yarn

yarn -v
1.22.10
```

## Conclusion + rant

Post-mortem analysis of this leaves me puzzled. I have no idea why the Homebrew versions of PHP and Composer got messed up like that. Perhaps something to do with certain processes that were running at the time getting corrupted when the system was forcefully shut down due to the low power state.

As much as I love the Mac, there's one thing about Mac laptops that I hate, and that is the power management with the lid open/closed.

Expected behavior when using *Shut Down*:

- the computer turns off completely - not asleep, OFF!
- I close the lid, then I open it, it stays OFF!
- it should power on only by pressing the Power button once

Instead, what I get - regardless if I use *Sleep* or *Shut Down* - is this:

- the computer turns off (?) - it actually goes to sleep
- I close the lid
- if I leave it connected to an external monitor (but not plugged in), it drains all the battery overnight
- I close the lid, then I open it, it wakes up
- the Power button seems like a decoration at this point, since the computer powers up regardless, every time I open the lid

There doesn't seem to be any setting that I can tweak to make it work the way I want. Both x86 and ARM versions behave similarly. If you have suggestions, let me know on [Twitter](https://twitter.com/brbcoding).
