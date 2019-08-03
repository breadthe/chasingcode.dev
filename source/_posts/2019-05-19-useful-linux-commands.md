---
extends: _layouts.post
section: content
title: Useful Linux Commands
date: 2019-05-19
description: A collection of useful Linux commands for developers.
categories: [Linux]
featured: false
image: https://source.unsplash.com/Tjbk79TARiE/?fit=max&w=1350
image_thumb: https://source.unsplash.com/Tjbk79TARiE/?fit=max&w=200&q=75
image_author: Sai Kiran Anagani
image_author_url: https://unsplash.com/@_imkiran
image_unsplash: true
---

This is my collection of useful Linux shell commands from the perspective of a developer who is not primarily a sysadmin, yet uses Linux on a daily basis to test and deploy code in local, staging, and production environments.

Many of these are curated from the amazing [Server for hackers](https://serversforhackers.com/) course.

# SSH Commands

## Generate an SSH key

```bash
ssh-keygen -t rsa -C "user@example.com" -b 4096
# optionally add a passphrase
```

## Add an SSH key to your keychain (Mac)

Add a key to the keychain.

```
ssh-add -K ~/.ssh/id_rsa
# enter passphrase
```

List all the keys in your keychain.

```bash
ssh-keygen -l
```

# Copy text to the clipboard

## Mac

```bash
pbcopy < ~/.ssh/id_rsa.pub
# or
cat ~/.ssh/id_rsa.pub | pbcopy
```

## Ubuntu

```bash
cat ~/.ssh/id_rsa.pub | /dev/clipboard
```

# lsb_release

Shows info about the Linux distribution.

```bash
lsb_release -a
 ```

**Sample Output**

```bash
No LSB modules are available.
Distributor ID: Ubuntu
Description:    Ubuntu 18.04.2 LTS
Release:        18.04
Codename:       bionic
```

# uname

Shows system info.

```bash
uname -a
```

**Sample Output**

```bash
Linux thebolapp-staging 4.15.0-1035-aws #37-Ubuntu SMP Mon Mar 18 16:15:14 UTC 2019 x86_64 x86_64 x86_64 GNU/Linux
```

```bash
uname -r
```

**Sample Output**

```bash
4.15.0-1035-aws
```

```bash
uname -i
```

```bash
x86_64
```

# df -h

Shows file system disk space (`-h` for human-readable file sizes).

```bash
df -h
```

**Sample Output**

```bash
Filesystem      Size  Used Avail Use% Mounted on
udev            985M     0  985M   0% /dev
tmpfs           200M  816K  199M   1% /run
/dev/xvda1       20G  6.9G   13G  36% /
tmpfs           996M     0  996M   0% /dev/shm
tmpfs           5.0M     0  5.0M   0% /run/lock
tmpfs           996M     0  996M   0% /sys/fs/cgroup
/dev/loop0       18M   18M     0 100% /snap/amazon-ssm-agent/1068
/dev/loop2       90M   90M     0 100% /snap/core/6673
/dev/loop3       18M   18M     0 100% /snap/amazon-ssm-agent/930
/dev/loop5       92M   92M     0 100% /snap/core/6531
/dev/loop6       90M   90M     0 100% /snap/core/6818
/dev/loop1       18M   18M     0 100% /snap/amazon-ssm-agent/1335
tmpfs           200M     0  200M   0% /run/user/1001
```

# `du storage/ -cah -d 1 -t 20M | sort -hr`

Disk usage. Useful to check how much space a directory, its subdirectories, and files, occupy. These are just some of the most useful flags and options that I use.

- `storage/` check inside the specified directory (by default will check the current root)
- `-c` shows a summary of the total
- `-a` shows files in addition to directories
- `-h` human readable format
- `-d 1` looks 1 directory deep
- `-t 50M` shows only files/directories over the specified size
- `| sort -hr` sort by size (`-h` sorts by human-readable sizes) (`-r` sorts in descending order of size)

**Examples**

Show the size of all 1st level subdirectories.

```bash
du -h -d 1
181M    ./vendor
972K    ./resources
112K    ./config
113M    ./storage
116K    ./tests
728K    ./app
148K    ./database
36K     ./routes
26M     ./.git
40K     ./bootstrap
9.0M    ./public
331M    .
```

Show the size of all 1st level subdirectories and files.

```bash
du -ah -d 1
181M    ./vendor
368K    ./composer.lock
4.0K    ./.env
972K    ./resources
4.0K    ./.gitignore
112K    ./config
113M    ./storage
324K    ./yarn.lock
4.0K    ./server.php
20K     ./README.md
4.0K    ./composer.json
4.0K    ./artisan
116K    ./tests
728K    ./app
4.0K    ./.gitattributes
148K    ./database
4.0K    ./webpack.mix.js
4.0K    ./phpunit.xml
4.0K    ./.env.example
36K     ./routes
32K     ./tailwind.js
26M     ./.git
4.0K    ./.editorconfig
40K     ./bootstrap
9.0M    ./public
4.0K    ./phpunit-printer.yml
4.0K    ./package.json
331M    .
```

Show the size of all 1st level subdirectories inside the `storage/` folder.

```bash
du storage/ -cah -d 1
4.0K    storage/oauth-public.key
3.2M    storage/framework
110M    storage/app
260K    storage/logs
4.0K    storage/oauth-private.key
113M    storage/
113M    total
```

Show the size of all 1st level subdirectories, with a summary of the total, sorted by size.

```bash
du -ch -d 1 | sort -h
36K     ./routes
40K     ./bootstrap
112K    ./config
116K    ./tests
148K    ./database
728K    ./app
972K    ./resources
9.0M    ./public
26M     ./.git
113M    ./storage
181M    ./vendor
331M    .
331M    total
```

Show the size of all 1st level subdirectories that are larger than 20M, with a summary of the total, sorted by descending size.

```bash
du -ch -d 1 -t 20M | sort -hr
331M    total
331M    .
181M    ./vendor
113M    ./storage
26M     ./.git
```

# free

Shows memory + swap usage.

```bash
free -h
```

**Sample Output**

```bash
              total        used        free      shared  buff/cache   available
Mem:           1.9G        704M        361M         17M        925M        1.1G
Swap:          1.0G         39M        984M
```

# ps

Shows currently running processes.

```bash
ps -aux
```

**Sample Output**

```bash
USER       PID %CPU %MEM    VSZ   RSS TTY      STAT START   TIME COMMAND
root         1  0.0  0.4 225480  9072 ?        Ss   Apr09   1:35 /sbin/init
root         2  0.0  0.0      0     0 ?        S    Apr09   0:00 [kthreadd]
root         4  0.0  0.0      0     0 ?        I<   Apr09   0:00 [kworker/0:0H]
root         6  0.0  0.0      0     0 ?        I<   Apr09   0:00 [mm_percpu_wq]
root         7  0.0  0.0      0     0 ?        S    Apr09   3:18 [ksoftirqd/0]
root         8  0.0  0.0      0     0 ?        I    Apr09   9:29 [rcu_sched]
root         9  0.0  0.0      0     0 ?        I    Apr09   0:00 [rcu_bh]
root        10  0.0  0.0      0     0 ?        S    Apr09   0:00 [migration/0]
...
```

To sort by **descending memory** usage `ps aux --sort -rss`.

As above but **get first n lines** `ps aux --sort -rss | head -n15`.

# chmod

Change user, group, other permissions.

```bash
chmod u=rwx,g=rx,o=-rwx .ssh

# equivalent to
chmod u+rwx,g+rx,o-rwx .ssh
```

More advanced example:

```bash
chmod u-rw+x,g-rw+x,o-r+wx XXX

# output
---x--x-wx  1 forge forge     0 May 17 19:14 XXX*
```

