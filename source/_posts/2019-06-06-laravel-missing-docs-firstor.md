---
extends: _layouts.post
section: content
title: Laravel - The Missing Docs - firstOr()
date: 2019-06-06
description: Documenting the undocumented firstOr() Eloquent method.
categories: [Laravel]
featured: false
image: /assets/img/2019-06-06-laravel-missing-docs-firstor.png
image_thumb: /assets/img/2019-06-06-laravel-missing-docs-firstor.png
image_author:
image_author_url:
image_unsplash:
---

As wonderful as Laravel's documentation is, there are still plenty of undocumented features and hidden gems in the codebase. One of them is an Eloquent method called `firstOr()`.

It first came to my attention through this [tweet](https://twitter.com/codebyjeff/status/1130253186973888512/photo/1). It looked intriguing so I fell through the rabbit hole and did a little bit of my favorite new sport: source diving through Laravel's codebase.

## What does `firstOr()` do?

This method seems to have been introduced in Laravel 5.4 and it can be found in the Eloquent/Builder class `vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php`. It should look familiar because it is similar to sister methods such as `first()` and `firstOrFail()`. Unlike `firstOrFail()`, it executes a callback when it doesn't find a result, which can be a very powerful feature depending on your use case.

The **first** parameter is an array of columns that you wish to extract from your query (if it finds results). The **second** parameter is the callback I mentioned.

Let's see this in action. Here are a few examples I put together illustrating how you might use this.

## Fail with Response

```php
$r = App\User::where('id', 1)->firstOr(['name', 'email'], function () {
    return response()->json([
        'message' => 'This user does not exist.',
    ], 404);
});
```

```php
Illuminate\Http\JsonResponse {#3474
     +headers: Symfony\Component\HttpFoundation\ResponseHeaderBag {#3480},
     +original: [
       "message" => "This user does not exist.",
     ],
     +exception: null,
   }
```

## Fail with Exception

```php
$r = App\User::where('id', 1)->firstOr(['name', 'email'], function () {
    throw new \Exception('This user does not exist.');
});
```

```php
Exception {#3388
    #message: "This user does not exist",
    #file: "...\vendor\psy\psysh\src\ExecutionLoopClosure.php(55) : eval()'d code",
    #line: 2,
}
```

## Fail with Logger

```php
$r = App\User::where('id', 1)->firstOr(['name', 'email'], function () {
    logger('This user does not exist.');
});
```

Then in `laravel.log` you will see:

```bash
[2019-06-02 21:14:03] local.DEBUG: This user does not exist.
```

## Success

A successful query returns an Eloquent collection object.

```php
App\User {#3441
    name: "Mr. Leon Muller",
    email: "maiya57@example.net",
}
```

If you want the array representation, you can chain `toArray()`, of course:

```php
$r = App\User::where('id', 1)->firstOr(['name', 'email'], function () {
    throw new \Exception('This user does not exist.');
})->toArray();
```

But there is an alternative:

```php
$r = App\User::where('id', 1)->firstOr(function() {
    throw new \Exception('This user does not exist.');
})->only('name', 'email');
```

```php
// result
[
    "name" => "Mr. Leon Muller",
    "email" => "maiya57@example.net",
]
```

