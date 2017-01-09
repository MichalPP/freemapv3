<?php
// mozem kontrolovat activediv='hladaj'
// https://raw.githubusercontent.com/mattbryson/TouchSwipe-Jquery-Plugin/master/jquery.touchSwipe.js includnut
$config['swipe'] = array(
	'name' => 'Bez názvu',
	// ake je html
	'html' => '',
	'css' => '',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
$("#left").swipe( {
    swipeLeft:function(event, direction, distance, duration, fingerCount) { toright(); },
    swipeRight:function() { divback(); }
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        //threshold:0
    });

', 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
