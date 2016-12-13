# American Bars Webapp

[![N|Solid](https://americanbars.com/default/images/americanbars.png)](https://nodesource.com/products/nsolid)

American Bars Webapp is the client–server software application, in which the client runs in a web browser. In addition, American Bars API for native apps is stored in this repo and runs on the same server as AB Webapp. 

For convinience, AB Webapp refers to both the webapp and API.

This guide describes:

  - The steps to set up dev env, and build, test and deploy AB Webapp
  - The pipline
  - The Magic
 
##### This guide gets updated accordingly.

## Get Started

### Step #1
* Download [homebrew][homebrew], a package manager for Mac, by running:
```sh
$ /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```
* To work with the newest versions of homebrew apps, run:
```sh
$ echo 'export PATH=/usr/local/bin:$PATH' >> ~/.profile
```

* Download git:
```sh
$ brew install git
```

* Download php 7.1.0:
```sh
$ brew tap homebrew/dupes
$ brew tap homebrew/versions
$ brew tap homebrew/homebrew-php
$ brew install php71
```

### Step #2
[Add a public key to your GitHub account][sshkey]

### Step #3
Clone the webapp repo to your local directory by running:
```sh
$ git clone git@github.com:americanbars/webapp.git $/Projects/americanbars/apps/webapp/
$ git config --global user.name [your name]
$ git config --global user.email [your email address]
```

## Set up your Dev Env

Install the following:

* [AngularJS] - HTML enhanced for web apps!
* [Ace Editor] - awesome web-based text editor
* [markdown-it] - Markdown parser done right. Fast and easy to extend.
* [Twitter Bootstrap] - great UI boilerplate for modern web apps
* [node.js] - evented I/O for the backend
* [Express] - fast node.js network app framework [@tjholowaychuk]
* [Gulp] - the streaming build system
* [keymaster.js] - awesome keyboard handler lib by [@thomasfuchs]
* [jQuery] - duh

### Build

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)



   [@thomasfuchs]: <http://twitter.com/thomasfuchs>
   [sshkey]: <http://daringfireball.net/projects/markdown/>
   [homebrew]: <http://brew.sh>
