<?php 

class mord{
	// SELECT idoco, fecoco FROM ordcom 
	//Mostrar datos
	public function selord($filtro, $rvalini, $rvalfin){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idoco, fecoco FROM ordcom";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE fecoco LIKE :filtro";
		}
		$sql .= " ORDER BY fecoco LIMIT $rvalini, $rvalfin";
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
	//Contar datos ordcom
	public function sqlcount($filtro){
		$sql = "SELECT count(idoco) AS Npe FROM ordcom";
		if($filtro)
			$sql .= " WHERE idoco LIKE '%$filtro%'";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}	
	//Mostrar un registro de ordcom
	public function selord1($idoco){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idoco, fecoco FROM ordcom";
		$sql .= " WHERE idoco=:idoco";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idoco',$idoco);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	// SELORD 2
	public function selord2($fecoco){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idoco FROM ordcom WHERE fecoco=:fecoco ";
		
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':fecoco',$fecoco);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//Llamar al procedimiento de de insertar o actualizar 
	public function ordiu($idoco, $fecoco){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL ordiu(:idoco, :fecoco)";
		//echo "<br><br><br><br>".$sql."<br>".$idoco."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idoco',$idoco);
		$result->bindParam(':fecoco',$fecoco);
		
		if(!$result)
			echo "<script>alert('ERROR AL INSERTAR/ACTUALIZAR');</script>";
		else
			$result->execute();
	}
	public function karact(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT idkar FROM kardex WHERE act=1";

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$result->bindParam(':idfac',$idfac);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>