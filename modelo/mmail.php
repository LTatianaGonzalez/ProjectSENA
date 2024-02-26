<?php
class mmail{
	public function vmail($mail){
		$res = null;
		$modelo = new conexion();
		$conexion = $modelo ->get_conexion();
		$sql= "SELECT idusu, concat(nomusu,' ',apeusu) AS nom FROM usuario WHERE emausu=:mail;";
		//echo $sql;
		$result = $conexion->prepare($sql);
		$result->bindParam(':mail',$mail);
		if($result) $result->execute();

		while($f=$result->fetch())
			$res[] = $f;

		return $res;
	}
	// Consulta que nos actuliza 
	public function ufc($idusu,$fecsolusu,$clausu){
		$modelo = new conexion();
		$conexion = $modelo ->get_conexion();
		$sql= "UPDATE usuario set feccolusu=:fecsolusu, clausu=:clausu WHERE idusu=:idusu";
		//echo $sql;
		$result = $conexion->prepare($sql);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':fecsolusu',$fecsolusu);
		$result->bindParam(':clausu',$clausu);
		$result->execute();
	}

	public function upas($idusu){
		$modelo = new conexion();
		$conexion = $modelo ->get_conexion();
		$sql= "UPDATE usuario SET pasusu=:pasusu WHERE idusu=:idusu";
		//echo $sql;
		$result = $conexion->prepare($sql);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':pasusu',$pasusu);
		$result->execute();
	}

	public function susucf($clausu,$fecsolusu){
		$res = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql= "SELECT idusu, nomusu, apeusu FROM usuario WHERE clausu=:clausu AND ADDDATE(fecsolusu, INTERVAL 12 hour)>=:fecsolusu;";
		//echo $sql;
		$result = $conexion->prepare($sql);
		$result->bindParam(':clausu',$clausu);
		$result->bindParam(':fecsolusu',$fecsolusu);
		if($result) $result->execute();
		while($f=$result->fetch())
			$res[] = $f;
		return $res;
	}
}
?>