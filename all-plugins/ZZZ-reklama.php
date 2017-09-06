<?php
// mozem kontrolovat activediv='hladaj'
$config['reklama'] = array(
	'name' => 'Reklama',
	// ake je html
	'fullhtml' => "<div class='reklamaall'><div class='reklama'></div><div class='reklama'></div></div>",
	'css' => '',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '$(".reklama").each(function() {$(this).load("reklama.php");});', 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
$php ='<?php
echo preg_replace("/<img src=\'1p.*/", "",  strtr(file_get_contents("http://www.freemap.sk/?c=banner.show&Width=120&Height=60&DivName=LeftAreaBanner2&Ajax=LeftAreaBanner2"), array("src=\'." => "src=\'http://www.freemap.sk")));
?>';
file_put_contents('www/reklama.php', $php);
?>
