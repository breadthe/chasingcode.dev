---
extends: _layouts.post
section: content
title: Refactor Laravel Eloquent Query Conditions to a Trait
date: 2022-06-08
description: A possible refactoring solution for Laravel Eloquent query conditions using PHP traits
tags: [php, laravel, livewire, eloquent]
featured: false
image: /assets/img/2022-06-08-refactor-code.jpg
image_thumb: /assets/img/2022-06-08-refactor-code-thumb.jpg
image_author: wombo.art
image_author_url: https://wombo.art
image_unsplash:
---

My recent [tweet on refactoring Laravel Eloquent query conditions to a trait](https://twitter.com/brbcoding/status/1534209246883192834) proved popular so here it is with a little more context, in permanent form.

## Intro

My biggest side-project at the moment ([NextBike](https://nextbike.mumu.pw)) is about visualizing cycling data from Strava's API. It's main feature is a searchable, filterable, sortable datatable of all your cycling activities.

This table currently has 18 filters, but it didn't start like that. At first it had 2, then I kept adding more, and I will likely add even more. The table is also a Livewire component containing most of the logic. It reached 500+ lines before I decided it was time to extract certain parts to slim it down and more easily locate the associated logic.

People on Twitter have asked *porque no* pipeline structure or custom query builder? Sure, why not. Traits are **one way** of refactoring it, and **likely not the best way**. It's what I like right now and what works for me.

**WARNING** NextBike is in beta, use at your risk. The UX is not fully fleshed out and may be confusing initially. Be aware that you can delete your account with all the data if you wish.

## The initial query

There's more detail here than in the tweet because I want to show more types of filters. All the datatable logic is contained within the `app/Http/Livewire/Rides.php` Livewire component.

```php
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Rides extends Component
{
    use WithPagination;

    const PER_PAGE = 20; // rides per page, this will become a configurable property later

    public $sortField = 'start_date';
    public $sortDirection = 'desc';

    // Filter properties
    public $year;
    public $bike;
    public $frame;
    public $stravaIds;

    // Provides the data for the table
    private function getRides(): LengthAwarePaginator
    {
        $rides = Ride::query()->with('bike')
            ->where(['user_id' => $this->userId])

            // filter YEAR
            ->when(
                $this->year && $this->year !== 'all',
                fn($query) => $query->whereRaw(
                    'YEAR(start_date_local) = ?', [$this->year]
                )
            )

            // filter BIKE
            ->when(
                $this->bike > 0 && $this->bike !== 'all',
                fn($query) => $query
                    ->has('bike')
                    ->where('bike_id', $this->bike)
            )

            // filter bike FRAME (on a relationship)
            ->when(
                $this->frame > 0 && $this->frame !== 'all',
                fn($query) => $query->whereHas('bike', fn($query) => $query->where('bikes.frame_type', $this->frame))
            )

            // filter STRAVA IDS (Example: 123456789,987654321)
            ->when(
                $this->stravaIds,
                fn($query) => $query->whereIn('id', Arr::map(explode(',', $this->stravaIds), fn($id) => trim($id)))
            )

            // + 14 other filters... this can get long

            // sort the results
            ->when(
                $this->sortField,
                fn($query) => $query
                    ->orderBy(
                        $this->sortField, $this->sortDirection
                    )
            );

        return $rides->paginate(self::PER_PAGE);
    }
}
```

## Refactoring to a trait

The reason I picked a trait and not something else is because, well, I just love traits in PHP. They are multipurpose by allowing not just multiple inheritance, but also providing a simple way to extract code and logic.

Now of course, there's the danger that one might get confused by properties and methods that don't seem to be defined in the class that imports a trait, but this can be inferred by checking which traits are imported, and/or by clicking through to the property or method definition in the IDE.

Laravel itself (and much of the ecosystem) makes heavy use of traits, and by giving them intuitive names makes it straightforward to understand their purpose. See for example the `Livewire\WithPagination` trait in the code example above.

To refactor, I've extracted the conditional `->when()` parts of the Eloquent query, the filtering logic, associated properties, and methods from `app/Http/Livewire/Rides.php` to `app/Http/Traits/Filters/WithFilters.php`.

```php
namespace App\Http\Livewire;

use App\Http\Traits\WithFilters;
use Livewire\Component;
use Livewire\WithPagination;

class Rides extends Component
{
    use WithPagination, WithFilters;

    const PER_PAGE = 20; // rides per page, this will become a configurable property later

    public $sortField = 'start_date';
    public $sortDirection = 'desc';

    private function getRides(): LengthAwarePaginator
    {
        $baseQuery = Ride::query()->with('bike')
            ->where(['user_id' => $this->userId]);

        $rides = $this->withFilters($baseQuery)

            // sort
            ->when(
                $this->sortField,
                fn($query) => $query
                    ->orderBy(
                        $this->sortField, $this->sortDirection
                    )
            );

        return $rides->paginate(self::PER_PAGE);
    }
}
```

And this is how the trait looks (showing only the method containing the Eloquent condition chain).

```php
namespace App\Http\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait WithFilters
{
    // Filter properties
    public $year;
    public $bike;
    public $frame;
    public $stravaIds;

    // Only 4/18 filters shown in this example
    private function withFilters(Builder $query): Builder
    {
        return $query

            // filter YEAR
            ->when(
                $this->year && $this->year !== 'all',
                fn($query) => $query->whereRaw(
                    'YEAR(start_date_local) = ?', [$this->year]
                )
            )

            // filter BIKE
            ->when(
                $this->bike > 0 && $this->bike !== 'all',
                fn($query) => $query
                    ->has('bike')
                    ->where('bike_id', $this->bike)
            )

            // filter bike FRAME (on a relationship)
            ->when(
                $this->frame > 0 && $this->frame !== 'all',
                fn($query) => $query->whereHas('bike', fn($query) => $query->where('bikes.frame_type', $this->frame))
            )

            // filter STRAVA IDS (Example: 123456789,987654321)
            ->when(
                $this->stravaIds,
                fn($query) => $query->whereIn('id', Arr::map(explode(',', $this->stravaIds), fn($id) => trim($id)))
            )

            // + 14 other filters...
            ;
    }
}
```

Note how the `withFilters()` method accepts and returns an Eloquent `Builder` instance, allowing it to be chained in the original/parent query. Incidentally I didn't specify the return type in the tweet screenshot.

So that's all there is to it. This pattern can be used to extract other things from a big Laravel Eloquent/DB query when it makes sense. Remember, it may not be the best method, but *it could be the best for you*.