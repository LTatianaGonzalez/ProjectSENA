<?php
class meps{
	public function seleps($filtro, $rvalini,$rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT epsnit, nomeps, logoeps FROM eps";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE nomeps LIKE :filtro ";
		}
		$sql .= " ORDER BY epsnit, nomeps LIMIT $rvalini,$rvalfin;";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($filtro){
			$result->bindParam(':filtro',$filtro);
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql = "SELECT COUNT(epsnit) AS Npe FROM eps";
		if($filtro)
			$sql .= " WHERE e.nomeps LIKE '%$filtro%'";
		return $sql;
	}

	public function seleps1($epsnit){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT epsnit, nomeps, logoeps FROM eps";
		$sql .= " WHERE epsnit=:epsnit";
		$result = $conexion->prepare($sql);

		$result->bindParam(':epsnit',$epsnit);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function epsiu($epsnit, $nomeps, $logoeps){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL epsiu(:epsnit, :nomeps, :logoeps);";
		//echo "<br><br><br><br><br>".$sql."<br>".$epsnit."-".$nomeps."-".$logoeps."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':epsnit',$epsnit);
		$result->bindParam(':nomeps',$nomeps);
		$result->bindParam(':logoeps',$logoeps);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR LA EPS');</script>";
		else
		$result->execute();
	}

	public function epsdel($epsnit){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL epsdel(:epsnit);";
		//echo $epsnit;
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':epsnit',$epsnit);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
}
?>