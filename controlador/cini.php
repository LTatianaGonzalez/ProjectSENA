<?php

function erroraute(){
	$error = isset($_GET['error']) ? $_GET['error']:NULL;
	if($error=="ok"){
		$txt = '<div class="alert alert-warning cen" style="padding-top: 10px;" role="alert">';
			$txt .= 'Datos incorrectos.';
		$txt .= '</div>';
		echo $txt;
	}
}


?>