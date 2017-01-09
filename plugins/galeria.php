<?php
// mozem kontrolovat activediv='hladaj'
// todo vysuvacie menu z tmp/objekty.html - kontroluje zakliknute kategorie
$config['galeria'] = array(
	'name' => 'galeria',
	// ake je html
	'html' => '<div id="galeria_zoznam" class="zoznam">Ak viac priblížiš mapu, zobrazí sa ti tu galéria.</div>',
	'css' => '#galeria p { display: none; height: 0px; }
        #galeria p.clicked { display: block; height: auto; font-weight: bold; }
		#galeria p.clicked img { width: 100%; }
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
', 
// $(".objektkategoria").click(function() {if(this.checked) { $(':checkbox.'+this.id).each(function() { this.checked=true;})} else { $(':checkbox.'+this.id).each(function() { this.checked=false;})} }); 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	'onmove' => '
if(mapa.getZoom() < 15) return;
$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=foto&format=fm&callback=?", function (data) {
	routeLayer.clearLayers();
	routeLayer.addData(data);
	$(".zoznam").text(" ");
	$.each(data, function(k, feature) { 
		$("#galeria_zoznam").append("<p id=\'"+feature.properties.id+"\'><b>"+feature.properties.name+"</b><br/><img src=\'"+feature.properties.icon+"\'/><br/><a href=\'"+feature.properties.uri+"\'>viac</a></p>");
	});
	//$("#galeria_zoznam > img").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});

',
	// asi netreba: do mapy on close: vypni layer
);
/*
nefunguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
