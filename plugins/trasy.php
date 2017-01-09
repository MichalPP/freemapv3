<?php
// mozem kontrolovat activediv='hladaj'
$config['trasy'] = array(
	'name' => 'trasy',
	// ake je html
	'html' => '<div id="trasy_zoznam" class="zoznam">Ak viac priblížiš mapu, zobrazia sa ti trasy v okolí. Ak máš zapnutú vrstvu turistiky, budú to turistické trasy, pri cyklovrstve cyklistické trasy, pri mape dopravy linky dopravy a MHD, pri zimnej mape to budú lyžiarske trasy.</div>',
	'css' => '#trasy p { height:1.05em; overflow:hidden; line-height: 1em; }
        #trasy p.clicked { height: auto; font-weight: bold; border-style: double; border-width: 2px; border-color: black; padding: 5px;}
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
var trasy;
function getcolour(feature) {
      if(jQuery.inArray( trasy,["mhd", "ulice"]) > -1 ) {
            str = feature.properties.name.split("").reverse().join("");
            for (var i = 0, hash = 0; i < str.length; hash = str.charCodeAt(i++) + ((hash << 5) - hash));
            for (var i = 0, colour = "#"; i < 3; colour += ("00" + ((hash >> i++ * 8) & 0xFF).toString(16)).slice(-2));
            return colour;
        }
		if( feature.properties == undefined) { return "#800080"; }
		if( feature.properties.colour == undefined) { return "#800080"; }
        switch (feature.properties.colour) {
            case "green": return "#1BA12B";
            case "blue": return "#2F31AD";
            case "red": return "#DE1F29";
            case "yellow": return "#E8CD02";
            default: return "#800080";
       }
    }

', 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	'onmove' => '
vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
if(vrstva == "Autoatlas" || vrstva == "OSM" ) { trasy="ulice"; if(mapa.getZoom() < 14) return; }
else if(vrstva == "Turistická mapa") { trasy="turistika";}
else if(vrstva == "Cykloatlas" || vrstva == "OCM") { trasy="cyklotrasa"; }
else if(vrstva == "Zimná mapa") { trasy="lyziarskatrasa"; }
else if(vrstva == "Mapa dopravy") { trasy="mhd"; }
else { return; }
$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=trasy&typ="+trasy+"&format=fm&callback=?", function (data) {
	routeLayer.clearLayers();
	routeLayer.addData(data);
	$(".zoznam").text(" ");
	$.each(data, function(k, feature) { 
		$("#trasy_zoznam").append("<p id=\'"+feature.properties.id+"\' style=\'color:"+getcolour(feature)+";\'>"+feature.properties.description+"</p>");
	});
	$("#trasy_zoznam > p").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});

',
	// asi netreba: do mapy on close: vypni layer
);
/*
nefunguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
