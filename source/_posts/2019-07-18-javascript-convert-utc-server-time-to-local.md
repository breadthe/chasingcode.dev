---
extends: _layouts.post
section: content
title: Convert UTC Server Time to Local with JavaScript
date: 2019-07-18
description: The technologies on my personal radar for 2019.
categories: [JavaScript]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

There are many advantages to storing timestamps in UTC in your database but I'm not going to go into them right now. But what do you do when you want to display the user's local time on the frontend?

One technique is to fetch the UTC time from the server and convert it to client time with JavaScript, using the browser's built-in APIs. Here's how.

```javascript
var serverTime = '2019-07-19 17:04:03';

// split into components by "-", " ", ":" and convert to integer
var splitIntoComponents = serverTime.split(/-|\s|:/).map(c => parseInt(c, 10)); // [2019, 07, 19, 17, 04, 03]

var date = new Date(Date.UTC(...splitIntoComponents));

date.toLocaleDateString(); // "8/19/2019" <-- this is because Date.UTC month parameter is 0-index based
date.toLocaleTimeString(); // "12:04:03 PM"
```
