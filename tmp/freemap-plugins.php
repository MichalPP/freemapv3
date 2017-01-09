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
<?php
//     <a href="#facebook"><i class='fa fa-facebook'></i> facebook</a>
// todo: aby netahalo pokial nekliknem, az potom nacitaj iframe a do height daj realne cislo

$config['facebook'] = array(
    'name' => 'Facebook',
	'menu-horne' => "<i class='fa fa-facebook'></i>acebook",
    // ake je html
//    'html' => 
//"<iframe id='facebook' class='submenu' src='http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/FreemapSlovakia&amp;colorscheme=light&amp;show_faces=false&amp;stream=true&amp;header=false&amp;scrolling=false&amp;border=0' scrolling='no' frameborder='0' style='border:none; ' data-width='100%'></iframe>"
);
//file_put_contents("www/data/facebook.html", "<iframe src='http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/FreemapSlovakia&colorscheme=light&show_faces=false&stream=true&header=false&height=600&scrolling=false&border=0' scrolling='no' frameborder='0' style='border:none; width: 95%; height:95%;'></iframe>");

//file_put_contents("www/data/facebook.html", "<iframe src='http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/FreemapSlovakia&amp;colorscheme=light&amp;show_faces=false&amp;stream=true&amp;header=false&amp;height=600&amp;scrolling=false&amp;border=0' scrolling='no' frameborder='0' style='border:none; width: 95%; height:95%;'></iframe>");
file_put_contents("www/data/facebook.html",'
<div class="fb-page" data-href="https://www.facebook.com/FreemapSlovakia" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-height="700" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/FreemapSlovakia" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/FreemapSlovakia">Freemap Slovakia - Mapujte s nami Slovensko</a></blockquote></div>
<div id="fb-root"></div>
<script>
$(".fb-page").attr("data-height", $(".submenu").height());
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sk_SK/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
');
?>
<?php
// mozem kontrolovat activediv='#hladaj'
$config['funkcie'] = array(
	'name' => 'funkcie',
	// ake je html
	'menu-horne' => '&fnof; funkcie',
	'html' => 'Popis funkcionality portálu: <p>podľa toho akú máte zapnutú vrstvu, sa menia nastavenia (napríklad v časti <a href="#trasy">trasy</a> sa zobrazujú iné trasy, <a href="#navigacia">navigácia</a> naviguje iným profilom, ...).</p><p></p><b>čo neponúkame:</b><ul><li>vytvorenie vlastnej mapy s vlajočkami a čiarami, pozri <a href="http://umap.openstreetmap.fr">použi sesterský projekt umap</a></li></ul>',
);
?>
<?php
// mozem kontrolovat activediv='hladaj'
// todo vysuvacie menu z tmp/objekty.html - kontroluje zakliknute kategorie
$config['galeria'] = array(
	'name' => 'galeria',
	// ake je html
	'html' => '<div id="galeria_zoznam" class="zoznam">Ak viac priblížiš mapu, zobrazí sa ti tu galéria.</div>',
	'css' => '#galeria p { display: none; height: 0px; }
        #galeria p.clicked { display: block; height: auto; font-weight: bold; }
		#galeria p.clicked img { width: 100%; }
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
', 
// $(".objektkategoria").click(function() {if(this.checked) { $(':checkbox.'+this.id).each(function() { this.checked=true;})} else { $(':checkbox.'+this.id).each(function() { this.checked=false;})} }); 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	'onmove' => '
if(mapa.getZoom() < 15) return;
$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=foto&format=fm&callback=?", function (data) {
	routeLayer.clearLayers();
	routeLayer.addData(data);
	$(".zoznam").text(" ");
	$.each(data, function(k, feature) { 
		$("#galeria_zoznam").append("<p id=\'"+feature.properties.id+"\'><b>"+feature.properties.name+"</b><br/><img src=\'"+feature.properties.icon+"\'/><br/><a href=\'"+feature.properties.uri+"\'>viac</a></p>");
	});
	//$("#galeria_zoznam > img").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});

',
	// asi netreba: do mapy on close: vypni layer
);
/*
nefunguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
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
<?php
// mozem kontrolovat activediv='#navigacia'
$config['navigacia'] = array(
	'name' => 'navigacia',
	// ake je html
	'html' => '',
	'css' => '
.leaflet-routing-container { width: 100%; max-height: 100%; } 
.leaflet-routing-alt { max-height: 100%; }
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> ''
);
// todo: https://github.com/perliedman/leaflet-control-geocoder
$navigacia_js = file_get_contents('tmp/lrm.js');
$navigacia_js .= '
mapa.on("baselayerchange", function(e) {
  control.getRouter().options.serviceUrl = navigacia_router();
  control.route();
});

function navigacia_router() {
	vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
	if(vrstva == "OSM") { var navigacia_router = "https://router.project-osrm.org/route/v1"; }
	else if(vrstva == "Turistická mapa") { var navigacia_router = "http://pesi.routing.epsilon.sk/route/v1"; }
	else { var navigacia_router = "http://pesi.routing.epsilon.sk/route/v1"; }
	console.log(navigacia_router);
	return navigacia_router;
}

var control = L.Routing.control({
	language: "sk", fitSelectedRoutes: false, geocoder: "TODO",
	lineOptions: { styles: [{color: "red", opacity: 0.5, weight: 15}] },
	serviceUrl: navigacia_router()
});

var routeBlock = control.onAdd(mapa); document.getElementById("navigacia").appendChild(routeBlock);
//$(".leaflet-routing-container").height(visiblehei);

mapa.on("contextmenu", function(e) {
	if(activediv != "#navigacia") { return false; }
	if(control.getWaypoints()[0].name == "" ) { control.spliceWaypoints(0, 1, e.latlng); }
	else { control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng); }
});

';
file_put_contents('www/data/navigacia.html', '
<script type="text/javascript">'.$navigacia_js.'</script>

');
/*
funguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
<?php
// mozem kontrolovat activediv='hladaj'
// todo vysuvacie menu z tmp/objekty.html - kontroluje zakliknute kategorie
$config['objekty'] = array(
	'name' => 'objekty',
	// ake je html
	'html' => '
<div id="objekty_kategorie"><div id="objekty_kategorie_hlavicka"><b>Kategórie</b> (klikni)</div><form id="objekty_kategorie_menu" class="freemapform">'.file_get_contents("tmp/objekty.html").'</form></div>
<div id="objekty_zoznam" class="zoznam">Ak viac priblížiš mapu, zobrazí sa ti tu zoznam objektov vo výreze (napríklad reštaurácie alebo zastávky dopravy).</div>',
	'css' => '#objekty p { height:1.05em; overflow:hidden; line-height: 1em; }
        #objekty p.clicked { height: auto; font-weight: bold;}
		label.objekty_nadmenu { display: block; }
		label.objekty_submenu { display: none; }
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
$("#objekty_kategorie_hlavicka").click(function() {$("#objekty_kategorie_menu").toggle(); });
$(".objektkategoria").change(function() {
	$("."+$(this).attr("id")).prop("checked", $(this).is(":checked"));
	console.log("is clicked? ."+$(this).attr("id")+" "+$(this).is(":checked"));
	refreshLayer();
});', 
/*$(".objekty_nadmenuu").click(function() { 
	var clicked=$(this).children("input").prop("checked"); console.log("is clicked? "+$(this).children("input").attr("id")+" "+clicked);
	$("."+$(this).children("input").attr("id")).prop("checked", clicked); 
	refreshLayer(); return true; });
',*/ 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	'onmove' => '
vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
if(vrstva == "Autoatlas") { trasy="ulice"; }
else if(vrstva == "Turistická mapa") { trasy="turistika";}
else if(vrstva == "Cykloatlas" || vrstva == "OCM") { trasy="cyklotrasa"; }
else if(vrstva == "Zimná mapa") { trasy="lyziarskatrasa"; }
else if(vrstva == "Mapa dopravy") { trasy="mhd"; }
else if(vrstva == "OSM") { trasy="ulice"; }
else { return; }
if(mapa.getZoom() < 15) return;
// typy 
var typy = "";
$("#objekty_kategorie_menu input:checked").each(function() { if(typeof $(this).attr("name") !== "undefined") { typy = typy+$(this).attr("name")+",";} });
if(typy.length >4) { typy = "&typ="+typy; }

$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=poi"+typy+"&format=fm&callback=?", function (data) {
	routeLayer.clearLayers();
	routeLayer.addData(data);
	$(".zoznam").text(" ");
	$.each(data, function(k, feature) { 
		$("#objekty_zoznam").append("<p id=\'"+feature.properties.id+"\'>"+feature.properties.description+"</p>");
	});
	$("#objekty_zoznam > p").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});

