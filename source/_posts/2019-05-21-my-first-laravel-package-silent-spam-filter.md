---
extends: _layouts.post
section: content
title: My First Laravel Package - laravel-silent-spam-filter
date: 2019-05-21
description: I created my first open-source Laravel package and I couldn't be happier.
categories: [Laravel]
featured: false
image: /assets/img/2019-05-21-my-first-laravel-package-silent-spam-filter.png
image_thumb: /assets/img/2019-05-21-my-first-laravel-package-silent-spam-filter.png
image_author:
image_author_url:
image_unsplash:
---

I've wanted to contribute to open-source for a long time but getting started is always the hardest part. PHP package development is one of those areas that sounds simple on the surface but if you want to do it properly you'll realize that there are many subtle layers to it, making it easy to find excuses not to do it at all.

So when I heard that [Marcel Pociot](https://twitter.com/marcelpociot) (a prominent open-source contributor and Laravel expert) was working on a course on [PHP package development](https://phppackagedevelopment.com/) I knew it was going to be worth every penny. And no, in case you're wondering, he's not paying me to say this, I'm just very happy with his course.

Owning the tools is cool but putting them to work is another story. Luckily, one thing I don't lack is a shortage of ideas. Initially I had a more ambitious package in mind (which will probably be the next one I build) but the need arose for a reusable and configurable piece of Laravel code, and after a Sunday of on-and-off coding I produced what I'm about to describe.

## The TL;DR version

If you want to hear my rambling history of how this package came about, hang around. Otherwise, here's the short version of what it does.

[laravel-silent-spam-filter](https://github.com/breadthe/laravel-silent-spam-filter) does a very simple thing. It analyzes a string for certain keywords or phrases and returns `true` if it finds those words or `false` otherwise. Sounds useless but there's more depth to it.

First, the keywords are configurable in a config file. When you publish the package config, a file will be created under `config/silentspam.php` that comes pre-loaded with just 2 entries:

```php
return [
    'blacklist' => [
        '(beautiful|best|sexy) girls',
        'girls in your (city|town)',
    ],
];
```

You can replace these and/or add your own. In this example, if a string contains any combination of "beautiful girls" or "best girls" or "sexy girls" or "girls in your city" or "girls in your town", it will be marked as spam.

Thus, the second feature is that you can use regex patterns to filter spam.   

Third, you can use Laravel's facade to run the spam check, as shown below:

```php
SilentSpam::isSpam('Find sexy girls in your city'); // true
```

Finally, while the keywords in the config are global to the entire application, you can add additional keywords at runtime, before calling `isSpam`:

```php
SilentSpam::blacklist([
    'buy pills',
]);

SilentSpam::isSpam('Go to this site to buy pills'); // true
```

And if you feel lazy, there's also a `notSpam` command, which is exactly the opposite of `isSpam`.

```php
SilentSpam::notSpam('This is a normal message'); // true
```

## A spammy situation

One of my projects named [Sikrt](https://sikrt.com/) has apparently caught the attention of some spammers who've latched on to the public-facing contact form, despite being protected by Google's Recaptcha. I wasn't getting a lot of spam, but it was constantly trickling in, at a rate of 1-2 a day. Perhaps Recaptcha was actually doing its job, or else I would have been swamped? Who knows. The fact is that it still let some of it through.

Now, these spammers (bots really) operate under the premise that any public form might be attached to a commenting system or something similar (like on a blog for example). They'll fill in and submit the form with their garbage which almost always contains links to whatever they're trying to promote. Very often these messages will get passed through, ending up as "legit" content on that page. From there, Google will pick up the links, and a few visitors will click them. Sometimes the form contents are emailed to the site owner's address, from where additional mischief can occur.

Unfortunately for them, all my contact form does is save an entry in my database. I didn't build a more complex solution because I don't need it at the moment. I can check messages directly in the DB. So the spam doesn't end up anywhere productive. There's still the matter of clearing these out occasionally (as I said, the volume received is low).

I thought I would automate this clearing-out process without complex checks or third-party APIs.

But before that, I wanted to try yet another protection method: the honeypot. And what package would be better suited for this than one from Spatie (a heavy-duty Laravel contributor). I added [laravel-honeypot](https://github.com/spatie/laravel-honeypot) but unfortunately, just like Google Recapcha, it still lets some spam through. I was kinda expecting that. By now I would've thought that spammers have grown wise to this method and built smarter bots that can bypass it.

## The package idea

By analyzing the spam messages I had so far, I noticed some very obvious patterns and words that could be easily filtered by. It looks like all of it came from the same spamming "authority" so it was trivial to create a few very simple rules to handle those kinds of messages.

The way I decided to approach it was to simply not save anything in the database if it matched those patterns. The spammer would receive feedback that the form was submitted successfully, but the data would end up in a black hole.

Initially I built the pattern matching as a service in [Sikrt](https://sikrt.com/) itself, using TDD of course, but soon after launching it in production I decided it would make a great (if very basic) first package.

I wanted 2019 to be the year I released at least one open-source package and even though I had something more complex in mind, this was a great learning experience.

## Building the package

As I mentioned at the beginning, [PHP package development](https://phppackagedevelopment.com/) is amazing in guiding you step by step through the PHP package-building process, including Laravel-specifics. Hand-crafting still remains a little tedious, especially for someone who hasn't done this a hundred times before, but luckily the author has also built [Laravel Package Boilerplate](https://laravelpackageboilerplate.com/#/) which makes it trivial to scaffold the whole directory structure, along with all the bells and whistles he describes in the course.

Of course, as it oft happens in these pioneering moments, after moving my original logic to the package, I spent 3 hours trying to figure out why my tests were failing with a cryptic message, only to discover that I had the wrong namespace somewhere in my new code. Lesson learned.

My original spam filtering service worked something like this:

```php
use App\Services\SpamService;

// Silently reject spam messages
if ((new SpamService(config('spam.blacklist')))->notSpam(request('message'))) {
    // save the contact form data
}
```

My goal was to simplify the API by implicitly loading the blacklist from the config file, and also to be able to use Laravel's facade accessor. 

Converting the code was simply a matter of copy-pasting it from the original service to the new package structure, replacing the calls with the facade accessor and making sure the tests still worked. Which, until I discovered the elusive mangled namespace, they didn't.

Overall, the experience was smoother than expected. Back in my [Sikrt](https://sikrt.com/) project codebase, it was even more simple to `composer require breadthe/laravel-silent-spam-filter` and swap everything out. And the app continued to work perfectly.

 ## In conclusion
 
 The package may be very basic but it's my package and I'm proud of it. Building it allowed me not just to dip my toes in this exciting new world, but also opened my eyes to what the package-building process entails.
 
 You may ask why this is strictly a Laravel package. For one thing, I'm deeply embedded in the Laravel ecosystem and wouldn't have anything else at the moment. For another, as simple as it is, I don't think there would be much value in creating a general PHP package. After all, the core functionality is just a regex check. But if you are still upset about the Laravel exclusivity, you are always invited to [contribute](https://github.com/breadthe/laravel-silent-spam-filter/blob/master/CONTRIBUTING.md).

It's a bit of a drug. I'm already brainstorming what the next one should be.
