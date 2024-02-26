<?php require_once("modelo/seguridad.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>MedicEps</title>
	<link rel="shortcut icon" href="image/mediceps.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script> -->
	<script src="js/jquery-3.2.1.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	
	<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
	<!--	<script src="https://kit.fontawesome.com/dbb91b0748.js" crossorigin="anonymous"></script> -->
	<link href="css/all.css" rel="stylesheet"> 
</head>
<body>
	<header>
		<?php 
			$nu = 2;
			$alto = "0px";
			$pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"]:NULL;
			include ("vista/cabe.php"); 
		?>		
	</header>
	<!-- Section Menu Interno -->
	<section>
		<?php
			$pefid = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
			include("vista/vmen.php");
			//require_once 'controlador/titulo.php';
		?>		
	</section>
	<!-- Contenido -->
	<section>
		<?php 
			moscon($pefid, $pg);
		?>
	</section>

	<footer>
		<?php include ("vista/pie.php"); ?>
	</footer>
	<script type="text/javascript" src="js/valida.js"></script>
	<script src="js/classie.js"></script>
	<script src="js/gnmenu.js"></script>
	<script>
		new gnMenu(document.getElementById('gn-menu'));
	</script>
	<script>ocultar(<?php echo $nu; ?>,"<?php echo $alto; ?>");</script>
</body>
</html>