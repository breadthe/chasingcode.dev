---
extends: _layouts.post
section: content
title: My PHP Forked Package Workflow
date: 2021-05-26
description: Documenting my workflow for dealing with forked PHP packages
tags: [php]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
---

Packages are great - they bring specific functionality out of the box, without the need to re-invent it yourself. The downside is that each additional package installed into an application creates one extra dependency. Eventually, one of these dependencies will lag behind, potentially causing your project to grind to a halt.

My personal preference is to keep dependencies at a minimum, for several reasons, but that's a rant for another time.

Here are a few ways in which 3rd party packages can cause headaches:

- the package stops being maintained
- the author is slow to release new features or fix bugs
- the package isn't updated in a timely manner for new language or framework versions

When a dependency "breaks" for me, I typically do the following:

- fork the package
- implement a fix
- make a pull request to the original repository
- while waiting for the PR to be merged (not always guaranteed), I'll switch to using the fork

This will get me unstuck for the time being, but the ideal outcome is for my contribution to be accepted in the official package.

## Quick primer on PHP package management

In PHP we use `composer` to manage packages (install, remove, update, etc). Dependencies are defined in the `composer.json` file.

To install a new package, we run the following command (actual example from one of my apps):

```bash
composer require codetoad/strava
```

This creates an entry in `composer.json` like so:

```json
...
    "require": {
        "php": "^8.0",
        "ext-json": "*",
        "codetoad/strava": "^1.0",
        ...
    },
...
```

Note that the official repository for this package is located at [https://github.com/RichieMcMullen/laravel-strava](https://github.com/RichieMcMullen/laravel-strava).

## Forking the original package

Continuing on the previous example, I've been using the Laravel Strava package in one of my apps, and so far it's been great at pulling data *from* Strava's API. However, it does not have the ability to modify data.

I decided I wanted to update several parameters belonging to an Activity, such as name, description, and gear. Since I couldn't simply ask the author to implement this for me, I knew I had to do it myself.

The first step is to fork the package. In GitHub, simply click the Fork button in the top right corner, and it will create a copy of the repository under your own organization. For me, that would be [https://github.com/breadthe/laravel-strava](https://github.com/breadthe/laravel-strava).

## Clone the fork locally

Now I want to work on the fork locally, so I simply clone it with `git clone https://github.com/breadthe/laravel-strava`, then implement the features I need.

## Linking the app to the local fork

One of the cool things Composer lets you do is to link a package to a local directory. This can be done with a relative or absolute link.

I cloned the forked package in the following directory (Mac): `/Users/myuser/code/packages/php/laravel-strava`.

The app that requires the package is in `/Users/myuser/code/laravel/example-app`. Let's switch to it now, in the terminal. Then I'm going to remove the `codetoad/strava` package using Composer.

```bash
cd /Users/myuser/code/laravel/example-app
composer remove codetoad/strava
```

Open up `composer.json` and add the following top-level key:

```json
    "repositories": [
        {
            "type": "path",
            "url": "/Users/myuser/code/packages/php/laravel-strava"
        }
    ],
```

This tells Composer to install a package called `laravel-strava` from the local path. Alternatively, you can use a relative path such as `../../packages/php/laravel-strava`.

Finally install the package with a `@dev` constraint:

```bash
composer require codetoad/strava @dev
```

You should see this in `composer.json`:

```json
    "require": {
        "php": "^8.0",
        "ext-json": "*",
        "codetoad/strava": "@dev",
        ...
```

Now any changes made to the local fork will appear in the app.

## Linking the app to the remote fork

Once local development on the fork is complete, I can push my changes to the remote fork. From there, I can create a pull request to the original package, and hope the changes will be accepted.

Meanwhile, there's no need to delay development, since I can simply link to my own fork.

To do this, once again remove the package:

```bash
composer remove codetoad/strava
```

Then modify the `repositories` key in `composer.json` like so:

```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/breadthe/laravel-strava"
        }
    ],
```

This tells Composer to install a package called `laravel-strava` from the Version Control System location specified in the URL (instead of the default repo for `codetoad/strava`).

Finally, install the package once more, with a `dev-master` constraint:

```bash
composer require codetoad/strava dev-master
```

You should see this in `composer.json`:

```json
    "require": {
        "php": "^8.0",
        "ext-json": "*",
        "codetoad/strava": "dev-master",
        ...
```

And that's it. The app can now be deployed to a production server, and running `composer install` will install the forked package.

## PR merged, now what?

At the time of writing this, my PR hasn't yet been merged, but here's what I would do next:

- remove the package `composer remove codetoad/strava`
- remove the `repositories` key from `composer.json`
- (optional) delete the `vendor/` folder
- run the original install command `composer require codetoad/strava`

## Conclusion

This is simpler than it sounds, but I had to document it for my own benefit. I don't deal with forks often enough to have it committed to muscle memory, so writing it down will definitely help when I need it again. I hope it will be useful to you as well, and if I missed anything or you find any mistakes, let me know on [Twitter](https://twitter.com/brbcoding/).
