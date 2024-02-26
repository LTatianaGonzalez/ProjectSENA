public function selpg(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idpag, nompag, arcpag FROM pagina ORDER BY ordpag";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selpxp($idperf,$idpag){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idpag, idperf FROM pagper WHERE idperf=:idperf AND idpag=:idpag";
		//echo "<br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idperf',$idperf);
		$result->bindParam(':idpag',$idpag);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function delpxp($idperf){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "DELETE FROM pagper WHERE idperf=:idperf;";
		//echo "<br><br><br><br>".$sql."<br>".$idperf."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idperf',$idperf);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	public function inspxp($idpag, $idperf){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "INSERT INTO pagper VALUES (:idpag, :idperf);";
		//echo "<br><br><br><br>".$sql."<br>'".$idpag."','".$idperf."'<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idpag',$idpag);
		$result->bindParam(':idperf',$idperf);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}
}
?>