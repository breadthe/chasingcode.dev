---
extends: _layouts.post
section: content
title: How to Install the Latest (or Specific) Version of PHP in Windows 10
date: 2019-10-31
description: Documenting my process for installing a specific version of PHP in Windows 10 and making it available in bash.
tags: [php, windows]
featured: false
image: /assets/img/2019-10-31-install-specific-php-version-windows-10.jpg
image_thumb: /assets/img/2019-10-31-install-specific-php-version-windows-10.jpg
image_author: 
image_author_url: 
image_unsplash: 
---

I won't make a secret of the fact that I just don't like coding open source on Windows. It makes really hard to get all the necessary tools in working order, and then it's super slow for common and frequent tasks such as running composer or npm/yarn. However, circumstances sometimes dictate that one makes do with the hand they are dealt. So this dude abides... Hence this little guide for installing the latest or a specific version of PHP in Windows 10.

## 1. Download PHP

Download your desired PHP version from the [official repository](https://windows.php.net/download/). At the time of writing this, I used `PHP 7.3 VC15 x64 Non Thread Safe`.

![Download PHP](/assets/img/2019-10-31-download-php.png)

## 2. Move the folder

Unzip the zip archive, rename the folder to something like `php` or if you want to have multiple versions of PHP, `php-7.3`, and move it to your `C:\` folder.

## 3. Alias it in bash

Open your bash terminal of choice. I use Zshell.

I maintain a separate `.aliases` file in my home folder.

Add a new entry (or change the existing alias) for the new PHP executable.

```bash
alias php="/mnt/c/php-7.3/php.exe"
```

In your `.bashrc` or `.zshrc` make sure this line exists:

```bash
source ~/.aliases
```

Restart your terminal (or run `source ~/.bashrc` or `source ~/.zshrc`) and check the PHP version:

```bash
$ php -v
PHP 7.3.8 (cli) (built: Jul 30 2019 12:44:08) ( NTS MSVC15 (Visual C++ 2017) x64 )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.8, Copyright (c) 1998-2018 Zend Technologies
```

## 4. `php.ini` configuration 

There are likely a few things you might want to configure in `php.init` to bring it in line with your previous config, or to make it run properly. Here are some of the things I do.

In the php folder, copy `php.ini.development` to `php.ini`.

Increase `memory_limit` to `1G`.

Increase `post_max_size` and `upload_max_filesize` to whatever works for you, typically higher than the default 8M and 2M, respectively. I typically set my `upload_max_filesize` to 64M.

Uncomment the line `;extension_dir = "ext"` by removing the `;`.

In the `Dynamic Extensions` section enable the following (YMMV - no need to enable all database extensions):

```
extension=curl
extension=fileinfo
extension=gd2
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=pdo_pgsql
extension=pdo_sqlite
extension=sockets
extension=sqlite3
extension=xmlrpc
```

## Final thoughts

This should be sufficient to allow you to run PHP in your Windows (bash) terminal of choice. You can switch versions either by re-aliasing the `php` command, or by creating version-specific aliases (for example `php72`).
