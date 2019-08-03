---
extends: _layouts.post
section: content
title: How to Install HTTPie in Windows 10
date: 2019-05-26
description: HTTPie is a pretty cool tool but installing it in Windows is not as straightforward as on the Mac.
categories: [DevTools]
featured: false
image: https://source.unsplash.com/8qDTh2VuY2E/?fit=max&w=1350
image_thumb: https://source.unsplash.com/8qDTh2VuY2E/?fit=max&w=200&q=75
image_author: Artur Rutkowski
image_author_url: https://unsplash.com/@alienowicz
image_unsplash: true
---

[HTTPie](https://httpie.org/) where were you all my life? I just discovered this command line tool and wanted to give it a try right away. Unfortunately I was working on a Windows 10 machine and the project's homepage hints that it's a Mac exclusive. Luckily, the [documentation](https://httpie.org/doc#windows-etc) contains installation instructions for Windows.

While you can just follow the instructions there, I'm going to document the steps anyway, for my own sake.

## Install pip/Python and upgrade pip

Download the [Windows x86-64 executable installer](https://www.python.org/downloads/windows/) and run it.

```bash
python -m pip install --upgrade pip
```
## Install HTTPie

```bash
pip install --upgrade pip setuptools pip install --upgrade httpie
```
That's it.

## Basic usage

First of all, the command itself is `http`, NOT ~~httpie~~. I was wondering why it wasn't working after I installed it.

I was interested in testing a GET API endpoint in a local environment that had a bunch of query parameters appended at the end of the URL.

Turns out that HTTPie has a special syntax for query parameters, which can cast to specific types if the value is not a string. Here are a few, but the [documentation](https://httpie.org/doc#querystring-parameters) has more.

**Strings** `name==john` or `name=="john wick"`

**Numbers/Booleans** `year:=2015` or `active:=true`

**Request headers** `key:value` or `key:"value with spaces"`

## Example

Here I'm making a GET request with some query parameters as well as a couple of headers.

`GET example.com/api/quote?year=2015&name=john&birthday=06/21/2001&zipcode=60201`

Headers:

`Authorization:"Bearer tPOm3BXiYSv7fwnIN5dUCzpCy6sGH2Mdclj2BwBZvFw..."`  
`accept:application/json`

Command terminal (Windows/Mac/etc):

```bash
http GET example.com/api/quote year:=2015 name==john birthday==06/21/2001 zipcode==60201 Authorization:"Bearer tPOm3BXiYSv7fwnIN5dUCzpCy6sGH2Mdclj2BwBZvFwbDhLrAh0NmvtnyF4fdR3CbqAAdPQMPbSFYKXk" accept:"application/json"
```

The response:

```bash
HTTP/1.1 200 OK 
Cache-Control: no-cache 
Connection: keep-alive 
Content-Type: application/json 
Date: Sat, 19 May 2019 19:11:45 GMT 
Server: nginx/1.15.0 
Set-Cookie: XSRF-TOKEN=eyJpdiI6ImlCK3M4bXI3NXdwUmw3ekpTcEs...; expires=Sat, 19-May-2019 21:11:45 GMT; Max-Age=7200; path=/ Set-Cookie: laravel_session=eyJpdiI6ImZYMm10djgwS29i...%3D; expires=Fri, 25-May-2019 07:11:45 GMT; Max-Age=216000; path=/; HttpOnly Transfer-Encoding: chunked

{ "data": { "somenumber": 4242.42 }, "message": "Here is your data", "success": true }
```

If you get the following error when running it in Git Bash:

```bash
http: error: Request body (from stdin or a file) and request data (key=value) cannot be mixed. Pass --ignore-stdin to let key/value take priority...
```

Then just run the same command but append the `--ignore-stdin` flag at the end.
