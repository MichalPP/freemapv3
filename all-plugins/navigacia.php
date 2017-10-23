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
  control.getRouter().options.profile = navigacia_profile();
  control.route();
});

function navigacia_router() {
	vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
	if(vrstva == "Autoatlas") { navigaciaRouter = "https://routing.epsilon.sk/route/v1"; }
	else if(vrstva == "Turistická mapa") { navigaciaRouter = "https://routing.epsilon.sk/route/v1"; }
	else if(vrstva == "Cykloatlas" || vrstva == "OCM") { navigaciaRouter = "https://routing.epsilon.sk/route/v1"; }
    else if(vrstva == "Zimná mapa") { navigaciaRouter = "https://routing.epsilon.sk/route/v1"; }
	//else { var navigacia_router = "http://pesi.routing.epsilon.sk/route/v1"; }
	console.log(navigaciaRouter);
	return navigaciaRouter;
}
function navigacia_profile() {
    vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
    if(vrstva == "Autoatlas") { navigaciaRouter = "car"; }
    else if(vrstva == "Turistická mapa") { navigaciaRouter = "foot"; }
    else if(vrstva == "Cykloatlas" || vrstva == "OCM") { navigaciaRouter = "bike"; }
    else if(vrstva == "Zimná mapa") { navigaciaRouter = "test"; }
	return navigaciaRouter;
}

var control = L.Routing.control({
	language: "sk", fitSelectedRoutes: false, geocoder: L.Control.Geocoder.nominatim(),
	lineOptions: { styles: [{color: "red", opacity: 0.5, weight: 15}] },
	serviceUrl: navigacia_router(), profile: navigacia_profile(),
});

var routeBlock = control.onAdd(mapa); document.getElementById("navigacia").appendChild(routeBlock);
//$(".leaflet-routing-container").height(visiblehei);

var navigaciaRouter = "https://routing.epsilon.sk/route/v1";

mapa.on("contextmenu", function(e) {
	if(activediv != "#navigacia") { return false; }
	if(control.getWaypoints()[0].name == "" ) { control.spliceWaypoints(0, 1, e.latlng); }
	else { control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng); }
});

mapa.on("click", function(e) {
    if(activediv != "#navigacia") { return false; }
    if(control.getWaypoints()[0].name == "" ) { control.spliceWaypoints(0, 1, e.latlng); }
	else if(control.getWaypoints()[1].name == "" ) { control.spliceWaypoints(1, 1, e.latlng); }
    //else { control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng); }
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
