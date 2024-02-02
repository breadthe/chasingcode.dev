---
extends: _layouts.post
section: content
title: Must-have Laravel & PHP Packages
date: 2023-01-06
updated: 2023-02-05
description: A repository of my must-have Laravel and PHP packages for every project
tags: [laravel, php]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/109645605072597368
---

A list of Laravel and PHP packages I **absolutely** need in every project, continuously updated.

This list is relatively short because I follow the principle "avoid packages until it hurts". I use packages that encapsulate complex functionality and features that would take too long to implement from scratch. I also heavily favor those that are well maintained, which is why you'll see a lot of Spatie ones on the list.

## Must-have

* [livewire/livewire](https://github.com/livewire/livewire) - Laravel Livewire.
* [wire-elements/modal](https://github.com/wire-elements/modal) - Wire Elements Modal, a modal component for Laravel Livewire.
* [spatie/laravel-google-fonts](https://github.com/spatie/laravel-google-fonts) - Manage self-hosted Google Fonts in Laravel apps.
* [spatie/laravel-backup](https://github.com/spatie/laravel-backup) - A modern backup solution for Laravel apps.
* [opcodesio/log-viewer](https://github.com/opcodesio/log-viewer) - Easy-to-use, fast, and beautiful log viewer for Laravel apps.
* [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) **dev** - Laravel Debugbar.
* [spatie/laravel-ray](https://github.com/spatie/laravel-ray) **dev** - Laravel adapter for Ray.
* [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) **dev** - Laravel IDE Helper. It generates helper files that enable your IDE to provide accurate autocompletion. Especially useful to allow PHPStorm to make sense of facades. Run the following commands after installing:
  * `php artisan clear-compiled`
  * `php artisan ide-helper:generate`
  * (optional) `php artisan ide-helper:models`
  * (optional) `php artisan ide-helper:meta`

## Sometimes

* [spatie/laravel-data](https://github.com/spatie/laravel-data) - Powerful data objects for Laravel.
* [spatie/simple-excel](https://github.com/spatie/simple-excel) - Read and write simple Excel and CSV files.
* [spatie/laravel-markdown](https://github.com/spatie/laravel-markdown) - A highly configurable markdown renderer and Blade component for Laravel.
* [spatie/laravel-personal-data-export](https://github.com/spatie/laravel-personal-data-export) - Create zip files containing personal data.
* [roach-php/laravel](https://github.com/roach-php/laravel) - Web Scraping for Laravel.
* [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) - PHP dotenv / Loads environment variables from .env to getenv(), $_ENV and $_SERVER automagically.
* [bringyourownideas/laravel-backblaze](https://github.com/bringyourownideas/laravel-backblaze) - B2-Backblaze Storage Adapter for Laravel 5+.
* [brendt/php-sparkline](https://github.com/brendt/php-sparkline) - Generate [sparkline](https://en.wikipedia.org/wiki/Sparkline) SVGs in PHP.
    * [YouTube - Building the SparkLine package](https://www.youtube.com/watch?v=N_6Y09NLaqM)

## My packages

* [breadthe/php-simple-calendar](https://github.com/breadthe/php-simple-calendar) - Generate a 7 x 6 (42) or 7 x 5 (35) element array of the days of the month for any date in PHP.
* [breadthe/laravel-silent-spam-filter](https://github.com/breadthe/laravel-silent-spam-filter) - Silently ignore messages submitted via contact forms in Laravel.
* [PHP Contrast Tools](https://github.com/breadthe/php-contrast) - Various utilities for working with color contrast in PHP.
