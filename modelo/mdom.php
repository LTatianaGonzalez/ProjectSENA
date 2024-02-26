<?php
class mdom{
	//Mostrar datos
	public function seldom($filtro, $rvalini, $rvalfin){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddom, nomdom, pardom FROM dominio";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE nomdom LIKE :filtro";
		}
		$sql .= " ORDER BY iddom LIMIT $rvalini, $rvalfin";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
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
	//Contar datos
	public function sqlcount($filtro){
		$sql = "SELECT count(iddom) AS Npe FROM dominio";
		if($filtro)
			$sql .= " WHERE nomdom LIKE '%$filtro%'";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}
	//Mostrar un registro
	public function seldom1($iddom){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddom, nomdom, pardom FROM dominio";
		$sql .= " WHERE iddom=:iddom";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddom',$iddom);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Actualizar y/o Insertar
	public function domver($iddom, $nomdom, $pardom){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL domver(:iddom,:nomdom, :pardom);";
		//echo "<br><br><br><br>".$sql."<br>".$iddom."-".$nomdom."-".$pardom."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddom',$iddom);
		$result->bindParam(':nomdom',$nomdom);
		$result->bindParam(':pardom',$pardom);
		
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	//Eliminar
	public function deldom($iddom){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL domdel(:iddom);";
		//echo "<br><br><br><br>".$sql."<br>".$iddom."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddom',$iddom);
		
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
}
?>