',
	// asi netreba: do mapy on close: vypni layer
);
/*
nefunguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
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
<?php
// mozem kontrolovat activediv='hladaj'
$config['trasy'] = array(
	'name' => 'trasy',
	// ake je html
	'html' => '<div id="trasy_zoznam" class="zoznam">Ak viac priblížiš mapu, zobrazia sa ti trasy v okolí. Ak máš zapnutú vrstvu turistiky, budú to turistické trasy, pri cyklovrstve cyklistické trasy, pri mape dopravy linky dopravy a MHD, pri zimnej mape to budú lyžiarske trasy.</div>',
	'css' => '#trasy p { height:1.05em; overflow:hidden; line-height: 1em; }
        #trasy p.clicked { height: auto; font-weight: bold; border-style: double; border-width: 2px; border-color: black; padding: 5px;}
',
	'css-mobile' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> '
var trasy;
function getcolour(feature) {
      if(jQuery.inArray( trasy,["mhd", "ulice"]) > -1 ) {
            str = feature.properties.name.split("").reverse().join("");
            for (var i = 0, hash = 0; i < str.length; hash = str.charCodeAt(i++) + ((hash << 5) - hash));
            for (var i = 0, colour = "#"; i < 3; colour += ("00" + ((hash >> i++ * 8) & 0xFF).toString(16)).slice(-2));
            return colour;
        }
		if( feature.properties == undefined) { return "#800080"; }
		if( feature.properties.colour == undefined) { return "#800080"; }
        switch (feature.properties.colour) {
            case "green": return "#1BA12B";
            case "blue": return "#2F31AD";
            case "red": return "#DE1F29";
            case "yellow": return "#E8CD02";
            default: return "#800080";
       }
    }

', 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	'onmove' => '
vrstva=$("input.leaflet-control-layers-selector:checked").parent().children("span").html().trim();
if(vrstva == "Autoatlas" || vrstva == "OSM" ) { trasy="ulice"; if(mapa.getZoom() < 14) return; }
else if(vrstva == "Turistická mapa") { trasy="turistika";}
else if(vrstva == "Cykloatlas" || vrstva == "OCM") { trasy="cyklotrasa"; }
else if(vrstva == "Zimná mapa") { trasy="lyziarskatrasa"; }
else if(vrstva == "Mapa dopravy") { trasy="mhd"; }
else { return; }
$.getJSON("http://www.oma.sk/api?bbox="+bbox+"&tabulka=trasy&typ="+trasy+"&format=fm&callback=?", function (data) {
	routeLayer.clearLayers();
	routeLayer.addData(data);
	$(".zoznam").text(" ");
	$.each(data, function(k, feature) { 
		$("#trasy_zoznam").append("<p id=\'"+feature.properties.id+"\' style=\'color:"+getcolour(feature)+";\'>"+feature.properties.description+"</p>");
	});
	$("#trasy_zoznam > p").click(function() { zoznamclickpart($(this).attr("id")); toright(); });
});

',
	// asi netreba: do mapy on close: vypni layer
);
/*
nefunguje po prekliku vrstvy v menu
po prvom loade nezapise activediv

*/
?>
<?php
//     <a href="#facebook"><i class='fa fa-facebook'></i> facebook</a>
// todo: aby netahalo pokial nekliknem, az potom nacitaj iframe a do height daj realne cislo

