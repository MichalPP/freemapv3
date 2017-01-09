<?php
// mozem kontrolovat activediv='hladaj'
$config['domov'] = array(
	'name' => 'Domov',
	// ake je html
	'html' => file_get_contents('freemap-domov.html'),
	'css' => '',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> "", 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
