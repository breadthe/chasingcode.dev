---
extends: _layouts.post
section: content
title: How to Make Safari Download Files Properly with Laravel
date: 2019-06-02
description: When downloading files with Laravel, Safari may need some coaxing. Here's how.
categories: [Laravel]
featured: false
image: https://source.unsplash.com/0LwfbRtQ-ac/?fit=max&w=1350
image_thumb: https://source.unsplash.com/0LwfbRtQ-ac/?fit=max&w=200&q=75
image_author: Hu Chen
image_author_url: https://unsplash.com/@huchenme
image_unsplash: true
---

I'm building a file upload/download feature into my SaaS app [Sikrt](https://sikrt.com/), and after working out the kinks in a prototype version of the feature, to my consternation I discovered that clicking the download link in Safari produced a different outcome than in other browsers.

The expected behavior when downloading, say, a `.jpg` file is for the file to be saved with the designated name and the `.jpg` extension. Well, turns out that Safari appends a `.html` at the end, thus saving the file as `filename.jpg.html` instead of `filename.jpg`.

After a little googling I came across this [discussion](https://forums.macrumors.com/threads/safari-erroneously-adding-dms-extension-to-downloads.2080108/) that helped me isolate and fix the problem. The interesting bit here is the `curl -I` command.

Running this command against my download link, I got the following (in this particular case I'm trying to download an icon file with an `.ico` extension):

```bash
curl -I http://sikrt.test/d/oc6anhsjt

HTTP/1.1 200 OK
Server: nginx/1.15.0
Content-Type: text/html; charset=UTF-8
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/7.2.12
0: Content-Type: application/octet-stream
1: Content-Disposition: attachment; filename="oc6anhsjt.ico"
Cache-Control: no-cache, private
Date: Mon, 03 Jun 2019 02:23:03 GMT
Content-Disposition: attachment; filename=oc6anhsjt.ico
Set-Cookie: XSRF-TOKEN=eyJpdiI6IlVoXC8yOTVtQWRVT3ZuUmVqWitOcWhBPT0iLCJ2YWx1ZSI6InA3aHpSWE5pR0o3cUV5cEdjQXJySE4yVFJsdFVqQk5UOUtyXC9UQTZ2TXRLYlBUYWk1aFJ3UU5hVWk4TE5ibTdYIiwibWFjIjoiODY3ZmQ4ZTU1YzNjODRmODU2ZTgyNDJhN2Q2YjczNzRjY2MyZGIwZDVhMjFhZmMxNDU1NDJlNjZhOGM0NzYyZSJ9; expires=Tue, 04-Jun-2019 02:23:03 GMT; Max-Age=86400; path=/
Set-Cookie: sikrt_session=eyJpdiI6IkpRWjhlUEJvTTltWTBkUGFGa1h5bWc9PSIsInZhbHVlIjoicTdycmQ1U3czSGhoS3BFNER5SGo3bFo4OG1yMFFwRGxWZTdmSmZcL1dPNVdTUmROY1VPMUV2YXRNOW9HK1pUb2oiLCJtYWMiOiIzMjMxYjIwODE4NjVhNGQ3OTRmN2ViZTgxMDRmYTMyOGFkMzA1ZTM3YTNiNzZmMGUxYjc5MjdiYmYwZGQ0MWU1In0%3D; expires=Tue, 04-Jun-2019 02:23:03 GMT; Max-Age=86400; path=/; httponly
```

The trick to get Safari to download the file with the proper extension is to send the correct headers, in this case `Content-Type: application/octet-stream`.

Right off the bat you might notice this bit:

```bash
0: Content-Type: application/octet-stream
1: Content-Disposition: attachment; filename="oc6anhsjt.ico"
```

Something looks funky here, and that's because there shouldn't be a `0: ` in front of the header. Why is that? Because I was passing the headers as an array of strings instead of an associative array. Laravel's documentation doesn't explain how the headers array should be structured. Running the curl command helped me diagnose the issue.

**Before**

```php
[
    'Content-Type: application/octet-stream',
    ...
]
```

**After**

```php
[
    'Content-Type' => 'application/octet-stream',
    ...
]
```

Following this fix, Safari was able to download the file with the correct extension.

Running `curl -I` again produced the correct output:

```bash
curl -I http://sikrt.test/d/oc6anhsjt

HTTP/1.1 200 OK
Server: nginx/1.15.0
Content-Type: application/octet-stream
Content-Length: 610
Connection: keep-alive
X-Powered-By: PHP/7.2.12
Content-Disposition: attachment; filename=oc6anhsjt.ico
Cache-Control: no-cache, private
Date: Mon, 03 Jun 2019 02:27:05 GMT
Set-Cookie: XSRF-TOKEN=eyJpdiI6InIySU1uOEJcL0hDMFdyaUk3Q3BIKzB3PT0iLCJ2YWx1ZSI6IjVFaG9Iem1zeXY5UVdPeCtWdFkzXC95cVcwU2Njd0ZyMHFaMXd6bDQrUnJYNkJtRUV5THk4UlFPcjRXaTMzd2F0IiwibWFjIjoiZDA1MWU1YzEzYzVlMGE0OWZjMTIxNzdhOTNmMGU1YTY1MzRkMWYzMWU5M2RmYWZjMDVlZWU5YmUzYTU3ZjNhNCJ9; expires=Tue, 04-Jun-2019 02:27:05 GMT; Max-Age=86400; path=/
Set-Cookie: sikrt_session=eyJpdiI6IkxGT0lUZytKSXFuUWltOXZqSzAySHc9PSIsInZhbHVlIjoiazRDUHlUUHNEMTI3cGtkRktGVVFEMmo1QXRhc1MyVGE1OEdCNE9SZHJPWXRLbVowSXJLZDRcL3QwYTg4MVZFbFwvIiwibWFjIjoiNWU1NDllNDJiNTBiZDFiYzY0NThlNThjYTg4NmM0OGEyNzFmYmYwZjg1ODdhYzQzZjJjMzJhY2MyOWI0NThjOCJ9; expires=Tue, 04-Jun-2019 02:27:05 GMT; Max-Age=86400; path=/; httponly
```

The piece of code that handles the download looks something like this:

```php
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

// ...

$filesystem = new Filesystem(new MemoryAdapter()); // keep the file in memory
$filesystem->write('file', $filedata);

return response()->streamDownload(function () use ($filesystem) {
    echo $filesystem->read('file');
}, $filename, [
    'Content-Type' => 'application/octet-stream',
    'Content-Length' => $filesystem->getSize('file'),
    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
]);
```
