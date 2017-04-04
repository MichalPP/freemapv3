<?php
// mediawiki https://wiki.openstreetmap.org/wiki/Slovakia/MappingParty?action=render
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
