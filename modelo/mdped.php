<?php
class mdped{
	public function selres($iddet, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		//$sql = "SELECT r.iddet, r.iddet, r.codpro, r.cantpro FROM respuesta AS r LEFT JOIN pregunta AS p ON r.iddet=p.iddet";
			//$sql .= " WHERE r.iddet=:iddet";
		//$sql .= " ORDER BY r.iddet LIMIT $rvalini, $rvalfin;";

		//echo "<br><br><br><br><br>".$sql."<br>".$iddet."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddet',$iddet);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selres1($iddet){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		//$sql = "SELECT iddet, iddet, codpro, cantpro FROM respuesta WHERE iddet=:iddet";
		
		//echo "<br><br><br><br><br>".$sql."<br>".$iddet."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddet',$iddet);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//MOSTRAR PEDIDO
	public function selped($iddet){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		//$sql = "SELECT iddet, idvis, despre, tippre, idprd FROM pedido WHERE iddet=:iddet";
		//echo "<br><br><br><br><br>".$sql."<br>".$iddet."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddet',$iddet);
		$result->execute();
		while ($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//CONTAR DATOS
	public function sqlcount($filtro){
		//$sql = "SELECT COUNT(r.iddet) AS Npe FROM respuesta AS r INNER JOIN pregunta AS p ON r.iddet=p.iddet";
		//if($filtro){
		//	$sql .= " WHERE r.iddet='$iddet';";
		//}
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}
	//ACTUALIZAR O INSERTAR
	public function dpediu($iddet, $idped, $codpro, $cantpro, $idcate){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		//$sql = "CALL resiu(:iddet, :iddet, :codpro, :cantpro)";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':iddet',$iddet);
		$result->bindParam(':idped',$idped);
		$result->bindParam(':codpro',$codpro);
		$result->bindParam(':cantpro',$cantpro);
		$result->bindParam(':cantpro',$cantpro);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
	//ELIMINAR
	public function dpeddel($iddet){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL resdel(:iddet);";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddet',$iddet);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
}
?>