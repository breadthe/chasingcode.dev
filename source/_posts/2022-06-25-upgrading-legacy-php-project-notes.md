---
extends: _layouts.post
section: content
title: Notes on Upgrading a Legacy PHP 5.X Project to a Modern Stack in 2022
date: 2022-06-25
description: Notes and observations about reviving an old PHP 5.X project and making it run on PHP 8.1
tags: [php]
featured: false
image: /assets/img/2020-11-03-bankalt.jpg
image_thumb: /assets/img/2020-11-03-bankalt-thumb.jpg
image_author:
image_author_url:
image_unsplash:
---

I talked before about [BankAlt.com](/blog/my-first-side-project/), the first side-project with dynamic PHP/MySQL functionality I ever shipped. In that article I expressed my desire to resurrect the legacy PHP 5.X project and make it run on PHP 8.1.

What follows is a list of notes I made while reviving BankAlt. It is by no means an exhaustive guide, rather a list of steps I took to declare myself satisfied with the outcome.

## The framework

BankAlt was created circa 2009 when it was still acceptable to roll your own framework. As a result, it is based on a PHP mini-framework someone at work had written. I simplified it even further since I didn't need all the features of the original.

The code is all procedural, which is fine for such a small project. It does not implement MVC.

## The stack

* Apache
* PHP 5.2 (or 5.3) - hard to tell exactly
* MySQL 5.1.20, with lots of stored procedures
* jQuery
* plain CSS
* hosted on a shared server run by a friend
* no SSL

## Revival goals

Why revive this project at all? Why not let it fade into memory? Nostalgia. BankAlt was a labor of love and very dear to me at the time. Besides, I was curious how much of a lift it would be to update it to a modern 2022 stack.

**Main goals:**

- run in a local environment on Nginx
- replace SVN with Git
- use Composer to manage dependencies
- get it working on PHP 8.1
- upgrade the database from MySQL 5.1 to 8
- refactor deprecated code + folder structure
- do NOT rewrite the code if I don't need to

**Bonus goals:**

- replace msqli with PDO
- use modern tooling to bundle JS + CSS
- replace jQuery with Alpine.js

**Super bonus goal** (that will likely never be attempted): rebuild it on Laravel with Livewire.

## Local environment setup

**Note** All my coding is done on a Mac, so if you're on a different platform this won't apply.

Since I'm already using [Valet](https://laravel.com/docs/9.x/valet#main-content) for my local environment, I wanted to use it for this as well. You can run pretty much any PHP project locally with it.

