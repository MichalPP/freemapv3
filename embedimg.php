#!/usr/bin/php
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
/*
This script replaces image links in input file (html, css, leaflet) with base64 encoded images.
It also adds prefix to your images (if needed).

Advantages:
single file, no TCP overhead for each (small) image
standard file compression by apache adds only 2-4% filesize compared to png


typical usage:
edited.html | php embedimg.php 'http://www.oma.sk' > final.html
edited.css | php embedimg.php 'http://www.oma.sk'| your-favorite-css-minimazer > final.css

see https://en.wikipedia.org/wiki/Data_URI_scheme for specification


Copyright © 2015 Michal Páleník <michal.palenik@freemap.sk>
This work is free. You can redistribute it and/or modify it under the
terms of the Do What The Fuck You Want To Public License, Version 2,
as published by Sam Hocevar. See http://www.wtfpl.net/ for more details.

*/
function imgtobase64($m) {
    $path = $m[2];
    $type = pathinfo($path, PATHINFO_EXTENSION); //echo "$path: $type\n";
    if($type == '') $type='png';
    $data = file_get_contents($path);
	// todo? check for image size: if too large => do not embed
	if(strlen($data) > 100000 or strlen($data) < 100) return $m[1].$m[2].$m[3];
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $m[1].$base64.$m[3];
    }
function embedimg($fm) {
    $fm = preg_replace_callback("#(<img[^>]+src=')(http[^']*)('[^>]+>)#", "imgtobase64", $fm); // html
    $fm = preg_replace_callback('#(<img[^>]+src=")(http[^"]*)("[^>]+>)#', "imgtobase64", $fm); // html
    $fm = preg_replace_callback('#(url\(["\']*)(http[^"\'\)]*)(["\']*\))#', "imgtobase64", $fm); // css
	$fm = preg_replace_callback('#(iconUrl:[\s]*["\'])(http[^"\']*)(["\'])#', "imgtobase64", $fm); //leaflet js
    return $fm;
}
function srcaddprefix($fm, $pref='') {
    $fm = strtr($fm, array(
		'src="/' => "src=\"".$pref."/", "src='/" => "src='$pref/", 'src="./' => "src=\"".$pref."/", "src='./" => "src='$pref/", // html
		'url(i' => 'url('.$pref.'/i', 'url("i' => 'url("'.$pref.'/i' // css
	));
    return $fm;
}

$res = fopen('php://stdin', 'r');
$pref = $argv[1]; // default prefix for images, eg: http://www.oma.sk/
while (!feof($res)) {
	echo embedimg(srcaddprefix(fgets($res), $pref));
}

// ? https://github.com/tchwork/jsqueeze  stream_get_contents($res)
?>
