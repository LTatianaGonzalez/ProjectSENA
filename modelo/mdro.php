<?php
class mdro{
	//Metodo de Insertar drogueria 
	public function seldrog($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT dr.iddro, dr.nomdro, dr.codubi, u.nomubi, dr.dirdro, dr.teldro, u.nomubi AS Mun, d.nomubi AS Dep FROM drogueria AS dr LEFT JOIN ubicacion AS u ON dr.codubi=u.codubi LEFT JOIN ubicacion AS d ON u.depubi=d.codubi";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE dr.iddro=:filtro OR u.nomubi LIKE :filtro2";
		}
		$sql .= " ORDER BY dr.iddro LIMIT $rvalini, $rvalfin;";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($filtro){
			$result->bindParam(':filtro',$filtro);
			$result->bindParam(':filtro2',$filtro2);
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function seldrog1($iddro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT dr.iddro, dr.nomdro, dr.codubi, u.nomubi, dr.dirdro, dr.teldro AS Mun, d.nomubi AS Dep FROM drogueria AS dr LEFT JOIN ubicacion AS u ON dr.codubi=u.codubi LEFT JOIN ubicacion AS d ON u.depubi=d.codubi WHERE dr.iddro=:iddro";
		//echo "<br><br><br><br><br>".$sql."<br>".$iddro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddro',$iddro);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql = "SELECT COUNT(dr.iddro) AS Npe FROM drogueria AS dr INNER JOIN ubicacion AS u ON dr.codubi=u.codubi";
		if($filtro){
			$sql .= " WHERE d.iddro='filtro' OR u.nomubi LIKE '%filtro%';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}
	public function drogiu($iddro,$nomdro,$codubi,$dirdro,$teldro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL drogiu(:iddro,:nomdro,:codubi,:dirdro,:teldro)";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		echo "<br><br><br><br>".$sql."<br>".$iddro."-".$nomdro."-".$codubi."-".$dirdro."-".$teldro."<br>";
		echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result = $conexion->prepare($sql);
		$result->bindParam(':iddro',$iddro);
		$result->bindParam(':nomdro',$nomdro);
		$result->bindParam(':codubi',$codubi);
		$result->bindParam(':dirdro',$dirdro);
		$result->bindParam(':teldro',$teldro);

		if(!$result){
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		}else{
			$result->execute();
		}
	}
	public function drogdel($iddro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL drogdel(:iddro);";
		//echo "<br><br><br><br><br>".$sql."<br>".$iddro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddro',$iddro);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
	public function selubi(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.codubi, c.nomubi AS ciu, d.nomubi AS dep FROM ubicacion AS c INNER JOIN ubicacion AS d ON c.depubi=d.codubi ORDER BY nomubi;";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function seldep(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codubi, nomubi FROM ubicacion WHERE depubi=0 ORDER BY nomubi;";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

}
?>