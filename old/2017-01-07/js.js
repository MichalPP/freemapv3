var T = new L.tileLayer("http://{s}.freemap.sk/T/{z}/{x}/{y}.jpeg", {maxZoom: 16,attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> vrstva <a href="http://www.freemap.sk">Freemap.sk</a>'});
var C = new L.tileLayer("http://{s}.freemap.sk/C/{z}/{x}/{y}.jpeg", {maxZoom: 16,attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> vrstva <a href="http://www.freemap.sk">Freemap.sk</a>'});
var A = new L.tileLayer("http://{s}.freemap.sk/A/{z}/{x}/{y}.jpeg", {maxZoom: 16,attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> vrstva <a href="http://www.freemap.sk">Freemap.sk</a>'});
var K = new L.tileLayer("http://{s}.freemap.sk/K/{z}/{x}/{y}.jpeg", {maxZoom: 16,attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> vrstva <a href="http://www.freemap.sk">Freemap.sk</a>'});
var OBM = new L.tileLayer("http://tileserver.memomaps.de/tilegen/{z}/{x}/{y}.png", {maxZoom: 18, attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> vrstva <a href="http://openbusmap.org/">OpenBusMap</a>'});
var OSM = new L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {maxZoom: 18, attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>'});
var OCM = new L.tileLayer("http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png", {maxZoom: 18, attribution: 'Podkladové dáta &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>'});

L.Icon.Default.imagePath = "http://www.oma.sk/js";
var baseLayers = {"Turistická mapa": T,"Cykloatlas": C,"Autoatlas": A,"Zimná mapa": K,"Mapa dopravy": OBM,"OSM": OSM,"OCM": OCM};
var Layers = {"Turistická mapa":'T',"Cykloatlas":'C',"Autoatlas": 'A',"Zimná mapa":'K',"Mapa dopravy":'OBM',"OSM":'OSM',"OCM":'OCM'};

var extraLayers = {};

var historia = ["#domov", location.hash];
var activediv='#domov';
var activedivname = 'Domov';

var visiblehei = 400;


loc = {};
var a=$.deserialize(location.hash.replace('#', ''), {});
if(typeof a['map'] === 'string') {
    loc=a['map'].split('/');
}


var mapa = new L.Map("mapa",{ layers: [window[loc[0]] || T], 
	zoom: loc[1] || 8, center: [loc[2]||48.53479,loc[3]||19.80286], 
	minZoom: 6 });
mapa.attributionControl.setPrefix("");
L.control.scale({imperial:false}).addTo(mapa);

var layers=L.control.activeLayers(baseLayers,extraLayers).addTo(mapa);

$("#toright").on('click', function() { $(".fullh").hide(); $("#mapa").show(); $("#toright").hide(); $("#toleft").show(); mapa.invalidateSize(); });
$(".toright").on('click', function() {toright(); });
function toright() { 
	if($(window).width() < 520) { $("#toright").click(); }
}
function toleft() {
	if($(window).width() < 520) { $("#toleft").click(); }
}

/*$("#left").swipe( {
	swipeLeft:function(event, direction, distance, duration, fingerCount) { toright(); },
	swipeRight:function() { divback(); }
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        //threshold:0
	});
*/
$("#toleft").click(function() { $(".fullh").hide(); $("#left").show(); $("#toleft").hide(); $("#toright").show();});

$("#topmenushow").click(function() { 
	if( $("#topsmallmenu:visible").length > 0) { $(".fullh").hide(); $("#mapa").show(); $("#toright").hide(); $("#toleft").show();}
	else { $(".fullh").hide(); $("#topsmallmenu").show(); $("#toleft").hide(); $("#toright").show(); }
	});

//$("#topmenu").click(function() { $("#topmenushow").click(); });

function divback() {
	b= historia.pop();
	if(b == activediv) { b=historia.pop(); }
	if(typeof b === undefined || b == undefined) { divshow('#domov'); return; }
	divshow(b);
}
$("#naspat").click(divback);

function divshow(tt) {
	// zobraz na malej obrazovke
	console.log(tt);
	if(typeof tt !== 'string') { return false; }
	if( tt == '#undefined') { return false; }
	//if(typeof tt === 'string' && tt.indexOf('/') > -1) { return false; }
	if(typeof tt === 'string' && tt.indexOf('&') > -1) { 
		var aa=$.deserialize(tt.replace('#', ''), {});
		console.log(aa['page']);
		return divshow('#'+aa['page']);
	}
	//if( $(tt).length < 1 ) { return false; }
	activediv=tt;

	if($(tt).length!=1 ) {
        $("#left").append("<div id='"+tt.replace('#', '')+"' class='submenu'></div>");
        $(tt).load("/data/"+tt.replace('#', '')+".html");
    	}
	refreshLayer();
	if( $(window).width() > 520 && $(tt).length==1) {  $("div.submenu").hide(); $(tt).show(); return true; }
	if( $(tt).length==1 ) {
		$("div.submenu").hide(); $(".fullh").hide(); $("#left").show();
		$(tt).show();
		$("#toleft").hide(); $("#toright").show();
		return true;
	} 
}

function hreflink(href) {
    var link={};
    $(""+activediv+" .freemapform :input" ).each(function() { link[$(this).attr('name')] = $(this).val(); });
    link['page'] = href.replace('#', '');
    link['map'] = Layers[$("label:has(input:checked)").children("span").html().trim()]+'/'+mapa.getZoom()+'/'+Math.round(mapa.getCenter().lat*100000)/100000+'/'+Math.round(mapa.getCenter().lng*100000)/100000;
    l='#'+decodeURIComponent($.param(link));
    historia.push(l);
    location.hash = l; //$(this).attr("href"); // kvoli mobilnym browserom co refreshovali 
}

// todo: filter iba zacinajuce na pismeno, 
// filter(function() { return this.id.match(/abc+d/); })
$('a[href^="#"][href!="#"]').click(function(e) {
	e.preventDefault();
	$("a").removeClass("clicked"); $('a[href="'+$(this).attr("href")+'"]').addClass("clicked");
	//if(history.pushState) { history.pushState(null, null, $(this).attr("href"));}  else { location.hash = $(this).attr("href"); }
	hreflink($(this).attr("href"));
	divshow($(this).attr("href"));
	return false;
});

function resizebigger() {
	//if(abs($(window).width() - $("#left").width()) < 100 || abs($(window).height() == $(".fullh").height() + $("#topmenu").height()) < 100) { return; }
	//alert('resize'+$(window).width()+' x '+$(window).height());
	whei = Math.min(window.screen.availHeight, window.innerHeight, $(window).height(), document.documentElement.clientHeight);
	console.log("whei "+whei+" "+$("#topmenu").height()+" reklama: "+$(".reklamaall").height());
	if( $(window).width() < 520) {
		$(".smallnav").show(); $("#topmenushow").show(); $("#toright").hide();
		$("#topsmallmenu").hide().addClass("fullh");
		$("#leftmenu").addClass("submenu");
		if(divshow('#'+a['page']) == false) { $("#left").hide(); $("#mapa").show(); }
		console.log("whei "+whei+" "+$("#topmenu").height()+" reklama: "+$(".reklamaall").height());
		var visiblehei = whei - $("#topmenu").height() - $(".reklamaall").height();
		$("#leftmenu, #topsmallmenu, div.submenu").height(whei - $("#topmenu").height() - $(".reklamaall").height());
	} else {
		$("#left").show(); $("#mapa").show(); $(".smallnav").hide(); $("#topmenushow").hide();
		$("#topsmallmenu").show().removeClass("fullh").height("60px");
		$(".tofull").removeClass("fullh").height("auto");$("div.submenu").removeClass("fullh").height("auto");
		$("#leftmenu").show().height("auto").removeClass("submenu");
		console.log("whei "+whei+" "+$("#topmenu").height()+" reklama: "+$(".reklamaall").height());
		var visiblehei = whei - $("#topmenu").height()- $("#leftmenu").height() - $(".reklamaall").height();
		$(".submenu").height(whei - $("#topmenu").height()- $("#leftmenu").height() - $(".reklamaall").height());
	}
	console.log("whei "+whei+" "+$("#topmenu").height()+" reklama: "+$(".reklamaall").height());
	$(".fullh").height(whei - $("#topmenu").height()-2);
	//$("body, html").height(whei);
	mapa.invalidateSize();
}
resizebigger();

var resizeTimeout;
$(window).resize(function() {
	//console.log("widht "+Math.abs($(window).width() - $("#left").width())); console.log('height '+Math.abs($(window).height() - $(".fullh").height() - $("#topmenu").height()) );
	if(Math.abs($(window).width() - $("#left").width()) < 40 && Math.abs($(window).height() - $(".fullh").height() - $("#topmenu").height()) < 150) { console.log('mala vyska alebo vyska'); return; }
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function(){    
        resizebigger();
    }, 200); });

function zoznamclickpart(id) {
	$('p.clicked').removeClass('clicked'); $('#'+id).addClass('clicked');
    routeLayer.eachLayer(function (layer) {
        layer.setStyle({opacity: 0.5, weight: 15});
        if(layer.feature.properties.id==id || layer.feature.id==id) {layer.setStyle({opacity: 1, weight: 35 });}
    });
}
function zoznamclick(feature) {
	if(typeof feature.id === undefined || feature.id == undefined) { id=feature.properties.id; }
	else { id=feature.id; }
	zoznamclickpart(id);
	// ak neexistuje element s tym id, skus ho nacitat z perex.php?div=activediv&id=id
	document.getElementById(id).scrollIntoView();
	toleft();
}

var routeLayer = L.geoJson({ type: 'FeatureCollection', features: [] }, {
        style: function(feature) {
          return {color:  getcolour(feature), opacity: 0.5, fillOpacity: 0.25, weight: 15};
        } , 
        onEachFeature: function (feature, layer) { 
            layer.on('click', function () { 
				tt=activediv.replace('#', '');
				if(jQuery.isFunction(window[tt+"_routeclick"])) {
					window[tt+"_routeclick"](feature);
				} else { zoznamclick(feature); }
			});
		},
		pointToLayer: function (feature, latlng) {
			// return L.marker ak existuje properties.icon: foto, pocasie, ...
			if(typeof feature.properties.icon === "string") {
				return L.marker(latlng, { icon: L.divIcon({html: "<img src='"+feature.properties.icon+"'/>", iconAnchor: [50, 50], iconSize: null }) });
			}
	        return L.circleMarker(latlng);
		}
            // layer.on('dblclick', function() { zoznamdbclick(self, feature); });
    })
routeLayer.addTo(mapa);

$(".permalink").click(function(e) { e.preventDefault(); hreflink(activediv); return false; });

var posledny = 0;
function refreshLayer() {
        if(mapa.getZoom() < 12) return;
        sucasny = Date.now();
        if(posledny + 4000 > sucasny) return;
        posledny = sucasny;
        var bbox = mapa.getBounds().toBBoxString();
        hreflink(activediv);
		@@@onmove@@@
    }

mapa.on("moveend", function() { refreshLayer(); });
mapa.on("baselayerchange", function() {refreshLayer();} );



if(divshow('#'+a['page']) == false)  { divshow("#domov"); }
$('#'+a['page']+" form").autofill(a);

refreshLayer();


