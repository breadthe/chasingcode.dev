---
extends: _layouts.post
section: content
title: Mac Screen Recoding GIF Workflow
date: 2019-12-04
description: My personal workflow for screen recording and converting to GIF on the Mac
categories: [Mac,Workflow]
featured: false
image: https://media.giphy.com/media/S3VRqjVQsZI5zNAgPQ/giphy.gif
image_thumb: https://media.giphy.com/media/S3VRqjVQsZI5zNAgPQ/giphy.gif
image_author: 
image_author_url: 
image_unsplash: 
---

Are you a developer who wants to record part or all of your screen on a Mac, and then convert it to GIF to post on social media or elsewhere? Here's my personal workflow to achieve this.

The things I record most often are either in the browser or in some kind of text editor, mostly PHPStorm.

Please note that this is a *Mac-only* guide. I haven't needed to do this on a PC yet.

## Tools needed

**QuickTime Player** - For basic screen recordings you don't need any fancy software because OSX comes with a built-in tool for this, though it's not very obvious. This tool is **QuickTime Player**. 

**Giphy** - My tool of choice for converting a video to GIF is [giphy](https://giphy.com/). I believe in the past you could upload GIFs anonymously to giphy but that's no longer the case. I find that having an account is useful because you can reference your GIFs anytime you want. Here's my [Giphy channel](https://giphy.com/channel/chasingcode) as an example.

(optional) **PHPStorm** - For code or script recordings, you can use your text editor of choice, but I prefer PHPStorm for the majority of my work. PHPStorm offers one feature that is very important for distraction-free screen recording, and that is presentation mode. In this mode, the current editor window covers the whole screen and all the menus are hidden.

## The workflow

### 1. Preparation

Start the browser/text editor/app/document that you want to record.

Put the app in presentation mode if possible. Here are some instructions for my most used editors.

**PHPStorm** - Go to *View > Appearance > Enter Presentation Mode*. To exit, hover the mouse pointer at the top of the screen to reveal the main menu, then *View > Appearance > Exit Presentation Mode*.

**VSCode** - *View > Appearance > Full Screen*, then *View > Appearance > Zen Mode*. There's also the tabs area that I haven't found a menu option to toggle but you can avoid that by recording only part of the screen. Sorry but I'm not a power VSCode user - PHPStorm works really well out of the box for me, without endlessly customizing it and installing a few dozen plugins to get all the functionality I need.

### 2. Start QuickTime Player

Go to *File > New Screen Recording*. You may be asked to give QuickTime access to record your screen in System Preferences.

QuickTime's screen recorder, although very basic, offers some powerful tools. Among those, the ability to record the entire screen or only a portion of it. As part of the options, you can also choose to record mouse clicks or set a timer to make the recording start after a few seconds.

Recording a portion can be very handy when you want to capture only a certain part of the screen, while ignoring things like menus, scrollbars, irrelevant items on the screen, or other distractions.

To stop the QuickTime recording is a little tricky. I haven't found another way than to CMD-TAB back to QT, hit New Screen Recording again, then click the stop button when the toolbar appears at the bottom of the screen.

### 3. Trimming the clip

You can trim the clip immediately after recording (and before exporting) it. Typically I don't want very long pauses at the beginning or end, while I'm starting or stopping the recording. Hit *Edit > Trim* or CMD-T, then drag the yellow handles accordingly. There's a handy preview showing you the result.

It's also possible to trim the video after exporting it. To do that, open it with QuickTime (should be set as the default) from the exported location. Then go to *Edit > Trim* or CMD-T. 

### 4. Exporting the clip

Once you've recorded your video, go to *File > Export As... > 4K* or *1080p*. For me 1080p is sufficient.

### 5. Uploading to Giphy

In Giphy, hit *Upload*, then add the video you created earlier.

I'm not sure what *Source URL* is, but I assume it's there if you upload a video that you didn't author yourself, which is usually not the case for screen recordings.

I recommend tagging the clip, using comma separated terms, such as `code editor, ide, php, phpstorm`.

Finally hit *Upload to Giphy*. Once it finishes uploading it directs you to the GIF's page where you can share it to social media or, my preference, *Copy link*. This option opens a dialog with several flavors of URLs. The "Short Link" is handy for sharing on Twitter.
