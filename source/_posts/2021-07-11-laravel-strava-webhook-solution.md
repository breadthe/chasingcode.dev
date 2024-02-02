---
extends: _layouts.post
section: content
title: A possible Laravel-Strava webhook solution
date: 2021-07-11
description: How to build a basic Strava webhook with Laravel.
tags: [laravel,strava]
featured: false
image: https://source.unsplash.com/6sB8gMRlEAU/?fit=max&w=1350
image_thumb: https://source.unsplash.com/6sB8gMRlEAU/?fit=max&w=200&q=75
image_author: Steve Johnson
image_author_url: https://unsplash.com/@steve_j
image_unsplash: true
---

## The need for webhooks

When building an app around [Strava's API](https://developers.strava.com/), webhooks become critical, first to avoid unnecessarily polling the API, and second to enable automatic updates for activities and user profile.

The latter is particularly important in order to abide by Strava's terms & conditions. [Quote](https://developers.strava.com/docs/getting-started/#webhooks): *"Per our API terms, you need to implement webhooks to know when an athlete has deauthorized your API application"*.

## Preamble

At the moment, the most popular Laravel Strava package is [https://github.com/RichieMcMullen/laravel-strava](https://github.com/RichieMcMullen/laravel-strava). I have contributed to it previously, in order to further development of my own app.

The package, however, does not have webhook support. I am considering contributing to that, but it's a double-edged sword. Between the design difficulties and the maintenance burden, I'm not sure I want to take on that responsibility.

So in the meantime I hacked together some fairly decent, but basic, webhook functionality directly inside my Laravel 8 app.

## Basic design considerations

Parsing [Strava's webhook docs](https://developers.strava.com/docs/webhooks/), the basic idea is that an app can subscribe to Strava webhooks, and also unsubscribe from it later. While subscribed, any athlete or activity event triggers an event that gets pushed to the app. The app must be previously authorized from within the Strava web UI.

For example, I finish a bicycle ride and save it on my Garmin device, which pushes it to Strava, which in turn fires off a `create` event for a new `activity`.

Unfortunately, that's all it does - it doesn't send any activity data, so the developer would need to make an additional request. This additional request can be done with the [laravel-strava](https://github.com/RichieMcMullen/laravel-strava) package.

Here's how the communication flow looks like:

- App → Strava: subscribe
- Strava → App: verify (needs GET route)
- App: subscribed
- Strava → App: event (needs POST route)
- App: view subscription
- App: unsubscribe

I'll go over each in detail. For now, here's a top-level view of how I designed this feature. *Keep in mind that I am not overly concerned with best practices, testing, etc*. It's all experimental at this point, and made for my own needs, however you can use it as a starting point for your own projects.

I built this inside my existing Laravel 8 app in 4 main components:

- A webhook service (class) registered as a singleton in the `app` container.
- A series of `artisan` commands that I can use to quickly subscribe/view/unsubscribe from the command line.
- A couple of `GET/POST webhook` routes in `routes/web.php`.
- A handful of configuration/environment keys.

Let's dig into the details.

## The Strava webhook service

The service class lives in `app/Services/StravaWebhookService.php`. It contains methods for making/processing outbound/incoming Strava HTTP requests.

Here's the skeleton (leaving out method implementation for later).

```php
<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class StravaWebhookService
{
    private string $client_id;
    private string $client_secret;
    private string $url;
    private string $callback_url;
    private string $verify_token;

    public function __construct()
    {
        $this->client_id = config('ct_strava.client_id');
        $this->client_secret = config('ct_strava.client_secret');
        $this->url = config('services.strava.push_subscriptions_url');
        $this->callback_url = config('services.strava.webhook_callback_url');
        $this->verify_token = config('services.strava.webhook_verify_token');
    }

    public function subscribe(): int|null
    {
        //
    }

    public function unsubscribe(): bool
    {
        //
    }

    public function view(): int|null
    {
        //
    }

    public function validate(string $mode, string $token, string $challenge): Response|JsonResponse
    {
        //
    }
}
```

**Note** If I had done this "by the book" (protip: there is no such thing in programming, don't let anyone tell you that), I might have implemented a more generic interface, say `WebhookServiceInterface`. Since I only care about a single webhook service for the foreseeable future - and since my app is all about Strava - I don't need the additional complexity at this point.

The constructor is pretty straightforward; it simply assigns a bunch of configuration options.

Config keys prefixed with `ct_strava` come from `config/ct_strava.php` which is the config for [laravel-strava](https://github.com/RichieMcMullen/laravel-strava). Read the docs to see how it works. *This package is pretty much a requirement for my implementation of Strava webhooks.* 

Keys prefixed with `services.strava.` are my own webhook-specific configuration. Here's how to configure them:

**`config/services.php`** - webhook service config

```php
return [
    // ...

    'strava' => [
       'push_subscriptions_url' => env('STRAVA_PUSH_SUBSCRIPTIONS_URL'),
       'webhook_callback_url' => env('STRAVA_WEBHOOK_CALLBACK_URL'),
       'webhook_verify_token' => env('STRAVA_WEBHOOK_VERIFY_TOKEN'),
    ],
];
```

**`.env`** - application config

```php
#...
STRAVA_PUSH_SUBSCRIPTIONS_URL="https://www.strava.com/api/v3/push_subscriptions"

# The app webhook callback URL that Strava uses to fire GET/POST events
STRAVA_WEBHOOK_CALLBACK_URL="https://www.yoursite.com/webhook"

# A random string generated by my app that Strava uses to verify the request
STRAVA_WEBHOOK_VERIFY_TOKEN=ABC123defXYZ4567
```

A word about the verify token. This is a string (preferably random) that you will have to generate somehow. There are many ways to do it. I chose to do it the lazy way, by running `Str::random();` once, and dumping the result in `.env`. It's probably worth regenerating this token every once in a while in case it gets leaked on Strava's side somehow. If your `.env` file gets hacked, you have bigger problems to worry about. I'm fine with the way it works now.

## Register the service as a singleton

Now that the service skeleton is ready, let's take a detour and bind it to the Laravel app container as a singleton. Why a singleton? Because we want this to be instantiated only once throughout the app's lifecycle. Quoting from the [Strava webhook docs](https://developers.strava.com/docs/webhooks/) *"Each application may only have one subscription"*.

To bind the service, open `app/Providers/AppServiceProvider.php` and add the following:

```php
use App\Services\StravaWebhookService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(StravaWebhookService::class, function ($app) {
            return new StravaWebhookService();
        });
    }

    // ...
}
```

This allows us to call the methods on the singleton from anywhere on the app, without needing to instantiate it. For example:

```php
$id = app(StravaWebhookService::class)->subscribe();
```

## The `subscribe()` method

I'll preface this by saying that I don't like to return mixed types. Here I'm returning a subscription id as an integer, or null for any other reason. Ideally I would return an object with additional information, such as response status and errors. For what I need, this does the job.

To subscribe to Strava's webhooks, my app needs to `POST` the following data. If successful, Strava will respond with a JSON string in the form of `"{"id": 1234}"`. You can use this id to store it in the DB if you want to keep track of it, but I'm not doing that.

```php
public function subscribe(): int|null
{
    $response = Http::post($this->url, [
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
        'callback_url' => $this->callback_url,
        'verify_token' => $this->verify_token,
    ]);

    if ($response->status() === Response::HTTP_CREATED) {
        return json_decode($response->body())->id;
    }

    return null;
}
```

## The `validate()` method

This is translated to Laravel/PHP from the Node example in the [docs webhook example](https://developers.strava.com/docs/webhookexample/).

It runs when Strava makes a `GET` request to my app's webhook callback. For example: `GET https://www.yoursite.com/webhook?hub.verify_token=RANDOMSTRING&hub.challenge=15f7d1a91c1f40f8a748fd134752feb3&hub.mode=subscribe`.

If successful, this method responds with a JSON object containing the Strava challenge string. For example: `{"hub.challenge": "15f7d1a91c1f40f8a748fd134752feb3"}`. If it fails for any reason, it returns `403 Forbidden`.

```php
public function validate(string $mode, string $token, string $challenge): Response|JsonResponse
{
    // Checks if a token and mode is in the query string of the request
    if ($mode && $token) {
        // Verifies that the mode and token sent are valid
        if ($mode === 'subscribe' && $token === $this->verify_token) {
            // Responds with the challenge token from the request
            return response()->json(['hub.challenge' => $challenge]);
        } else {
            // Responds with '403 Forbidden' if verify tokens do not match
            return response('', Response::HTTP_FORBIDDEN);
        }
    }

    return response('', Response::HTTP_FORBIDDEN);
}
```

## The `view()` method

This utility method is useful to check the status of a subscription. Once again, it returns mixed types.

If there's a valid subscription, it returns an integer id. Otherwise, it returns null.

As with the `subscribe()` method, this could be improved by returning an object with more context. It's good enough for what I need.

```php
public function view(): int|null
{
    $response = Http::get($this->url, [
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
    ]);

    if ($response->status() === Response::HTTP_OK) {
        $body = json_decode($response->body());

        if ($body) {
            return $body[0]->id; // each application can have only 1 subscription
        } else {
            return null; // no subscription found
        }
    }

    return null;
}
```

## The `unsubscribe()` method

Unsubscribing from the Strava webhooks will delete the subscription, and disconnect the app from receiving additional push notifications.

It has 2 parts:

- first, it calls the `view()` method on the singleton to check if there's an active subscription. This will return the subscription id, with the advantage that we don't have to store it on the app side.
- second, it sends a `DELETE` request with the id in the URL.

This method has only 2 possible outcomes: either the entire operation succeeded, or it failed.

```php
public function unsubscribe(): bool
{
    $id = app(StravaWebhookService::class)->view(); // use the singleton

    if (!$id) {
        return false;
    }

    $response = Http::delete("$this->url/$id", [
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
    ]);

    if ($response->status() === Response::HTTP_NO_CONTENT) {
        return true;
    }

    return false;
}
```

## The web routes

**`GET /webhook` callback**

This is the callback used by Strava to validate the subscription request. As explained earlier, Strava will send a `GET https://www.yoursite.com/webhook?hub.verify_token=RANDOMSTRING&hub.challenge=15f7d1a91c1f40f8a748fd134752feb3&hub.mode=subscribe` request that my app needs to handle.

All the work can be done directly in the route callback method by returning the singleton `validate` method with the request parameters.

**Note** Query string parameters in the form of `hub.verify_token=RANDOMSTRING` are parsed by Laravel like this `$request->query('hub_verify_token')` (underscore replaces period).

```php
Route::get('/webhook', function (Request $request) {
    $mode = $request->query('hub_mode'); // hub.mode
    $token = $request->query('hub_verify_token'); // hub.verify_token
    $challenge = $request->query('hub_challenge'); // hub.challenge

    return app(StravaWebhookService::class)->validate($mode, $token, $challenge);
});
```

**`POST /webhook` callback**

Whenever there's an event, Strava will fire a `POST /webhook` request with the following data.

The app needs respond with `200 OK` within 2s, otherwise Strava will retry 3 more times before it stops.

```php
Route::post('/webhook', function (Request $request) {
    $aspect_type = $request['aspect_type']; // "create" | "update" | "delete"
    $event_time = $request['event_time']; // time the event occurred
    $object_id = $request['object_id']; // activity ID | athlete ID
    $object_type = $request['object_type']; // "activity" | "athlete"
    $owner_id = $request['owner_id']; // athlete ID
    $subscription_id = $request['subscription_id']; // push subscription ID receiving the event
    $updates = $request['updates']; // activity update: {"title" | "type" | "private": true/false} ; app deauthorization: {"authorized": false}

    Log::channel('strava')->info(json_encode($request->all()));

    return response('EVENT_RECEIVED', Response::HTTP_OK);
})->withoutMiddleware(VerifyCsrfToken::class);
```

Notice that at this point I'm simply logging the payload, so that I can parse it later and figure out how to handle it.

Also notice the quick'n'lazy way of disabling CSRF token checking. By default, Laravel will require a CSRF token from any POST request, which is not needed in this situation. I could have created a separate middleware for webhooks, but it's a lot quicker to do it inline for the single endpoint. 

## The artisan commands

To make it easy to subscribe/view/unsubscribe, I created 3 very basic artisan commands as follows:

**`app/Console/Commands/SubscribeToStravaWebhookCommand.php`**

Run as: `php artisan strava:subscribe`

```php
<?php

namespace App\Console\Commands;

use App\Services\StravaWebhookService;
use Illuminate\Console\Command;

class SubscribeToStravaWebhookCommand extends Command
{
    protected $signature = 'strava:subscribe';

    protected $description = 'Subscribes to a Strava webhook';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = app(StravaWebhookService::class)->subscribe();

        if ($id) {
            $this->info("Successfully subscribed ID: {$id}");
        } else {
            $this->warn('Unable to subscribe');
        }

        return 0;
    }
}
```

**`app/Console/Commands/ViewStravaWebhookCommand.php`**

Run as: `php artisan strava:view-subscription`

```php
<?php

namespace App\Console\Commands;

use App\Services\StravaWebhookService;
use Illuminate\Console\Command;

class ViewStravaWebhookCommand extends Command
{
    protected $signature = 'strava:view-subscription';

    protected $description = 'Views a Strava webhook subscription';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = app(StravaWebhookService::class)->view();

        if ($id) {
            $this->info("Subscription ID: $id");
        } else {
            $this->warn('Error or no subscription found');
        }

        return 0;
    }
}
```

**`app/Console/Commands/UnsubscribeStravaWebhookCommand.php`**

Run as: `php artisan strava:unsubscribe`

```php
<?php

namespace App\Console\Commands;

use App\Services\StravaWebhookService;
use Illuminate\Console\Command;

class UnsubscribeStravaWebhookCommand extends Command
{
    protected $signature = 'strava:unsubscribe';

    protected $description = 'Deletes a Strava webhook subscription';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (app(StravaWebhookService::class)->unsubscribe()) {
            $this->info("Successfully unsubscribed");
        } else {
            $this->warn('Error or no subscription found');
        }

        return 0;
    }
}
```

## Putting it all together

You can find all the pieces assembled in this [Gist](https://gist.github.com/breadthe/2787c4f6d6ac805ef9eb698a91b6a750). If you look closely, you'll notice some additional logging in the service methods, in lieu of returning explicit errors.

## Next steps

The goal of this project was to complete the Strava webhook subscription flow, without overengineering it. I have achieved that successfully, with a little extra polish that I hadn't planned on initially. This code is now running in production, with an active webhook subscription that accepts Strava events, and logs them for analysis.

To actually make use of the event data I'm collecting, I need to do more work. Here are some of the things that I would like to eventually accomplish using the foundation I've established.  

- use the webhook to make requests for activity & athlete information
- use the webhook to disconnect the app if the user de-authorizes it
- improve some of the coding & design shortcuts/liberties taken above
- schedule a periodic check to see if the subscription is active, and renew it if not
- integrate it into the [laravel-strava](https://github.com/RichieMcMullen/laravel-strava/) package

I consider the last point to be quite important for the Laravel-Strava dev community at large. It is a long term goal of mine to eventually have all the Laravel-Strava API+webhook functionality in one package. There are a few caveats, though.

For one thing, the author of the package is not very active - understandably so! It is a huge responsibility to maintain a popular package, and it can become a burden if you're not actively vested in. If I were to get this functionality merged in, it would become my responsibility, at least partly.

For another, I'm having constant doubts about the API for this kind of functionality. What works for me may not work for others, and I'm not keen on endless debates or covering every possible scenario/use-case.

I have the option of building it into my own fork [breadthe/laravel-strava](https://github.com/breadthe/laravel-strava), so keep an eye on that in case you're interested.

Hopefully this was a helpful explanation of how I implemented Strava webhooks in my Laravel app. Feel free to use the code in any way you see fit, and hit me up on [Twitter](https://twitter.com/brbcoding) for ideas or suggestions.