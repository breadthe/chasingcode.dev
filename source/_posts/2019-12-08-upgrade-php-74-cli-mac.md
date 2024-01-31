---
extends: _layouts.post
section: content
title: Upgrade the PHP CLI to 7.4 on Mac
date: 2019-12-08
description: How to upgrade to PHP 7.4 on Mac and run the correct version in the CLI
tags: [mac,php]
featured: false
image: /assets/img/2019-12-08-upgrade-php-74-cli-mac.png
image_thumb: /assets/img/2019-12-08-upgrade-php-74-cli-mac.png
image_author: 
image_author_url: 
image_unsplash: 
---

On Mac, PHP can be easily upgraded to 7.4 with Homebrew. However, the command line may continue to show the previous version. Here's how to fix that.

[Upgrade to PHP 7.4 with Homebrew on Mac](https://stitcher.io/blog/php-74-upgrade-mac) is a very succinct article by [@brendt_gd](https://twitter.com/brendt_gd) that boils it down to two simple commands: `brew update` and `brew upgrade php`. 

The problem I ran into was that my PHP CLI in the terminal remained linked to the previous version. Checking the version, before and after running the brew command produced the same result:

```bash
$ php -v
PHP 7.2.9 (cli) (built: Aug 21 2018 07:42:00) ( NTS )
```

Just to make sure 7.4 was actually installed, I ran the upgrade command again, then checked the actual location of PHP 7.4:

```bash
$ brew upgrade php
Warning: php 7.4.0 already installed

$ ls /usr/local/etc/php/7.4
OK
```

To switch the PHP CLI to 7.4, first I ran Homebrew's unlink/link command:

```bash
$ brew unlink php && brew link php
```

This should produce an output similar to this:

```bash
Unlinking /usr/local/Cellar/php/7.X... XX symlinks removed
Linking /usr/local/Cellar/php/7.4.0... 24 symlinks created
```

Finally, you need to export the proper path variable for the PHP executable in either `.bashrc` or `.zshrc`. These are typically located in your home (`~`) folder:

```bash
$ cd ~
$ vi .zshrc
``` 

Locate the following (or similar) line...

```bash
export PATH=/usr/local/php5/bin:$PATH
```

... and change it to:

```bash
export PATH=/usr/local/bin/php:$PATH
```

> **Note**  
> If you list the PHP executable... 
> ```bash
> $ ls -al /usr/local/bin/php
> /usr/local/bin/php -> ../Cellar/php/7.4.0/bin/php
> ```
> ... you'll notice that `/usr/local/bin/php` is a symlink pointing to `/usr/local/Cellar/php/7.4.0` which is the same location that was linked by Homebrew above.

Finally, run `source .zshrc` to get the terminal to update its configuration.

For good measure, close the terminal window and open a fresh one. If you now run `php -v` you should be rewarded with this:

```bash
$ php -v
PHP 7.4.0 (cli) (built: Nov 29 2019 16:18:44) ( NTS )
```
