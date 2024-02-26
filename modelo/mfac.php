<?php 
class mfac{
	public function selfac($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT p.idfac, p.idusu, l.docusu, l.nomusu, l.apeusu, p.fecfac, p.estfac, p.formed FROM factura AS p INNER JOIN usuario AS l ON p.idusu=l.idusu";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql.=" WHERE p.idfac=:filtro OR p.fecfac LIKE :filtro2";
		}
		$sql.= " ORDER BY p.fecfac LIMIT $rvalini, $rvalfin;";

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
	public function selfac1($idfac){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT p.idfac, p.idusu, l.docusu, l.nomusu, l.apeusu, p.fecfac, p.estfac, p.formed FROM factura AS p INNER JOIN usuario AS l ON p.idusu=l.idusu WHERE p.idfac=:idfac";

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function selfac2($idusu, $fecfac, $estfac, $formed){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT idfac FROM factura WHERE idusu=:idusu AND fecfac=:fecfac AND estfac=:estfac AND formed=:formed";

		$result = $conexion->prepare($sql);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':fecfac',$fecfac);
		$result->bindParam(':estfac',$estfac);
		$result->bindParam(':formed',$formed);

		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function sqlcount($filtro){
		$sql = "SELECT COUNT(p.idfac) AS Npe FROM factura AS p INNER JOIN usuario AS l ON p.idusu=l.idusu";
		if($filtro){
			$sql.=" WHERE p.idfac='$filtro' OR p.fecfac LIKE '%$filtro%';";
		}
		return $sql;
	}
	//Insertar o actualizar
	public function faciu($idfac, $idusu, $fecfac, $estfac, $formed){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL faciu(:idfac, :idusu, :fecfac, :estfac, :formed);";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':fecfac',$fecfac);
		$result->bindParam(':estfac',$estfac);
		$result->bindParam(':formed',$formed);

		if(!$result)
			echo "<script>alert('Error al registrar');</script>";
		else
			$result->execute();
	}
	public function facdel($idfac){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL facdel(:idfac)";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
		if(!$result)
			echo"<script>alert('Error al eliminar');</script>";
		else
			$result->execute();
	}
	public function selusu(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT idusu, nomusu FROM usuario";

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function karact(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT idkar FROM kardex WHERE act=1";

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