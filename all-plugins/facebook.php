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
