---
extends: _layouts.post
section: content
title: How to Use MySQL CTE in Laravel to Group by Year and Month with Gaps
date: 2022-03-30
description: Group statistics with gaps by year-month using MySQL Common Table Expressions in Laravel
tags: [mysql, laravel]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

Following up on my previous article on [grouping data using MySQL Common Table Expressions](/blog/mysql-cte-group-by-year-month-with-gaps/), I am offering an implementation of the same technique in Laravel.

**Note** This requires MySQL v8.0+.

## Recap - The original Eloquent query

Grouping total distance by year-month (e.g. `2016-03`) for a specific bike is pretty straightforward...

```php
$ridesByYearMonth = 
    DB::table('rides')
        ->select(
            'start_date',
            DB::raw('SUM(distance) AS total_distance'),
        )
        ->where([
            'user_id' => $userId,
            'bike_id' => $bikeId,
        ])
        ->groupBy('start_date')
        ->orderBy('start_date')
        ->get();
```

... but it doesn't return gaps for months without rides.

## Option 1 - 📦 Use the staudenmeir/laravel-cte package

There's a Laravel package for everything, and CTEs are no exception. [laravel-cte](https://github.com/staudenmeir/laravel-cte) is a popular, well maintained package that offers an Eloquent-like syntax for Common Table Expressions across the most popular SQL databases.

Unfortunately I wasn't able to figure out how to use this package in the short time I dedicated to it. Here's an [article](https://johnathansmith.com/laravel-mysql-cte/) that might shed some light.

## Option 2 - 🧀 Cheese it with raw SQL

Personally I like to keep dependencies to a bare minimum. In this case, the same outcome can be achieved with raw SQL, though it won't look as clean as using the package. Here's how this looks in Laravel:

```php
$user_id = 1;
$bike_id = 100;
$bindings = [$user_id, $bike_id, $user_id, $bike_id, $user_id, $bike_id];

$query = "
WITH RECURSIVE dates (
	date
) AS (
	SELECT
		DATE(LAST_DAY(MIN(start_date)))
	FROM
		rides
	WHERE
		user_id = ?
		AND bike_id = ?
	UNION ALL
	SELECT
		DATE(LAST_DAY(date)) + INTERVAL 1 MONTH
	FROM
		dates
	WHERE
		DATE(LAST_DAY(date)) <= (
			SELECT
				DATE(MAX(start_date))
			FROM
				rides
			WHERE
				user_id = ?
				AND bike_id = ?)
)
SELECT
	DATE_FORMAT(date, '%Y-%m') AS 'year_month', COALESCE(total_distance, 0) AS total_distance
FROM
	dates
	LEFT JOIN (
		SELECT
			DATE_FORMAT(start_date, '%Y-%m') AS yearmonth,
			SUM(distance) AS total_distance
		FROM
			rides
		WHERE
			user_id = ?
			AND bike_id = ?
		GROUP BY
			DATE_FORMAT(start_date, '%Y-%m')
    ) AS rides ON DATE_FORMAT(date, '%Y-%m') = yearmonth;
";

$ridesByYearMonthArray = DB::connection()
    ->select($query, $bindings); // returns an array

$ridesByYearMonthCollection = collect($ridesByYearMonthArray); // cast to collection
```

I'm not very happy with how I pass the query bindings (same pair of ids repeated 3 times), but it does the job. You should also consider doing extra validation and casting on those bindings to prevent garbage data.

`DB::select(...)` also works.

## Conclusion

I hope Laravel will have first class support for Common Table Expressions at some point in the future, but for now these two techniques should suffice.

Thoughts and improvements? Hit me up on [Twitter](https://twitter.com/brbcoding).