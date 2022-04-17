---
extends: _layouts.post
section: content
title: Carbon PHP Practical Examples
date: 2022-04-17
description: Carbon PHP library tips, tricks, shortcuts, utilities, patterns, and examples
categories: [PHP, Carbon, Laravel]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

I've been working and experimenting a lot lately with [Carbon](https://carbon.nesbot.com/), the sublime PHP date and time utility library. I've tweeted a lot of Carbon tips and decided to collect all these tips into a permanent article. 

## Laravel - Carbon\Carbon vs Illuminate\Support\Carbon

If you're using Laravel, Carbon is included in the framework by default. There are, however, two versions of it: `Carbon\Carbon` and `Illuminate\Support\Carbon`. Which one to use?

Based on my research, it appears that it's safe to use either. Personally I tend to use `Carbon\Carbon` because it looks cleaner when I import it. The `Illuminate` version is a wrapper around the official Carbon library, for backward/forward compatibility.

## Laravel - now() vs today()

Laravel offers several date/time shortcuts. The most commonly used are `now()` and `today()`.

```php
// Carbon\Carbon::now() vs now() -- they are functionally equivalent but...

Carbon\Carbon::now(); // returns an instance of Carbon\Carbon
now(); // returns an instance of Illuminate\Support\Carbon

Carbon\Carbon::today(); // returns an instance of Carbon\Carbon
today(); // returns an instance of Illuminate\Support\Carbon

// Difference between now() and today()

now(); // returns the full timestamp
// => Illuminate\Support\Carbon @1648647277 {#3867
//     date: 2022-03-30 13:34:37.437085 UTC (+00:00),
//   }

today(); // returns only the date part
// => Illuminate\Support\Carbon @1648598400 {#3870
//     date: 2022-03-30 00:00:00.0 UTC (+00:00),
//   }
```

## Timezone considerations

When working with any date/time helper, be aware that by default the result is always expressed in UTC (universal) time. UTC is the format most commonly used to  store timestamps in the database (with some exceptions).

As a consequence, using `now()` to retrieve a timestamp for a user who is not in the UTC timezone might give unwanted results.

One technique to show each user their local timezone is to:
- store the timestamp in UTC for each user record
- store the local timezone for each user (Example: `'America/Chicago'`)
- perform timezone conversion as shown below to display local time

```php
now(); // returns UTC time
// => Illuminate\Support\Carbon @1648647744 {#3864
//     date: 2022-03-30 13:42:24.742152 UTC (+00:00),
//   }

now()->setTimezone('America/Chicago'); // returns local time
now()->tz('America/Chicago'); // alias
now('America/Chicago'); // alias
// => Illuminate\Support\Carbon @1648647747 {#3865
//     date: 2022-03-30 08:42:27.037484 America/Chicago (-05:00),
//   }

today()->setTimezone('America/Chicago'); // returns local date
today()->tz('America/Chicago'); // alias
today('America/Chicago'); // alias
// => Illuminate\Support\Carbon @1648598400 {#3871
//     date: 2022-03-29 19:00:00.0 America/Chicago (-05:00),
//   }

now()->tz; // gets the current timezone
// => Carbon\CarbonTimeZone {#1112
//      timezone: UTC (+00:00),
//    }
now('America/Chicago')->tz;
// => Carbon\CarbonTimeZone {#1107
//      timezone: America/Chicago (-05:00),
//    }

// These are the same; all return "2022-03-30" UTC
date('Y-m-d'); // native PHP
now()->format('Y-m-d');
now()->toDateString(); // nice shortcut for the above
```

In Laravel Eloquent:

```php
$userId = 123;
$user = User::find($userId)->created_at;

```

## Start/end of week/month/year

Every developer will eventually need to calculate week/month/year boundaries (start/end dates). Carbon makes this easy.

**Note** Consider using timezone conversion, otherwise you might not get the desired result if the local time is only a few hours away from UTC. In other words, it might be "tomorrow" in UTC, but still "today" in local time.

