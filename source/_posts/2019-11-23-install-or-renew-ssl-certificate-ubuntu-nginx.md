---
extends: _layouts.post
section: content
title: How to Install or Renew a SSL Certificate in Ubuntu with Nginx
date: 2019-11-23
description: 
categories: [Linux,Forge]
featured: false
image: https://source.unsplash.com/y_ZPwFTCp84/?fit=max&w=1350
image_thumb: https://source.unsplash.com/y_ZPwFTCp84/?fit=max&w=200&q=75
image_author: Robert Anasch
image_author_url: https://unsplash.com/@diesektion
image_unsplash: true
---

To my consternation, the SSL certificate on my pet project [1secret.app](https://1secret.app/) expired when I least expected it, leaving the site in that dubious state where every browser displays an ugly security warning, essentially scaring away visitors. And since all my `http` traffic is automatically redirected to `https`, you couldn't access the site non-securely either.

So how did it end up here? Well, I let my [Forge](https://forge.laravel.com/) subscription expire in the hope that I will score a Black Friday deal. After all, Forge is not critical in day-to-day operations. To me it's mostly useful for provisioning new sites. Now though, it turns out that Forge also manages SSL certificates, renewing them automatically. How does it do that? It's a bit of a mystery but I couldn't rely on it this time.

Fortunately this story will be short. Because I use [Letsencrypt](https://letsencrypt.org/), I headed there for help, then I ended up on [Certbot](https://certbot.eff.org/lets-encrypt/ubuntubionic-nginx), an amazing automated tool that handles all the SSL heavy lifting for you.

If you hit that link, you'll notice it's already pre-configured with my own environment: **Ubuntu 18.04** running **Nginx**. I literally followed the instructions on this page to a T.

The only thing to pay attention to is Step 4 where you have the options of either letting Certbot configure Nginx automatically with the new certificate or just getting the certificate (leaving you with the task to configure Nginx appropriately). To avoid any drama, I chose option 1 and Certbot did an amazing job of auto-configuring everything.

> **Note 1** During Step 4 you'll be asked for an email address. It's up to you if you want to provide one. See below.

```bash
Enter email address (used for urgent renewal and security notices)

If you really want to skip this, you can run the client with
--register-unsafely-without-email but make sure you then backup your account key
from /etc/letsencrypt/accounts
```

> **Note 2** If you are running multiple sites on the same server (like I do), don't worry. Certbot scans for all the sites and asks you for which domains you'd like a certificate.

```bash
Which names would you like to activate HTTPS for?
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
1: 1secret.app
2: www.1secret.app
3: allmy.sh
4: www.allmy.sh
5: ...
6: ...
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Select the appropriate numbers separated by commas and/or spaces, or leave input
blank to select all options shown (Enter 'c' to cancel): 1,2
```

> **Note 3** A good tool to check the status of your SSL certificate is linked at the bottom of the Certbot instructions: [SSL Labs](https://www.ssllabs.com/ssltest/).

There's really nothing more to it. If you made it this far, chances are you were able to install or renew your SSL certificate(s).