$config['twitter'] = array(
    'name' => 'Twitter',
	'menu-horne' => "<i class='fa fa-twitter'></i> twitter",
    // ake je html
//    'html' => 
//"<iframe id='facebook' class='submenu' src='http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/FreemapSlovakia&amp;colorscheme=light&amp;show_faces=false&amp;stream=true&amp;header=false&amp;scrolling=false&amp;border=0' scrolling='no' frameborder='0' style='border:none; ' data-width='100%'></iframe>"
);
//file_put_contents("www/data/facebook.html", "<iframe src='http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/FreemapSlovakia&colorscheme=light&show_faces=false&stream=true&header=false&height=600&scrolling=false&border=0' scrolling='no' frameborder='0' style='border:none; width: 95%; height:95%;'></iframe>");

//file_put_contents("www/data/facebook.html", "<iframe src='http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/FreemapSlovakia&amp;colorscheme=light&amp;show_faces=false&amp;stream=true&amp;header=false&amp;height=600&amp;scrolling=false&amp;border=0' scrolling='no' frameborder='0' style='border:none; width: 95%; height:95%;'></iframe>");
file_put_contents("www/data/twitter.html",'
<a class="twitter-timeline" data-height="335" data-chrome="nofooter" href="https://twitter.com/wwwOMAsk">Tweets by @FreemapSlovakia</a>
<script>
$(".twitter-timeline").attr("data-height", $(".submenu").height());
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>

');
?>
<?php
// mozem kontrolovat activediv='hladaj'
$config['vrstvy'] = array(
	'name' => 'Vrstvy',
	// ake je html
	'html' => '<a href="#FreemapSlovakia">Freemap</a> ponúka vrstvy:
<ul><li><a href="#" class="vrstva">Turistická mapa</a></li><li><a href="#" class="vrstva">Cykloatlas</a></li><li><a href="#" class="vrstva">Autoatlas</a></li><li><a href="#" class="vrstva">Zimná mapa</a>: najmä bežkárske trasy</li></ul>
Vrstvy z iných zdrojov (ale stále <a href="#OpenStreetMap">OpenStreetMap</a>):<ul><li><a href="#" class="vrstva">Mapa dopravy</a>: OpenBusMap</li><li><a href="#" class="vrstva">OSM</a>: základná vrstva openstreetmap</li><li><a href="#" class="vrstva">OCM</a>: OpenCycleMap</li></ul>
Všetky vrstvy pochádzajú zo sesterských projektov v rámci <a href="#OpenStreetMap">OpenStreetMap</a>.',
	'css' => '
',
	'css-mobile' => '#hladaj_q { width: 90%; }',
	// js funckie zavolane onload, jquery
	'jquery'=> '$("#vrstvy .vrstva").click(function(e) {
    e.preventDefault();
    if(typeof baseLayers[$(this).html()] === "object") {
        $("label:has(span:contains("+$(this).html()+"))").children("input").click();
        hreflink(activediv);
        toright();
        }
    return false;
    });
