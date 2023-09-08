---
extends: _layouts.post
section: content
title: CSV import with Laravel building blocks - Part 1
date: 2023-09-08
description: Importing CSVs into a SQLite database with Laravel Prompts, spatie/laravel-data, and spatie/simple-excel, part 1.
categories: [Laravel]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/111031677371344658
---

I've been hacking on a side project in Laravel that may never see the light of day, but I think it's worth talking about the building blocks I used for it. The core functionality revolves around importing data from a CSV (or XLS) file, transforming it into a [DTO](https://en.wikipedia.org/wiki/Data_transfer_object) (Data Transfer Object), and then saving it to a SQLite database.

For context, I've been tracking bigger personal expenses in a Google Sheet for many years. By "bigger expenses" I mean material things that tend to last for a while. For example a bike, a laptop, a phone, tools, a nice pair of shoes, etc.

I wanted more insight into my spending habits: tracking expenses across different categories (or tags as I think of them), brands, and time spans (yearly, monthly), plotting expense charts, and calculating the lifetime cost of a particular item.

These are all things that an Excel expert might accomplish easily, but my hammer of choice is Laravel, so that's what I used.

The good news is that it doesn't take a lot of work to glue these blocks together to get a command-line CSV import working. The hard part is building the UI for all the complex visualizations I want to do. This series, however, will focus strictly on the import process.

In Part 1 I want to describe the command I built with Laravel Prompts to import the CSV file.

## The building blocks

- Laravel 10
- SQLite
- [Laravel Prompts](https://laravel.com/docs/10.x/prompts)
- [spatie/laravel-data](https://spatie.be/docs/laravel-data/v3/introduction)
- [spatie/simple-excel](https://github.com/spatie/simple-excel)
- [Livewire 3](https://livewire.laravel.com/) for the UI
- [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#laravel-breeze) for authentication
- Tailwind CSS

## The CSV file

The CSV file I'm importing looks like this:

```
received_on,ordered_on,brand,model,days,years,months,days,age,price,with_tax,store,tags,notes
12/6/2020,,Keychron,K1 v4 87-key RGB Red switches wireless mechanical keyboard,989,2,8,18,2 years 8 months 18 days,$95.61,including tax,Amazon,,
1/11/2021,,Microsoft,Xbox Wireless Controller + USB-C cable,953,2,7,12,2 years 7 months 12 days,$53.11,including tax,Xbox store,computer,
3/8/2021,,Leatherman,Squirt PS4 Multi-Tool,897,2,5,16,2 years 5 months 16 days,$45.75,including tax,REI,"bike, tool",This is a note
```

Note that `days` , `years` , `months` , `age` are all calculated by a formula in the Google Sheet. I don't need them in my database, so I'm going to ignore them.

*But why don't you just connect directly to the Google Sheet?* you might ask. Well, mostly because I don't want to go through the hassle of setting up OAuth and all that. I just want to export the Google Sheet as a CSV file and import it. I don't need this data to be live, since I don't update the original Sheet very often.

## The import command

I decided to dump the CSV in `storage/app` and then my import command can find it there.

Run the command with `php artisan stuff:import`.

[Laravel Prompts](https://laravel.com/docs/10.x/prompts) was announced at this year's Laracon and I just had to use it. It gives the command line superpowers through enhanced interactivity.

Here's what the command looks like (imports omitted for brevity):

```php
class ImportCommand extends Command
{
    protected $signature = 'stuff:import';

    protected $description = 'Import from CSV or XLS';

    private ?int $userId = null; // User ID to import to
    private ?string $fileName = null; // File name (CSV/XLS) to import from

    public function handle(): int
    {
        $this->getUserId();

        $this->getFileName();

        $this->warn('Importing from "' . Storage::path($this->fileName) . '"');

        $rows = SimpleExcelReader::create(Storage::path($this->fileName))
            ->getRows()
            ->map(function (array $row) {
                unset($row['days']);
                unset($row['years']);
                unset($row['months']);
                unset($row['age']);
                return $row;
            });

        $bar = $this->output->createProgressBar();
        $bar->start();

        $rows->each(function (array $rowProperties) use ($bar) {
            try {
                $itemData = ItemData::from($rowProperties);

                $item = $this->saveItem($itemData);

                $bar->advance();
            } catch (CannotCreateData $e) {
                $this->error($e->getMessage());
                return;
            }
        });

        $bar->finish();

        DashboardDataService::bustCache($this->userId);

        return Command::SUCCESS;
    }

    private function getUserId(): void
    {
        //
    }

    private function getFileName(): void
    {
        //
    }

    private function saveItem(ItemData $itemData): Builder|Model
    {
        //
    }
}
```

First, I use `$this->getUserId()` to prompt for a user's email. I am the only user of this app, but I decided to make it support multiple users with authentication (via Breeze) from the start, just in case.

As you type, Prompts searches the database for a matching email and autocompletes it. It then returns the user's ID. It keeps prompting until a valid email is entered, or you hit "Ctrl+C" to exit.

![Using Prompts search to get the user's email](/assets/img/2023-09-08-import-command-1.png)

```php
private function getUserId(): void
{
    do {
        $userId = search(
            label:  'What is the user\'s email?',
            options: fn(string $value) => strlen($value) > 0
                ? User::where('email', 'like', "%{$value}%")->orderBy('email')->pluck('email', 'id')->all()
                : [],
            scroll: 10
        );

        $this->userId = (int)$userId;
    } while (User::query()->where('id', $this->userId)->doesntExist());
}
```

Once I have a user ID, I use `$this->getFileName()` to display a list of CSV/XLS files in the `storage/app` folder. In this case there's only one.

![Using Prompts search to show a list of CSV/XLS files](/assets/img/2023-09-08-import-command-2.png)

```php
private function getFileName(): void
{
    do {
        $this->fileName = select(
            label:   'Select file to import (<fg=white>CSV/XLS in storage/app</>)',
            options: array_values(preg_grep('/\.csv|\.xls$/', Storage::files())),
            scroll:  10
        );

        if (!$this->fileName) {
            $this->info('bye');
            exit;
        }
    } while (!Storage::exists($this->fileName));
}
```

Next, I use `SimpleExcelReader` to read the CSV file and return a collection of rows, which I map over to remove the columns I don't need.

I then start a progress bar and iterate over the rows, creating an `ItemData` DTO from each row, and then saving it to the SQLite database.

![Reading the CSV and saving the rows to the database](/assets/img/2023-09-08-import-command-3.png)

The `saveItem()` method is a bit messy, but it does exactly what I need it to: it saves the data to the related tables (`brands`, `stores`, `tags`, `items`), all inside a transaction.

I won't go into the details of the models and their relationships because it's outside the scope of this series, but it should also be fairly self-explanatory.

```php
private function saveItem(ItemData $itemData): Builder|Model
{
    DB::beginTransaction();

    $brand = null;
    if ($itemData->brand) {
        $brand = Brand::query()->updateOrCreate(
            [
                'user_id' => $this->userId,
                'name' => $itemData->brand,
            ],
            [
                'name' => $itemData->brand,
            ]
        );
    }

    $store = null;
    if ($itemData->store) {
        $store = Store::query()->updateOrCreate(
            [
                'user_id' => $this->userId,
                'name' => $itemData->store,
            ],
            [
                'name' => $itemData->store,
            ]
        );
    }

    $item = Item::query()->updateOrCreate(
        [
            'user_id' => $this->userId,
            'received_on' => $itemData->received_on,
            'ordered_on' => $itemData->ordered_on,
            'brand_id' => $brand?->getAttribute('id') ?? null,
            'model' => $itemData->model,
        ],
        [
            'price' => $itemData->price,
            'with_tax' => $itemData->with_tax,
            'store_id' => $store?->getAttribute('id') ?? null,
            'notes' => $itemData->notes,
        ]
    );

    foreach ($itemData->tags as $itemTag) {
        $tag = Tag::query()->updateOrCreate(
            [
                'user_id' => $this->userId,
                'name' => $itemTag,
            ],
            [
                'name' => $itemTag,
            ]
        );

        try {
            $item->tags()->attach($tag);
        } catch (\Exception $e) {
            // ignore exceptions if re-importing the same items
        }
    }

    DB::commit();

    return $item;
}

```

You might also notice this statement `DashboardDataService::bustCache($this->userId);`. I won't go into the inner workings, just know that all the data displayed on the user's dashboard is cached for performance (keyed by the user id), and the cache needs to be cleared every time new data is imported.

## Conclusion

If you're a seasoned (Laravel) developer you might be offended at the idea of building all the import logic in the import command itself. I agree that it's not ideal, but I don't care. There are a myriad ways to optimize this, but it's simply not worth it for a quick prototype where the bulk of the functionality lies in the UI.

That's it for Part 1. In Part 2 I'll dive deeper into how I used `spatie/laravel-data` to create the `ItemData` DTO as well as custom data casts that I used for some of the CSV columns.
