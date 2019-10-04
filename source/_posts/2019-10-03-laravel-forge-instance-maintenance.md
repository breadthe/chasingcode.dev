---
extends: _layouts.post
section: content
title: Maintenance Procedure for a Laravel Forge Instance
date: 2019-10-03
description: Documenting my process for maintaining a Laravel Forge Linux instance.
categories: [Laravel, Forge]
featured: false
image: https://source.unsplash.com/v_CxSroHKWg/?fit=max&w=1350
image_thumb: https://source.unsplash.com/v_CxSroHKWg/?fit=max&w=200&q=75
image_author: Matthew Hamilton
image_author_url: https://unsplash.com/@thatsmrbio
image_unsplash: true
---

## Preamble

I've been using [Laravel Forge](https://forge.laravel.com) for over a year at my day job, but also to provision and deploy my side project [1Secret.app](https://1secret.app/). To me, the biggest benefit that Forge brings is the ability to easily and quickly provision Laravel-ready server instances, whether on AWS, DigitalOcean, Linode or others.

My server OS of choice is Ubuntu, and Forge has been doing some sort of magic to keep it updated to the latest version. This means I'm currently running 18.04 on multiple instances. This is all good, however there's still some maintenance that I need to perform manually from time to time, namely OS security patch and package updates. I also like to keep an eye on disk space and clear some of that if necessary.

If, when you SSH into your Forge instance, you see a message like below...

```bash
14 packages can be updated.
1 update is a security update.


*** System restart required ***
Last login: Sun Sep  8 22:09:04 2019 from xxx.xxx.xxx.xxx
``` 

... that means it's probably time to update those packages. Here's my procedure for doing that, bearing in mind that I'm not a sysadmin, and everything you read below was cobbled together from various sources but works 👍 for me.

## The procedure(s)

### SSH into the instance

In my case, [1Secret.app](https://1secret.app/) is served from `104.200.17.161` so my command will be (`id_rsa` is my private SSH key):

```bash
ssh forge@104.200.17.161 -i ~/.ssh/id_rsa
```
### Check and reclaim disk space

**File system**

The file system can easily fill up with stuff like uploaded files, logs, database, etc. First I like to see an overview of the total disk usage.

```bash
df -h

Filesystem      Size  Used Avail Use% Mounted on
udev            985M     0  985M   0% /dev
tmpfs           200M  816K  199M   1% /run
/dev/xvda1       20G  7.1G   13G  37% /
tmpfs           996M     0  996M   0% /dev/shm
tmpfs           5.0M     0  5.0M   0% /run/lock
tmpfs           996M     0  996M   0% /sys/fs/cgroup
/dev/loop0       18M   18M     0 100% /snap/amazon-ssm-agent/1068
/dev/loop2       18M   18M     0 100% /snap/amazon-ssm-agent/930
/dev/loop4       18M   18M     0 100% /snap/amazon-ssm-agent/1335
/dev/loop1       89M   89M     0 100% /snap/core/7169
/dev/loop5       89M   89M     0 100% /snap/core/7270
tmpfs           200M     0  200M   0% /run/user/1001
```

In this example, the important line is `/dev/xvda1       20G  7.1G   13G  37% /` because that is my primary disk. Here, it is 37% full out of a total of 20 GB, which is good.

**Application storage**

Laravel apps store stuff and things in `myapp/storage`. If you find a lot of disk space is consumed by the storage folder, refering to my [Useful Linux Commands](https://chasingcode.dev/blog/useful-linux-commands/) article, you can run something like this to check which subfolder takes the most space:

```bash
du -ch -d 1 | sort -hr

760K	total
760K	.
704K	./framework
28K	./logs
16K	./app
8.0K	./debugbar
```
In this example there's almost no space used. Let's move on.

**Journal size**

Another place where a lot of storage can potentially be used is the system journal. This is a where Linux stores a lot of logging data, for example system events and such. It tends to grow in size over time. Depending how important this data is to you, you can choose to delete some or all of it, or restrict how much space it can use.

Here's how I would check how much space the system journal uses on my Ubuntu 18.04 instances:

```bash
du -ach /var/log/journal/ | sort -hr

1.8G    total
1.8G    /var/log/journal/1302ef9b7d514d588b562228feb06a4c
1.8G    /var/log/journal/
81M     /var/log/journal/1302ef9b7d514d588b562228feb06a4c/system@2b1e5536b8964276bd01478033377b9b-000000000017bdd9-00058b9e4032a3be.journal
81M     /var/log/journal/1302ef9b7d514d588b562228feb06a4c/system@2b1e5536b8964276bd01478033377b9b-0000000000167546-00058adae74a631a.journal
...
41M     /var/log/journal/1302ef9b7d514d588b562228feb06a4c/system.journal
8.1M    /var/log/journal/1302ef9b7d514d588b562228feb06a4c/user-1001@f935c142f48041da86bb9920da4f84de-000000000003acdb-0005815031482878.journal
...
8.0M    /var/log/journal/1302ef9b7d514d588b562228feb06a4c/user-1001.journal
8.0M    /var/log/journal/1302ef9b7d514d588b562228feb06a4c/user-1000.journal
```

1.8 GB may not seem much, but when your entire instance is 20 GB, that's actually quite significant.

**Clear journal entries manually**

To recover disk space, journal entries can be cleared manually in a couple ways.

Retain only the past two days:

```bash
sudo journalctl --vacuum-time=2d
```

Retain only the past 500 MB:

```bash
sudo journalctl --vacuum-size=500MB
```

**Restrict max journal size**

The journal size can be restricted through the configuration.

```bash
sudo vi /etc/systemd/journald.conf
```

Set `SystemMaxUse=500M` to restrict it to 500M.

Restart the `systemd-journald` service ([see this for more details](https://unix.stackexchange.com/questions/253203/how-to-tell-journald-to-re-read-its-configuration)):

```bash
sudo systemctl restart systemd-journald
```

**Clear /usr/src/**

**CAUTION** Working with AWS instances, as well as S3, I found lots of `linux-aws-headers-*` files in `/usr/src/`. Based on my research, these should be safe to delete, which I did without negative consequences, but you should be extra careful just in case I'm wrong.

To clear the AWS-specific files out of `/usr/src/`, run this command:

```bash
sudo apt-get purge linux-aws-headers-4.15.0
```

### Update system packages

Finally we're ready to update the system packages. The commands below can be run in sequence to upgrade all the packages. You can skip the `list` commands if you wish, those are just to give you an overview of what packages there are.

You may see a prompt asking if you want to upgrade certain packages or configurations. That's where you need to be extra careful because it may overwrite your custom configurations. In my case, I usually get two prompts, for Redis and php.ini.

Update Redis? `Y`

Update php.ini? `N` (keep the local version currently installed)

```bash
# updates available list of packages & versions
sudo apt update

# lists the installed packages
sudo apt list --installed

# lists the packages that can be upgraded
sudo apt list --upgradeable

# actually perform the packages
sudo apt upgrade

# removes packages that are no longer required
sudo apt autoremove
```

Finally, reboot the server.

```bash
sudo reboot
```

### Check if services are running

Once the system has rebooted, SSH back into it. You should be greeted with this shiny new message:

```bash
0 packages can be updated.
0 updates are security updates.
```
 
Now check if your vital services are running. In my case there are only 3 I care about:

```bash
systemctl status systemd-journald supervisor redis
```

If these are green (`Active: active (running)`), you are good to go.

This concludes my maintenance procedure for Laravel Forge provisioned servers. I will update these instructions as I see fit, but in the meantime keep on forging ahead!
