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
