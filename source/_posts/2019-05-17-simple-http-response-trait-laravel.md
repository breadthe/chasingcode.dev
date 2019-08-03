---
extends: _layouts.post
section: content
title: Simple HTTP Response Trait in Laravel
date: 2019-05-17
description: A very simple trait you can use to make your HTTP responses in Laravel less verbose.
categories: [Laravel]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

Building APIs in Laravel (or more generally in PHP) often implies responding with some sort of JSON data. The format of this data should ideally be standardized. I try to follow the [JSON API standard](https://jsonapi.org/) loosely, though I'm flexible on the exact implementation.

My personal flavor of this typically responds with something similar to this for a successful request:

```php
// Failed request
return response([
        'success' => true,
        'data' => $data,
        'message' => $message,
    ], 200);
``` 

Or for a failed request:

```php
// Failed request
return response([
        'success' => false,
        'message' => $message,
    ], 422);
``` 

**Note** The `422 Unprocessable Entity` status seems to be quite popular in the Laravel ecosystem so that's what I use for generic error codes.

Repeating the above snippets over and over for a myriad endpoints can get tedious, and is a good example of code that can be extracted into some sort of reusable entity.

## Traits to the rescue!

Traits hold a special place in my heart. I like how they can be used to handle multiple inheritance but also to share some similar piece of functionality across different classes.

I keep my traits in `app/Traits`, which is standard practice in a Laravel project. In this particular case I named my trait `RespondsWithHttpStatus` (yeah, I know, it's always hard to name things). And here's how such a trait might be constructed:

```php
trait RespondsWithHttpStatus
{
    protected function success($message, $data = [], $status = 200)
    {
        return response([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }
    
    protected function failure($message, $status = 422)
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
```

## Usage

You can import this trait into any class or method where you need to return an HTTP response.

```php
use App\Traits\RespondsWithHttpStatus;

class MyClass
{
    use RespondsWithHttpStatus;
    ...
```

**Respond with success**

```php
return $this->success(
    'Here is your data',
    [
        'field1' => 'Field 1 data',
        'field2' => 'Field 2 data',
    ]
);
```

**Response** `200 OK`

```json
{
  "success": true,
  "data": {
    "field1": "Field 1 data",
    "field2": "Field 2 data",
  },
  "message": ""
}
```

**Respond with failure**

```php
return $this->failure('Invalid token');
```

**Response** `422 Unprocessable Entity`

```json
{
    "success": false,
    "message": "Invalid token"
}
```

Right away you can tell that in most situations where I'm returning a standard successful `200` code or a generic error `422` code, there's a lot less boilerplate to deal with but there's always the option to return a different status code if required.

May the Trait be with you!
