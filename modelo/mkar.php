<?php
class mkar{
	public function selkar($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idkar, fecini, fecfin, act FROM kardex";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE idkar LIKE :filtro";
		}
		$sql .= " ORDER BY idkar LIMIT $rvalini, $rvalfin;";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		if ($filtro){
			$result->bindParam(':filtro', $filtro);
		}
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selkar1($idkar){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idkar, fecini, fecfin, act FROM kardex WHERE idkar=:idkar";
		//echo "<br><br><br><br><br>".$sql."<br>".$idkar."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idkar',$idkar);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selkar2($fecini, $fecfin, $act){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idkar FROM kardex WHERE fecini=:fecini AND fecfin=:fecfin AND act=:act";
		
		$result = $conexion->prepare($sql);
		$result->bindParam(':fecini',$fecini);
		$result->bindParam(':fecfin',$fecfin);
		$result->bindParam(':act',$act);
		
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	//CONTAR DATOS
	public function sqlcount($filtro){
		$sql = "SELECT COUNT(idkar) AS Npe FROM kardex";
		if($filtro){
			$sql .= " WHERE idkar LIKE :filtro";
		}
		return $sql;
	}

	//ACTUALIZAR O INSERTAR
	public function kariu($idkar, $fecini, $fecfin, $act){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL kariu(:idkar, :fecini, :fecfin, :act)";
		//echo "<br><br><br><br>".$sql."<br>'".$idkar."','".$fecini."','".$fecfin."','".$act"'<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idkar',$idkar);
		$result->bindParam(':fecini',$fecini);
		$result->bindParam(':fecfin',$fecfin);
		$result->bindParam(':act',$act);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}
	//ELIMINAR
	public function kardel($idkar){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL kardel(:idkar);";
		//echo "<br><br><br><br>".$sql."<br>".$idkar."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idkar',$idkar);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR')</script>";
		else
			$result->execute();
	}

	public function kardact(){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "UPDATE kardex SET act=2;";
		//echo "<br><br><br><br>".$sql."<br>".$idkar."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idkar',$idkar);
		if(!$result)
			echo "<script>alert('ERROR AL ACTUALIZAR EL ACTIVO')</script>";
		else
			$result->execute();
	}
}
?>