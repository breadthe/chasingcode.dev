---
extends: _layouts.post
section: content
title: Laravel Add & Remove URL Query Parameters Helpers
date: 2019-04-07
description: Simple helper functions that allow quick removal or addition of URL query parameters.
categories: [Laravel]
featured: false
image: https://source.unsplash.com/nXt5HtLmlgE/?fit=max&w=1350
image_thumb: https://source.unsplash.com/nXt5HtLmlgE/?fit=max&w=200&q=75
image_author: Kyle Glenn
image_author_url: https://unsplash.com/@kylejglenn
image_unsplash: true
---

## The problem

There are situations where I need to remove one or more query parameters from my app's URL, and then return the new URL. Similarly, I want to be able to add a new parameter easily. Furthermore, in my Laravel 5.8 app, I want to invoke these helpers from anywhere in my code, including Blade templates.

This type of scenario is very common in filtering (or faceting) data by various (URL) parameters.

## The solution

I made these two functions that do exactly that. Be aware that these are Laravel-specific (due to using the built-in `url()` helper) but they can be easily adapted to be framework-agnostic.

**Remove Parameters**

```php
/**
 * URL before:
 * https://example.com/orders/123?order=ABC009&status=shipped
 *
 * 1. remove_query_params(['status'])
 * 2. remove_query_params(['status', 'order'])
 *
 * URL after:
 * 1. https://example.com/orders/123?order=ABC009
 * 2. https://example.com/orders/123
 */
function remove_query_params(array $params = [])
{
    $url = url()->current(); // get the base URL - everything to the left of the "?"
    $query = request()->query(); // get the query parameters (what follows the "?")

    foreach($params as $param) {
        unset($query[$param]); // loop through the array of parameters we wish to remove and unset the parameter from the query array
    }

    return $query ? $url . '?' . http_build_query($query) : $url; // rebuild the URL with the remaining parameters, don't append the "?" if there aren't any query parameters left
}
```

**Add Parameters**

```php
/**
 * URL before:
 * https://example.com/orders/123?order=ABC009
 *
 * 1. add_query_params(['status' => 'shipped'])
 * 2. add_query_params(['status' => 'shipped', 'coupon' => 'CCC2019'])
 *
 * URL after:
 * 1. https://example.com/orders/123?order=ABC009&status=shipped
 * 2. https://example.com/orders/123?order=ABC009&status=shipped&coupon=CCC2019
 */
function add_query_params(array $params = [])
{
    $query = array_merge(
        request()->query(),
        $params
    ); // merge the existing query parameters with the ones we want to add

    return url()->current() . '?' . http_build_query($query); // rebuild the URL with the new parameters array
}
```

## Converting to global helpers

For my particular use-case, I needed to be able to use these functions either from a controller (or other class), or directly in a Blade template. Though some detest the idea of global functions, Laravel uses this pattern a lot and it does make it a lot easier to build features and get things done.

Based on this [StackOverflow answer](https://stackoverflow.com/a/28290359), one way of creating a global helpers file is to follow the following steps.

1. Create a `helpers.php` file (containing your functions) in the `bootstrap` folder.
2. Add it to `composer.json`
```json
"autoload": {
        "classmap": [
            ...
        ],
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "bootstrap/helpers.php"
        ]
}
```
3. Run `composer dump-autoload`.

Now your helpers should be available globally throughout your app.
