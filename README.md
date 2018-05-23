# University of Helsinki Courses Embed
This Drupal module allows to create content pages that builds an interface for
looking for given organisation's courses.

This module is available for [Drupal 7](https://github.com/UH-StudentServices/uh_courses_embed/tree/drupal7) and [Drupal 8](https://github.com/UH-StudentServices/uh_courses_embed/tree/drupal8) versions.

## Getting started
1. Install module
2. Create content *"Content" > "Add content" > "Courses Embed"*
3. Enter title and organisation code
4. Save
5. View your recently content page and it should contain courses of that organisation

Note: Organisation code field supports only cardinality 1. If you use many
values, only the first value is being used. If you want to enter multiple
organisations, type them separated by commas.

## Running on Docker container

**1a. For Drupal 7:** Download module and run it on a `drupal:7` container
```
$ wget https://github.com/UH-StudentServices/uh_courses_embed/archive/drupal7.zip
$ unzip drupal7.zip -d uh_courses_embed
$ cd uh_courses_embed
$ docker run -d -v `pwd`:/var/www/html/sites/all/modules/uh_courses_embed drupal:7
```
**1b. For Drupal 8:** Download module and run it on a `drupal:8` container
```
$ wget https://github.com/UH-StudentServices/uh_courses_embed/archive/drupal8.zip
$ unzip drupal8.zip -d uh_courses_embed
$ cd uh_courses_embed
$ docker run -d -v `pwd`:/var/www/html/modules/uh_courses_embed drupal:8
```
2. Go to your container's IP address and install Drupal
3. Enable "University of Helsinki Courses Embed" module
4. Follow "Getting started" steps 2-5

# Questions

Please post your question to doo-projekti@helsinki.fi

# License
This software is developed under [GPL v3](LICENSE.txt).