```php
$today = Carbon\Carbon::now()->setTimezone('America/Chicago');
// => Carbon\Carbon @1649218375 {#1110
//      date: 2022-04-05 23:12:55.846210 America/Chicago (-05:00),
//    }

$startOfWeek = $today->startOfWeek()->toDateString(); // => "2022-04-04"
$endOfWeek = $today->endOfWeek()->toDateString(); // => "2022-04-10"

$startOfMonth = $today->startOfMonth()->toDateString(); // => "2022-04-01"
$endOfMonth = $today->endOfMonth()->toDateString(); // => "2022-04-30"

$startOfYear = $today->startOfYear()->toDateString(); // => "2022-01-01"
$endOfYear = $today->endOfYear()->toDateString(); // => "2022-12-31"
```

## First/last day of month using fluid string constructors

Carbon offers a neat way of building date/time objects. One of them is the fluid string constructor which lets you use natural English language to build your object.

```php
use Carbon\Carbon;

// today = 2022-04-07
// returns UTC DateTime object
// chain ->toDateString() to get only the date part
Carbon::make('first day of this month'); // 2022-04-01
Carbon::make('last day of this month'); // 2022-04-30

Carbon::make('first day of last month'); // 2022-03-01
Carbon::make('last day of last month'); // 2022-03-31

Carbon::make('first day of next month'); // 2022-05-01
Carbon::make('last day of next month'); // 2022-05-31
```

## Get total seconds in a string interval

This technique is extremely powerful for calculating total units for a specified interval.

Here's how I used it in a Laravel project. I'm tracking bicycle rides and each record in the database has a `INT duration` field in seconds. The user should be able to filter rides of a certain duration, using a user-friendly string like `1h30m`. I can use `CarbonInterval` to easily perform the conversion to seconds which I can then use to query the database.

```php
use Carbon\CarbonInterval;

// Several ways to initialize the interval:
CarbonInterval::fromString('1h30m')->total('minutes');
CarbonInterval::make('1h30m')->total('minutes');
CarbonInterval::make('1h30m')->totalMinutes;
// => 90

// Many ways to write the fluid string:
// '1h 30m'
// '1hour30minutes'
// '1 hour 30 minute'
// '1 hour 30 minutes'
// '1 hour and 30 minutes'

CarbonInterval::fromString('1h 30m')->total('seconds');
// 5400

// Also
$seconds = CarbonInterval::fromString('1hour30minutes')->total('seconds');
$seconds = CarbonInterval::fromString('1 hour 30 minutes')->total('seconds');
$seconds = CarbonInterval::fromString('1 hour and 30 minutes')->total('seconds');
$seconds = CarbonInterval::fromString('1 h 30 m')->total('seconds');
$seconds = CarbonInterval::fromString('1 h 30 m')->totalSeconds;
```

You can obtain the reverse as shown next. Note that the output string is not exactly the same as the input (I need to figure out if this is possible). More on `cascade()` in the next sections.

```php
use Carbon\CarbonInterval;

CarbonInterval::fromString('5400 seconds')->cascade()->forHumans(null, true);
CarbonInterval::fromString('5400seconds')->cascade()->forHumans(null, true);
CarbonInterval::fromString('5400s')->cascade()->forHumans(null, true);
// => "1h 30m"
```

Here are simplified examples of how you might use this with Laravel Eloquent.

```php
/**  
 * Laravel Eloquent examples
 * - The "1h30m" string may come from a user-friendly input
 * - The duration DB column is in seconds
 */
use Carbon\CarbonInterval;

// Retrieve all rides at least 1h30m long
$seconds = CarbonInterval::fromString('1h30m')->totalSeconds;
Rides::where(['user_id' => $user->id, ['duration', '>=', $seconds]])->get();

// Retrieve rides between 30m and 2h long
$minDuration = CarbonInterval::fromString('30m')->totalSeconds;
$maxDuration = CarbonInterval::fromString('2h')->totalSeconds;
Rides::where('user_id', $user->id)->whereBetween('duration', [$minDuration, $maxDuration])->get();
```

## CarbonInterval factor

One gotcha when using `CarbonInterval` factors is that it will return 336 days in a year instead of 365 as most of us are used to. Carbon's month also has 28 days. How is that?

