<?php
// mozem kontrolovat activediv='#hladaj'
$config['empty'] = array(
	'name' => 'Bez názvu',
	// ake je html
	'html' => '',
	'css' => '
',
	'css-mobile' => '#hladaj_q { width: 90%; }',
	// js funckie zavolane onload, jquery
	'jquery'=> "
", 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
