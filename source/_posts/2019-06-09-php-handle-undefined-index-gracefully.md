---
extends: _layouts.post
section: content
title: PHP - Handle Undefined Index Gracefully
date: 2019-06-09
description: A more convenient way to handle undefined variables/indexes in PHP even in older versions.
categories: [PHP]
featured: false
image: /assets/img/2019-06-09-php-handle-undefined-index-gracefully.png
image_thumb: /assets/img/2019-06-09-php-handle-undefined-index-gracefully.png
image_author:
image_author_url:
image_unsplash:
---

Let's say I'm processing some input in the form of an array or object, and I can't predict which keys are defined.

```php
// input
$item = [
    'name' => 'Item name',
];

$year = $item['year']; // Undefined index: year
```

If I try to reference a non-existent key and don't handle that properly, I'll get this nice little error, and my code will break:

```bash
PHP error:  Undefined index: year on line x
```

So let's assume that I want to handle this by assigning `null` to an undefined value or index. This can be done a few different ways.

**Option 1**

Long form. I've seen this a lot in older code bases (especially pre-7.0) and I just don't like it. It's too lengthy and awkward. 

```php
$year = isset($item['year']) ? $item['year'] : null; // null
```

**Option 2**

[Null coalescing operator](https://en.wikipedia.org/wiki/Null_coalescing_operator) (??). Way cleaner and much more elegant. PHP 7.0+.

```php
$year = $item['year'] ?? null; // null
```

**Option 3**

A more graceful approach with [error reporting suppression](https://www.php.net/manual/en/language.operators.errorcontrol.php). I haven't used PHP's `@` (error control) operator in a long time and had almost forgot about it. Frustrated with the verbosity of error handling in an older PHP project that did not have access to null coalesce, I discovered this much shorter syntax and it does exactly what I need.

If you want to assign anything but `null`, this method won't work, of course.

```php
$year = @$item['year']; // null
```

**NB** Test this well to ensure it works in your local and/or production environments. I haven't found any issues in any of mine, but *caveat emptor*. Also, if you have custom error handling/reporting in place, this might not work. Always test your code when trying this method!

**Bonus**

To expand on this, let's say I want to assign a default year, if the year in the input is not defined. Using the long form approach, I could do the following - and it's messy and hard to follow:

```php
$current_year = 2019;

$year = isset($item['year']) ? $item['year'] : (isset($year) ? $year : $current_year); // 2019
```

Using the error control operator it can be simplified to:

```php
$year = isset($item['year']) ? $item['year'] : @$current_year; // 2019
```

Or even further for PHP 7.0+:

```php
$year = $item['year'] ?? @$current_year; // 2019
```
