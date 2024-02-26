<?php
class musu{

//Insertar usuario
	public function insusu($idusu, $tdocusu, $docusu, $nomusu, $apeusu, $dirusu, $codubi, $telusu, $emausu, $pefid, $epsnit, $pasusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL usuiu(:idusu, :tdocusu, :docusu, :nomusu, :apeusu, :dirusu, :codubi, :telusu,  :emausu, :pefid, :epsnit, :pasusu);";
		//echo "<br><br><br><br>".$sql."<br>'".$nomusu."','".$apeusu."','".$dirusu."','".$codubi."','".$telusu."','".$emausu."','".$pefid."','".$epsnit."','".$pasusu."'";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);
		$result->bindParam(':tdocusu',$tdocusu);
		$result->bindParam(':docusu',$docusu);
		$result->bindParam(':nomusu',$nomusu);
		$result->bindParam(':apeusu',$apeusu);
		$result->bindParam(':dirusu',$dirusu);
		$result->bindParam(':codubi',$codubi);
		$result->bindParam(':telusu',$telusu);
		$result->bindParam(':emausu',$emausu);
		$result->bindParam(':pefid',$pefid);
		$result->bindParam(':epsnit',$epsnit);
		if($pasusu){
			$pas = sha1(md5($pasusu));
			$result->bindParam(':pasusu',$pas);	
		}else{
			$result->bindParam(':pasusu',$pasusu);	
		}

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}
//Método de eliminar usuarios
	public function usudel($idusu){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL usudel (:idusu);";
		//echo "<br><br><br><br>".$sql."<br>'".$idusu."'";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);

		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR')</script>";
		else
			$result->execute();
	}

//Método de mostrar usuarios
	public function selusu($filtro,$rvalini,$rvalfin){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.tdocusu, u.docusu, u.nomusu, u.apeusu, u.dirusu, u.codubi, b.nomubi, u.telusu, u.emausu, u.pefid, p.pefnom, u.epsnit, e.nomeps FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN eps AS e ON u.epsnit=e.epsnit";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE u.nomusu LIKE :filtro OR u.apeusu LIKE :filtro";
		}
		$sql .= " ORDER BY u.nomusu, u.apeusu LIMIT $rvalini, $rvalfin";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
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

	//Método de mostrar usuarios
	public function selusers(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.tdocusu, u.docusu, u.nomusu, u.apeusu, u.dirusu, u.codubi, b.nomubi, u.telusu, u.emausu, u.pefid, p.pefnom, u.epsnit, e.nomeps FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN eps AS e ON u.epsnit=e.epsnit";
		$sql .= " ORDER BY u.nomusu, u.apeusu";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Método contar los registros de usuarios
	public function sqlcount($filtro){
		$sql = "SELECT count(u.idusu) AS Npe FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN eps AS e ON u.epsnit=e.epsnit";
		if($filtro)
			$sql .= " WHERE u.nomusu LIKE '%$filtro%' OR u.apeusu LIKE '%$filtro%'";
		return $sql;
	}

//Método de mostrar un usuario
	public function selusu1($idusu){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT u.idusu, u.tdocusu, u.docusu, u.nomusu, u.apeusu, u.dirusu, u.codubi, b.nomubi, u.telusu, u.emausu, u.pefid, p.pefnom, u.epsnit, e.nomeps FROM usuario AS u INNER JOIN ubicacion AS b ON u.codubi=b.codubi INNER JOIN perfil as p ON u.pefid=p.pefid LEFT JOIN eps AS e ON u.epsnit=e.epsnit WHERE u.idusu=:idusu";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idusu',$idusu);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Metodo de mostrar la ubicacion
	public function selubi(){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT c.codubi, c.nomubi AS ciu, d.nomubi AS dep FROM ubicacion AS c INNER JOIN ubicacion AS d ON c.depubi=d.codubi ORDER BY nomubi;";
		//echo "<br><br><br><br><br>".$sql."<br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function seldep(){
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

//Metodo de mostrar los Perfiles
	public function selpef(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pefid, pefnom FROM perfil";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

// Metodo de mostrar la EPS
	public function seleps(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT epsnit, nomeps FROM eps";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
// Metodo de mostrar Tipo de documento
	public function seldoc(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT codval, iddom, nomval FROM valor";
		//echo "<br><br><br><br>".$sql."<br>";
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