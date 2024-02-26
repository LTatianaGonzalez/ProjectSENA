<?php
class mcat{
	public function selcat($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idcate, nomcate FROM categoria";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE idcate OR nomcate LIKE $rvalini, $rvalfin ";
		}

		$sql .= " ORDER BY nomcate LIMIT $rvalini, $rvalfin;";
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

	public function selcat1($idcate){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idcate, nomcate FROM categoria"; 
		//echo "<br><br><br><br><br>".$sql."<br>".$idconf."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcate',$idcate);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql = "SELECT COUNT('idcate')  FROM categria";
		if($filtro){
			$sql .=" WHERE idcate='$filtro' LIKE '%$filtro%';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}

	public function cateiu($idcate,$nomcate){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL cateiu(:idcate,:nomcate)";
		//echo "<br><br><br><br><br>".$sql."<br><br>";

		$result = $conexion->prepare($sql);
		$result->bindParam(':idcate',$idcate);
		$result->bindParam(':nomcate',$nomcate);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	public function catedel($idcate){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL catedel(:idcate);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idcate',$idcate);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
}
	

