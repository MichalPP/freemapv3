<?php

$config['pocasie'] = array(
    'name' => 'Počasie',
	'menu-horne' => "<i class='fa fa-cloud'></i> počasie",
	'jquery' => '
function pocasie_routeclick(feature) { 
	console.log(feature.properties.id);
	$("#pocasie_zoznam").load("/data/pocasie.php?id="+feature.properties.id);
	$.ajax({
        url: "/data/pocasie.php?station_id="+feature.properties.id,
        dataType: "json",
        success: function (data) { $("#pocasie-"+feature.properties.id).loadJSON(data); }
    })

	}
', 
	'onmove' => '
$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=predpoved&callback=?", function (data) {
    routeLayer.clearLayers();
    routeLayer.addData(data);
    $(".zoznam").text(" ");
    $.each(data, function(k, feature) { 
        $("#pocasie_zoznam").append(feature.properties.description);
    });
    $("#pocasie_zoznam > p").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});
',
'onmove_minzoom' => 10
);
if($runfull) { 
	system("wget -q -O tmp/pocasie-small.css http://www.oma.sk/js/pocasie-small.css");
    system("wget -q -O tmp/jquery.loadJSON.js http://www.oma.sk/js/source/jquery.loadJSON.js");
}
file_put_contents("www/data/pocasie.html",'
<style type="text/css">'.file_get_contents('tmp/pocasie-small.css').'</style>
<script type="text/javascript">'.file_get_contents('tmp/jquery.loadJSON.js').'</script>
<div id="pocasie_zoznam" class="zoznam"></div>
');

$php ='<?php
if(strlen($_GET["id"]) > 1) echo file_get_contents("http://pocasie.oma.sk/js/pocasie.php?id=".$_GET["id"]);
else echo file_get_contents("http://pocasie.oma.sk/js/json.php?station_id=".$_GET["station_id"]);
?>';

file_put_contents("www/data/pocasie.php", $php);
?>
