---
extends: _layouts.post
section: content
title: How to Use MySQL CTE to Group by Year and Month with Gaps
date: 2022-03-26
description: Group statistics with gaps by year-month using MySQL Common Table Expressions
categories: [MySQL]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

**Note** CTE (Common Table Expressions) are a MySQL feature since v8.0. Earlier versions won't be able to use this technique.

## Intro

My passion project these days is a Laravel app for cycling data from the [Strava](https://strava.com/) API.

I have a Charts section which plots ride distances for all or individual bikes on a bar chart, grouped by year or month.

## The problem

Notice how there should be gaps in the graph for months without rides for the selected filters (this particular bike), but the graph skips those.

![Month gaps in statistical data](/assets/img/2022-03-26-month-gaps.jpg "Month gaps in statistical data")

The SQL I'm using to generate the graph looks like this:

```sql
SELECT
	DATE_FORMAT(start_date, '%Y-%m') AS 'year_month',
	COALESCE(SUM(distance), 0) AS total_distance
FROM
	rides
WHERE
	user_id = XXX
	AND bike_id = YYY
GROUP BY
	DATE_FORMAT(start_date, '%Y-%m');
```

A typical record in the `rides` table looks like this (redacted for brevity):

```bash
id    user_id   bike_id   distance      start_date
123   XXX       YYY       26934.2000    2017-05-13 15:48:15
```

The partial result of the query is:

```bash
year_month  total_distance

2016-03	    35692.4000
2016-04	    390209.3000
2016-05	    71417.6000
# gap
2016-08	    88008.1000
2016-09	    88051.3000
# gap
2017-05	    51819.1000
# gap
2018-05	    25426.8000
2018-06	    205786.6000
2018-07	    66438.5000
2018-08	    150242.9000
# ...
2022-03	    428588.5000
```

Here's a [DB Fiddle](https://www.db-fiddle.com/f/5swkrL8pLteXFXYyV8xdRQ/0) of the initial implementation (works in MySQL < 8.0).

But what I want is:

```bash
year_month  total_distance

2016-03	    35692.4000
2016-04	    390209.3000
2016-05	    71417.6000
2016-06	    0.0000
2016-07	    0.0000
...
2016-08	    88008.1000
2016-09	    88051.3000
# and so on...
```

## The solution

I've been punting on fixing this for a long time, partially because I had bigger priorities and partially because I'm not a SQL expert who can find a solution in a few minutes.

Earlier in the week I saw this [tweet by Tobias Petry](https://twitter.com/tobias_petry/status/1506632076317138947) which shed light on the problem I was facing. This led me down the path of [MySQL 8.0 Common Table Expressions](https://dev.mysql.com/doc/refman/8.0/en/with.html).

Tobias' solution wasn't a drop-in replacement for my specific use-case. Most examples I found on the web deal with 1-day intervals. It seems that most people implementing this pattern need it to track visits on websites, counters, etc. For these you typically want daily intervals. In my case you can have 2-3 rides max in one day accumulating a number of miles/kilometers, so I'm more interested in longer mileage intervals to the order of weeks, months and years. 

So I spent a few hours tweaking various aspects of the CTE to fit my use-case. Here's what I came up with.

```sql
-- CTE start
WITH RECURSIVE dates (
	date
) AS (
	SELECT
		DATE(LAST_DAY(MIN(start_date)))
	FROM
		rides
	WHERE
		user_id = XXX
		AND bike_id = YYY
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
				user_id = XXX
				AND bike_id = YYY)
)
-- CTE end
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
			user_id = XXX
			AND bike_id = YYY
		GROUP BY
			DATE_FORMAT(start_date, '%Y-%m')
    ) AS rides ON DATE_FORMAT(date, '%Y-%m') = yearmonth;
```

I won't go over every line explaining what it does (read the MySQL docs for that), but essentially the recursive CTE generates an interval (monthly in this case) between the first and last recorded dates, then `LEFT JOIN`s it against the table we want to summarize. The `LEFT JOIN` ensures empty values are preserved in the results.

One interesting side effect of this approach is that the lower and upper bounds of the range will map directly to the timestamps of the first and last recorded rides resulting from the query. 

Here's a [DB Fiddle](https://www.db-fiddle.com/f/rxHqJEtQVqy6ydwL4UvPEw/2) of the CTE solution (MySQL 8.0+).

The result is what I was hoping to achieve 🎉

```bash
year_month	total_distance

2016-03	    35692.4000
2016-04	    105004.6000
2016-05	    71417.6000
2016-06	    0.0000
2016-07	    0.0000
2016-08	    88008.1000
```

And here's how the chart looks now.

![Month gaps displaying correctly with MySQL CTE](/assets/img/2022-03-26-month-gaps-fixed-mysql-cte.jpg "Month gaps displaying correctly with MySQL CTE")

## Additional reading

[Tobias Petry](https://twitter.com/tobias_petry) wrote a article about [filling gaps in statistical time series results](https://sqlfordevs.com/statistical-results-fill-gaps) with MySQL and PostgreSQL examples and a detailed explanation. He also recently launched a free ebook on [advanced databased techniques](https://sqlfordevs.com/ebook) which is a must-read.

## Caveats and conclusion

Not everything is perfect:

- It's probably **not** the **cleanest** or **most efficient** implementation. I will have to revisit it at some point in an attempt to extract additional performance from it. 
- It's **slower** than the original implementation (4-8ms vs 1-3ms for ~280 records when filtered by bike, or ~570 records for all bikes).
- Since the CTE is a **recursive query**, one needs to pay attention to the potential **number of iterations**. Exceeding the configured value will result in `Query 1 ERROR: Recursive query aborted after 1001 iterations. Try increasing @@cte_max_recursion_depth to a larger value.`. This error can be triggered by changing the interval from `1 MONTH` to `1 DAY`, for example.

All things considered, **it solves my problem** and the speed penalty is insignificant.

While I have vague apprehension about scaling for a large number of records, I am realistic to know that it's not an immediate concern. For one thing, not even professional cyclists would accumulate so many rides to trigger this error. For another, if I ever reach the point where this becomes an issue, it means I'm in an excellent situation (many users with lots of data is a good "problem" to have).

If you have ideas on how to improve it, hit me up on [Twitter](https://twitter.com/brbcoding) ideally with a [DB Fiddle](https://www.db-fiddle.com/) example.