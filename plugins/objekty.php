<?php
// mozem kontrolovat activediv='hladaj'
// todo vysuvacie menu z tmp/objekty.html - kontroluje zakliknute kategorie
$config['objekty'] = array(
	'name' => 'objekty',
	// ake je html
	'html' => '
<div id="objekty_kategorie"><div id="objekty_kategorie_hlavicka"><b>Kategórie</b> (klikni)</div><form id="objekty_kategorie_menu" class="freemapform">'.file_get_contents("tmp/objekty.html").'</form></div>
<div id="objekty_zoznam" class="zoznam">Ak viac priblížiš mapu, zobrazí sa ti tu zoznam objektov vo výreze (napríklad reštaurácie alebo zastávky dopravy).</div>',
	'css' => '#objekty p { height:1.05em; overflow:hidden; line-height: 1em; }
        #objekty p.clicked { height: auto; font-weight: bold;}
		label.objekty_nadmenu { display: block; }
		label.objekty_submenu { display: none; }
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
$("#objekty_kategorie_hlavicka").click(function() {$("#objekty_kategorie_menu").toggle(); });
$(".objektkategoria").change(function() {
	$("."+$(this).attr("id")).prop("checked", $(this).is(":checked"));
	console.log("is clicked? ."+$(this).attr("id")+" "+$(this).is(":checked"));
	refreshLayer();
});', 
/*$(".objekty_nadmenuu").click(function() { 
	var clicked=$(this).children("input").prop("checked"); console.log("is clicked? "+$(this).children("input").attr("id")+" "+clicked);
	$("."+$(this).children("input").attr("id")).prop("checked", clicked); 
	refreshLayer(); return true; });
',*/ 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	'onmove' => '
vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
if(vrstva == "Autoatlas") { trasy="ulice"; }
else if(vrstva == "Turistická mapa") { trasy="turistika";}
else if(vrstva == "Cykloatlas" || vrstva == "OCM") { trasy="cyklotrasa"; }
else if(vrstva == "Zimná mapa") { trasy="lyziarskatrasa"; }
else if(vrstva == "Mapa dopravy") { trasy="mhd"; }
else if(vrstva == "OSM") { trasy="ulice"; }
else { return; }
if(mapa.getZoom() < 15) return;
// typy 
var typy = "";
$("#objekty_kategorie_menu input:checked").each(function() { if(typeof $(this).attr("name") !== "undefined") { typy = typy+$(this).attr("name")+",";} });
if(typy.length >4) { typy = "&typ="+typy; }

$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=poi"+typy+"&format=fm&callback=?", function (data) {
	routeLayer.clearLayers();
	routeLayer.addData(data);
	$(".zoznam").text(" ");
	$.each(data, function(k, feature) { 
		$("#objekty_zoznam").append("<p id=\'"+feature.properties.id+"\'>"+feature.properties.description+"</p>");
	});
	$("#objekty_zoznam > p").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});

',
	// asi netreba: do mapy on close: vypni layer
);
/*
nefunguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
