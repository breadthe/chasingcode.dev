---
extends: _layouts.post
section: content
title: How to Verify a PGP Signature on Windows 10  
date: 2021-03-28
description: Step-by-step guide on how to check a file's PGP signature on Windows 10
categories: [Windows10]
featured: false
image: 
image_thumb: 
image_author:
image_author_url:
image_unsplash:
---

Downloading and executing an `exe` file on Windows is safer when it comes with a [PGP signature](https://en.wikipedia.org/wiki/Pretty_Good_Privacy) that you can verify.

How do you check a PGP signature though? I've always avoided it until now, when I needed to make double-certain that a certain installer was the real deal.

## Installing the Windows 10 SDK

Unfortunately Windows 10 does not offer any tools out of the box, instead requiring installation of the [Windows 10 SDK](https://developer.microsoft.com/en-US/windows/downloads/windows-10-sdk/).

After downloading and installing from the link above, the [SignTool](https://docs.microsoft.com/en-us/windows/win32/seccrypto/signtool) utility should become available. This is what you'll be using to verify PGP signatures.

## Checking the PGP signature

Let's assume you downloaded a file called `installer.exe` from whatever website. If the website provided a PGP signature, it will likely be named `installer.exe.asc`, so download it in the same folder as the `.exe`.

First, locate the exact path of `signtool.exe`. Mine ended up in a weirdly-named folder: `C:\Program Files (x86)\Windows Kits\10\bin\10.0.17763.0\x64`. You may have multiple folders named similar to `10.0.17763.0`. Browse all of them until you find the tool.

Next, open *Command Prompt* and navigate to the directory where the file (`.exe`) and its signature (`.exe.asc`) reside.

Then run this command:

```bash
# simplified - when you have signtool in your path
signtool verify /pa installer.exe

# full
C:\Program Files (x86)\Windows Kits\10\bin\10.0.17763.0\x64\signtool.exe verify /pa installer.exe
```

If the verification succeeded, you will see this message:

```bash
Successfully verified: <path>\installer.exe
```

This guide is based on these [instructions](https://www.ghacks.net/2018/04/16/how-to-verify-digital-signatures-programs-in-windows/), and adapted for my own use-case.
