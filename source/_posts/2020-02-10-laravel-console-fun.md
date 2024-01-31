---
extends: _layouts.post
section: content
title: Fun at the Laravel Console 
date: 2020-02-10
description: How to display colored ASCII logos in the Laravel console 
tags: [laravel]
featured: false
image: /assets/img/2020-02-10-laravel-console-fun.png
image_thumb: /assets/img/2020-02-10-laravel-console-fun.png
image_author: 
image_author_url: 
image_unsplash: 
---

When I spun up a new [Livewire](https://laravel-livewire.com/) component with `artisan` (Laravel's CLI tool) recently, I was intrigued enough by the cute ASCII logo to take a look at the [source code](https://github.com/livewire/livewire/blob/master/src/Commands/FileManipulationCommand.php) to see how it was made.

![Livewire ASCII logo](/assets/img/2020-02-10-livewire-console.png "Livewire ASCII logo")

What interested me the most was not the logo itself, but rather the custom colors. I admit I haven't dug deep before into what makes these console commands tick. To my knowledge, Laravel doesn't offer custom colors out of the box.

## Enter Symfony's Console Formatter

I already knew that Laravel's console uses [Symfony's Console Output Formatter](https://symfony.com/doc/current/components/console/helpers/formatterhelper.html) package(s) under the hood, which in turn offer a variety of [colors and styles](https://symfony.com/doc/current/console/coloring.html) that you can apply to your output.

## It's all downhill from here

Armed with this knowledge, the `<fg=cyan>...</>` tags in Livewire's code made perfect sense now.

For my future convenience I created the following two commands:

### 1. List all the default Symfony styles

[Command gist](https://gist.github.com/breadthe/3b82ed24b41a38346f32318e4f585a5d)

### 2. Generate a Ghostbusters logo

The Ghostbusters logo was copied from this lovely [repository of ASCII art](https://asciiart.website/index.php). The Laravel console command in the gist generates the colored logo in the main article image. 

[Command gist](https://gist.github.com/breadthe/c1bc6fff18f21605fbf11726956d43e9)

## Reference

Let's take a closer look at what colors and styles are available and how they can be applied.

**Foreground colors**
 
![Symfony available foreground colors](/assets/img/2020-02-10-symfony-available-fg-colors.png "Symfony available foreground colors")

Usage:

```php
$this->line('<fg=magenta>Magenta text</>');
```

**Background colors**

![Symfony available background colors](/assets/img/2020-02-10-symfony-available-bg-colors.png "Symfony available background colors")

Usage:

```php
$this->line('<bg=blue>Blue background</>');
```

**Options**

![Symfony available options](/assets/img/2020-02-10-symfony-available-options.png "Symfony available options")

Usage:

```php
$this->line('<options=bold>Bold text</>');
```

**Styles**

![Symfony predefined styles](/assets/img/2020-02-10-symfony-available-styles.png "Symfony predefined styles")

Usage (each style is its own individual tag):

```php
$this->line('<question>question</question>');
```

**Custom combos**

You may certainly combine the above to produce custom effects.

![Custom color/style combos](/assets/img/2020-02-10-symfony-available-custom-combos.png "Custom color/style combos")

Usage:

```php
$this->line('<fg=blue;options=blink;bg=yellow>blue text on yellow background</>');
$this->line('Clickable URL: <href=https://github.com;fg=blue;options=underscore>github.com</>');
```

I don't know about you but I'll be sure to make my future Laravel console command output more colorful!
