<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>MedicEps</title>
	<link rel="shortcut icon" href="image/mediceps.png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<!--	<script type="text/javascript" src="js/bootstrap.js"></script>-->
	
	<script src="js/jquery-3.2.1.min.js"></script>
	<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet" >

	<!--	<script src="https://kit.fontawesome.com/dbb91b0748.js" crossorigin="anonymous"></script> -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>


	<link href="css/all.css" rel="stylesheet"> 
</head>
<body>
	<header>
		<?php 
			$pg = isset($_GET["pg"]) ? $_GET["pg"]:NULL;
			include ("vista/cabe.php");
		?>
	</header>
	<!-- Contenido -->
	<section>
		<?php 
			$nu = 2;
			$alto = "0px";
			//require_once 'controlador/titulo.php';
			if($pg=="200" OR !$pg)
				include ("vista/vini.php");
			elseif($pg=="100")
		 		include ("vista/vreg.php"); 
		 	elseif($pg=="105")
		 		include ("vista/vmail.php");
		?>
	</section>
	<footer>
		<?php include ("vista/pie.php"); ?>
	</footer>
	<script type="text/javascript" src="js/valida.js"></script>
</body>
</html>