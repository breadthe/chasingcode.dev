---
extends: _layouts.post
section: content
title: Upgrade PHP 7.4 to 8.0 on Ubuntu
date: 2021-03-05
description: PHP 7.3 to 8.0 upgrade procedure on Ubuntu 
categories: [PHP,Linux]
featured: false
image: 
image_thumb: 
image_author: 
image_author_url: 
image_unsplash: 
---

I host several websites on a Linode VPS, originally provisioned with Laravel Forge. I have long since canceled my Forge subscription, and I do my own maintenance, manually. I may not be the quickest to upgrade to the latest version of anything, but I will do it eventually.

As an indie maker with zero revenue from my side projects, it wasn't making financial sense to pay for Forge. The biggest value Forge brought me was the initial provisioning of the instance. Afterwards, I continued to deploy code manually (how hard can `git pull` be?), and do my own basic server maintenance. I've been doing this successfully for the better part of the last 2 years.

This guide is about upgrading from PHP 7.4 to 8.0 on Ubuntu 18.04. As of this writing, I have yet to upgrade to Ubuntu 20.04, but it will happen soon(ish).

The instructions are partly based on this excellent [article](https://php.watch/articles/php-8.0-installation-update-guide-debian-ubuntu), but I've added many specifics, details, and pitfalls I encountered in my own situation. It wasn't exactly smooth sailing, as you'll see.

## Prep

SSH into the instance, then...

```bash
# Check PHP version
php -v
PHP 7.4.15 (cli) (built: Feb 23 2021 15:12:05) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
    with Zend OPcache v7.4.15, Copyright (c), by Zend Technologies

# List all PHP packages
dpkg -l | grep php | tee packages.txt

# List
ii  php-common                             2:81+ubuntu18.04.1+deb.sury.org+1                                  all          Common files for PHP packages
ii  php-igbinary                           3.2.1+2.0.8-6+ubuntu18.04.1+deb.sury.org+1                         amd64        igbinary PHP serializer
ii  php-memcached                          3.1.5+2.2.0-9+ubuntu18.04.1+deb.sury.org+1                         amd64        memcached extension module for PHP, uses libmemcached
ii  php-msgpack                            2.1.2+0.5.7-6+ubuntu18.04.1+deb.sury.org+1                         amd64        PHP extension for interfacing with MessagePack
ii  php-pear                               1:1.10.12+submodules+notgz+20210212-1+ubuntu18.04.1+deb.sury.org+1 all          PEAR Base System
ii  php7.4-bcmath                          7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        Bcmath module for PHP
ii  php7.4-cli                             7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        command-line interpreter for the PHP scripting language
ii  php7.4-common                          7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        documentation, examples and common module for PHP
ii  php7.4-curl                            7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        CURL module for PHP
ii  php7.4-dev                             7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        Files for PHP7.4 module development
ii  php7.4-fpm                             7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        server-side, HTML-embedded scripting language (FPM-CGI binary)
ii  php7.4-gd                              7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        GD module for PHP
ii  php7.4-igbinary                        3.2.1+2.0.8-6+ubuntu18.04.1+deb.sury.org+1                         amd64        igbinary PHP serializer
ii  php7.4-imap                            7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        IMAP module for PHP
ii  php7.4-intl                            7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        Internationalisation module for PHP
ii  php7.4-json                            7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        JSON module for PHP
ii  php7.4-mbstring                        7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        MBSTRING module for PHP
rc  php7.4-memcached                       3.1.5+2.2.0-9+ubuntu18.04.1+deb.sury.org+1                         amd64        memcached extension module for PHP, uses libmemcached
ii  php7.4-msgpack                         2.1.2+0.5.7-6+ubuntu18.04.1+deb.sury.org+1                         amd64        PHP extension for interfacing with MessagePack
ii  php7.4-mysql                           7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        MySQL module for PHP
ii  php7.4-opcache                         7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        Zend OpCache module for PHP
ii  php7.4-pgsql                           7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        PostgreSQL module for PHP
ii  php7.4-readline                        7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        readline module for PHP
ii  php7.4-soap                            7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        SOAP module for PHP
ii  php7.4-sqlite3                         7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        SQLite3 module for PHP
ii  php7.4-xml                             7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        DOM, SimpleXML, XML, and XSL module for PHP
ii  php7.4-zip                             7.4.15-7+ubuntu18.04.1+deb.sury.org+1                              amd64        Zip module for PHP
ii  php8.0-common                          8.0.2-7+ubuntu18.04.1+deb.sury.org+1                               amd64        documentation, examples and common module for PHP
ii  php8.0-igbinary                        3.2.1+2.0.8-6+ubuntu18.04.1+deb.sury.org+1                         amd64        igbinary PHP serializer
ii  php8.0-memcached                       3.1.5+2.2.0-9+ubuntu18.04.1+deb.sury.org+1                         amd64        memcached extension module for PHP, uses libmemcached
ii  php8.0-msgpack                         2.1.2+0.5.7-6+ubuntu18.04.1+deb.sury.org+1                         amd64        PHP extension for interfacing with MessagePack
ii  pkg-php-tools                          1.35ubuntu1                                                        all          various packaging tools and scripts for PHP packages
```

## Add PPAs

```bash
# Add ondrej/php PPA
sudo add-apt-repository ppa:ondrej/php # Press enter when prompted.
# CAVEATS:
# 1. If you are using php-gearman, you need to add ppa:ondrej/pkg-gearman
# 2. If you are using apache2, you are advised to add ppa:ondrej/apache2
# 3. If you are using nginx, you are advised to add ppa:ondrej/nginx-mainline or ppa:ondrej/nginx

sudo add-apt-repository ppa:ondrej/nginx

# Remove a repository (not needed here, listed for reference)
# sudo add-apt-repository --remove ppa:ondrej/nginx

# Check if PPA was added - should see a number of entries
grep ^ /etc/apt/sources.list /etc/apt/sources.list.d/* | grep ondrej/php
grep ^ /etc/apt/sources.list /etc/apt/sources.list.d/* | grep ondrej/nginx

sudo apt-get update
```

## Install PHP 8.0

```bash
sudo apt install php8.0-common php8.0-cli -y

# Check version
php -v
PHP 8.0.2 (cli) (built: Feb 23 2021 15:13:59) ( NTS )
Copyright (c) The PHP Group
Zend Engine v4.0.2, Copyright (c) Zend Technologies
    with Zend OPcache v8.0.2, Copyright (c), by Zend Technologies

# Check modules (each will appear on its own line, listed on a single line here for brevity)
php -m
[PHP Modules] calendar Core ctype date exif FFI fileinfo filter ftp gettext hash iconv igbinary json libxml memcached msgpack openssl pcntl pcre PDO Phar posix readline Reflection session shmop sockets sodium SPL standard sysvmsg sysvsem sysvshm tokenizer Zend OPcache zlib
[Zend Modules]
Zend OPcache

# Install additional extensions that were present in 7.4
# Note: no need to install php8.0-json; it's already provided by other packages  
sudo apt install php8.0-{bcmath,curl,dev,fpm,gd,igbinary,imap,intl,mbstring,memcached,msgpack,mysql,opcache,pgsql,readline,soap,sqlite3,xml,zip}
```

## Cleanup

Since I won't be using old versions of PHP (< 7.4), now is a good time to remove them.

```bash
# Purge old packages, in my case from PHP 5.6 thru 7.3
sudo apt purge '^php5.6.*'
sudo apt purge '^php7.0.*'
sudo apt purge '^php7.1.*'
sudo apt purge '^php7.2.*'
sudo apt purge '^php7.3.*'
```

## Update Nginx config for each site

This is for Nginx servers only. Sorry, I can't help you with Apache.

Repeat the procedure for each site. There's a way to automate it, probably with `sed` but I don't do this often enough to warrant the  

```bash
sudo vi /etc/nginx/sites-enabled/example.com

# Look for the following block
location ~ \.php$ {
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock; # change to php8.0-fpm.sock or even better to php8.0-fpm.sock
    fastcgi_index index.php;
    include fastcgi_params;
}

# Test Nginx config
sudo nginx -t
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful

# Restart PHP FPM & Nginx
sudo service php8.0-fpm restart
sudo service nginx restart
```

**Note** The reason I recommend using the generic `php-fpm.sock` instead of `php8.0-fpm.sock`  is because, on my server at least, `php-fpm.sock` is actually aliased to `php8.0-fpm.sock`. Run these commands to find out:

```bash
ls -al /var/run/php/php-fpm.sock # /var/run/php/php-fpm.sock -> /etc/alternatives/php-fpm.sock
ls -al /etc/alternatives/php-fpm.sock # /etc/alternatives/php-fpm.sock -> /run/php/php8.0-fpm.sock
```

I don't know the specifics of why it is so, but I assume it was done as part of the PHP 8 upgrade, which works really well for me as I don't have to worry about changing the Nginx config the next time I upgrade PHP.

## Composer install errors?

Let's say that, after upgrading PHP to the shiny new 8.0, you want to run `composer install --no-interaction --prefer-dist --optimize-autoloader` in your Laravel project, and see the following errors:

```bash
Deprecation Notice: Required parameter $path follows optional parameter $schema in phar:///usr/local/bin/composer/vendor/justinrainbow/json-schema/src/JsonSchema/Constraints/UndefinedConstraint.php:62
Deprecation Notice: Required parameter $path follows optional parameter $schema in phar:///usr/local/bin/composer/vendor/justinrainbow/json-schema/src/JsonSchema/Constraints/UndefinedConstraint.php:108
Deprecation Notice: Method ReflectionParameter::getClass() is deprecated in phar:///usr/local/bin/composer/src/Composer/Repository/RepositoryManager.php:130
Deprecation Notice: Method ReflectionParameter::getClass() is deprecated in phar:///usr/local/bin/composer/src/Composer/Repository/RepositoryManager.php:130
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
PHP Fatal error:  Uncaught ArgumentCountError: array_merge() does not accept unknown named parameters in phar:///usr/local/bin/composer/src/Composer/DependencyResolver/DefaultPolicy.php:84
Stack trace:
#0 [internal function]: array_merge()
#1 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/DefaultPolicy.php(84): call_user_func_array()
#2 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/Solver.php(387): Composer\DependencyResolver\DefaultPolicy->selectPreferredPackages()
#3 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/Solver.php(740): Composer\DependencyResolver\Solver->selectAndInstall()
#4 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/Solver.php(231): Composer\DependencyResolver\Solver->runSat()
#5 phar:///usr/local/bin/composer/src/Composer/Installer.php(489): Composer\DependencyResolver\Solver->solve()
#6 phar:///usr/local/bin/composer/src/Composer/Installer.php(232): Composer\Installer->doInstall()
#7 phar:///usr/local/bin/composer/src/Composer/Command/InstallCommand.php(122): Composer\Installer->run()
#8 phar:///usr/local/bin/composer/vendor/symfony/console/Command/Command.php(245): Composer\Command\InstallCommand->execute()
#9 phar:///usr/local/bin/composer/vendor/symfony/console/Application.php(835): Symfony\Component\Console\Command\Command->run()
#10 phar:///usr/local/bin/composer/vendor/symfony/console/Application.php(185): Symfony\Component\Console\Application->doRunCommand()
#11 phar:///usr/local/bin/composer/src/Composer/Console/Application.php(281): Symfony\Component\Console\Application->doRun()
#12 phar:///usr/local/bin/composer/vendor/symfony/console/Application.php(117): Composer\Console\Application->doRun()
#13 phar:///usr/local/bin/composer/src/Composer/Console/Application.php(113): Symfony\Component\Console\Application->run()
#14 phar:///usr/local/bin/composer/bin/composer(61): Composer\Console\Application->run()
#15 /usr/local/bin/composer(24): require('...')
#16 {main}
  thrown in phar:///usr/local/bin/composer/src/Composer/DependencyResolver/DefaultPolicy.php on line 84

Fatal error: Uncaught ArgumentCountError: array_merge() does not accept unknown named parameters in phar:///usr/local/bin/composer/src/Composer/DependencyResolver/DefaultPolicy.php:84
Stack trace:
#0 [internal function]: array_merge()
#1 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/DefaultPolicy.php(84): call_user_func_array()
#2 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/Solver.php(387): Composer\DependencyResolver\DefaultPolicy->selectPreferredPackages()
#3 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/Solver.php(740): Composer\DependencyResolver\Solver->selectAndInstall()
#4 phar:///usr/local/bin/composer/src/Composer/DependencyResolver/Solver.php(231): Composer\DependencyResolver\Solver->runSat()
#5 phar:///usr/local/bin/composer/src/Composer/Installer.php(489): Composer\DependencyResolver\Solver->solve()
#6 phar:///usr/local/bin/composer/src/Composer/Installer.php(232): Composer\Installer->doInstall()
#7 phar:///usr/local/bin/composer/src/Composer/Command/InstallCommand.php(122): Composer\Installer->run()
#8 phar:///usr/local/bin/composer/vendor/symfony/console/Command/Command.php(245): Composer\Command\InstallCommand->execute()
#9 phar:///usr/local/bin/composer/vendor/symfony/console/Application.php(835): Symfony\Component\Console\Command\Command->run()
#10 phar:///usr/local/bin/composer/vendor/symfony/console/Application.php(185): Symfony\Component\Console\Application->doRunCommand()
#11 phar:///usr/local/bin/composer/src/Composer/Console/Application.php(281): Symfony\Component\Console\Application->doRun()
#12 phar:///usr/local/bin/composer/vendor/symfony/console/Application.php(117): Composer\Console\Application->doRun()
#13 phar:///usr/local/bin/composer/src/Composer/Console/Application.php(113): Symfony\Component\Console\Application->run()
#14 phar:///usr/local/bin/composer/bin/composer(61): Composer\Console\Application->run()
#15 /usr/local/bin/composer(24): require('...')
#16 {main}
  thrown in phar:///usr/local/bin/composer/src/Composer/DependencyResolver/DefaultPolicy.php on line 84
```

Oops, apparently I completely forgot that my server still runs Composer 1.0, while my local environment was upgraded to 2.0 a long time ago. Time to upgrade the server too.

## Upgrade Composer from 1.0 to 2.0

This [article](https://blog.laravel.com/upgrading-to-composer-v2) partially covers the procedure, but here are my own steps:

```bash
# Check version
composer --version
Composer version 1.10.1 2020-03-13 20:34:27

# Upgrade Composer to 2.0
sudo composer self-update

# Downgrade Composer to 1.0 (in case you need it)
# sudo composer self-update --rollback # return to version 1.10.1

# Check version
composer --version
Composer version 2.0.11 2021-02-24 14:57:23
```

`composer install` should once again work without issues.

## 500 Internal Server Error

Everything looks fine and dandy, right? Not so fast. There's always a final wrench in the proverbial gears. You may not encounter this specific issue, but it's absolutely worth documenting.

When I loaded one of my main Laravel sites in the browser, I was presented with a nice blank page (production client reporting is off as it should be), but with a `500 Internal Server Error` in the dev console. So let's tail the Nginx app log to see what is going on, using `tail -f /var/log/nginx/example.com-error.log`: 

```bash
2021/03/05 06:42:09 [error] 836#836: *1 FastCGI sent in stderr: "PHP message: PHP Fatal error:  Uncaught ErrorException: file_put_contents(/home/forge/example.com/storage/framework/views/2e31adb7dfd4e14cc6108d8b49272e43adaa7371.php): Failed to open stream: Permission denied in /home/forge/example.com/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php:135
Stack trace:
#0 [internal function]: Illuminate\Foundation\Bootstrap\HandleExceptions->handleError()
#1 /home/forge/example.com/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(135): file_put_contents()
#2 /home/forge/example.com/vendor/laravel/framework/src/Illuminate/View/Compilers/BladeCompiler.php(150): Illuminate\Filesystem\Filesystem->put()
#3 /home/forge/example.com/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(51): Illuminate\View\Compilers\BladeCompiler->compile()
#4 /home/forge/example.com/vendor/facade/ignition/src/Views/Engines/CompilerEngine.php(37): Illuminate\View\Engines\CompilerEngine->get()
#5 /home/forge/example.com/vendor/laravel/fram...PHP message: PHP Fatal error:  Uncaught ErrorException: file_put_contents(/home/forge/example.com/storage/framework/views/2e31adb7dfd4e14cc6108d8b49272e43adaa7371.php): Failed to open stream: Permission denied in /home/forge/example.com/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php:135
Stack trace:
#0 [internal function]: Illuminate\Foundation\Bootstrap\HandleExceptions->handleError()
#1 /home/forge/example.com/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php(135): file_put_contents()
#2 /home/forge/example.com/vendor/laravel/framework/src/Illuminate/View/Compilers/BladeCompiler.php(150): Illuminate\Filesystem\Filesystem->put()
#3 /home/forge/example.com/vendor/laravel/framework/src/Illuminate/View/Engines/CompilerEngine.php(51): Illuminate\View\Compilers\BladeCompiler->compile()
#4 /home/forge/example.com/vendor/facade/ignition/src/Views/Engines/CompilerEngine.php(37): Illuminate\View\Engines\CompilerEngine->get()
```

At first glance it looks like Laravel doesn't have permissions to write to the `storage/` folder.

After some digging, I realized that ownership and permissions for the `storage/` folder have changed for some reason. I seem to recall a similar situation from a couple of years back.

An easy way to find if permissions are out of whack is to compare with another site that still works. Right away I noticed that the sub-folders in `storage/` had `755` permissions instead of `775`.

```bash
# Before 755
ls -al /home/forge/example.com/storage/framework/
total 76
drwxr-xr-x 6 forge forge  4096 Mar  5 07:00 .
drwxr-xr-x 6 forge forge  4096 Aug 23  2019 ..
drwxr-xr-x 3 forge forge  4096 Aug 23  2019 cache
-rwxr-xr-x 1 forge forge   103 Aug 23  2019 .gitignore
drwxr-xr-x 2 forge forge 40960 Mar  5 06:16 sessions
drwxr-xr-x 2 forge forge  4096 Aug 23  2019 testing
drwxr-xr-x 2 forge forge 12288 Mar  5 06:37 views

# Recursively fix ownership and permissions 
sudo chown -R forge:www-data storage
sudo chmod -R ug+w storage

# After 775
ls -al /home/forge/example.com/storage/framework/
total 48
drwxrwxr-x 6 forge forge  4096 Jan 19  2020 .
drwxrwxr-x 5 forge forge  4096 Jan 19  2020 ..
drwxrwxr-x 3 forge forge  4096 Jan 19  2020 cache
-rwxrwxr-x 1 forge forge   103 Jan 19  2020 .gitignore
drwxr-xr-x 2 forge forge 40960 Mar  5 06:16 sessions
drwxrwxr-x 2 forge forge  4096 Jan 19  2020 testing
drwxr-xr-x 2 forge forge 12288 Mar  5 06:37 views

php artisan cache:clear
composer dumpautoload
sudo service nginx restart
# OK
```

## The end

This concludes the PHP 7.4 -> 8.0 upgrade. All systems are green. Lessons were learned.