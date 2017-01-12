<?php
// mozem kontrolovat activediv='#hladaj'
$config['share'] = array(
	'name' => 'Zdieľaj',
	// ake je html
	'html' => 'Rozne tlacitka na posielanie sucasnej vrstvy, shorlinky, ... <a href="#" class="permalink">Trvalý odkaz</a><hr/><h3>Stred mapy je v</h3> <div class="zoznam" id="share_zoznam"></div><hr/><div class="zoznam" id="share_chko_zoznam"></div>',
	'css' => '',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> "", 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
	'onmove' => '
$.getJSON("http://www.oma.sk/api?lat="+mapa.getCenter().lat+"&lon="+mapa.getCenter().lng+"&tabulka=regiony&format=fm&callback=?", function (data) {
    routeLayer.clearLayers();
    //routeLayer.addData(data);
    $(".zoznam").text(" ");
    $.each(data, function(k, feature) { 
		if(jQuery.inArray(feature.properties.typ, ["chko", "pohorie"]) > -1) {
			$("#share_chko_zoznam").append("<p id=\'"+feature.properties.id+"\' >"+feature.properties.description+"</p>");
		} else {
	        $("#share_zoznam").append("<p><a href=\'"+feature.properties.uri+"\' id=\'"+feature.properties.id+"\'>"+feature.properties.name+"</a></p>");
		}
    });
});
'
);
?>