```php
use Carbon\CarbonInterval;

// Retrieve the default factors for
CarbonInterval::getFactor('days', 'week'); // days in a week: 7
CarbonInterval::getFactor('weeks', 'month'); // weeks in a month: 4
CarbonInterval::getFactor('months', 'year'); // months in a year: 12

// => total days in a month = 7 * 4 = 28
CarbonInterval::getFactor('days', 'month'); // days in a month: 28

// => total days in a year = 7 * 4 * 12 = 336
CarbonInterval::getFactor('days', 'year'); // days in a year: 336
```

When you break it down like this it makes a lot of sense. There needs to be some consistency when doing date/time math and this is how Carbon achieves it. As a consequence, it might trip you up if you're not careful, as shown below. Luckily you can define your own interval factors:

```php
use Carbon\CarbonInterval;

CarbonInterval::fromString('1 year')->total('days'); // ❌ 336
CarbonInterval::fromString('1 year')->totalDays; // ❌ 336

// Find out how many days are defined per year by default
CarbonInterval::getFactor('days', 'year'); // 336

// Set your own
CarbonInterval::setCascadeFactors([
  'year' => [365,  'days']
]);

// Now you get the "real" number of days in a year
CarbonInterval::getFactor('days', 'year'); // ✅ 365
CarbonInterval::fromString('1 year')->totalDays; // ✅ 365
```
Cascade factor argument order is important - the last factor in the arguments array should be the one you need to operate on. Consider these two examples:

```php
CarbonInterval::setCascadeFactors([
  'month' => [30, 'days'],
  'year' => [365, 'days'],
]);
CarbonInterval::getFactor('days', 'year'); // ✅ 365
CarbonInterval::getFactor('days', 'month'); // ❌ 0
CarbonInterval::make('1 year')->totalDays; // ✅ success: 365
CarbonInterval::make('1 month')->totalDays; // ❌ failure: 0

CarbonInterval::setCascadeFactors([
  'year' => [365, 'days'],
  'month' => [30, 'days'],
]);
CarbonInterval::getFactor('days', 'year'); // ❌ 0
CarbonInterval::getFactor('days', 'month'); // ✅ 30
CarbonInterval::make('1 year')->totalDays; // ❌ failure: 0
CarbonInterval::make('1 month')->totalDays; // ✅ success: 30
```

## CarbonInterval cascade (sloppy interval conversion)

When working with `CarbonInterval` it is often useful to display the resulting string in a readable, consistent format. This is where `cascade()` comes in.

In the examples below, we are building a fluid string interval using simple English. If we pass a messy/sloppy string we get the same back, but wouldn't it be nice to automatically parse these units into something that makes more sense? The simplest example is `25h` to `1d 1h`. This is what cascade does.

A practical use-case can be collecting/collating different time interval units from various parts of the app or database, then transforming them into a consistent string for displaying to the end user.

```php
/**
 * CarbonInterval's cascade() method converts units
 * into the next one up, when they "spill" over.
 * This allows freeform fluid string conversion.
 */
use Carbon\CarbonInterval;

// Ugly and not very readable
CarbonInterval::fromString('13 months 36 days 56 hours')
    ->forHumans();
// => "13 months 5 weeks 1 day 56 hours"

// Let's cascade that into "standard" units
CarbonInterval::fromString('13 months 36 days 56 hours')
    ->cascade()
    ->forHumans();
// "1 year 2 months 1 week 3 days 8 hours"

// Let's get really sloppy
// The order of the units doesn't matter - same result
CarbonInterval::fromString('56 hours 36 days 13 months')
    ->cascade()
    ->forHumans();
// "1 year 2 months 1 week 3 days 8 hours"

// You can use shorthand for the constructor
CarbonInterval::fromString('25h')->cascade()->forHumans();
// => "1 day 1 hour"
```

## Carbon arithmetic - adding, subtracting time intervals

It's very easy to perform any kind of date/time arithmetic with Carbon. The API is so natural that you can simply guess it without referring to the documentation. A good IDE makes that even easier.

Furthermore, there are multiple ways of achieving the same result, including syntactic sugar for common operations such as `yesterday()` or `tomorrow()`. Units can also be specified in singular or plural.

