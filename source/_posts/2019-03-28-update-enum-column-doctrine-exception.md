---
extends: _layouts.post
section: content
title: Update Enum Column Doctrine Exception in Laravel
date: 2019-03-28
description: Solving Doctrine exception when trying to update a table containing an enum column in Laravel.
categories: [Laravel]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

I have a predilection for using enum column types in my Laravel projects. I don't abuse them but I turn to them often when I have a well-defined range of possible values.

One of the disadvantages of using the `enum` column type in Laravel migrations - it turns out - is that you can't easily perform a migration on a table that contains an enum column. So it's not even a matter of *changing* the enum column itself, merely the presence of an enum column in a table will screw things up when trying to execute the migration.

In my scenario, I wanted to create a new migration in my Laravel 5.8 project to update a colum from `string` to `text`. The table in question contained an enum column.

When I ran the migration, I got the following error:

```
Doctrine\DBAL\DBALException  : Unknown database type enum requested, 
Doctrine\DBAL\Platforms\MySQL57Platform may not support it.
```

After some research I came upon [this answer](https://stackoverflow.com/questions/29165259/laravel-db-migration-renamecolumn-error-unknown-database-type-enum-requested) on Stack Overflow which clears things up a little.

[Laravel's documentation](https://laravel.com/docs/5.8/migrations#modifying-columns) does mention that in order to do this you first need to `composer require doctrine/dbal`.

Following that, my solution became this:

```php
?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWidgetNameWidgetsTable extends Migration
{
    public function up()
    {
        $this->registerEnumWithDoctrine();

        Schema::table('widgets', function (Blueprint $table) {
            $table->text('widget_name')->nullable()->change();
        });
    }

    public function down()
    {
        $this->registerEnumWithDoctrine();

        Schema::table('widgets', function (Blueprint $table) {
            $table->string('widget_name')->nullable()->change();
        });
    }

    private function registerEnumWithDoctrine()
    {
        DB::getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
    }
}
```

Basically you need to register and map the `enum` type to `string` with Doctrine, using this snippet:

```php
DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
``` 

Admittedly, the `registerEnumWithDoctrine` function should probably reside in the global scope but I think it's fine for the purpose of this example.
