<?php
require_once('modelo/conexion.php');
require_once('modelo/mmail.php');
require_once('sendemail.php');

$mmail = new mmail();

$mail = isset($_POST["mail"]) ? $_POST["mail"]:NULL;
$cla = isset($_GET["cla"]) ? $_GET["cla"]:NULL;
$idusu = isset($_POST["idusu"]) ? $_POST["idusu"]:NULL;
$pass = isset($_POST["pass"]) ? $_POST["pass"]:NULL;

if($idusu && $pass){
	//echo $idusu." ".$pass;
	$pas = sha1(md5($pass));
	$mmail->upas($idusu,$pas);
	echo '<script>alert("Contraseña cambiada con exito.");</script>';
	echo "<script type='text/javascript'>window.location='index.php';</script>";
}
if($cla){
	$fecsolusu = date("Y-m-d H:i:s");
	$data = $mmail->susucf($cla,$fecsolusu);
	if($data){
		camcon($data[0]["idusu"],$data[0]["nomusu"]." ".$data[0]["apeusu"]);
	}else{
		echo '<script>alert("No es posible realizar el cambio de contraseña, por favor intentelo nuevamente.");</script>';
		echo "<script type='text/javascript'>window.location='index.php';</script>";
	}
}

$nom = "Prueba";

if($mail){
	verimail($mail);
}

function verimail($mail){
	$mmail = new mmail();
	$data = $mmail->vmail($mail);

	$data = isset($data) ? $data:NULL;

	if($data){
		$cla = sha1(md5(gencla(10)));
		$fecsolusu = date("Y-m-d H:i:s");
		//echo $data[0]['idusu']." ".$fecsolusu." ".$cla;
		$mmail->ufc($data[0]['idusu'],$fecsolusu,$cla);

		//mail($mail, "Cambio Contraseña",$cla);
		//Llamar funcion enviar mail
		$asunto = "Cambio de clave MedicEps";
		$ema = "vanessapirachican@gmail.com";
		sendemail($ema,$ema,$mail,$data[0]['nom'],$cla,$asunto,$fecsolusu);

		echo '<script>alert("Se ha enviado al email '.$mail.' los pasos para el cambio de contraseña.");</script>';
	}else{
		echo '<script>alert("El E-mail no se ecuentra registrado en nuestra base de datos, por favor intentelo nuevamente.");</script>';
	}

}

function olvcon(){
	$txt = '';
	$txt .= '<div class="inicio">';
		$txt .= '<h2>¿Olvido su contraseña?</h2>';
		$txt .= '<form name="frm1" action="index.php?pg=105" method="POST">';
			$txt .= '<label>Ingrese su E-mail registrado</label>';
			$txt .= '<input type="email" name="mail" class="form-control" required>';
			
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" value="Solicitar contraseña">';
			$txt .= '</div>';
		$txt .= '</form>';

		$txt .= '<div class="cen">';
			$txt .= '<a href="index.php">';
				$txt .= '<button type="button" class="btn btn-outline-secondary">Volver</button>';
			$txt .= '</a>';
			
		$txt .= '</div>';
	$txt .= '</div>';
	echo $txt;
}

function gencla($nu){
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$password = '';
	for($i=0;$i<$nu;$i++)
		$password .= substr($str,rand(0,61),1);
	return $password;
}

function camcon($idusu,$nom){
	$txt = '';
	$txt .= '<div class="inicio">';
		$txt .= '<h2>Cambie su contraseña '.$nom.'</h2>';
		$txt .= '<form name="frm1" action="index.php?pg=110" method="POST">';
			$txt .= '<input type="hidden" name="idusu" value="'.$idusu.'" required>';
			$txt .= '<label>Nueva contraseña</label>';
			$txt .= '<input type="password" name="pass" id="pas1" class="form-control" required>';
			$txt .= '<label>Confirmar contraseña</label>';
			$txt .= '<input type="password" id="pas2" class="form-control" required>';
			
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" onclick="return validadat();" value="Cambiar contraseña">';
			$txt .= '</div>';
		$txt .= '</form>';

		$txt .= '<div class="cen">';
			$txt .= '<a href="index.php">';
				$txt .= '<button type="button" class="btn btn-outline-secondary">Volver</button>';
			$txt .= '</a>';
			
		$txt .= '</div>';
	$txt .= '</div>';
	echo $txt;
}

?>