<?php
class mval{	
	public function selval ($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.codval, v.iddom, d.nomdom, v.nomval, v.parval
               FROM valor AS v INNER JOIN dominio AS d ON v.iddom=d.iddom";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE v.codval=:filtro OR v.iddom=:filtro OR v.nomval LIKE :filtro2";
		}
		$sql .= " ORDER BY v.codval LIMIT $rvalini,  $rvalfin";
		// echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		if($filtro){
			$result->bindParam(':filtro', $filtro);
			$result->bindParam(':filtro2', $filtro2);		
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selval1 ($codval){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT v.codval, v.iddom, v.nomval, v.parval
               FROM valor AS v INNER JOIN dominio AS d ON v.iddom=d.iddom 
               WHERE v.codval=:codval";
		// echo "<br><br><br><br><br>".$sql."<br>".$codval."<br>";
		$result = $conexion->prepare($sql);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		$result->bindParam(':codval', $filtro);		
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}



	public function sqlcount($filtro){
		$sql = "SELECT COUNT(v.codval) AS Npe FROM valor AS v INNER JOIN dominio AS d ON v.iddom=d.iddom";
		if($filtro){
			$sql .= " WHERE v.codval='$filtro' OR v.nomval LIKE '%$filtro';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}

	public function valiu ($codval, $iddom, $nomval, $parval){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL valiu(:codval, :iddom, :nomval, :parval)";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':codval',$codval);
		$result->bindParam(':iddom',$iddom);
		$result->bindParam(':nomval',$nomval);
		$result->bindParam(':parval',$parval);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	public function valdel ($codval){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL valdel(:codval);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		$result->bindParam(':codval', $codval);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
	
	public function seldom (){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddom FROM dominio WHERE nomdom=0 and pardom=0;";
		
		// echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>