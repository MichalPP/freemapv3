<?php
// mozem kontrolovat activediv='hladaj'
$config['hladaj'] = array(
	'name' => 'Hľadaj',
	// ake je html
	'html' => '<form class="freemapform"><input type="text" name="hladaj_q" id="hladaj_q"/><input type="submit" name="hladaj_commit" value="hl."/></form><div id="hladaj_zoznam"></div>',
	'css' => '#hladaj p { height:1.05em; overflow:hidden; line-height: 1em; }
		#hladaj p.clicked { height: auto; }
',
	'css-mobile' => '#hladaj_q { width: 90%; }',
	// js funckie zavolane onload, jquery
	'jquery'=> "
function hladaj_klik(s) {
 var bbox = self.mapa.getBounds().toBBoxString();
 $.getJSON('http://nominatim.openstreetmap.org/search?q='+s+'&zoom='+mapa.getZoom()+'&viewbox='+bbox+'&countrycodes=sk&limit=15&format=jsonv2&accept-language=sk_SK&name_details=1&polygon_geojson=1&json_callback=?', function (data) {
        routeLayer.clearLayers();
		$('#hladaj_zoznam').text(' ');
		var d = [];
		$.each(data, function(k, v) { 
			$('#hladaj_zoznam').append('<p id=\"'+v.osm_type+'-'+v.osm_id+'\" class=\"hladajelement\" data-lon=\"'+v.lon+'\" data-lat=\"'+v.lat+'\">'+v.display_name+'</p>');
			var a = {};
			a.type='Feature'; a.geometry = v.geojson; a.id=v.osm_type+'-'+v.osm_id;
			//a.onclick = function() { zoznamclick(self, feature); };
			d.push(a);
		});
		routeLayer.addData(d);
		$('.hladajelement').click(function() { 
			$('p.clicked').removeClass('clicked'); $(this).addClass('clicked'); 
			mapa.panTo([$(this).data('lat'), $(this).data('lon')]); toright(); 
		});
    });
}

$('form').on('submit',function(){ hladaj_klik($('#hladaj_q').val()); $('#hladaj_q').focusout(); return false; });
$('#hladaj_q').bind('afterShow', function() { $(this).focus(); });
//$('.hladajelement').each().on('click', function() { mapa.panTo([$(this).data('lat'), $(this).data('lon')]); } );
", 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
