<?php
require 'PHPMailer/PHPMailerAutoload.php';
//function sendemail($mailusuemi,$mailpasemi,$correnv,$nomusu,$corr,$mensaj,$asunto, $template){
//function sendemail($idcema,$titumail,$correnv,$nomusu,$corr,$mensaj,$asunto){
function sendemail($ema,$correnv,$corr,$nomusu,$cla,$asunto,$fecsolusu){
	include("modelo/configuracion.php");
	

	//$template="../tempmail.html";//Path template HTML email
	$template="tempmail.html";
	$titumail="MedicEps";

	$mail = new PHPMailer;
	$mail->isSMTP(); //Utilizar SMTP
	$mail->Host = 'smtp.gmail.com'; // Especificar el servidor 
	$mail->SMTPAuth = true; // Habilitar la autenticacion
	$mail->Username = $mailusuemi; // E-mail saliente
	$mail->Password = $mailpasemi; // Contraseña mail
	$mail->SMTPSecure = 'tls'; // Habilitar encriptacion SSL
	$mail->Port = 587; // Puerto TCP 
	$mail->setFrom($correnv, $nomusu);//Email real. Nombre remitente
	$mail->addReplyTo($correnv, $nomusu);//A quien responder
	$mail->addAddress($corr);   // Para quien el e-mail
	$mensaje = file_get_contents($template); // Diseño mail
	$fec = substr($fecsolusu,0,10);
	$hor = substr($fecsolusu,11,8);
	$mensaje = str_replace('{{first_name}}', $titumail, $mensaje);
	$mensaje = str_replace('{{nomusu}}', $nomusu, $mensaje);
	$mensaje = str_replace('{{claj}}', $cla, $mensaje);
	$mensaje = str_replace('{{fec}}', $fec, $mensaje);
	$mensaje = str_replace('{{hor}}', $hor, $mensaje);
	$mensaje = str_replace('{{correnv}}', $correnv, $mensaje);
	$mensaje = str_replace('{{idcema}}', $ema, $mensaje);
	$mail->isHTML(true);  // Formato de email en HTML
	
	$mail->Subject = $asunto;
	$mail->msgHTML($mensaje);
	if(!$mail->send()) {
		echo '<p style="color:red">No se pudo enviar el mensaje..';
		echo 'Error de correo: ' . $mail->ErrorInfo;
		echo "</p>";
	} else {
		echo ' ';
		echo "<script>alert('Datos enviados a su correo registrado. El correo enviado puede llegar al spam o correos no deseados, por favor verifique.');</script>";
		echo "<script type='text/javascript'>window.location='index.php';</script>";
		//echo '<p style="color:green">Tu mensaje ha sido enviado!</p>';
	}
}

?>