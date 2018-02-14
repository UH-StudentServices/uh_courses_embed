# University of Helsinki Courses Embed
This Drupal 7 module allows to create content pages that builds an interface
for looking for given organisation's courses.

This module uses NPM package "[courses-app](https://www.npmjs.com/package/courses-app)" to generate distributable JS that embeds courses into the content page.

## Getting started
1. Install module (see how to [install modules](https://www.drupal.org/docs/7/extend/installing-modules))
2. Create content *"Content" > "Add content" > "Courses Embed"*
3. Enter title and organisation code
4. Save
5. View your recently content page and it should contain courses of that organisation

Note: Organisation code field supports only cardinality 1. If you use many values, only the first value
is being used. If you want to enter multiple organisations, type them separated by commas.

## Running on Docker container
1. Download module and run it on a `drupal:7` container
```
$ wget https://github.com/mikaelkundert/uh_courses_embed/archive/master.zip
$ unzip master.zip -d uh_courses_embed
$ cd uh_courses_embed
$ docker run -d -v `pwd`:/var/www/html/sites/all/modules/uh_courses_embed drupal:7
```
2. Go to your container's IP address and install Drupal
3. Enable "University of Helsinki Courses Embed" module
4. Follow "Getting started" steps 2-5

## Updating NPM package
Course browser app is injected to this module as an external NPM dependency.
**Required JS and CSS are already copied in this module**, but sometimes you want to try out
another version.

To avoid pushing all the `node_module` libraries to this module, there's an run
script that allows you to copy required files to this module (after `npm install`).

When you want to update the package:
```
$ # This will install all dependencies and build the app
$ npm install courses-app@^YOUR-VERSION
```
```
$ # This will copy distributable JS/CSS that's used by this module 
$ npm run copy-dist
``` 

# Questions

Please post your question to doo-projekti@helsinki.fi

# License
This software is developed under [GPL v3](LICENSE.txt).
