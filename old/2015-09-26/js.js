var historia = ["#domov", location.hash];
var activediv='#domov';
var activedivname = 'Domov';
/*
(function( $ ) {
$.fn.noClickDelay = function() {

var $wrapper = this;
var $target = this;
var moved = false;
// http://cubiq.org/remove-onclick-delay-on-webkit-for-iphone
$wrapper.bind('touchstart mousedown',function(e) {
e.preventDefault();
moved = false;
$target = $(e.target);
if($target.nodeType == 3) {
$target = $($target.parent());
}
$target.addClass('pressed');

$wrapper.bind('touchmove mousemove',function(e) {
moved = true;
$target.removeClass('pressed');
});

$wrapper.bind('touchend mouseup',function(e) {
$wrapper.unbind('mousemove touchmove');
$wrapper.unbind('mouseup touchend');
if(!moved && $target.length) {
$target.removeClass('pressed');
$target.trigger('click');
$target.focus();
}
});
});

};
})( jQuery );
$('#topmenu #left').noClickDelay();
*/
$("#toright").on('click', function() { $(".fullh").hide(); $("#mapa").show(); $("#toright").hide(); $("#toleft").show(); mapa.invalidateSize(); });
$(".toright").on('click', function() {toright(); });
function toright() { 
	if($(window).width() < 520) { $("#toright").click(); }
}
function toleft() {
	if($(window).width() < 520) { $("#toleft").click(); }
}

$("#left").swipe( {
	swipeLeft:function(event, direction, distance, duration, fingerCount) { toright(); },
	swipeRight:function() { divback(); }
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        //threshold:0
	});

$("#toleft").click(function() { $(".fullh").hide(); $("#left").show(); $("#toleft").hide(); $("#toright").show();});

$("#topmenushow").click(function() { 
	if( $("#topsmallmenu:visible").length > 0) { $(".fullh").hide(); $("#mapa").show(); $("#toright").hide(); $("#toleft").show();}
	else { $(".fullh").hide(); $("#topsmallmenu").show(); $("#toleft").hide(); $("#toright").show(); }
	});

function divback() {
	b= historia.pop();
	if(b == activediv) { b=historia.pop(); }
	console.log('back '+b);
	if(typeof b === undefined || b == undefined) { divshow('#domov'); return; }
	 divshow(b);
}
$("#naspat").click(divback);

function divshow(tt) {
	// zobraz na malej obrazovke
	if(typeof tt === 'string' && tt.indexOf('/') > -1) { return false; }
	if( $(tt).length < 1 ) { return false; }
	activediv=tt;
	if( $(window).width() > 520 && $(tt).length==1) {  $("div.submenu:not(#leftmenu)").hide(); $(tt).show(); return true; }
	if( $(tt).length==1 ) {
		$("div.submenu").hide(); $(".fullh").hide(); $("#left").show();
		$(tt).show();
		$("#toleft").hide(); $("#toright").show();
		return true;
	} // nacitaj z webu */
}
if(divshow(location.hash) == false) { divshow("#domov"); }

$('a[href^="#"]').click(function(e) {
	e.preventDefault();
	divshow($(this).attr("href"));
	$("a").removeClass("clicked"); $('a[href="'+$(this).attr("href")+'"]').addClass("clicked");
	historia.push($(this).attr("href"));
	location.hash = $(this).attr("href"); // kvoli mobilnym browserom co refreshovali 
	//if(history.pushState) { history.pushState(null, null, $(this).attr("href"));}  else { location.hash = $(this).attr("href"); }
	return false;
});

function resizebigger() {
	if($(window).width() == $("#left").width() && $(window).height() == $(".fullh").height() + $("#topmenu").height()) { return; }
	//alert('resize'+$(window).width()+' x '+$(window).height());
	if( $(window).width() < 520) {
		$(".smallnav").show(); $("#topmenushow").show(); $("#toright").hide();
		$("#topsmallmenu").hide().addClass("fullh");
		if(divshow(location.hash) == false) { $("#left").hide(); $("#mapa").show(); }
		$("#leftpart, #leftmenu, #topsmallmenu").css('max-height', ($(window).height() - $("#topmenu").height() - $(".reklamaall").height())+'px').css('height','');
	} else {
		$("#left").show(); $("#mapa").show(); $(".smallnav").hide(); $("#topmenushow").hide();
		$("#topsmallmenu").show().removeClass("fullh").height("60px");
		$(".tofull").removeClass("fullh").height("auto");$("div.submenu").removeClass("fullh").height("auto");
		$("#leftmenu").show().height("auto");
		$("#leftpart").height($(window).height() - $("#topmenu").height()- $("#leftmenu").height() - $(".reklamaall").height());
	}
	//$(".fullh").height($(window).height() - $("#topmenu").height());
	mapa.invalidateSize();
}
resizebigger();
var resizeTimeout;
$(window).resize(function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function(){    
        resizebigger();
    }, 200); });

function zoznamclick(feature) {
	$('p.clicked').removeClass('clicked'); $('#'+feature.id).addClass('clicked');
	// $('#hladaj').scrollTo('#target');
    // $('#hladaj').scrollTop($('#'+feature.id).offset().top - $('#hladaj').offset().top + $('#hladaj').scrollTop());
	//$('#hladaj').scrollTop($('#hladaj').scrollTop() + $('#'+feature.id).offset().top);
	//console.log($('#hladaj').offset().top + 'aa' + $('#'+feature.id).offset().top + 'tt');
	//$('#hladaj').offset().top =900;
	toleft();
	document.getElementById(feature.id).scrollIntoView();

}

var vrstva_zvyraznena = L.geoJson({ type: 'FeatureCollection', features: [] }, {
        style: {
            weight: 20,
            color: '#ff00aa',
            opacity: 1
        }, onEachFeature: function(feature, layer) {
            layer.on('click', function() {
                zoznamclick(self, feature);
            });
            layer.on('dblclick', function() {
                zoznamdbclick(self, feature);
            });
        }
    }).addTo(mapa);

var routeLayer = L.geoJson({ type: 'FeatureCollection', features: [] }, {
        style: function(feature) {
          return {color: 'red', opacity: 0.5, fillOpacity: 0.25, weight: 8};
        } , 
        onEachFeature: function (feature, layer) { 
            layer.on('click', function () {
                zoznamclick(feature);
            });
            // layer.on('dblclick', function() { zoznamdbclick(self, feature); });
        }
    })
routeLayer.addTo(mapa);

$(".reklama").each(function() {$(this).load("reklama.php");});

$("#vrstvy li").click(function() {$("label:has(span:contains("+$(this).html()+"))").children("input").click(); toright(); });


