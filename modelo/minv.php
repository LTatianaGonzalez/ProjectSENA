<?php
class minv{	
	public function selinv ($filtro, $rinvini, $rinvfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT i.idinv, i.iddro, i.fecininv, i.fecfininv, i.act
               FROM inventario AS i INNER JOIN drogueria AS d ON i.iddro=d.iddro";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE i.idinv=:filtro OR i.iddro=:filtro OR i.fecininv OR i.fecfininv OR i.act LIKE :filtro2";
		}
		$sql .= " ORDER BY i.idinv LIMIT $rinvini,  $rinvfin";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

	public function selinv1 ($idinv){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT i.idinv, i.iddro, i.fecininv, i.fecfininv, i.act
               FROM inventario AS i INNER JOIN drogueria AS d ON i.iddro=d.iddro 
               WHERE i.idinv=:idinv";
		// echo "<br><br><br><br><br>".$sql."<br>".$codval."<br>";
		$result = $conexion->prepare($sql);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		$result->bindParam(':idinv', $filtro);		
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}



	public function sqlcount($filtro){
		$sql = "SELECT COUNT(i.idinv) AS Npe FROM inventario AS i INNER JOIN drogueria AS d ON i.iddro=d.iddro";
		if($filtro){
			$sql .= " WHERE i.idinv='$filtro' OR i.iddro LIKE '%$filtro';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}

	public function inviu ($idinv, $iddro, $fecininv, $fecfininv, $act){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL valiu(:idinv, :iddro, :fecininv, :fecfininv, :act)";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idinv',$idinv);
		$result->bindParam(':iddro',$iddro);
		$result->bindParam(':fecininv',$fecininv);
		$result->bindParam(':fecfininv',$fecfininv);
		$result->bindParam(':act',$act);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	public function invdel ($idinv){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL invdel(:idinv);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		// echo = $conexion-> setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_EXCEPTION);
		$result->bindParam(':idinv', $idinv);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
	
	public function seldro (){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT iddro, nomdro FROM drogueria;";
		
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