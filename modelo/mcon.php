<?php
class mcon{
	public function selcon($filtro, $rvalini, $rvalfin){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.idconf, c.nit, c.nomemp, c.dircon, c.mosdir, c.telcon, c.mostel, c.celcon, c.moscel, c.emacon, c.mosema, c.logocon, c.consen, c.codubi, u.nomubi AS Mun, d.nomubi AS Dep FROM configuracion AS c LEFT JOIN ubicacion AS u ON c.codubi=u.codubi LEFT JOIN ubicacion AS d ON u.depubi=d.codubi";
		if($filtro){
			$filtro2 = "%".$filtro."%";
			$sql .= " WHERE c.idconf=:filtro OR c.nit=:filtro OR c.nomemp LIKE :filtro2";
		}
		$sql .= " ORDER BY c.nomemp LIMIT $rvalini, $rvalfin;";
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
	public function selcon1($idconf){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.idconf, c.nit, c.nomemp, c.dircon, c.mosdir, c.telcon, c.mostel, c.celcon, c.moscel, c.emacon, c.mosema, c.logocon, c.consen, c.codubi, u.nomubi AS Mun, d.nomubi AS Dep FROM configuracion AS c LEFT JOIN ubicacion AS u ON c.codubi=u.codubi LEFT JOIN ubicacion AS d ON u.depubi=d.codubi WHERE c.idconf=:idconf";
		//echo "<br><br><br><br><br>".$sql."<br>".$idconf."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idconf',$idconf);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql = "SELECT COUNT(c.idconf) AS Npe FROM configuracion AS c INNER JOIN ubicacion AS u ON c.codubi=u.codubi INNER JOIN ubicacion AS d ON u.depubi=d.codubi";
		if($filtro){
			$sql .=" WHERE c.idconf='$filtro' OR c.nit='$filtro' OR c.nomemp LIKE '%$filtro%';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}

	public function cofiu($idconf,$nit, $nomemp, $dircon, $mosdir, $telcon, $mostel, $celcon, $moscel, $emacon, $mosema, $logocon, $consen, $codubi){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL cofiu(:idconf,:nit, :nomemp, :dircon, :mosdir, :telcon, :mostel, :celcon, :moscel, :emacon, :mosema, :logocon, :consen, :codubi)";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->bindParam(':idconf',$idconf);
		$result->bindParam(':nit',$nit);
		$result->bindParam(':nomemp',$nomemp);
		$result->bindParam(':dircon',$dircon);
		$result->bindParam(':mosdir',$mosdir);
		$result->bindParam(':telcon',$telcon);
		$result->bindParam(':mostel',$mostel);
		$result->bindParam(':celcon',$celcon);
		$result->bindParam(':moscel',$moscel);
		$result->bindParam(':emacon',$emacon);
		$result->bindParam(':mosema',$mosema);
		$result->bindParam(':logocon',$logocon);
		$result->bindParam(':consen',$consen);
		$result->bindParam(':codubi',$codubi);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	public function cofdel($idconf){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL cofdel(:idconf);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idconf',$idconf);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}
	
	public function selubi(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codubi, nomubi FROM ubicacion WHERE depubi=0 ORDER BY nomubi;";
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