---
extends: _layouts.post
section: content
title: Automate the Laravel 6 -> 7 Upgrade with PHPStorm
date: 2020-03-15
description: How I transplanted a previous Laravel 7 upgrade to a Laravel 6 project, using PHPStorm.
tags: [laravel]
featured: false
image: /assets/img/2020-03-15-automate-laravel-6-7-upgrade-phpstorm.png
image_thumb: /assets/img/2020-03-15-automate-laravel-6-7-upgrade-phpstorm.png
image_author: 
image_author_url: 
image_unsplash: 
image_overlay_text:
---

Apologies in advance for the slightly click-baity title, but bear with me and this method might prove useful to you. At any rate, I'm documenting it for my own use.

The official [6.0 -> 7.0 upgrade guide](https://laravel.com/docs/7.x/upgrade) is good enough if you want the bare minimum, but for my own projects I chose to apply the [diffs from the official repo](https://github.com/laravel/laravel/compare/6.x...master) instead.  

Until the present, I've upgraded 3 of my projects to Laravel 7 and the upgrade times were decent, as summarized in this tweet:

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">🚀 Manually upgraded 3️⃣ <a href="https://twitter.com/hashtag/laravel?src=hash&amp;ref_src=twsrc%5Etfw">#laravel</a> 6.0 projects → 7.0 over 2 days.<br><br>Including deployment, it took:<br>1st - 54 min - some dependencies caused issues<br>2nd - 20 min<br>3rd - 10 min<br><br>1/3</p>&mdash; Placebo Domingo (@brbcoding) <a href="https://twitter.com/brbcoding/status/1236721526554189824?ref_src=twsrc%5Etfw">March 8, 2020</a></blockquote>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

Right away a pattern emerged: my projects weren't overly complex, and all upgrades followed basically the same path. The hero image at the top summarizes the list of framework files that need to be upgraded. When a 4th project became an upgrade candidate, it got me thinking that I should perhaps automate this to an extent.

PHPStorm has this neat feature that can create a patch from a commit. I've used this many times before, to lift certain diffs and then reapply them somewhere else. I thought, what if I could lift the diffs from one Laravel project, and apply them to another?

**Note** You might be able to do the same with `git` at the command line if you're a Git wizard. I've done it in the past but while I mostly use the command line, for certain tasks I prefer an IDE. Sadly I didn't document the specific commands I used and due to not using them on a regular basis, they've kinda vacated my brain.

So here are the steps I followed to transplant the Laravel 7 upgrade from Project A (previously upgraded to Laravel 7) to Project B (Laravel 6).

- In PHPStorm go to `Version Control > Log` for Project A, select the Laravel 7 upgrade commit (the entire framework upgrade is part of a single commit, in my case)
- Right-click and choose `Create Patch`
- Save it to disk
- Open Project B (the project to be upgraded) in PHPStorm
- In the main menu, choose `VCS > Apply Patch` and select the `.patch` file created previously
- You'll be presented with the list of files from the commit
- Unselect `composer.lock` from the file list
- Unselect `routes/web.php`, then add `use Illuminate\Support\Facades\Route;` manually after. **Note** You may need to do this for other files in this list where you have custom changes, most notably `routes/api.php`.
- Change `MAIL_DRIVER` -> `MAIL_MAILER` in `.env` manually after
- Delete `composer.lock`
- Run `composer install`

At this point the Project B should have been successfully upgraded to Laravel 7.

While it doesn't follow the pure definition of "automation", this technique worked really well for me. Your mileage will obviously vary, and the more complex your project the less likely it will go as smoothly for you.

Here's the file structure in text form, should you need to copy/paste any of it, and happy upgrading!

```bash
app/
    Exceptions/
        Handler.php
    Http/
        Middleware/
            VerifyCsrfToken.php
        Kernel.php
config/
    app.php
    cache.php
    cors.php
    filesystems.php
    mail.php
    queue.php
    session.php
resources/land/en/
    passwords.php
public/
    .htaccess
routes/
    api.php
    console.php
    web.php
.env.example
composer.json
composer.lock
phpunit.xml
```
