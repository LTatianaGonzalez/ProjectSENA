<?php
	class mdka{
		//Método de Insertar detalle de kardex
		public function insdka($iddk, $idkar, $idpro, $tipo, $cant, $valor, $des,$iddf, $iddo, $fecdk){
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "CALL dkaiu (:iddk, :idkar, :idpro, :tipo, :cant, :valor, :des, :iddf, :iddo, :fecdk);";
			//echo "<br><br><br><br>".$sql."<br>'".$idpro."','".$iddf."','".$iddo."','".$tipo."','".$cant."','".$valor."','".$des."','".$fecdk."';
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->bindParam(':iddk',$iddk);
			$result->bindParam(':idkar',$idkar);
			$result->bindParam(':idpro',$idpro);
			$result->bindParam(':tipo',$tipo);
			$result->bindParam(':cant',$cant);
			$result->bindParam(':valor',$valor);
			$result->bindParam(':des',$des);
			$result->bindParam(':iddf',$iddf);
			$result->bindParam(':iddo',$iddo);
			$result->bindParam(':fecdk',$fecdk);
			if(!$result)
				echo "<script>alert('ERROR AL REGISTRAR')</script>";
			else
				$result->execute();
		}
		//Método de eliminar detalle de kardex
		public function dkadel($iddk){
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "CALL dkadel (:iddk);";
			//echo "<br><br><br><br>".$sql."<br>'".$iddk."'";
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->bindParam(':iddk',$iddk);

			if(!$result)
				echo "<script>alert('ERROR AL REGISTRAR')</script>";
			else
				$result->execute();
		}
		//Método de mostrar usuarios
		public function seldk($idkar,$filtro,$rvalini,$rvalfin){
			$resultado=null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "SELECT d.iddk, d.idkar, d.idpro, d.tipo, d.cant, d.valor, d.des, d.iddf, d.iddo, d.fecdk, p.nompro, p.preven, p.precom FROM detkar AS d INNER JOIN producto AS p ON d.idpro=p.idpro WHERE d.idkar=:idkar";
			if($filtro){
				$filtro = "%".$filtro."%";
				$sql .= " AND d.iddk LIKE :filtro";
			}
			$sql .= " ORDER BY d.idkar LIMIT $rvalini, $rvalfin";
			//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
			$result = $conexion->prepare($sql);
			$result->bindParam(':idkar', $idkar);
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
		//Método contar los registros de detalles de kardex
		public function sqlcount($idkar,$filtro){
			$sql = "SELECT count(d.iddk) AS Npe FROM detkar AS d INNER JOIN producto AS p ON d.idpro=p.idpro WHERE d.idkar='$idkar'";
			if($filtro)
				$sql .= " AND d.iddk LIKE :filtro";
			return $sql;
		}
		//Método de mostrar un detalle de kardex
		public function seldka1($iddk){
			$resultado=null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "SELECT d.iddk, d.idkar, d.idpro, d.tipo, d.cant, d.valor, d.des, d.iddf, d.iddo, d.fecdk FROM detkar AS d INNER JOIN kardex as k ON d.idkar=k.idkar INNER JOIN producto AS p ON d.idpro=p.idpro INNER JOIN detfac AS t ON d.iddf=t.iddf INNER JOIN detoc AS e ON d.iddo=e.iddo WHERE d.iddk=:iddk";
			//echo "<br><br><br><br>".$sql."<br>";
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->bindParam(':iddk',$iddk);
			$result->execute();

			while($f=$result->fetch()){
				$resultado[]=$f;
			}
			return $resultado;
		}
		//Metodo para seleccionar detalle de factura
		public function seldfa(){
			$resultado=null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "SELECT iddf, idfac FROM detfac";
			//echo "<br><br><br><br>".$sql."<br>";
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->execute();

			while($f=$result->fetch()){
				$resultado[]=$f;
			}
			return $resultado;
		}
		//Metodo para seleccionar detalle de orden de compra
		public function seldoc(){
			$resultado=null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "SELECT iddo, idoco, cando FROM detoc";
			//echo "<br><br><br><br>".$sql."<br>";
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->execute();

			while($f=$result->fetch()){
				$resultado[]=$f;
			}
			return $resultado;
		}
		//Metodo para seleccionar kardex
		public function selkar($idkar){
			$resultado=null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "SELECT idkar, fecini, fecfin FROM kardex";
			$sql .= " WHERE idkar=:idkar";
			//echo "<br><br><br><br>".$sql."<br>";
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->bindParam(':idkar',$idkar);
			$result->execute();

			while($f=$result->fetch()){
				$resultado[]=$f;
			}
			return $resultado;
		}
		//Metodo para seleccionar producto
	public function selpro(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idpro, nompro,codval,tppro,preven,precom FROM producto ORDER BY nompro";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	//
	//Metodo para seleccionar deun producto y un kardex indicado la cantidad dependiendo del tipo
	public function selcpkt($idkar,$idpro,$tipo,$tip2){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT sum(cant) AS can FROM detkar WHERE idkar=:idkar AND idpro=:idpro AND (tipo=:tipo OR tipo=:tip2)";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idkar', $idkar);
		$result->bindParam(':idpro', $idpro);
		$result->bindParam(':tipo', $tipo);
		$result->bindParam(':tip2', $tip2);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>