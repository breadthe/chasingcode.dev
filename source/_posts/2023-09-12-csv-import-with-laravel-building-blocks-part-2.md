---
extends: _layouts.post
section: content
title: CSV import with Laravel building blocks - Part 2
date: 2023-09-12
description: Importing CSVs into a SQLite database with Laravel Prompts, spatie/laravel-data, and spatie/simple-excel, part 2.
categories: [Laravel]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/111058634121897287
---

**UPDATED September 13, 2023**

In [Part 1](/blog/csv-import-with-laravel-building-blocks-part-1/) I described the command I built with Laravel Prompts to import a CSV file into a SQLite database.

Now, I'll dive deeper into how I used [spatie/laravel-data](https://spatie.be/docs/laravel-data/v3/introduction) for the `ItemData` DTO, plus some custom data casts for the CSV columns.

## The Data Transfer Object

A DTO is a simple class that holds data. It's a great way to encapsulate data and pass it around the application.

Imagine receiving a CSV with inconsistent column data. Some columns could be empty, or contain data in a different format than my database likes. The `spatie/laravel-data` package helps with transforming and validating the data into a consistent format that I can then dump into the database.

For this application I needed a single DTO class which I created in `app/DataObjects/ItemData.php`

These are the contents of the class:

```php
namespace App\DataObjects;

use App\DataCasts\CommaSeparatedStringToArrayCast;
use App\DataCasts\DollarStringToIntCast;
use App\DataCasts\DateStringToCarbonImmutableCast;
use App\DataCasts\StringToNullCast;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class ItemData extends Data
{
    public function __construct(
        #[WithCast(DateStringToCarbonImmutableCast::class, 'm/d/Y')]
        public CarbonImmutable|null $received_on,
        #[WithCast(DateStringToCarbonImmutableCast::class, 'm/d/Y')]
        public CarbonImmutable|null $ordered_on,
        #[WithCast(StringToNullCast::class)]
        public string|null $brand,
        public string $model,
        #[WithCast(DollarStringToIntCast::class)]
        public int $price,
        public string $with_tax,
        #[WithCast(StringToNullCast::class)]
        public string|null $store,
        #[WithCast(CommaSeparatedStringToArrayCast::class)]
        public array $tags,
        public string $notes,
    ) {
    }
}
```

In [part 1](/blog/csv-import-with-laravel-building-blocks-part-1/) I was mapping each row of the CSV to a DTO like this (where `$rowProperties` is an array of column values):

```php
$itemData = ItemData::from($rowProperties);
```

The cool thing about this is that certain columns that I didn't want to include (like `days`, `years`, `months`, `age`) are automatically ignored, because they are not defined in the DTO.

## Data casts

The `spatie/laravel-data` package uses PHP attribute notation to apply custom casts to data properties. I'm not casting every column, just the ones that need to be transformed into a specific format.

Here's what each of my casts looks like. All casts are under `namespace App\DataCasts;`, and all import the `Spatie\LaravelData\Casts\Cast` interface, as well as the `Spatie\LaravelData\Support\DataProperty` class.

**DateStringToCarbonImmutableCast**

Transforms a "m/d/Y" string to a CarbonImmutable object, or null if empty.

```php
use Carbon\CarbonImmutable;

class DateStringToCarbonImmutableCast implements Cast
{
    private string $timezone = 'UTC'; // 'America/Chicago'

    public function __construct(
        protected ?string $format = null,
    ) {
    }

    public function cast(DataProperty $property, mixed $value, array $context): ?CarbonImmutable
    {
        if (! $value) return null;

        return CarbonImmutable::createFromFormat($this->format, $value, $this->timezone)->startOfDay();
    }
}
```

**StringToNullCast**

Casts empty strings to null (because I prefer a NULL in my DB column rather than an empty string).

```php
class StringToNullCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): string|null
    {
        return $value === '' ? null : $value;
    }
}
```

**DollarStringToIntCast**

Transforms a dollar string to cents as integer.

Example: `"$1,600.72"` becomes `160072`.

```php
class DollarStringToIntCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): int
    {
        return (int)((float)preg_replace('/[$,]/', '', $value) * 100);
    }
}
```

**CommaSeparatedStringToArrayCast**

Transforms a string of comma separated tags into an array of tags.

Example: `"bike, tool"` becomes `['bike', 'tool']`.

```php
class CommaSeparatedStringToArrayCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): array
    {
        return str($value)
            ->explode(',')
            ->map(fn($tag) => str($tag)->trim()->toString())
            ->filter()
            ->toArray();
    }
}
```

Once each CSV row has been transformed into a DTO, I can then save it to the database. The `saveItem` function won't have to worry about any of the data transformations, it only needs to save the object to the corresponding tables.

```php
$item = $this->saveItem($itemData);
```

Now the data is in the database, and I can use it to build the dashboard and other features. This, however, is outside the scope of this series.

## Conclusion

I've only scratched the surface of what's possible with `spatie/laravel-data`. DTOs may not make sense right away, but once they do you might find yourself reaching for the pattern more often than not.

Going back to the concept of building blocks, with Laravel you don't have to build everything from scratch. Not only does it come with its own robust (and ever-growing) set of building blocks, but the surrounding ecosystem is so vast and mature that you can find a package for almost anything. Quite often it's just a matter of gluing the right packages together with a sprinkle of custom code, and voilà, you have a functional MVP!

## And one more thing...

Here's a video from Laracon 2023 of Mr Spatie himself (Freek Van der Herten), showing off some advanced techniques using the `spatie/laravel-data` package.

<iframe width="656" height="369" src="https://www.youtube.com/embed/CrO_7Df1cBc" title="Freek Van Der Herten &quot;Enjoying Laravel Data&quot; - Laracon US 2023 Nashville" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>