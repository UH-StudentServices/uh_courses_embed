# University of Helsinki Courses Embed
This Drupal 7 module allows to create content pages that builds an interface
for looking for given organisation's courses.

## Running on Docker container
```
$ wget https://github.com/UH-StudentServices/uh_courses_embed/archive/master.zip
$ unzip master.zip -d uh_courses_embed
$ cd uh_courses_embed
$ docker run -d -v `pwd`:/var/www/html/sites/all/modules/uh_courses_embed drupal:7
```

# License
This software is developed under [GPL v3](LICENSE.txt).
