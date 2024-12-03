---
extends: _layouts.post
section: content
title: I made a game
date: 2024-12-03
# updated:
description: I made a silly game with Svelte 5
tags: [gamedev,svelte]
featured: false
image: /assets/img/2024-12-03-i-made-a-game.jpg
image_thumb: /assets/img/2024-12-03-i-made-a-game.jpg
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: 
---

I thought you - I - should [make a game](/blog/make-a-game). So I made one. It's a Trading Card Game in the browser, built with Svelte 5.

It's silly. The gameplay is shallow, it copies concepts from another game, and there's no endgame (lol). But it makes for a pretty damn good milestone, seeing as it's the first game I ever made.

Here's a link to the [game](https://breadthe.github.io/stcg/) and another to the code on [GitHub](https://github.com/breadthe/stcg).

Why did I make this? Because it's fun to play games and sometimes I get the urge to make one. This time I followed through. I was heavily inspired by [Trading Card Game Simulator](https://store.steampowered.com/app/3070070/TCG_Card_Shop_Simulator/) (Steam link), a viral game that got me hooked for a while.

My game is named STCG, expanded to Svelte Trading Card Game. Essentially it is a Pokemon-like card collecting game.

I wanted a small project that I could use to try out Svelte 5 and this was the perfect candidate. I got to play around with the new runes API and global stores. I really like what I've seen so far. I feel that it is easier now to manage global state compared to Svelte 3-4.

This project provided a good sandbox for wiring together various bits and pieces of state that need to stay in sync across multiple components and in computed expressions. Runes really do make this easier to handle. But I think that one of the best additions is the ability to use runes with complex logic inside `.svelte.js` files to act as a global store.

You might notice that the game doesn't have an intricate UI, but I did my best to make it inoffensive, unless you hate lots of colors. The jumble of colors is intentional. Sometimes I like a rainbow explosion in my UI, and this is one of those times.

I used ChatGPT to help me with 2 things: name generation for the cards (except for one - I'll let you find it), and the animated gradient background for foil cards (nobody ain't got no time for that!)

What next? The game is a finished product, as far as I'm concerned. I do want to tinker around with it a little more, to fix minor issues, add some friction and conveniences.

Give it a try and don't take it too seriously, but more importantly check out the code especially if you're looking to implement global stores in Svelte 5.