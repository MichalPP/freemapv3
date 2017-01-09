<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$fm = file_get_contents('freemap.html');
if(isset ($argv[1]) and $argv[1] == 'true') $runfull=true; else $runfull=false;

$replace['plugins-css'] = file_get_contents('tmp/leaflet.css');
$replace['plugins-css'] .= file_get_contents('img/font-awesome-4.4.0/css/font-awesome.min.css');

// plugins
system("cat plugins/* > tmp/freemap-plugins.php"); 
include("tmp/freemap-plugins.php");
$tidy = new tidy();
$tidyconf=array('DocType' => 'omit', 'tidy-mark' => 'no', 'show-body-only'=>true, 'indent' => false, 'wrap' => 0, 'vertical-space' => false, 'output-html' => true );
foreach($config as $k => $v) if(1) { // ak je plugin spomenuty v html
	// todo: skontrolvoat ci su uzvrete tagy
	if(strlen($v['html'])> 5) $replace['plugins-html'] .= "<div id='$k' class='submenu'>".strtr($tidy->repairString($v['html'],$tidyconf, 'utf8'), array("\n"=> ''))."</div>\n";
	if(strlen($v['fullhtml'])> 5) $replace['plugins-html'] .= strtr($tidy->repairString($v['fullhtml'], $tidyconf, 'utf8'), array("\n"=> ''))."\n";
	if(strlen($v['onmove']) >5) $replace['onmove'] .= "if(activediv == '#$k') {".$v['onmove']."}\n";
	$replace['plugins-jquery'] .= $v['jquery'];
	$replace['plugins-css'] .= $v['css'];
	$replace['plugins-css-mobile'] .= $v['css-mobile'];
}
foreach($replace as $k => $v) $fm = strtr($fm, array("@@@$k.html@@@" => $v));
$fm = preg_replace_callback('/["\']#([A-Z][^"\']*)[\'"]/', 'wlower', $fm);
$fm = preg_replace('/&([a-zA-Z1-9]*[,=])/', '&amp;\1', $fm);
$fm = preg_replace('/<td [^>]*>/', '<td>', preg_replace('/<table [^>]*>/', '<table>', $fm));
file_put_contents('tmp/freemap-tmp.html', $fm);
system("cat tmp/freemap-tmp.html | php embedimg.php > tmp/freemap.html");
$fm = file_get_contents("tmp/freemap.html");
//$fm = embedimg($fm);


$css = file_get_contents('css.css');
foreach($replace as $k => $v) $css = strtr($css, array("@@@$k.html@@@" => $v));
file_put_contents('tmp/css.css', $css);
file_put_contents('tmp/lib-js/98.js', $replace['plugins-jquery']);
file_put_contents('tmp/lib-js/96.js', strtr(file_get_contents('js.js'), array( '@@@onmove@@@' => $replace['onmove'])));
if($runfull) {
	system("cat tmp/lib-js/9* | yui-compressor --type js > tmp/freemap-js.js"); 
	system('cat tmp/css.css | yui-compressor --type css > tmp/freemap-css.css');
} else { system("cat tmp/lib-js/9* > tmp/freemap-js.js"); system('cat tmp/css.css > tmp/freemap-css.css'); }

$fm = strtr($fm, 
	array('@@@js@@@' => "<script type='text/javascript'>".file_get_contents('tmp/freemap-js.js')."</script>",
	'@@@css@@@' => file_get_contents('tmp/freemap-css.css')
	));
file_put_contents('www/index.html', $fm);

?>
