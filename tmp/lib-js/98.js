$(".reklama").each(function() {$(this).load("reklama.php");});


function hladaj_klik(s) {
 var bbox = self.mapa.getBounds().toBBoxString();
 $.getJSON('http://nominatim.openstreetmap.org/search?q='+s+'&zoom='+mapa.getZoom()+'&viewbox='+bbox+'&countrycodes=sk&limit=15&format=jsonv2&accept-language=sk_SK&name_details=1&polygon_geojson=1&json_callback=?', function (data) {
        routeLayer.clearLayers();
		$('#hladaj_zoznam').text(' ');
		var d = [];
		$.each(data, function(k, v) { 
			$('#hladaj_zoznam').append('<p id="'+v.osm_type+'-'+v.osm_id+'" class="hladajelement" data-lon="'+v.lon+'" data-lat="'+v.lat+'">'+v.display_name+'</p>');
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



$("#objekty_kategorie_hlavicka").click(function() {$("#objekty_kategorie_menu").toggle(); });
$(".objektkategoria").change(function() {
	$("."+$(this).attr("id")).prop("checked", $(this).is(":checked"));
	console.log("is clicked? ."+$(this).attr("id")+" "+$(this).is(":checked"));
	refreshLayer();
});
function pocasie_routeclick(feature) { 
	console.log(feature.properties.id);
	$("#pocasie_zoznam").load("/data/pocasie.php?id="+feature.properties.id);
	$.ajax({
        url: "/data/pocasie.php?station_id="+feature.properties.id,
        dataType: "json",
        success: function (data) { $("#pocasie-"+feature.properties.id).loadJSON(data); }
    })

	}

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

$("#vrstvy .vrstva").click(function(e) {
    e.preventDefault();
    if(typeof baseLayers[$(this).html()] === "object") {
        $("label:has(span:contains("+$(this).html()+"))").children("input").click();
        hreflink(activediv);
        toright();
        }
    return false;
    });