', 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
<?php
function towikilower($m) {
    return "<a href='#".strtolower($m[1])."'>".$m[2]."</a>";
    }
function wlower($m) { return '"#'.strtolower($m[1]).'"';}
function towiki($l, $level=1) {
    $ll = $l; $l = strtolower($l);
    if(is_readable("tmp/wiki/$l.html")) return;
    echo "-$ll $l -";
    $t = file_get_contents("http://www.freemap.sk/cms/$ll");
	if(strlen($t) < 10) return;
    $out = preg_grep('/load_wiki.*/', explode('"', $t));
    $t = preg_replace_callback('#<a href="javascript:void\(0\);" onclick="load_wiki_content\(\'([^)]*)\'\);">([^<]*)</a>#', 'towikilower', $t);
    $t = strtr($t, array('<div id="content">' => '', "\t" => '', "\r" => '', "  "=> ' ',  "\n" => '', '<div style="clear: both"></div>' => '', "<0d>" => '', '<0d>' => ''));
    $t = preg_replace('#<!--[^>]*>#', '', $t);
    $t = preg_replace('#<span class="missingpage" >[NS][^>]*>#i', '', $t);
    $t = preg_replace('#<form\b[^>]*>(.*?)</form>#', '', $t);
    $t = strtr($t, array('<div id="content">' => '', "\n" => '', '<div style="clear: both"></div>' => '', 'src="/' => 'src="http://wiki.freemap.sk/', "src='/" => "src='http://wiki.freemap.sk/", "<0d>" => ''));
    $t = substr($t,0, -6)."<br/><a href='http://wiki.freemap.sk/$l'>viac na wiki...</a></div>";
    file_put_contents("tmp/wiki/$l.html", "<div id='$l' class='submenu'>".$t."\n"); // posledny div mam
	file_put_contents("tmp/w.html", substr($t, 0, -6)); system("cat tmp/w.html | php embedimg.php http://wiki.freemap.sk > tmp/fullwiki/$l.html");
    foreach($out as $v) {
        $v = strtr($v, array("load_wiki_content('" => '', "');" => ''));
        $GLOBALS['wikip'][$v] = $v;
        }
	sleep(1);
}
if(strlen($fm) < 10) $fm=' #FreemapSlovakia '; // ak sme plugin spustili mimo buildovania
$w = preg_grep('/#[A-Z]/', preg_split('/[\s\'"]/', $fm));
foreach($w as $v) $wikip[] = strtr($v, array('href=' => '', '#' => '', '"'=> '', "#" => ''));
foreach($wikip as $v) towiki($v, 1);
foreach($wikip as $v) towiki( $v, 2);
//foreach($wikip as $v) towiki( $v, 3);
$s=20;
system("ls -sh tmp/fullwiki/ > tmp/wiki-list");
system("cd tmp/fullwiki; find -type f -size -${s}k -exec rm {} +; find -type f -size +${s}k -exec sh -c 'rm ../wiki/{};' \;; cp * ../../www/data/;");
system("cd tmp/wiki; cat * | php ../../embedimg.php http://wiki.freemap.sk > ../freemap-wiki.html; cd ../../");
system("rm tmp/w.html; ");

// mozem kontrolovat activediv='hladaj'
$config['wiki'] = array(
	'name' => 'Bez názvu',
	// ake je html
	'fullhtml' => file_get_contents('tmp/freemap-wiki.html'),
	'css' => '',
	// js funckie zavolane onload, jquery
	'jquery'=> "", 
	// do mapy on start: pridaj layer, resp premaz layer, mam geojson layer, zvladne vsetko
	// do mapy on move: napln layer
	// asi netreba: do mapy on close: vypni layer
);
?>
