---
extends: _layouts.post
section: content
title: How to upgrade a Ubuntu server from 20.04 to 22.04
date: 2024-03-19
updated:
description: Procedure for upgrading Ubuntu from 20.04 to 22.04
tags: [linux]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url:
---

I operate a $5 Linode VPS and I just upgraded Ubuntu from 20.04 to 22.04.

I thought I would copy the young'uns and ask ChatGPT how do to it. Here's what it told me. Surprisingly it worked.

```bash
sudo apt-get update
sudo apt-get upgrade
sudo apt-get dist-upgrade
sudo apt-get autoremove
sudo reboot
```

But before you do this, you might need to get the [official sources for Ubuntu 22.04](https://wiki.ubuntuusers.de/sources.list/#Ubuntu-20-04). That's because you might get a `Invalid package information` error.

```
deb http://de.archive.ubuntu.com/ubuntu jammy main restricted universe multiverse
deb http://de.archive.ubuntu.com/ubuntu jammy-updates main restricted universe multiverse
deb http://de.archive.ubuntu.com/ubuntu jammy-security main restricted universe multiverse
deb http://de.archive.ubuntu.com/ubuntu jammy-backports main restricted universe multiverse
```

Copy these and paste them at the end of this file:
```bash
sudo vi /etc/apt/sources.list
```

Then proceed with the commands at the top. Occasionally you'll be asked whether to keep certain config files or replace them with fresh configs. I chose to keep my old ones.

```
Configuration file '/etc/crontab'
 ==> Modified (by you or by a script) since installation.
 ==> Package distributor has shipped an updated version.
   What would you like to do about it ?  Your options are:
    Y or I  : install the package maintainer's version
    N or O  : keep your currently-installed version
      D     : show the differences between the versions
      Z     : start a shell to examine the situation
 The default action is to keep your current version.
*** crontab (Y/I/N/O/D/Z) [default=N] ?
```

And that's it.
```bash
cat /etc/issue
Ubuntu 22.04.4 LTS
```
