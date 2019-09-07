---
extends: _layouts.post
section: content
title: Introducing 1Secret.app
date: 2019-09-07
description: Introducing my side project and SaaS, 1Secret.app.
categories: [1Secret]
featured: false
image: /assets/img/2019-09-07-1secret.jpg
image_thumb: /assets/img/2019-09-07-1secret.jpg
image_author: 
image_author_url: 
image_unsplash: 
---

As I'm nearing public launch, the time has come to talk briefly about [1Secret.app](https://1secret.app), the side project and SaaS app I've been building for a while.

## What is 1Secret?

In a nutshell, 1Secret is a browser-based app that is trying to solve the problem of sharing secure or sensitive data over insecure mediums. The best example of that is sending passwords over email. That is an inherently insecure practice and I wish IT professionals would use it less.

Recently, I discovered that Outlook can generate and send encrypted links, but the process to open such a link is awkward, and I can only imagine creating one is just as inconvenient. Besides, you're tied to a particular technology, Outlook in this case.

1Secret aims to make this process a lot easier, but also very secure.

## How does 1Secret work?

[1Secret's](https://1secret.app) main premise is the creation of transient - or short-lived - secrets. A "secret" is simply text or a file or both (later this will be expanded to multiple files and other goodies, but for now I'm keeping it simple).
 
 Once a secret is created, you'll be presented with a URL that terminates in a random string. Instead of emailing a clear-text password, you'll be emailing this URL instead. The advantages of this should be clear once I explain security layers below.

Creating a secret is kept simple, with most fields optional.

![Folder structure](/assets/img/2019-09-07-create-secret.jpg)

Of note are the **Duration** and what I call **Attempts** but also **Password**. The first two control how the secret expires (and is subsequently destroyed), while adding a password encrypts the secret with your own key, making it airtight.

To open a secret, load the URL in a browser. Depending if it is encrypted by the creator, you may be presented with a password prompt.

![Folder structure](/assets/img/2019-09-07-enter-password.jpg)

Once you've entered the correct password - if applicable - you'll see the message or file attachment.

![Folder structure](/assets/img/2019-09-07-open-secret.jpg)

If the file is an image there's a low resolution preview, but you can download the original image if you wish.

The message itself can be read, copied to the clipboard or downloaded as a text file.

## How does 1Secret protect your data?

1Secret is a bit like an onion, in that it offers multiple layers of security. Here are some of them.

### Secure transport

The message (along with any files) is transported securely over HTTPS to the server where it is processed.

### Transience (or short-livedness)

By not allowing a secret to live forever, I don't have to worry about forgetting that my secrets are spending the remaining of eternity on some server.

Transience is achieved in two ways: **duration** (or lifetime) that defaults to a sensible number and you can tweak it to your liking based on account type, and **number of attempts** (I really need to find an easier term for this) which determines how many times the secret URL can be opened before it is destroyed.

In both cases, once the secret has expired, it is purged (or destroyed) from the server and the URL becomes invalid.

### Encryption layer 1

Every secret is encrypted on the server by default. This automatically protects the data at rest from being compromised. An attacker would need to compromise two separate pieces of the puzzle in order to decrypt your information. But this is where layer 2 comes in.

### Encryption layer 2
 
Optionally (but *VERY HIGHLY RECOMMENDED*) you can encrypt a secret with your own password or key. Just make sure not to use your account password! This will wrap your secret around another encryption layer, but this time *you* control the key. No one else - not I (the provider), nor an attacker - will be able to access your information without the password. Also, the longer the password is, the better.

### Security through obscurity™️

"Security through obscurity" is a term that refers to obfuscating something, or making it long, complex, random, hidden from casual inspection, or a combination of all of those. In general I don't like this practice. It has its place in certain situations but it should never be the only security measure used.

In this case it adds yet another thin layer on top of the existing security onion. This is achieved by the random URL string that is generated when you create a secret, and looks like this `https://1secret.app/s/h5y85u4x`. When the secret expires, this URL is gone forever.

## What are some use cases?

Here's a handful of the most used scenarios that I run into on a daily basis. For others, use your imagination.

Remember, the main benefit of using [1Secret](https://1secret.app) is that each secret has a very limited lifespan, so you can "fire and forget it" and remain confident that it will be automatically destroyed when it reaches its end of life.

### Replace email for sending sensitive info

Create a password-encrypted secret, and email the 1Secret-generated URL instead. Then pass on the password through a separate medium, such as Slack, SMS, word of mouth, etc.

*Always spread the risk by using separate mediums to transfer the URL and the password.*

### Data transfer between devices

Yeah, you can use tools such as Dropbox, Google Drive and so on, but all those require a common interface (i.e. the program needs to be installed on both devices, you need to be signed in and so on). 1Secret needs only a browser, which is probably the most common and ubiquitous cross-device interface you'll find.

Besides, I don't have to worry about temporary bits and pieces of data cluttering my devices, since they only live briefly in the cloud. 

For that reason, I use 1Secret a lot to transfer text and files between my desktop(s)/laptop(s) and phone.

A good example is setting up a crypto wallet on a new device. In that case I'll just create a very short duration secret (say, 5 minutes) containing the encryption seed from my main machine (password-encrypted of course), then log into 1Secret on my new device and copy/paste the seed into the new wallet. In this case the password remains in my head.

### Tweeting

Another (slightly weird) scenario is for [tweeting](https://twitter.com/brbcoding). Yes, tweeting. Bear with me.

Often I find myself composing a tweet on one device, perhaps processing a screenshot, but I'm unable to tweet it on that device because I'm not logged into my account for various reasons (let's say I'm on a public device). So I'll create a secret containing the tweet and any associated image, then open it on a device from where I can actually send the tweet.

## Is there a free plan?

Yes! Check out the [Pricing](https://1secret.app/pricing) page where you'll find a list of features that each tier offers.

The **Free/Standard** tier offers most of the functionality you'll need on a casual basis from such a service: **password encryption** and the ability to **add smaller files**.

**Premium** will cost in the ballpark of $10 / month and will offer more conveniences, longer durations, more generous storage, and so on.

Please note that you'll need to create an account in order to use the password encryption or file attachment features. I'm not doing this in order to harvest your email address (read the [Privacy Policy](https://1secret.app/privacy) to see how little data I collect about you), but rather to prevent abuse.

## How can I pay for it?

For now, as you'll read below, I'm offering all the Premium features for free for the duration of the beta to anyone who signs up.

I don't have a payment solution in place but when the time comes I will support credit cards as a baseline. You can also pay me directly with Paypal if you prefer, or even cryptocurrency.

## Any plans for the future?

Glad you asked! I put quite a little bit of thought into what I want to build next and made a [roadmap](https://1secret.app/roadmap).

## 1Secret is in open beta

If you happen to come across this article and are intrigued by the idea, give [1Secret](https://1secret.app/) a spin! As of this writing, and until further notice, it is in open public beta and everyone who signs up *gets access to all the Premium features for free*, until the beta ends.

Plus, as early adopters I will offer you a special discount when the service goes commercial.

Thanks and I hope you'll find 1Secret useful!
