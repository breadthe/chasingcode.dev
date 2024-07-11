---
extends: _layouts.post
section: content
title: How I work in an async team
date: 2024-07-10
description: My daily routine as an async remote worker
tags: [career]
featured: true
image:
image_thumb:
image_author:
image_author_url:
image_unsplash:
mastodon_toot_url:
---

I am currently working in a remote asynchronous small SaaS company, but I have been a remote worker for many years. This requires a lot of self-management, and what works best for me is to document everything and keep extensive notes.

I have refined my work routine over the years, with adjustments pertaining to the company and the team, and I wanted to outline the current iteration for myself and others who might find it useful.

## Daily routine

These are the actions that I perform every day when I log into my workstation, roughly in this order of priorities.

- check Slack
	- address direct messages
	- skim production errors channel (or take further action if I'm on tech support duty that week)
	- read new messages & respond if appropriate (sometimes people have questions that I can answer)
- check the calendar for meetings (only a couple per week, but sometimes there are more)
- check email
	- delete most new emails (routine notifications & marketing stuff from vendors)
	- address anything that I need to take action on (almost never happens)
- check GitHub notifications
	- skim completed tickets (merges, closed issues) and dismiss them
	- read assigned issues (usually these are near-future todos)
	- reduce everything down to PRs (pull requests)
- create a new Obsidian document for today from a template (see below)
	- mark down today's tasks, including any meetings
	- sometimes I jot down notes that don't need to be remembered beyond today
- go through each PR request and review it (this can take a while)

Sometimes the above tasks might take half a day depending on how much administrative/clerical work there is.

Next...

- once PRs are handled, I'll start actual work
- the first work item is to address any feedback or requested changes on my own PRs
- once that's taken care of I can move to actual work on my own issues (coding mostly)
- open a PR once the work is completed
	- describe the changes
	- outline the testing methodology
	- tag reviewers
- move on to the next task

If I'm on tech support duty that week, I have additional tasks:

- inspect each production error carefully
- triage and (if necessary) capture each new error in a new issue with as much detail as possible
- if it's a serious issue start working on a (hot)fix immediately
- merge approved PRs
- once all the merged PRs have been merged into the Staging I'll do a Production deployment
- announce the deployment in a couple of specific Slack channels
- keep an eye on errors that might stem from the recent deployment (rare, but it sometimes it happens)

## Meetings

Thankfully there aren't many meetings at the current company - typically two per week. I do take notes during these meetings in the daily journal (see below).

## Document everything

I'm not one of those people who have a photographic memory and can remember what they had for breakfast 11 years ago on a Tuesday. So I find it very important to document everything at work: processes, how tos, daily tasks, meetings, etc.

The tool that I've been using for a few years now is [Obsidian](https://obsidian.md/). Like the [One Ring](https://en.wikipedia.org/wiki/One_Ring), I think this is - by far - the best note-taking tool ever. This is not an Obsidian review, but some of the things I love about it include: the simple UI, (deep) document linking, tagging, folders, global search, graph view, plugins.

I (ab)use it heavily to take hundreds (if not thousands by now) of notes. My vaults live in iCloud, so they are backed up and synchronized across my Apple devices.

## The Obsidian templates

I use Obsidian to track work by creating

- a new document for each work day
- a new document for every ticket I work on

### Daily template

I organize work days into weekly folders labeled from 001 to... infinity, as in `week 001` ... `week 999` (hopefully I'll retire long before week 999). I then archive each weekly folder into a yearly folder labeled `2024`, etc, once there are no incomplete tasks remaining in that week.

Document title: `Day 123 - Mon Jan 01`

Template:

```markdown
# Standup
*Today* (Mon Jan 01)
-
*Tomorrow*
-
*Need*
-

# Todo
- [ ] task 1
- [ ] task 2

# Meeting 1
- [ ] discuss thing 1
- [ ] discuss thing 2

# Meeting 2
-
```

The **Standup** section is useful to quickly copypasta into our daily status Slack channel. Markdown ensures it gets formatted nicely by Slack.

The **Todo** section is for ad-hoc tasks that I want to do that day, which don't require a separate document. Usually this is stuff I can finish that day. If not, it'll get punted to the next day.

The **Meeting** section is for taking notes when there's a meeting that day. I also have a checklist of things that I want to bring up with the team, questions or otherwise. I keep adding items to this list as I remember them.

Each day I make a duplicate of the previous day and change the title. So `Day 123 - Mon Jan 01` becomes `Day 124 - Tue Jan 02`. This has the added benefit of carrying over incomplete tasks. I can quickly delete the previous day's completed tasks and add new ones for today.

### Ticket template

In the same weekly folder `week 001` as described above, I will create a new document for each ticket I'm working on. The template below is its own document named `🏁99999-issue-branch-template` that I duplicate into a new document, and then rename the slug appropriately.

For tickets taking more than a week to complete, or that I haven't started yet in the current week, I'll move them to the next week. This way the current week always has unfinished tickets, and I can easily archive previous weeks.

Document title/slug: `🏁99999-issue-branch-template`

Template:

```markdown
Issue:
https://github.com/organization/repo/issues/99999

Branch:
99999-branch

🏁 Not started
🚧 In progress
👀 In review
♻️ Changes requested
✅ Merged
🚫 Not doing / deferred

PR:
https://github.com/organization/repo/pull/

# Notes


# Testing

```

The document slug is generated from the GitHub issue title. So for an issue titled `Page request copy is truncated #12345` my document slug would be `12345-page-request-copy-is-truncated`.

I use ChatGPT to quickly convert this to kebab case for me. The prompt is:

```
for all the subsequent conversations in this chat i want you to convert github issue titles that look like this "Page request copy is truncated #12345" into slugs that look like this "12345-page-request-copy-is-truncated" for the purpose of using it as git branches
```

I prefix the document slug with emoji icons to quickly distinguish ticket state while I'm working on it. This has the added benefit of automatically sorting issues by completion state in my weekly folder.

## Takeaway

If you work long enough in an environment where you have to self-manage, you'll find that certain patterns begin to emerge. While acknowledging that every company, team, or project is different, it's useful to form a "big picture" daily routine that you can apply to the majority of situations with minimum tweaks. The end goal is to make your work day more efficient and less stressful by implementing a blueprint that you can follow reliably every day of the week.

Obsessive note-taking may not work for everyone, but I wish I had discovered this a lot earlier in my career. If you feel like you're struggling or having trouble managing work (especially in a remote setting), I recommend finding an organizing framework and note-taking system that works for you. In the meantime, take a look at mine in case it's something you can use.
