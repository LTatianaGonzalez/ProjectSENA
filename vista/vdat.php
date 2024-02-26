<?php
	include("controlador/creg.php");
	$idusu = isset($_SESSION["idusu"]) ? $_SESSION["idusu"]:NULL;
	if($idusu){
		$GLOBALS['nu'] = 1;
		$GLOBALS['alto'] = "850px";
	}
	cargar($idusu,"402",$arc);
?>