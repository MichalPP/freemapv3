<?php
if(strlen($_GET["id"]) > 1) echo file_get_contents("http://pocasie.oma.sk/js/pocasie.php?id=".$_GET["id"]);
else echo file_get_contents("http://pocasie.oma.sk/js/json.php?station_id=".$_GET["station_id"]);
?>