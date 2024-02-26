<div class="barsupizq">
	<?php 
		date_default_timezone_set('America/Bogota');
		$dia = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		$mes = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
		$fecha = $dia[date("w")].", ".date("d")." de ".$mes[date("n")-1]." ".date("Y");
		echo $fecha;
		//echo "<br>".date("l, j F Y");
	?>
</div>
<div class="barsupder">
<?php
	if(session_status()!=2){
		echo '<a href="index.php"><button class="btn btn-dark boton">Ingresar</button></a>';
	}else{
		echo "Bienvenido, ".$_SESSION["nomusu"]."&nbsp;&nbsp;&nbsp;&nbsp;";
		echo '<a href="vista/vsal.php"><button class="btn btn-dark boton">Salir</button></a>';
	}
?>
</div>
<div class="ban">
	<h1>MEDIC EPS<img src="image/mediceps.png" class="imglogoedit"></h1>
	
</div>