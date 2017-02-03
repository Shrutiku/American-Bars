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
* Download [NetBeans][netbeans], our IDE.

### Step #2
* Download [Mamp][mamp], our local server environment.

### Step #3
[Add a public key to your GitHub account][sshkey]

## Set Up Your Dev Enviornment

### Step #1
* Download [Webapp Tools][webapp_tools]
* Unzip it and run:
```sh
$ cd [Webapp Tools Dir]
$ ./install [name] [email_address] [working_dir]
```

### Step #2
* Open NetBeans and create a new PHP project
* Choose our working dir as source and choose PHP version 7.0
* In Run Configuration choose run "as Local" and check "Copy files to another location" [/Applicatio/MAMP/htdocs/webapp]

### Step #3
* Open Mamp, click Preferences to open the Preferences panel, then select the Ports tab.
* Click 'Set to Default Apache and MySQL ports'. Apache port is reset to 80 and MySQL to 3306. 
* Click PHP and choose version 5.6.27.

## Build

* To build changes run:
```sh
$ ./build
```

* To build all files run:
```sh
$ ./build-all
```

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)


   [sshkey]: <https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/>
   [netbeans]: <https://netbeans.org/downloads/start.html?platform=macosx&lang=en&option=php>
   [mamp]: <http://downloads6.mamp.info/MAMP-PRO/releases/4.0.6/MAMP_MAMP_PRO_4.0.6.pkg>
   [webapp_tools]: <http://54.89.247.251:8080/userContent/webapp/*zip*/webapp.zip>
