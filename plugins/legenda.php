<?php
// mozem kontrolovat activediv='hladaj'
$config['legenda'] = array(
	'name' => 'Legenda',
	'menu-horne' => "<i class='fa fa-map-signs'></i> legenda",
	// ake je html
	'html' => '', //file_get_contents('tmp/freemap-legenda.html'),
	'css' => '
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> "
", 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
system('cp tmp/freemap-legenda.html www/data/legenda.html');
?>
