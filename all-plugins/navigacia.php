<?php
// mozem kontrolovat activediv='#navigacia'
$config['navigacia'] = array(
	'name' => 'navigacia',
	// ake je html
	'html' => '',
	'css' => '
.leaflet-routing-container { width: 100%; max-height: 100%; } 
.leaflet-routing-alt { max-height: 100%; }
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> ''
);
// todo: https://github.com/perliedman/leaflet-control-geocoder
$navigacia_js = file_get_contents('tmp/lrm.js');
$navigacia_js .= '
mapa.on("baselayerchange", function(e) {
  control.getRouter().options.serviceUrl = navigacia_router();
  control.route();
});

function navigacia_router() {
	vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
	if(vrstva == "OSM") { var navigacia_router = "https://router.project-osrm.org/route/v1"; }
	else if(vrstva == "Turistická mapa") { var navigacia_router = "http://pesi.routing.epsilon.sk/route/v1"; }
	else { var navigacia_router = "http://pesi.routing.epsilon.sk/route/v1"; }
	console.log(navigacia_router);
	return navigacia_router;
}

var control = L.Routing.control({
	language: "sk", fitSelectedRoutes: false, geocoder: "TODO",
	lineOptions: { styles: [{color: "red", opacity: 0.5, weight: 15}] },
	serviceUrl: navigacia_router()
});

var routeBlock = control.onAdd(mapa); document.getElementById("navigacia").appendChild(routeBlock);
//$(".leaflet-routing-container").height(visiblehei);

mapa.on("contextmenu", function(e) {
	if(activediv != "#navigacia") { return false; }
	if(control.getWaypoints()[0].name == "" ) { control.spliceWaypoints(0, 1, e.latlng); }
	else { control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng); }
});

';
file_put_contents('www/data/navigacia.html', '
<script type="text/javascript">'.$navigacia_js.'</script>

');
/*
funguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