```php
use Carbon\Carbon;

Carbon::today(); // 2022-04-12

// Add one or more days
Carbon::today()->addDay(); // 2022-04-13
Carbon::today()->addDays('1'); // 2022-04-13
Carbon::today()->add('1 day'); // 2022-04-13
Carbon::today()->add('1 days'); // 2022-04-13
Carbon::today()->add('5 day'); // 2022-04-17
Carbon::today()->addYear('2'); // 2024-04-12

// Subtract one or more days
Carbon::today()->subDay(); // 2022-04-11
Carbon::today()->subDays('1'); // 2022-04-11
Carbon::today()->subtract('1 day'); // 2022-04-11
Carbon::today()->sub('1 day'); // 2022-04-11
Carbon::today()->sub('1 days'); // 2022-04-11
Carbon::today()->sub('1 week'); // 2022-04-05
Carbon::today()->subMonth('2'); // 2022-02-12

// Use unit shorthand
Carbon::today()->add('1w'); // 2022-04-19
// Or a mix of units
Carbon::today()->sub('1w1d'); // 2022-04-04

// Easier shortcuts for adding/subtracting 1 day 😎
Carbon::tomorrow(); // 2022-04-13
Carbon::yesterday(); // 2022-04-11

// Don't forget timezone conversion
Carbon::today()->tz('America/Chicago')->add('1w'); // 2022-04-18 

// Timestamps work too
Carbon::now()->toDateTimeString();
// => "2022-04-12 02:50:24"
Carbon::now()->add('1h1m1s')->toDateTimeString();
// => "2022-04-12 03:51:25"

// Very small units (milliseconds/microseconds) also work (PHP 7.1+ for full microsecond support), although they are hard to capture
// Here's a way to test that by adding the equivalent of 1 second
dump([
  Carbon::now()->toDateTimeString(),
  Carbon::now()->add('1000ms')->toDateTimeString(),
]);
// => [
//      "2022-04-11 21:30:16",
//      "2022-04-11 21:30:17",
//    ]

dump([
  Carbon::now()->toDateTimeString(),
  Carbon::now()->add('1000000microsecond')->toDateTimeString(),
]);
// => [
//      "2022-04-12 02:41:11",
//      "2022-04-12 02:41:12",
//    ]
```

## Carbon vs CarbonImmutable

Both offer the same API, but when operated upon:

- Carbon - returns the same instance
- CarbonImmutable - returns a new instance with the new value.

When operating on Carbon instances, timestamps may get out of sync (drift) if you're not being careful. This can especially occur when chaining operations and assigning Carbon instances to multiple variables. Here's a practical example:

```php
// The problem - assigning a Carbon instance to a variable
$today = Carbon\Carbon::today(); // 2022-04-14

// As you pass around the same instance and apply operations to it, the initial timestamp gets mutated

$tomorrow = $today->addDay(); // ✅ 2022-04-15
$tomorrow = $today->addDay(); // ❌ 2022-04-16
$tomorrow = $today->addDay(); // ❌ 2022-04-17
$dayAfterTomorrow = $tomorrow->addDay(); // ❌ 2022-04-18

// $today is no longer "today"
echo $today->toDateString(); // ❌ "2022-04-18"
// $tomorrow is no longer "tomorrow" either
echo $tomorrow->toDateString(); // ❌ "2022-04-18"

// --------------------------------------

// The solution - prevent drift with CarbonImmutable
$today = Carbon\CarbonImmutable::today(); // 2022-04-14

// You can operate on the original instance as many times as you want...
// ... and it will remain the same
$tomorrow = $today->addDay(); // ✅ 2022-04-15
$tomorrow = $today->addDay(); // ✅ 2022-04-15
$tomorrow = $today->addDay(); // ✅ 2022-04-15
$dayAfterTomorrow = $tomorrow->addDay(); // ✅ 2022-04-16

// Now both $today and $tomorrow are correct
echo $today->toDateString(); // ✅ "2022-04-14"
echo $tomorrow->toDateString(); // ✅ "2022-04-15"
```

## Resources

A collection of Carbon-related resources from around the web.

- [Laravel Carbon Macros](https://github.com/dansoppelsa/laravel-carbon-macros)