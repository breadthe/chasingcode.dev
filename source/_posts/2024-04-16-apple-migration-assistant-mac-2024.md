---
extends: _layouts.post
section: content
title: Apple Migration Assistant on the Mac in 2024
date: 2024-04-16
# updated:
description: How good is Apple's Migration Assistant on the Mac in 2024?
tags: [mac]
featured: false
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url: https://indieweb.social/@brbcoding/112107825931770751
---

I bought a new Mac: a 2024 M3 MacBook Air that was just released a couple of weeks ago. This replaces a 2019 Intel i9 MacBook Pro. That machine was heavy and cumbersome, and slow as molasses despite the theoretical firepower.

I thought I would use the Migration Assistant to move all my stuff over. I was quite surprised by how well it worked. Here are some thoughts and insights.

The Migration Assistant can be used during the onboarding process as soon you power up the new machine. The "donor" needs to be powered on and on the same network. I selected everything to be moved over.

I was a little uneasy when it gave me a 13 hour estimate. In the end it took 1 hour. Keep in mind that the old machine had 1 TB while the new one has only 512 GB. The total data moved was somewhere north of 200 GB and I was left with 118 GB free. If you think that's low, it's because I have a lot of duplicate stuff that will be cleaned up soon.

I've setup a fair share of Macs over the years, but I don't recall using the Migration Assistant before. Surprisingly, it did an amazing job.

## What worked out of the box

It literally moved over **all** of my stuff.

Not only did my browsers still have the same **tabs open**, but I was **logged** into all the websites from the old machine.

My **documents** were all there, including the ones not in iCloud.

**Apps**, likewise, were all there and worked without a hitch. Some exceptions apply, read below.

The craziest thing is that the movie I had started watching in VLC on the old machine resumed in the same spot on the new Mac.

Best of all, the **coding tools** were in place (again, with some exceptions): Laravel Herd, DBngin, TablePlus being the most important.

My **ssh keys** were in place, and I was able to ssh to my remote server without a hitch. I also connected to the **remote database** (with the same ssh key) without issues.

**PHP** worked just fine at the command line, and my **side projects** ran in the browser the same way I left them. **composer** was fine.

**git** worked as before.

## What needed some tweaking

Some of the apps were made for **x86** and required **Rosetta** on the M3. I opted to uninstall them, and then downloaded the **ARM** version. Unfortunately certain apps are still missing an Apple Silicon build, thus requiring Rosetta (looking at you Garmin Express and Steam).

A few more that I had to replace with Apple Silicon versions are: 1Password, and JetBrains Toolbox.

At the **command line** (I use Warp for my terminal) I had a couple of issues. Bear in mind that all of these are related to migrating from an Intel machine to an Apple Silicon machine, and not really caused by the Assistant.

My **Node** version wasn't compatible with the new machine. It gave a `zsh: bad CPU type in executable: node` error. This was fixed quickly by installing the latest version with Herd.

**Homebrew** gave a `Bad CPU type in executable` error when I ran it. I uninstalled it, then reinstalled it. In my `.zprofile` I replaced `eval $(/usr/local/bin/brew shellenv)` with `eval "$(/opt/homebrew/bin/brew shellenv)"`.

**bat** (replacement for cat) gave a `zsh: bad CPU type in executable: bat` error. Fixed by running `brew install bat`.

**ncdu** (replacement for du) gave a `zsh: bad CPU type in executable: ncdu` error. Fixed by running `brew reinstall ncdu`.

**rustup** gave a `zsh: bad CPU type in executable: rustup` error. I fixed Rust by running the official install script `curl --proto '=https' --tlsv1.2 https://sh.rustup.rs -sSf | sh`.

**cargo** and **rustc** continued to give this error even after updating Rust `error: command failed: 'cargo/rustc': Bad CPU type in executable (os error 86)`. I should have done a fresh Rust install. So I uninstalled everything with `rustup self uninstall`, then ran the installation command again, and all 3 were working.

I ran into some problems with `npm run <any-script>` in a project.

```shell
npm run dev
[webpack-cli] Error: spawn Unknown system error -86
```

This was fixed by installing Rosetta. I had to do that in any case since a few programs refused to run without it, but I wanted to leave it last.

```shell
softwareupdate --install-rosetta
```
## Conclusion

Apple's Migration Assistant has done a bang-up job in my opinion. Not everybody likes to copy over old settings and apps, but I'm lazy and I don't have any pleasure in setting up a machine from scratch. Besides, the old machine had been setup fresh only a year ago, so it's unlikely that a lot of bitrot had set in.

The only issues that gave me some headache were entirely related to changing architectures from x86 to ARM.

If you're in a similar situation (or just lazy like me), I highly recommend it.

I'll keep an eye out for issues over the next period and update this post accordingly.