For the local database server I used [DBngin](https://dbngin.com/) running on localhost.

Valet uses Nginx as the webserver.

## Replace SVN with Git

Originally, I built BankAlt on a Windows machine. The code was versioned using SVN, specifically [TortoiseSVN](https://tortoisesvn.net/).

Before switching to Git, I wanted to get rid of all traces of SVN. To do this, I deleted all the `.svn` folders from the codebase. Unlike Git which creates a single `.git` file in the root of the project, SVN creates a `.svn` folder in each nested folder that is under version control.

Next, add the entire project to Git by running `git init`, followed by `git add . && git commit -m "init"`

Add a `.gitignore` file in the project root with the following contents:

```
.env
/vendor
/storage
```

* `.env` contains actual credentials, so it should never be under version control
* `vendor` is Composer's default package vendor location which, under 99.99% of situations, should not be version controlled
* `storage` in this case contains only one subfolder `logs` which should not be version controlled for obvious reasonss 

Push to GitHub.

Phew, now I can safely start slicing and dicing the codebase.

## Remove PHP closing tags

One of the first thing I did, just because it was griding my gears, was to remove all the PHP closing tags from the code. You see, back in the day it wasn't universally agreed upon whether to use the closing tags or not. So now I deleted all the `?>` tags and made sure every `.php` script ended in a blank line.

## Replace hardcoded DB credentials with .env file

Another big legacy *faux pas* was to hardcode the database credentials in the code AND VERSION CONTROL IT. So that had to be refactored pronto to a modern `.env` file.

First I tried to build my own `.env` parser. Very soon I realized that it's harder than it sounds, so I decided to use an off-the-shelf popular package called [vlucas/dotenv](https://github.com/vlucas/phpdotenv).

But wait, this requires Composer. Fast forward... After adding Composer:

```php
// call this after the autoloader
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
```

Now access `.env` variables from anywhere in the code with `$_ENV['DB_HOST']` etc.

I also added a `.env.example` file to the project root containing:

```
APP_NAME=BankAlt
APP_ENV=local
APP_DEBUG=true
APP_URL=https://bankalt-2022.test

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
```

Notice how it looks identical to a Laravel project. This is by intent.

## Add Composer

Run `composer init` in the project root.

Allow it to add PSR-4 autoloading from `src/`.

Originally the project had an entrypoint via `index.php` in the root, with logic inside `module` and `include` folders. I moved those two folders to `src`.

Add this line at the top of `index.php`:

```php
require __DIR__ . '/vendor/autoload.php';
```

Here's what `composer.json` looks like:

```json
{
    "name": "xxx/xxx",
    "description": "2022 edition of the original BankAlt.com code",
    "type": "project",
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    },
    "authors": [
        {
            "name": "xxx",
            "email": "xxx@xxx.xxx"
        }
    ],
    "require": {
        "vlucas/phpdotenv": "^5.4"
    }
}
```

## Use a Laravel-like directory structure

The original project structure was a bit archaic:

```bash
.svn
css
data
images
include
module
index.php
application.inc.php
```

I changed it to more closely resemble a Laravel project:

* Make `public` folder and move old `css`, `images`, `include/js` to it.
* Rename `images` to `img`. 
* Move the old `application.inc.php` (aka bootloader) to `src`.
* Move `include` folder to `src`.

The new structure looks like this:

```bash
.git
public
src
storage
vendor
.gitignore
.env
.env.example
composer.json
composer.lock
index.php
```

## Fix asset paths

Relocating the CSS + JS assets broke all the static links, so I had to search/replace the paths globally.

## Replace `define` constants with `const`

Read this [excellent explanation](https://stackoverflow.com/a/3193704) on why you might prefer `const` over `define`, especially in a modern codebase.

```php
define('_DIR_MODULE',	_DIR . 'module/');
// =>
const _DIR_INCLUDE = __DIR__ . '/include/';
```

## Restore DB, stored procedures, and one function

Thank goodness for keeping solid backups of ALL the data, including stored procedures! The zip archive contained the entire codebase, graphic assets, full database backups with the SQL tables, stored procedures, and functions, as well as raw design assets (PSD, etc) that should have lived elsewhere, but ultimately I was glad I had them all in one place.

The app is heavily reliant on stored procedures, 43 in fact. Those were the days when I preferred to put a lot of the business logic in stored procedures.

I created a new MySQL 8.1 database and restored from the backup easily. There were no issues restoring SQL exported from MySQL 5.1. I also removed unused stored procedures (present in the DB but not used in the code). Trimmed them down from 43 -> 16.

Later I realized that a stored procedure was also using a stored function. Running it gave a cryptic error.

```
This function has none of DETERMINISTIC, NO SQL, or READS SQL DATA in its declaration and binary logging is enabled (you *might* want to use the less safe log_bin_trust_function_creators variable)
```

A quick web-search later yielded these 2 solutions (I chose #1, as #2 appears to be less safe):

```sql
/* before */    
DELIMITER $$

CREATE FUNCTION `bla_bla`() RETURNS varchar(255) CHARSET utf8
-- function body


/* after - solution 1 */    
DELIMITER $$

CREATE FUNCTION `bla_bla`() RETURNS varchar(255) CHARSET utf8 DETERMINISTIC
-- function body

    
/* after - solution 2 */    
DELIMITER $$

SET GLOBAL log_bin_trust_function_creators = 1;

CREATE FUNCTION `bla_bla`() RETURNS varchar(255) CHARSET utf8
-- function body
```

## Add basic logging

With respect to keeping dependencies to a minimum I decided to throw together a quick logging class. I made it a singleton, and it does one thing only: appends a new line to the `error.log` file.

```php
namespace App;

/**
 * Barebones error logging class
 * 
 * Location: <project root>/src/Log.php
 * 
 * Usage: 
 * App\Log::error('Your error message');
 * 
 * Output (<project root>/storage/logs/error.log):
 * [2022-04-02 16:20:46] Your error message
 */
class Log
{
    private const PATH = __DIR__ . '/../storage/logs';
    private const FILENAME = 'error.log';

    private static self|null $singleton = null;

    protected function __construct()
    {
        self::createStorageFolderIfNotExists();
    }

    public static function singleton(): ?Log
    {
        if (self::$singleton === null) {
            self::$singleton = new self;
        }

        return self::$singleton;
    }

    public static function error(string $message): void
    {
        (new self)->writeError($message);
    }

    private static function createStorageFolderIfNotExists(): void
    {
        if (!file_exists(self::PATH)) {
            mkdir(self::PATH, 0755, true);
        }
    }

    private function writeError(string $message): void
    {
        $line = '['. self::timestamp() . '] ' . $message;
        $filename = self::PATH . DIRECTORY_SEPARATOR . self::FILENAME;
        file_put_contents($filename, $line, FILE_APPEND);
    }

    private static function timestamp(): string
    {
        return date('Y-m-d H:i:s');
    }
}
```

Feel free to use it in your own code. Here's the [gist](https://gist.github.com/breadthe/b8a7952bf2bbdf4f6df33ac75ec870f8).

## Fix more image links

Now that the stored procedures are in place more pieces of the site are beginning to work. The professions pages (containing datatables) work nicely but all the images are missing.

These come from JS/Ajax, so the src paths need to be updated in all the `.js` files. What used to be `/images/` is now `/img/`.  

## Fix `addslashes` deprecation... the lazy way

There was liberal usage of `addslashes($some_string_variable)` throughout the app (in ~100 places). Unfortunately I was getting *"Deprecated:  addslashes(): Passing null to parameter #1 ($string) of type string is deprecated"* errors in various places. I guess in PHP 5.X it wasn't a problem to pass `null` to this function, but 8.1 complains. 

Sometimes it's ok to be lazy to quickly fix or get around a problem. Instead of putting null checks in all 100 places I opted to create a similarly-named global function called `__addslashes` with built-in null checking. Then I did a global search-replace of all instances of `addslashes` with the new `__addslashes` function.

```php
function __addslashes(string|null $string): string
{
    return addslashes($string ?? '');
}
```

## Fix `preg_replace` deprecation

I came across a couple functions that were calling `preg_replace` without handling null strings. Quick fix here: typehint and initialize the parameter with empty string, and return early if null.

```php
// before
function blaBla($q)
{
    $patterns = [...];
    $replacements = [...];
    return preg_replace($patterns, $replacements, $q);
}

//after
function blaBla(string|null $q = '')
{
    if (!$q) return ''; // put this line at the top
 
    //...
}
```

## Admin section

Because it is hidden from the public, I had totally forgotten about the admin/CMS section. It has tooling for managing site content such as items, images, icons and a few other bits.

Part of its functionality depends on 3rd party sites (from where I scraped item icons for example), but those links are no longer valid. That's just fine, as this site will remain frozen in time and so will the admin section. 

## Other considerations & potential improvements

If this were an operational project, I would strongly consider the following:

- Replace `msqli` with `PDO`
- Make the DB connector class a singleton instead of instantiating it all over the place
- Bundle JS + CSS with a modern tool (such as Vite or Mix)
- Replace jQuery with [Alpine.js](alpinejs.dev/)
- Generate migrations for the DB tables
- Pull in a package that can execute DB migration
- Pull in a testing package and write some tests

## Even more improvements

One day when I'm very old and bored I might re-build BankAlt from scratch with Laravel/TALL stack, but for now the effort is not justified.

## Closing words

I went into this revival with general goals in mind but unsure what exactly to expect. I am very happy to have accomplished 80-90% of my goals in a couple of hours of surgical hacking.

Modernizing a 10-12 year old PHP codebase can be done in stages, starting with the lowest hanging fruit, and this is what I've done here. I employed Composer, limited dependencies to just one, and updated the project structure to match Laravel. The main goal was to load the project in a browser locally and be able to navigate all the pages without errors. This mission was accomplished successfully in less time than I had anticipated.

There's always more that could be improved, but I will hang my hat up here and call it a job well done. 