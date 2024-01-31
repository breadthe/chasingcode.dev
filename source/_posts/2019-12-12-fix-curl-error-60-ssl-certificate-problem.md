---
extends: _layouts.post
section: content
title: Fix cURL Error 60 SSL Certificate Problem
date: 2019-12-12
description: How to fix cURL error 60 in the local environment
tags: [windows,php]
featured: false
image: /assets/img/2019-12-12-fix-curl-error-60-ssl-certificate-problem.png
image_thumb: /assets/img/2019-12-12-fix-curl-error-60-ssl-certificate-problem.png
image_author: 
image_author_url: 
image_unsplash: 
---

Right after upgrading my local PHP environment to 7.4 on the Windows laptop that I use at work, I ran a Laravel artisan console command for an HTTP request to a 3rd party API. I ran the command in my Git Bash terminal. The request is done using Guzzle and I received the following cURL error:

```bash
GuzzleHttp\Exception\RequestException  : cURL error 60: SSL certificate problem: unable to get local issuer certificate (see https://curl.haxx.se/libcurl/c/libcurl-errors.html)

at C:\Users\MyUserName\code\myproject\vendor\guzzlehttp\guzzle\src\Handler\CurlFactory.php:201
  197|
  198|         // Create a connection exception if it was a specific error code.
  199|         $error = isset($connectionErrors[$easy->errno])
  200|             ? new ConnectException($message, $easy->request, null, $ctx)
> 201|             : new RequestException($message, $easy->request, $easy->response, null, $ctx);
  202|
  203|         return \GuzzleHttp\Promise\rejection_for($error);
  204|     }
  205|

Exception trace:

1   GuzzleHttp\Handler\CurlFactory::createRejection(Object(GuzzleHttp\Handler\EasyHandle))
    C:\Users\MyUserName\code\myproject\vendor\guzzlehttp\guzzle\src\Handler\CurlFactory.php:155

2   GuzzleHttp\Handler\CurlFactory::finishError(Object(GuzzleHttp\Handler\CurlHandler), Object(GuzzleHttp\Handler\EasyHandle), Object(GuzzleHttp\Handler\CurlFactory))
    C:\Users\MyUserName\code\myproject\vendor\guzzlehttp\guzzle\src\Handler\CurlFactory.php:105

Please use the argument -v to see more details.
```

I'm almost certain that the PHP 7.4 upgrade wasn't the only cause. Previously, I had screwed up a local SSL certificate that I was using for `https` in the browser for my local projects.

## Solution 1

The first thing I tried successfully was to ssh into the Vagrant box and run the artisan command from there. As expected this worked because Homestead is properly configured, including SSL certificates. If you don't care about being able to make Guzzle requests in your local terminal (using the locally-installed PHP), then try running it from the Vagrant box.

## Solution 2

Since I wanted to be able to run the command in the Git Bash terminal, I had to fix the problem.

First, if you don't already have a generic SSL certificate (local/test environment only - **NEVER USE THIS IN PRODUCTION**), grab one from [here](http://curl.haxx.se/ca/cacert.pem). I keep mine in the home folder which is `C:\Users\MyUserName\` on the PC.

Next, locate your PHP installation. In Windows, mine is at `C:\php-7.4`. Open `php.ini`, find the block show below and add the *absolute* path of the certificate to it:

```
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo = C:\Users\MyUserName\cacert.pem
```

That's it. Now you should be able to make Guzzle requests again from your local terminal.
