#!/usr/bin/php
<?php
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

$res = fopen('php://stdin', 'r');
while (!feof($res)) {
	$str .= fgets($res);
}

require 'Patchwork/JSqueeze.php';


$jz = new Patchwork\JSqueeze();

echo $jz->squeeze(
    $str,
    true,   // $singleLine
    true,   // $keepImportantComments
    false   // $specialVarRx
);

// ? https://github.com/tchwork/jsqueeze  stream_get_contents($res)
?>
