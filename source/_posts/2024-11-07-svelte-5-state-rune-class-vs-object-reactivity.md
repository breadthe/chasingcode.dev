---
extends: _layouts.post
section: content
title: Svelte 5 $state rune Class vs Object reactivity
date: 2024-11-07
updated: 2024-11-08
description: Exploring how storing a Class object vs a regular Object in a Svelte 5 $state rune differs
tags: [svelte]
featured: true
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: 
---

Svelte 5 was finally released after a long development cycle, and it brings the concept of runes, which changes the state paradigm quite a bit compared to Svelte 3/4. I stayed away from Svelte during this period, because I wanted to work with the finished product.

Playing around with the `$state` rune, I found that I generally like it. It was a lot harder to use it in a global, sharable store (because the official documentation is lacking in this respect), but a friendly Svelte contributor on bsky helped me with a working example.

I'm building a tiny app that uses a shared store to hold arrays of objects. This is both to test Svelte 5's new features, and to scratch an idea I had.

Now, the objects in my arrays are actual JavaScript class instances. I thought it makes sense to use classes instead of simple objects, because there are some OOP features here that can come in handy (in particular having logic in the constructor).

I got stuck on an issue though. When I updated a property of an object (class instance) in the array (incrementing a counter), it wasn't responsive. It took a while to figure out (my JS isn't my strong suit).

Long story short, it turns out that if you store a class instance using `$state`, its properties are not reactive. *While you can modify the internal state of the object, it won't re-render in the browser.*

**Note** You _can_, in fact, make class properties reactive. Read all the way down for the best solution. 

So what **can** you do? I found 2 solutions (you might know more):

- store a simple object instead of a class - `{}` instead of `new Widget()`
- or add a `toObject` method to the class which returns the properties you need, as a simple object (the implementation here might be naive, but it does what I need so I don't care)

Since I was adamant to use classes, I decided on the 2nd solution.

Here's the code, to illustrate what's happening. You can also find it in the [REPL](https://svelte.dev/playground/2068d2c9d18b423296d16139d0de12c7?version=5.1.11).

```html
<script>
	let collection = $state([])

	class Ob {
		id = null
		name = ''
		count = 1

		constructor(id, name) {
			this.id = id
			this.name = name
		}

		toObj() {
			return {
				id: this.id,
				name: this.name,
				count: this.count,
			}
		}
	}

	function incr(i) {
		collection[i].count++
	}

	collection.push(new Ob(1, '❌ Class'))
	collection.push({ id: 2, name: "✅ Object", count: 1 })
	collection.push(new Ob(3, '✅ Class.toObj()').toObj())
</script>


{#each collection as col, i}
	<button type="button" onclick={() => incr(i)}>+</button>
	{JSON.stringify(col)} 
	<br>
{/each}
```

And here's a GIF of the 3 scenarios.

![Svelte 5 state rune reactivity Class vs Object comparison](/assets/img/2024-11-07-svelte-5-state-rune-class-vs-object-reactivity.gif)

I hope this is helpful in case you run into the same problem. It sure enough got me unstuck and helped me understand Svelte 5's reactivity just a tiny bit more.

---

But wait, there's more. It turns out you can actually make the 1st scenario (Class properties) reactive by wrapping the class properties in `$state`. Who woulda thunk it? Here's an [updated REPL](https://svelte.dev/playground/e6fec79bd1a2490ba948dbf2e931865a?version=5.1.13). There's no need for the `toJSON` function with this approach.

```html
<script>
	let collection = $state([])

	class Ob {
        id = $state(null)
        name = $state('')
        count = $state(1)

	collection.push(new Ob(1, '✅ Class'))
```

Thanks to [Pablopang.svelte](https://bsky.app/profile/ricciuti.me) over on Bluesky for helping with this!