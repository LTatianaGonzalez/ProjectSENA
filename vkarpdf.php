<?php
require_once("modelo/seguridad.php");
require_once('controlador/cdka.php');
ini_set('memory_limit', '512M');
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$pdf = isset($_GET['pdf']) ? $_GET['pdf']:NULL;
$pag = isset($_GET["pag"]) ? $_GET["pag"]:NULL;

date_default_timezone_set('America/Bogota');
$dia = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
$fecha = date("d")." de ".$mes[date("m")-1]." de ".date("Y");
$fecha2 = date("Ymd");

$html = "<head>";
	$html .="<style type='text/css'>";
		$html .="html {";
			$html .="margin: 0;";
		$html .="}";
		$html .="body {";
			$html .="font-family: 'Arial', 'Verdana';";
			$html .="margin: 10mm 10mm 10mm 10mm;";
		$html .="}";
		$html .="th {";
			$html .="font-family: 'Arial', 'Verdana';";
			$html .="font-size: 12px;";
			$html .="font-weight: bold;";
			$html .="color: #000000;";
			$html .="background-color: #d8d8d7;";
		$html .="}";
		$html .="td {";
			$html .="font-family: 'Arial', 'Verdana';";
			$html .="font-size: 12px;";
			$html .="color: #000000;";
		$html .="}";
	$html .="</style>";
	$anchohoja = 750;
$html .="</head>";
$html .="<body>";
	$html .="<div align='left' style='float: left;'>";
		$html .= mostrar2($idkar,$pg,$arc);
	$html .="</div>";
$html .= "</body>";
//echo $html;
if($pdf==1547){
	//echo $html;
	$dompdf = new DOMPDF();
	$paper_size = array(0,0,612,792);
	
	$dompdf->loadHtml($html); 
	$dompdf->setPaper($paper_size);
	//$dompdf->setPaper('A4', 'landscape');
	$dompdf->render(); 
	$dompdf->stream("Kardex_".$fecha2.".pdf");
}else{
	echo $html;
	echo "<script type='text/javascript'>window.print();</script>";
}
?>