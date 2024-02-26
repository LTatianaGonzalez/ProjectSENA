<?php
	require_once'controlador/cdoc.php';
	cabezote($idoco,$pg,$arc);
	insdatos($iddo,$idoco,$pg,$arc);
	mostrar($idoco, $pg, $arc);
?>