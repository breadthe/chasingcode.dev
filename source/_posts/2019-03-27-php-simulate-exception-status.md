---
extends: _layouts.post
section: content
title: Simulate HTTP Exception Status
date: 2019-03-27
description: An easy way to generate an HTTP exception of a certain kind in PHP.
categories: [PHP]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

This may seem so obvious that I shouldn't be blogging about it but I'm doing it anyway.

I haven't really had to simulate a specific HTTP exception but recently I needed to create some custom 404, etc error pages in a Laravel project and I wanted to test that.

To make a short story long, there were 2 reasons for that. First, that project was upgraded to Laravel 5.8 which changes the default error screens for 403, 404, 500, and possibly others. Gone are the lovely Steve Schoger illustrations + "Go Home" button, to be replaced with a generic "404 Not Found" message and no link to go back to the home page. I don't want to rely on my users to figure out what to do in an error scenario so I built a few error pages with a proper link to the site root. Second, I wanted to extend the site's layout, to be able to have the app header and footer.

**Note** Laravel makes it easy to create custom error pages. Simply create a file named `404.blade.php` or equivalent, and place it in `views/errors`. 

To test the various error statuses, I used this nifty 1-liner to "simulate" the error, although that's a misnomer because it's actually throwing an error.

So in the controller that would return a view (any view for the purposes of testing this), instead of returning the view, use this instead (import at the top, of course):

```php
use Symfony\Component\HttpKernel\Exception\HttpException;
...

throw new HttpException(500);
```

When you load that view, you'll see the HTTP exception instead, which should load up the appropriate error page. Of course, this is not at all Laravel-specific.
