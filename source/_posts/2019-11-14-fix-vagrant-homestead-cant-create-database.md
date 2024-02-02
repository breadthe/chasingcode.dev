---
extends: _layouts.post
section: content
title: Fix Vagrant Homestead "Can't create database" Error
date: 2019-11-14
description: A technique for increasing the size of the MySQL partition in a Vagrant/Homestead local environment.
tags: [laravel]
featured: false
image: /assets/img/2019-11-14-fix-vagrant-homestead-cant-create-database.jpg
image_thumb: /assets/img/2019-11-14-fix-vagrant-homestead-cant-create-database.jpg
image_author: 
image_author_url: 
image_unsplash: 
---

Ever ran out of disk space on your Vagrant/Homestead database partition? Neither did I... until recently. Here's how it happened and how I fixed it.

## How did this even happen?

The image above is a screenshot of the error thrown by my HeidiSQL (Windows) DB client.

I had just imported a large amount of data into a few different databases for a Laravel project. I use [Homestead](https://laravel.com/docs/6.x/homestead) as my local dev environment for Laravel projects on both Mac and Windows.

Now this error in particular is not very helpful. It states that it can't create the database, without any context. It took some investigating before I found out what really caused it.

As you will later learn, Homestead creates a separate partition for storing the databases, and it provisions 10GB for this purpose. That should be more than enough for any amount of local apps, right? Well, sure, until you need to import production data on which to test certain functionality that you can't test without actual, live data.

> **Sidenote** I'm well aware that one way to handle this would be to write seeders but that particular project wasn't well suited for that. I needed not just live data but *historical* data as well. Finally, it was a lot quicker to import from prod than to write complex seeders.

## How do you even fix this?

**Disclaimer** This process was a lot of trial-and-error and I bungled some steps, but as I've mentioned before, my specialty is not sysadmin and the end result is close to what I wanted.

**WARNING** Try this at your own risk and only in your local environment, never in production, unless you really know what you're doing. But then you wouldn't be reading this article 😉

First thing was to find out more about this error. So I `SSH`ed into my Vagrant box (`vagrant ssh`) and ran `perror` on error `1006`:

```bash
$ perror 1006

MySQL error code 1006 (ER_CANT_CREATE_DB): Can't create database '%-.192s' (errno: %d)
```

Digging around the web I found a suggestion to fix this using `mysql_upgrade` (spoiler: it doesn't):

```bash
$ mysql_upgrade

Checking if update is needed.
Checking server version.
Running queries to upgrade MySQL server.
mysql_upgrade: [ERROR] 3: Error writing file './mysql/#sql-4876_5.frm' (Errcode: 28 - No space left on device)
```

Let's run `perror` again, on error `28` this time:

```bash
$ perror 28

OS error code  28:  No space left on device
```

Ah now I'm getting somewhere. Let me check the disk space real quick (more helpful [Linux commands here](/blog/useful-linux-commands/)):

```bash
$ df -h

Filesystem                               Size  Used Avail Use% Mounted on
udev                                     967M     0  967M   0% /dev
tmpfs                                    200M  7.0M  193M   4% /run
/dev/mapper/homestead--vg-root            18G  5.1G   12G  31% /
tmpfs                                    997M  8.0K  997M   1% /dev/shm
tmpfs                                    5.0M     0  5.0M   0% /run/lock
tmpfs                                    997M     0  997M   0% /sys/fs/cgroup
/dev/mapper/homestead--vg-mysql--master  9.8G  9.3G     0 100% /homestead-vg/master
vagrant                                  953G  167G  786G  18% /vagrant
home_vagrant_dbone                       953G  167G  786G  18% /home/vagrant/dbone
home_vagrant_dbtwo                       953G  167G  786G  18% /home/vagrant/dbtwo
home_vagrant_dbthree                     953G  167G  786G  18% /home/vagrant/dbthree
...
tmpfs                                    200M     0  200M   0% /run/user/1000
```

Note that I anonymized the actual databases to "dbone, dbtwo, etc" for this example.

The line `/dev/mapper/homestead--vg-mysql--master  9.8G  9.3G     0 100% /homestead-vg/master` indicates that the MySQL partition is full.

How do I know it is the DB partition? The database files are usually stored in `/var/lib/mysql` on Ubuntu Linux.

```bash
$ ls -al /var/lib/mysql

lrwxrwxrwx 1 root root 20 Sep 29 12:53 /var/lib/mysql -> /homestead-vg/master
```

This shows that `/var/lib/mysql` is aliased to `/homestead-vg/master`.

Run again with trailing `/` to see the actual contents:

```bash
$ ls -al /var/lib/mysql/

total 188552
drwxr-xr-x 23 mysql mysql     4096 Nov  9 20:23 .
drwxr-xr-x  3 root  root      4096 Sep 29 12:53 ..
-rw-r-----  1 mysql mysql       56 Sep 29 12:52 auto.cnf
drwxr-x---  2 mysql mysql     4096 Nov  9 18:35 dbone
drwxr-x---  2 mysql mysql     4096 Nov  9 18:45 dbtwo
drwxr-x---  2 mysql mysql     4096 Nov  9 18:49 dbthree
drwxr-x---  2 mysql mysql     4096 Nov  4 14:27 dbfour
-rw-r--r--  1 root  root         0 Sep 29 12:52 debian-5.7.flag
drwxr-x---  2 mysql mysql    12288 Nov  9 17:31 dbfive
drwxr-x---  2 mysql mysql     4096 Sep 29 12:53 homestead
-rw-r-----  1 mysql mysql      895 Nov  5 15:11 ib_buffer_pool
-rw-r-----  1 mysql mysql        0 Nov  9 19:53 ib_buffer_pool.incomplete
-rw-r-----  1 mysql mysql 79691776 Nov  9 20:18 ibdata1
-rw-r-----  1 mysql mysql 50331648 Nov  9 20:18 ib_logfile0
-rw-r-----  1 mysql mysql 50331648 Nov  9 19:11 ib_logfile1
-rw-r-----  1 mysql mysql 12582912 Nov  9 20:23 ibtmp1
...
drwx------  2 root  root     16384 Sep 29 12:53 lost+found
drwxr-x---  2 mysql mysql     4096 Nov  9 20:23 mysql
...
drwxr-x---  2 mysql mysql     4096 Nov  9 20:23 performance_schema
...
drwxr-x---  2 mysql mysql    12288 Sep 29 12:52 sys
...
```

Let's check how much space my databases take. The following command lists all the databases and their sizes on disk, sorted by size in descending order.

```bash
$ sudo du -ch -d 1 /var/lib/mysql/ | sort -shr

9.3G    /var/lib/mysql/
9.3G    total
4.0G    /var/lib/mysql/dbone
1.4G    /var/lib/mysql/dbtwo
1.1G    /var/lib/mysql/dbthree
833M    /var/lib/mysql/dbfour
831M    /var/lib/mysql/dbfive
495M    /var/lib/mysql/x
376M    /var/lib/mysql/xx
133M    /var/lib/mysql/xxx
75M     /var/lib/mysql/xxxx
25M     /var/lib/mysql/mysql
20M     /var/lib/mysql/xxxxx
2.2M    /var/lib/mysql/xxxxxx
1.1M    /var/lib/mysql/performance_schema
676K    /var/lib/mysql/sys
16K     /var/lib/mysql/lost+found
8.0K    /var/lib/mysql/xxxxxxx
8.0K    /var/lib/mysql/xxxxxxxx
8.0K    /var/lib/mysql/xxxxxxxxx
8.0K    /var/lib/mysql/xxxxxxxxxx
8.0K    /var/lib/mysql/homestead
8.0K    /var/lib/mysql/xxxxxxxxxxx
```

Next, I thought I should dig into the [Homestead provisioning script](https://github.com/laravel/settler/blob/master/scripts/provision.sh). Line 372 mentions that the MySQL storage partition is 10GB and can be expanded with `lvextend`. Looking at the total disk usage it's clear that I was hitting the limit.

## Increasing the size of the database partition

So now I know that I need to increase the size of the partition. Let's go with 20GB. Here's a [good explainer on lvextend](https://linux.die.net/man/8/lvextend).

**Take 1** What is the logical volume? After some trial-error, I figure it's `homestead-vg/thinpool` (get it from the Homestead provisioning script).

```bash
$ sudo lvextend -L +10G homestead-vg/thinpool

  Size of logical volume homestead-vg/thinpool_tdata changed from 40.00 GiB (10240 extents) to 50.00 GiB (12800 extents).
  Logical volume homestead-vg/thinpool_tdata successfully resized.
```

**Take 2** Read some more [here](https://www.rootusers.com/how-to-increase-the-size-of-a-linux-lvm-by-expanding-the-virtual-machine-disk/).
Actually no, it's `homestead-vg/mysql-master`. It comes from `homestead--vg-mysql--master`. The previous command just increased the size of my entire Vagrant box. Let's try this again...

```bash
$ sudo lvextend -L +10G homestead-vg/mysql-master

  Size of logical volume homestead-vg/mysql-master changed from 10.00 GiB (2560 extents) to 20.00 GiB (5120 extents).
  Logical volume homestead-vg/mysql-master successfully resized.
```

**Take 3** Extend the logical volume over the partition at `/dev/sda1`. Probably this is what I should have done initially.

```bash
$ sudo lvextend homestead-vg/mysql-master /dev/sda1

  WARNING: Sum of all thin volume sizes (79.29 GiB) exceeds the size of thin pool homestead-vg/thinpool and the amount of free space in volume group (59.29 GiB).
  WARNING: You have not turned on protection against thin pools running out of space.
  WARNING: Set activation/thin_pool_autoextend_threshold below 100 to trigger automatic extension of thin pools before they get full.
  Size of logical volume homestead-vg/mysql-master changed from 20.00 GiB (5120 extents) to 79.29 GiB (20299 extents).
  Logical volume homestead-vg/mysql-master successfully resized.
```

Oops, I think I might have accidentally increased the size of the MySQL partition to 80GB. Which is cool in my case, I have plenty of disk space on that particular dev machine.

```bash
$ sudo fdisk -l

...
Disk /dev/mapper/homestead--vg-mysql--master: 20 GiB, 21474836480 bytes, 41943040 sectors
Units: sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 65536 bytes / 65536 bytes
```

For some reason the MySQL database partition is still taking 20GB. Hmm... List the logical volumes:

```bash
$ sudo lvdisplay

...
--- Logical volume ---
  LV Path                /dev/homestead-vg/mysql-master
  LV Name                mysql-master
  VG Name                homestead-vg
  LV UUID                rYcEGB-dEB2-xJ4F-i8n4-u1KX-R7CU-xHmMhL
  LV Write Access        read/write
  LV Creation host, time vagrant, 2019-09-29 12:53:09 +0000
  LV Pool name           thinpool
  LV Status              available
  # open                 1
  LV Size                79.29 GiB
  Mapped size            12.03%
  Current LE             20299
  Segments               1
  Allocation             inherit
  Read ahead sectors     auto
  - currently set to     256
  Block device           253:6
```

Finally I found out that I needed to resize the file system so it can use the additional space:

```bash
$ sudo resize2fs /dev/homestead-vg/mysql-master

resize2fs 1.44.1 (24-Mar-2018)
Filesystem at /dev/homestead-vg/mysql-master is mounted on /homestead-vg/master; on-line resizing required
old_desc_blocks = 2, new_desc_blocks = 10
The filesystem on /dev/homestead-vg/mysql-master is now 20786176 (4k) blocks long.
```

Check the partition size again:

```bash
$ sudo fdisk -l

...
Disk /dev/mapper/homestead--vg-mysql--master: 79.3 GiB, 85140176896 bytes, 166289408 sectors
Units: sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 65536 bytes / 65536 bytes
```

Check the disk size one final time:

```bash
$ df -h

Filesystem                               Size  Used Avail Use% Mounted on
udev                                     967M     0  967M   0% /dev
tmpfs                                    200M  7.0M  193M   4% /run
/dev/mapper/homestead--vg-root            18G  5.1G   12G  31% /
tmpfs                                    997M  8.0K  997M   1% /dev/shm
tmpfs                                    5.0M     0  5.0M   0% /run/lock
tmpfs                                    997M     0  997M   0% /sys/fs/cgroup
/dev/mapper/homestead--vg-mysql--master   78G  9.3G   66G  13% /homestead-vg/master
vagrant                                  953G  167G  786G  18% /vagrant
home_vagrant_dbone                       953G  167G  786G  18% /home/vagrant/dbone
home_vagrant_dbtwo                       953G  167G  786G  18% /home/vagrant/dbtwo
home_vagrant_dbthree                     953G  167G  786G  18% /home/vagrant/dbthree
...
tmpfs                                    200M     0  200M   0% /run/user/1000
```

Well now it's way bigger than I wanted (80GB instead of 20GB) but at least it *should* have more space than I'll ever need.

## Conclusion

Don't try this at home kids. Or do, rather, as long as you stay away from production and limit it to your Vagrant environment. Keep in mind that starting at **Take 1** above I screwed up some steps by running an additional resize or two, which happened because I didn't understand correctly how logical and physical volume resizing works. I still don't 😬 but I was able to correct the problem and continue working.
