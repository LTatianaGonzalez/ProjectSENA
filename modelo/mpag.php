<?php 
class mpag{
	public function selpag($filtro, $rvalini, $rvalfin){
		$result = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT p.pagid, p.pagnom, p.pagarc, p.pagmos, p.pagord, p.pagmen, 
		p.icono FROM pagina AS p";
		if($filtro){
			$filtro2 = "%" .$filtro. "%";
			$sql .= " WHERE p.pagid=:filtro OR p.pagnom=:filtro LIKE :filtro2";
		}
		$sql .= " ORDER BY p.pagid LIMIT  $rvalini, $rvalfin;";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";

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
	public function selpag1($pagid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT p.pagid, p.pagnom, p.pagarc, p.pagmos, p.pagord, p.pagmen, p.icono 
		FROM pagina AS p WHERE p.pagid=:pagid ";

		$result = $conexion->prepare($sql);
		$result->bindParam(':pagid',$pagid);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

	public function sqlcount($filtro){
		$sql = "SELECT COUNT(p.pagid) AS Npe FROM pagina AS p";
		if($filtro){
			$sql =" WHERE p.pagid='$filtro' OR p.pagnom LIKE '%$filtro%';";
		}
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";
		return$sql;
	}

	public function pagiu($pagid,$pagnom, $pagarc, $pagmos, $pagord, $pagmen, $icono){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL pagiu(:pagid,:pagnom, :pagarc, :pagmos, :pagord, :pagmen, :icono);";
		//echo "<br><br><br><br><br>".$sql."<br>".$pagid."-".$pagnom."-".$pagarc."-".$pagmos."-".$pagord."-".$pagmen."-".$icono."<br>";

		$result = $conexion->prepare($sql);
		$result->bindParam(':pagid',$pagid);
		$result->bindParam(':pagnom',$pagnom);
		$result->bindParam(':pagarc',$pagarc);
		$result->bindParam(':pagmos',$pagmos);
		$result->bindParam(':pagord',$pagord);
		$result->bindParam(':pagmen',$pagmen);
		$result->bindParam(':icono',$icono);
		
		//echo $conexion->serAtrribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

	public function pagdel($pagid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL pagdel(:pagid);";
		//echo "<br><br><br><br><br>".$sql."<br>".$filtro."<br>";

		$result = $conexion->prepare($sql);
		//echo $conexion->serAtrribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':pagid',$pagid);
		if(!$result)
			echo "<script>alert('ERROR AL ELIMINAR');</script>";
		else
			$result->execute();
	}

	public function selpper(){
		$result = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pagid FROM pagper";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}
?>