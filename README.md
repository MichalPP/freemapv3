==== prerequities:

php cli - probably only standard libraries
php5-tidy - to close open tags in plugins
yui-compressor - minimifaction sw, probably safe to switch to another one
deploy scripts - should be changed

==== run:

sh make.sh true - will build everything into www folder.

==== configuration:

plugins directory, all-plugins  - everything should be updated only here
freemap.html - homepage, probably should not be changed
css.css - basic css (basic map, viewport change), all css should be altered in plugins
js.js - basic js (only map, clicking links, viewport change), all js should be altered in plugins

==== directories:

www - output html/js/css files to be copied on the webserver
tmp - temporary files, safe to truncate before running `make.sh true`
tmp/wiki - temporary files from wiki.freemap.sk
wiki/lib-js/ - temporary js files, like leaflet.js, ...
old - backup files, safe to remove once git is running :)
plugins - php files of plugins to be included
plugins-all - all plugins, probably to be used with symlinks

==== run files:

make.sh - master bash script; run `sh make.sh` for quick or `sh make.sh true` for full run (including download of all files, minimification, ...)
do.php - script to include all plugins, images, ... run by make.sh
embedimg.php - script which includes images as base64
