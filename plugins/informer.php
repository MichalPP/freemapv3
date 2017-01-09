<?php
// po kliku nacitaj 
// http://widget.idea.informer.com/wdg4.php?w=713&h=490&domain=freemap&bcolor=FFFFFF&glcolor=1f5c23&cmline=E0E0E0&vcolor=92c756&tcolor_aw4=3F4543
$config['informer'] = array(
	'name' => 'Dobrý nápad',
	// ake je html
	'html' => '',
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
?>
