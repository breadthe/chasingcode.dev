---
extends: _layouts.post
section: content
title: The ultimate PHP RSS feed parser library
date: 2024-03-23
updated:
description: This is the best PHP library for parsing RSS and Atom feeds
tags: [php,rss]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url:
---

The quest is over - I have found the perfect PHP library for parsing RSS and Atom feeds. I present you [SimplePie](http://simplepie.org/).

My 2024 side project is a browser-based RSS reader/aggregator. This post isn't about why I'm building something that already exists in countless forms. Suffice to say that, with the ongoing [enshittification](https://en.wikipedia.org/wiki/Enshittification) of the web, I strongly believe we should take back control of our data.

The core of an RSS reader is a reliable parser. Unfortunately, parsing XML is hard. RSS/Atom feeds aren't much easier to parse either, mostly because there are many different versions and standards for each but worst of all, the web is rife with feeds that don't conform to any standard or are broken.

I am not interested in building a feed parser. My goal is to build the experience - the functionality, the aggregation logic, the UX. My app is Laravel (PHP), so one of the first steps was to search for a pre-built open-source feed parsing library. Tough quest.

After going on the wrong track with a different library (that shall not be named because it's somewhat decent and a lot of work went into it), I came across [SimplePie](http://simplepie.org/).

At first glance, it's easy to discount SimplePie. After all, the website looks like it's frozen in the early 00s and the docs mention *downloading* the library. I mean, ugh, right? I don't mean to sound elitist because I hold a lot of nostalgia for that era, but we've long since moved on from that age with modern [composer](https://getcomposer.org/).

SimplePie does have its own website, so I took the time to read about its features and dig through the docs. The [public repo is on GitHub](https://github.com/simplepie/simplepie).

## Interesting facts

I found out that:

- it has been around for 20 years!
- it has been using composer for [12 years](https://github.com/simplepie/simplepie/commit/6bd35fa3b4a08a2421e99aea4f1c18c9329b1a0c)!
- it handles all kinds of feeds (even somewhat-broken ones) like a champ.
- the docs on the website stop at v1.3, yet the latest version on GitHub is v1.8.
- the latest version has lax requirements (PHP >= 7.2).
- it is still actively maintained (the latest commits are from a few months ago).
- it's got way more features than I currently need.
- the license is very permissive ([BSD-3](https://opensource.org/license/BSD-3-Clause)).

## Quirks and gotchas

- the website isn't very well maintained. Hell, it doesn't even run on HTTPS. I'm not holding this against the authors because I know how thankless open-source development is. Kudos to them for having a website in the first place and maintaining this project for so many years ❤️
- the [docs](http://simplepie.org/api/class-SimplePie.html) are very disorganized and old-school-like, yet thorough, and the API is documented in great detail.
- there are multiple 1000+ line classes, with the [main class](https://github.com/teamzac/larapie/blob/master/src/Feed.php) at 3000+ lines. I love it though, bring back the old web 🤘
- it's not immediately obvious how to use it; nothing that some [source-diving](https://github.com/simplepie/simplepie/blob/master/tests/SubscribeUrlTest.php) and careful parsing of the docs can't fix.

## Usage example

Here's a simple method that I added to a `Feed` model to get the data I need from an RSS/Atom feed url: basic feed metadata + feed items which I then dump into my database.

```php
public function fetch(): void
{
	$pie = new SimplePie;

	// I may decide to enable this later, for now it's fine the way it is
	$pie->enable_cache(false);

	// the original feed URL that I want to retrieve
	$pie->set_feed_url($this->link);

	if ($pie->init()) {
		$this->title = $pie->get_title();
		$this->description = $pie->get_description();
		$this->last_fetched_at = now();
		$this->link = $pie->subscribe_url(); // can be different than the original feed URL
		$this->site_link = $pie->get_base();

		$feed_items = [];

		foreach ($pie->get_items() as $item) {
			$feed_items[] = [
				'title' => $item->get_title(),
				'link' => $item->get_permalink(),
				'description' => $item->get_description(),
				'author' => $item->get_author()->name,
				'guid' => $item->get_id(),
				'published_date' => $item->get_date(),
				'updated_date' => $item->get_updated_date(),
			];
		}
		$this->feed_items = $feed_items;

		$this->save();
	}
}
```

## Bonus - Quick peek

Here's a bonus preview of a very early prototype for the RSS reader I'm working on. Made with Laravel + Livewire, and of course SimplePie.

![RSS reader early prototype](/assets/img/2024-03-23-rss-reader-early-prototype.gif)

## In closing

All things considered, *SimplePie kicks some serious ass*! It does exactly what I need it to, and the old-school vibe is actually attractive to this older developer who started his career in that era.

This is a serious and hardcore PHP codebase that puts newer libraries and frameworks to shame. While the [DX](https://github.blog/2023-06-08-developer-experience-what-is-it-and-why-should-you-care/) for the API isn't quite up to our modern sensibilities, I like the old-school vibes and honesty of it. Very importantly though, it is thoroughly [docblock](https://docs.phpdoc.org/guide/guides/docblocks.html)ed, giving the IDE good intelligence about the internals.

I'll end this love letter by urging any PHP developer interested in RSS to give SimplePie some affection and [star it on GitHub](https://github.com/simplepie/simplepie) because 1.5k stars for this jewel is low, man!
