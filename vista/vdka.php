<?php
	require_once 'controlador/cdka.php';
	moskar($idkar,$pg,$arc);
	cargar($idkar,$pg,$arc);
	mostrar($idkar,$conp,$nreg,$pg,$arc,$filtro,$bo);
	echo mostrar2($idkar,$pg,$arc)
?>