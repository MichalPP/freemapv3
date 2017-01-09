<?php
// scp freemap.html michal@10.9.0.10:/home/vseobecne/projekty/osm/oma/odberatelia/freemap-v3/

$doall=0;

function imgtobase64($m) {
    $path = $m[2];
    $type = pathinfo($path, PATHINFO_EXTENSION); //echo "$path: $type\n";
	if($type == '') $type='png';
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $m[1].$base64.$m[3];
    }
function embedimg($fm) {
	$fm = preg_replace_callback("#(<img[^>]+src=')(http[^']*)('[^>]+>)#", "imgtobase64", $fm);
	$fm = preg_replace_callback('#(<img[^>]+src=")(http[^"]*)("[^>]+>)#', "imgtobase64", $fm);
	$fm = preg_replace_callback('#(url\(["\']*)(http[^"\'\)]*)(["\']*\))#', "imgtobase64", $fm);
	return $fm;
}
function srcaddprefix($fm, $pref='http://www.freemap.sk') {
	$fm = strtr($fm, array('src="/' => "src=\"".$pref."/", "src='/" => "src='$pref/", 'src="./' => "src=\"".$pref."/", "src='./" => "src='$pref/"));
	return $fm;
}
if($doall) {
	system("wget -O - 'http://www.freemap.sk/?c=core.map.legend&Ajax=LeftArea' |sed \"s/ style='[^']*'//g\" | sed 's/valign=[^ ]* //g' |sed 's#<[/]*span[ ]*>##g' > t2;");
	// ikony
	//system("wget -O /home/vseobecne/www/weby/epsilon.sk/ulice/font-awesome.min.css https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css;");
	system('cp img/font-awesome-4.4.0/fonts/fontawesome-webfont.woff /home/vseobecne/www/weby/epsilon.sk/fonts/;
cp img/font-awesome-4.4.0/fonts/fontawesome-webfont.* /home/vseobecne/www/weby/freemap.epsilon.sk/fonts/;');
	// prehod obrazky
	$f = file_get_contents('t2');
	$r= preg_replace('#</div>$#', '', $f); 
	$r = embedimg(srcaddprefix($r, 'http://www.freemap.sk'));
	file_put_contents('freemap-legenda.html', $r);
}
$replace['freemap-legenda'] = file_get_contents('freemap-legenda.html');

function imgf($typ) {
	$m = array('', 'src="', "img/$typ.png", '"');
	$r = "<img ".imgtobase64($m)." alt='ikona $typ' />";
	return $r;
}

if($doall) {
// freemap domov: http://www.freemap.sk/?c=core.map.sitestart&Ajax=LeftArea
system("wget -O - 'http://www.freemap.sk/?c=core.map.sitestart&Ajax=LeftArea' | sed 's#<div#\\n<div#g' |sed \"s#src='\([^h]\)#src='http://www.freemap.sk/\\1#g\"  > t3");
$t= strtr(file_get_contents('t3'), array('%01' => '', '<01>' => ''));
$t = embedimg($t);
file_put_contents('t3', $t);
}
$replace['freemap-domov'] = file_get_contents('freemap-domov.html');

$fm = file_get_contents('freemap.html');

// z http://www.freemap.sk/cms/FreemapSlovakia rekurzivne stiahni vsetky stranky...
function towikilower($m) {
	return "<a href='#".strtolower($m[1])."'>".$m[2]."</a>";
	}
function wlower($m) { return '"#'.strtolower($m[1]).'"';} 
function towiki($l) {
	$ll = $l; $l = strtolower($l);
	if(is_readable("wiki/$l.html")) return;
	echo "-$ll $l -";
	$t = file_get_contents("http://www.freemap.sk/cms/$ll");
	$out = preg_grep('/load_wiki.*/', explode('"', $t));
	// z <a href="javascript:void(0);" onclick="load_wiki_content('FileDownload');">výstupov</a>
    // na <a href='FileDownload' class='submenu'vysupov</a>
	$t = embedimg(srcaddprefix($t, 'http://wiki.freemap.sk'));
    $t = preg_replace_callback('#<a href="javascript:void\(0\);" onclick="load_wiki_content\(\'([^)]*)\'\);">([^<]*)</a>#',
       // "<a href='#$1' class='submenu'>$2</a>", 
		'towikilower',
		$t);
	$t = strtr($t, array('<div id="content">' => '', "\t" => '', "\r" => '', "  "=> ' ',  "\n" => '', '<div style="clear: both"></div>' => '', "<0d>" => '', '<0d>' => ''));
	$t = preg_replace('#<!--[^>]*>#', '', $t);
	$t = preg_replace('#<span class="missingpage" >[NS][^>]*>#i', '', $t);
	//$t = preg_replace('#<form[^/form>]*</form>#', '', $t);
    $t = preg_replace('#<form\b[^>]*>(.*?)</form>#', '', $t);
	$t = strtr($t, array('<div id="content">' => '', "\n" => '', '<div style="clear: both"></div>' => '', 'src="/' => 'src="http://wiki.freemap.sk/', "src='/" => "src='http://wiki.freemap.sk/", "<0d>" => ''));
	//if(!in_array($l, array('recruitmentposter','winmobilebtgps','jtiledownloader','freemapstats','osmtracker'))) {
	// $t = preg_replace_callback("#(src=')([^']*)(')#", "imgtobase64", $t);$t = preg_replace_callback('#(src=")([^"]*)(")#', "imgtobase64", $t);
	//}
	$t = substr($t,0, -6)."<br/><a href='http://wiki.freemap.sk/$l'>viac na wiki...</a></div>";
	file_put_contents("wiki/$l.html", "<div id='$l' class='submenu'>".$t."\n"); // posledny div mam
	foreach($out as $v) {
		$v = strtr($v, array("load_wiki_content('" => '', "');" => ''));
		$GLOBALS['wikip'][$v] = $v;
		//$text = file_get_contents("http://www.freemap.sk/cms/$v");
		//if(!is_readable("wiki/$v.html")) file_put_contents("wiki/$v.html", "<div id='$v' class='submenu'>".towiki(array('', $v))."</div>\n");
		}
	// z <a href="javascript:void(0);" onclick="load_wiki_content('FileDownload');">výstupov</a>
	// na <a href='FileDownload' class='submenu'vysupov</a>
	//sleep(1);
}
//$fm = preg_replace_callback("#@@@([^@]*)@@@#", "towiki", $fm);
$w = preg_grep('/#[A-Z]/', preg_split('/[\s\'"]/', $fm));
foreach($w as $v) $wikip[] = strtr($v, array('href=' => '', '#' => '', '"'=> '', "#" => ''));
//print_r($wikip); die();
//$wikip = array('FreemapSlovakia','FileDownload');
foreach($wikip as $v) towiki($v);
foreach($wikip as $v) towiki( $v); 
//foreach($wikip as $v) towiki( $v);

system("cd wiki; find -type f -size +50k -exec rm {} +; cat * > ../freemap-wiki.html");
$replace['freemap-wiki'] = file_get_contents('freemap-wiki.html');

$replace['plugins-css'] = file_get_contents('/home/vseobecne/projekty/osm/oma/www/js/leaflet.min.css');
$replace['plugins-css'] .= file_get_contents('img/font-awesome-4.4.0/css/font-awesome.min.css');

// plugins
system("cat plugins/* > freemap-plugins.php");
include("freemap-plugins.php");
foreach($config as $k => $v) if(1) { // ak je plugin spomenuty v html
	$replace['plugins-html'] .= "<div id='$k' class='submenu'>".$v['html']."</div>";
	$replace['plugins-jquery'] .= $v['jquery'];
	$replace['plugins-css'] .= $v['css'];
	$replace['plugins-css-mobile'] .= $v['css-mobile'];
}
foreach($replace as $k => $v) $fm = strtr($fm, array("@@@$k.html@@@" => $v));
$fm = strtr($fm, array("@@@basicmapa.js@@@" => file_get_contents('/home/vseobecne/projekty/osm/oma/www/js/basic.js')));
$fm = preg_replace_callback('/["\']#([A-Z][^"\']*)[\'"]/', 'wlower', $fm);
$fm = preg_replace('/&([a-zA-Z1-9]*[,=])/', '&amp;\1', $fm);
$fm = preg_replace('/<td [^>]*>/', '<td>', preg_replace('/<table [^>]*>/', '<table>', $fm));
$fm = strtr($fm, array('</i> ' => '</i>&nbsp;'));
$fm = embedimg($fm);

$js = file_get_contents('/home/vseobecne/projekty/osm/oma/www/js/basic.js');
$js .= file_get_contents('js.js');
$js .= $replace['plugins-jquery'];
file_put_contents('freemap-js.js', $js);
$fm = strtr($fm, array('@@@js@@@' => "<script type='text/javascript'>".file_get_contents('freemap-js.js')."</script>"));
// cat freemap-js.js| yui-compressor --type js > js
file_put_contents('fm.html', $fm);

system("cp fm.html /home/vseobecne/www/weby/epsilon.sk/ulice/fm.html; 
cp fm.html /home/vseobecne/www/weby/freemap.epsilon.sk/index.html;
cp reklama.php /home/vseobecne/www/weby/epsilon.sk/ulice/ 
cp img/font-awesome-4.4.0/fonts/fontawesome-webfont.* /home/vseobecne/www/weby/epsilon.sk/fonts/;
cp reklama.php /home/vseobecne/www/weby/freemap.epsilon.sk/
oma ff;");

?>
