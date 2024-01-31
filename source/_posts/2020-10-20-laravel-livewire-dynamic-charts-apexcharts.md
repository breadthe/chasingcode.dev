---
extends: _layouts.post
section: content
title: How to Create Dynamic Charts with Laravel Livewire and ApexCharts
date: 2020-10-20
description: 
tags: [laravel, livewire, apex-charts]
featured: false
image: /assets/img/2020-10-20-livewire-apexcharts.jpg
image_thumb: /assets/img/2020-10-20-livewire-apexcharts-thumb.jpg 
image_author: 
image_author_url: 
image_unsplash: 
---

Cycling has become one of my most cherished hobbies in 2020, and I did what every developer does when they love a hobby: built an app for it.

I'm using [Strava's API](https://developers.strava.com/) to pull my rides into a Laravel 8 app. I use this data to create statistics for various metrics that are important to me.

I want to display the data in 2 forms: tabular and charts. I also want to be able to filter it dynamically, without page loads, and I chose [Livewire](https://laravel-livewire.com/) 2.x for this. As an avid cyclist, I ride both road and trail/singletrack. I have 2 bikes (road + mountain), and I want to track total stats, as well as individual stats for each bike.

For charting, I decided to use [ApexCharts](https://apexcharts.com/), a JavaScript charting library that meets my modest needs. 

Now that I have these building blocks, how do I put them together? One of my requirements is to be able to **update the charts dynamically** with Livewire. It took me a while to figure out how to do this, but here it is. 

**Note** During the time it took me to write this article, [Andrés Santibáñez](https://twitter.com/asantibanez) released a [Livewire package](https://github.com/asantibanez/livewire-charts) for ApexCharts that should be more flexible for the general population. I think there is value in my own solution, not just for the learning aspect, but also because it's customized to my very specific requirements. 

## What I'm making

The first chart I wanted is a total of riding miles per year (as tracked by Strava). In addition, I also wanted to be able to filter the chart by bike, using a dropdown. So when I select a specific bike, the chart should update to display only the yearly distances for that bike. 

Here's a gif of the final chart.

![Dynamic chart filtering with Livewire](https://media.giphy.com/media/UJ497lGjwE5EIGkki2/giphy.gif)

## The components

A Laravel app can be structured in many ways, but I ♥️ the Blade component system that was introduced in v7, so that's what I'm using. First, I started out by creating a regular view (`resources/views/stats.blade.php`) where I can display my chart(s).

Then there are 2 components that do the heavy lifting:

- a Livewire component which retrieves the chart data from the database and filters it when needed 
- a regular Laravel component acting as a wrapper for ApexCharts

Each generated component comes with a controller and a view.  Here's a [gist](https://gist.github.com/breadthe/1ed8eec0b464d511877b06a04898bbef) for the 2 controllers + 2 views, also embedded below:

<script src="https://gist.github.com/breadthe/1ed8eec0b464d511877b06a04898bbef.js"></script>

**Note** File paths in the gist appear as `app%Http%Livewire%Stats%DistanceByYear.php` instead of `app/Http/Livewire/Stats/DistanceByYear.php` due to GitHub's inability to use slashes in the file name.

## Livewire tricks and gotchas

👉 The `stats.blade.php` view is where I render multiple Livewire chart components. This also contains a bit of code which links the ApexCharts script from the official CDN and pushes it to the top of my JS scripts stack. For context, in my `app.blade.php` I have a corresponding `@stack('scripts')` right before the closing `</body>` tag. 

👉 The chart wrapper `ApexCharts.php` must have a unique id `$chartId`, to allow multiple chart instances on the same page. I experimented with passing a UUID but settled on a static identifier like "distance-by-year".

👉 To refresh the chart data when a filter is applied, I need to emit an event. Notice this part `$this->emit("refreshChartData-{$this->chartId}", [...])` in `DistanceByYear.php`. The event has a dynamic identifier which ensures that only a specific chart gets updated (in situations where multiple charts are on the same page). In this case, the event id resolves to `refreshChartData-distance-by-year`. But on the same page I have another chart which is identified as `distance-by-month`, and the corresponding event is `refreshChartData-distance-by-month`. The second argument of the event emitter is the (optional) data payload. If you've used events in [Vue](/blog/tags/vue/), this pattern should look familiar.

👉 Emitting an event is only half the equation. To actually get the chart to update, I need to listen for the event, then call a couple of ApexCharts methods responsible for updating the chart data.

👉 Listening and reacting to a Livewire event turned out to be the hardest part to figure out. It's just not very clearly explained in the [official documentation](https://laravel-livewire.com/docs/2.x/events), or at least not in a way that makes sense to me. So after much experimentation and web searches, I arrived at the following ugly-duckling-yet-functional solution (see `apex-charts-blade.php`):

```js
document.addEventListener('livewire:load', () => {
    @this.on('refreshChartData-{!! $chartId !!}', (chartData) => {
        chart.updateOptions({
            xaxis: {
                categories: chartData.categories
            }
        });
        chart.updateSeries([{
            data: chartData.seriesData,
            name: chartData.seriesName,
        }]);
    });
});
```

👉 The key part to listening in JavaScript to an event emitted in PHP/Livewire, seems to be wrapping everything in this:

```js
document.addEventListener('livewire:load', () => {
    @this.on('refreshChartData-{!! $chartId !!}', (chartData) => {
        // do JavaScripty stuff with chartData
    });
});
```

👉 Notice that I'm wrapping the entire JavaScript logic in a auto-executing function call `(function () {...}())`. Tangentially, here's a good explainer for [auto-executing functions in JavaScript](https://coolaj86.com/articles/how-and-why-auto-executing-function.html). The reason I'm doing this is to isolate the scope of the `chart` object to each individual instance. This allows me to refresh the chart data without re-instantiating the ApexCharts object, and prevents weird behavior with multiple globally defined `chart` objects. 

## Conclusion

I hope this shed some light on how you might create a Livewire wrapper for the ApexCharts library.

There are several caveats to my approach:

- It is not the most elegant solution, but *it works* for what I'm building. If you have a better solution, hit me up on [Twitter](https://twitter.com/brbcoding).
- It's not very reusable either, but thankfully there's the package I mentioned at the top of the article for those who prefer that
- I'm using just a tiny fraction of ApexCharts' capabilities and options, and I'm exposing very little of that to Livewire. And I'm fine with that for now, because I can always add more later as the need arises.

Having said that, I'm happy with the way this turned out, especially with the learning process figuring out the intricacies of integrating Livewire and ApexCharts.

Finally, here's how two independently filtering charts behave on the same page.

![Multiple independently filtering charts with Livewire](https://media.giphy.com/media/H2xHUVXlbTjZJFLzpC/giphy.gif)
