#!/bin/sh

mkdir -p www/data tmp/fullwiki/ tmp/wiki
rm www/data/*

if [ "$1" = "true" ]; then
	wget -q -O - 'http://www.freemap.sk/?c=core.map.legend&Ajax=LeftArea' |sed "s/ style='[^']*'//g" | sed 's/valign=[^ ]* //g' |sed 's#<[/]*span[ ]*>##g' | php embedimg.php http://www.freemap.sk > tmp/freemap-legenda.html;
	wget -q -O tmp/objekty.html 'http://www.oma.sk/js/objekty.html'
	fa="4.7.0"
	# http://fontawesome.io/assets/font-awesome-4.7.0.zip
	mkdir -p www/fonts; cp -p img/font-awesome-4.4.0/fonts/* www/fonts/;
	mkdir -p www/img; cp -p img/freemap-logo.png www/img/;
	mkdir -p tmp/wiki; rm tmp/wiki/*
	mkdir -p tmp/lib-js; rm tmp/lib-js/*
	lrm="3.2.4";
	cd tmp; 
	wget -q -O - http://www.liedman.net/leaflet-control-geocoder/Control.Geocoder.js > lrm.js;
	wget https://github.com/perliedman/leaflet-routing-machine/archive/v$lrm.zip; unzip v$lrm.zip; cat leaflet-routing-machine-$lrm/dist/leaflet-routing-machine.min.js >> lrm.js; cd ../; cp tmp/leaflet-routing-machine-$lrm/dist/leaflet.routing.icons.png www/
	$i=0;
	for l in `echo "http://code.jquery.com/jquery-1.11.3.js
https://raw.githubusercontent.com/creative-area/jQuery-form-autofill/master/jquery.formautofill.js
https://raw.githubusercontent.com/edgarjs/jquery-deserialize/master/jquery.deserialize.js
https://raw.githubusercontent.com/tuupola/jquery_lazyload/master/jquery.lazyload.js
http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js
https://github.com/vogdb/Leaflet.ActiveLayers/raw/master/src/ActiveLayers.js"`; do
		a="$(printf "%02d" $i)";
		wget -O tmp/lib-js/$a.js $l
		i=$(($i + 1));
	done
	cat  tmp/lib-js/[0-3]* |yui-compressor --type js > tmp/lib-js/90.js
	wget -q -O - 'http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css' | php embedimg.php http://cdn.leafletjs.com/leaflet-0.7.5 > tmp/leaflet.css
	cat leaflet-routing-machine-$lrm/dist/leaflet-routing-machine.css | php embedimg.php http://www.liedman.net/leaflet-routing-machine/dist >> tmp/leaflet.css
fi

php do.php false

# deploy
cp www/index.html /home/vseobecne/www/weby/epsilon.sk/ulice/fm.html; 
chmod -R o+rX www/*
cp -pr www/* /home/vseobecne/www/weby/freemap.epsilon.sk/;
#cp -p www/.[a-z]* /home/vseobecne/www/weby/freemap.epsilon.sk/

#oma ff;

if [ "$1" = "true" ]; then
	scp -r -p -P 21122 www/* 92.240.244.41:/home/michal/mobile.new/
	oma f freemap.epsilon.sk
	cd ../
	tar -c --bzip2 -f freemap-v3.tar.bz2 freemap-v3
fi

