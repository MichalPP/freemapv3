<?php
echo preg_replace("/<img src='1p.*/", "",  strtr(file_get_contents("http://www.freemap.sk/?c=banner.show&Width=120&Height=60&DivName=LeftAreaBanner2&Ajax=LeftAreaBanner2"), array("src='." => "src='http://www.freemap.sk")));
?>