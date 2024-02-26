<?php
class mpro{
//metodo para insertar datos
	public function selpro($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT p.idpro, p.codval, p.nompro, p.descsp, p.preven, p.precom, p.imgpro, p.tppro FROM producto AS p";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql.=" WHERE p.idpro=:filtro OR p.nompro LIKE :filtro2";
		}
		$sql.= " ORDER BY p.nompro LIMIT $rvalini, $rvalfin;";

		$result = $conexion->prepare($sql);

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
		$sql ="SELECT p.idpro, p.codval, p.nompro, p.descsp, p.preven, p.precom, p.tppro FROM producto AS p WHERE p.idpro=:idpro ";

		$result = $conexion->prepare($sql);
		$result->bindParam(':idpro',$idpro);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
}

public function sqlcount($filtro){
		$sql = "SELECT COUNT(idpro) AS Npe FROM producto";
		if($filtro){
			$sql.=" WHERE  idpro='$filtro' OR nompro LIKE '%$filtro%';";
		}
		return $sql;
}

public function proiu($idpro, $codval, $nompro, $descsp, $preven, $precom, $imgpro, $tppro){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL proiu(:idpro :codval, :nompro, :descsp, :preven, :precom, :imgpro, :tppro);";
		
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpro',$idpro);
		$result->bindParam(':codval',$codval);
		$result->bindParam(':nompro',$nompro);
		$result->bindParam(':descsp',$descsp);
		$result->bindParam(':preven',$preven);
		$result->bindParam(':precom',$precom);
		$result->bindParam(':imgpro',$imgpro);
		$result->bindParam(':tppro',$tppro);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
		$result->execute();
}

public function prodel($idpro){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL prodel(:idpro);";
		//echo $idlab;
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpro',$idpro);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
}
}