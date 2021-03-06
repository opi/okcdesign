OKC Design
-------------

OKCDesign is a Drupal 7 starter theme for developers, based on zurb foundation 5 framework :
http://foundation.zurb.com/

Use "drush okc-theme yourthemename" to create a subtheme and start working.
*Never* edit okcdesign files unless you wish to contribute to the project.

Features :
- Get all the power of foundation :  Grid system, components, responsive design etc...
- a ready-to-use integration of foundation topbar to Drupal, working out of the box.
- Remove all drupal native css, excepts those very needed for administration purposes
- Powerfull theme plugin system : Enabled plugins you need, configure them as needed.

REQUIREMENTS
-------------

To get the best from okcdesign and recompile scss yourself, you'll need several things :
- foundation requirements to work with sass : http://foundation.zurb.com/docs/sass.html
  - Git
  - Ruby 1.9+
  - NodeJs

- jquery_update drupal module with jquery >= 1.10
- drush

SCSS COMPILATION
------------------


The most efficient way is to simply type the following command at the root of your subtheme :
```shell
  grunt
```

It will read informations from Gruntfile.js and package.json to compile your project.
It uses libsass, which compile scss a lot faster than sass command.

alternatively, you can use sass, but you MUST include foundation components from okcdesign theme, this way :

```shell
  sass --watch scss:css -I ../okcdesign/bower_components/foundation/scss -I ../okcdesign/scss
```

START
-----------------

To start develop, you  *MUST* create a OKC Design subtheme.

Use the following drush command to automatically create a subtheme, then go to theme administration page to set it by default :

```shell
  drush okc-theme {yourthemename}
```

Now go to your freshly created subtheme, and run following command to start working
with scss files :

```shell
  grunt
```


