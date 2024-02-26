<?php
class mprd{
	public function selpro($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT p.idpro,p.codval,v.nomval,p.nompro,p.descsp,p.preven,p.precom,p.imgpro,p.tppro FROM producto AS p INNER JOIN valor AS v ON p.codval=v.codval";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE p.idpro=:filtro OR p.nompro LIKE :filtro2";
		}
		$sql .= " ORDER BY p.idpro LIMIT $rvalini, $rvalfin";
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
	public function selpro1($idpro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = " SELECT p.idpro,p.codval,v.nomval,p.nompro,p.descsp,p.preven,p.precom,p.imgpro,p.tppro FROM producto AS p INNER JOIN valor AS v ON p.codval=v.codval WHERE p.idpro=:idpro";
		//echo "<br><br><br><br><br>".$sql."<br>".$idpro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpro',$idpro);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function sqlcount($filtro){
		$sql = "SELECT COUNT(p.idpro) AS Npe FROM producto AS p INNER JOIN valor AS v ON p.codval=v.codval";
		if($filtro){
			$sql .= " WHERE p.idpro='filtro' OR nomcate LIKE '%filtro%';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}
	public function proiu($idpro,$codval,$nompro,$descsp,$preven,$precom,$imgpro,$ttpro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL proiu(:idpro, :codval, :nompro, :descsp, :preven, :precom, :imgpro, :ttpro)";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpro',$idpro);
		$result->bindParam(':codval',$codval);
		$result->bindParam(':nompro',$nompro);
		$result->bindParam(':descsp',$descsp);
		$result->bindParam(':preven',$preven);
		$result->bindParam(':precom',$precom);
		$result->bindParam(':imgpro',$imgpro);
		$result->bindParam(':ttpro',$ttpro);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	public function prodel($idpro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL prodel(':idpro');";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpro',$idpro);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
	//Seleccionar la categoria 
	public function selval(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, nomval FROM valor WHERE iddom= 2";
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