---
extends: _layouts.post
section: content
title: How to Fix Laravel's Dreaded "No input file specified" Error
date: 2019-11-10
description: A quick way to fix Laravel's "No input file specified" error when setting up a new project.
categories: [Laravel]
featured: false
image: /assets/img/2019-11-10-laravel-no-input-file-specified.jpg
image_thumb: /assets/img/2019-11-10-laravel-no-input-file-specified.jpg
image_author: 
image_author_url: 
image_unsplash: 
---

The first few times I ran into the "No input file specified" error while trying to get a new Laravel project working in my local environment, it took me a while to figure out.
 
Fear not, Laravel beginners. Despite having started more Laravel projects than I can count, I'm still tripped out by this error, if I'm not paying attention.

**Disclosure** My local environment has always been [Homestead/Vagrant](https://laravel.com/docs/6.x/homestead) on a Mac or PC. I've never used Valet, Docker or other methods. As such, these tips may only apply to a Homestead environment.

## The fix

More often than not, the "No input file specified" error happens when you don't map your local project to the Vagrant folder properly in your `Homestead.yaml` file.

To simplify things, I'll just show you the relevant portions of my own `Homestead.yaml`.

```yaml
folders:
    - map: ~/source/laravel/my-awesome-project-1
      to: /home/vagrant/my-awesome-project-1
    - map: ~/source/laravel/my-awesome-project-2
      to: /home/vagrant/my-awesome-project-2

sites:
    - map: awesomeproject1.test
      to: /home/vagrant/my-awesome-project-1/public
    - map: awesomeproject2.test
      to: /home/vagrant/my-awesome-project-2/public

databases:
    - awesomeproject1
    - awesomeproject2
```

For my latest project, for example, I had set up the `sites` and `databases` sections properly, but because I had a lot of sites and projects, I forgot to scroll to the `folders` section towards the top of the file. So when I loaded up the test site's URL `awesomeproject1.test` in my browser, I was presented with the always-charming "No input file specified" message.

The fix was to add the relevant entries for `map` and `to`.

**Heads up!** After making changes to `Homestead.yaml`, if Vagrant is running, just run `vagrant reload --provision` to get it to reload and integrate your changes. The `--provision` flag also applies if, say, you decide to change the database.

## Digging a little deeper

First of all, trying to be clever can bite you. I would suggest not changing or messing with the default Homestead/Vagrant folder structure `/home/vagrant/projectname`. I think I did that when I was learning Laravel and it only caused issues.

Next, here's a little insight into how my local folder structure is set up, by looking at my `folders` YAML section.

```yaml
folders:
    - map: ~/source/laravel/my-awesome-project-1
      to: /home/vagrant/my-awesome-project-1
```

This tells Vagrant to map the local (Mac, PC, etc) project folder (`~/source/laravel/my-awesome-project-1` in my case) to the `/home/vagrant/my-awesome-project-1` folder on the Vagrant box.

Your local project structure will very likely differ from mine so take that into account. Mine is a little weird - all my projects go into the `source` directory, but inside that I have them grouped up by technology, so there are sub-directories for `laravel`, `vue`, etc. Yeah, I'm not sure either if this is a smart way to organize projects but it's in my muscle memory so it works for me.

Finally, I would discourage you from changing the Vagrant structure away from `/home/vagrant/projectname`. Or if you have to, keep in mind that you'll have to make a corresponding change to the `sites` section (and then re-provision the Vagrant box). Here's an example:

Let's say you want to organize your projects in Vagrant inside a `projects` sub-directory (why tho?). Then you'd end up with the following config: 

```yaml
folders:
    - map: ~/source/laravel/my-awesome-project-1
      to: /home/vagrant/projects/my-awesome-project-1
      ...

sites:
    - map: awesomeproject1.test
      to: /home/vagrant/projects/my-awesome-project-1/public
      ...

databases:
    - awesomeproject1
```

**Final tip** If you're having trouble loading the `awesomeproject1.test` URL in your browser, make sure you've configured the test domain properly in your `hosts` file. On a Mac you'll find it at `/etc/hosts`, while on a PC it's usually at `C:\Windows\System32\drivers\etc\hosts` (reason #63421 why I don't like coding on a PC). Edit the file and add a new entry like so:

```bash
192.168.10.10 awesomeproject1.test
192.168.10.10 awesomeproject2.test
```

Homestead is configured by default to run on `192.168.10.10`, it's right at the top of `Homestead.yaml`. All your local sites will run on the same IP. 

And that's it. Hopefully this will help you get your Laravel project started quicker and with less headache!
