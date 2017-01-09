<?php
// mozem kontrolovat activediv='hladaj'
$config['vrstvy'] = array(
	'name' => 'Vrstvy',
	// ake je html
	'html' => '<a href="#FreemapSlovakia">Freemap</a> ponúka vrstvy:
<ul><li><a href="#" class="vrstva">Turistická mapa</a></li><li><a href="#" class="vrstva">Cykloatlas</a></li><li><a href="#" class="vrstva">Autoatlas</a></li><li><a href="#" class="vrstva">Zimná mapa</a>: najmä bežkárske trasy</li></ul>
Vrstvy z iných zdrojov (ale stále <a href="#OpenStreetMap">OpenStreetMap</a>):<ul><li><a href="#" class="vrstva">Mapa dopravy</a>: OpenBusMap</li><li><a href="#" class="vrstva">OSM</a>: základná vrstva openstreetmap</li><li><a href="#" class="vrstva">OCM</a>: OpenCycleMap</li></ul>
Všetky vrstvy pochádzajú zo sesterských projektov v rámci <a href="#OpenStreetMap">OpenStreetMap</a>.',
	'css' => '
',
	'css-mobile' => '#hladaj_q { width: 90%; }',
	// js funckie zavolane onload, jquery
	'jquery'=> '$("#vrstvy .vrstva").click(function(e) {
    e.preventDefault();
    if(typeof baseLayers[$(this).html()] === "object") {
        $("label:has(span:contains("+$(this).html()+"))").children("input").click();
        hreflink(activediv);
        toright();
        }
    return false;
    });
', 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
