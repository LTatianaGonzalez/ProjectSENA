<?php
class mdfa{

//Método de Insertar/Actualizar un detalle de factura
	public function iudet($iddf, $idfac, $idpro, $candf){
		//$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL iudet(:iddf, :idfac, :idpro, :candf);";
		echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddf',$iddf);
		$result->bindParam(':idfac',$idfac);
		$result->bindParam(':idpro',$idpro);
		$result->bindParam(':candf',$candf);	

		$result->execute();
	}

//Método de mostrar detalles de factura
	public function seldetalle($idfac){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT d.iddf, d.idfac,d.idpro, d.candf,f.idusu, f.fecfac, f.estfac , p.codval, p.nompro,p.descsp, p.preven, p.precom, p.tppro, u.nomusu, u.apeusu, u.docusu, v.nomval FROM detfac AS d INNER JOIN factura AS f ON d.idfac=f.idfac INNER JOIN producto AS p ON d.idpro=p.idpro INNER JOIN usuario AS u On f.idusu=u.idusu INNER JOIN valor AS v ON p.codval=v.codval WHERE d.idfac=:idfac";
		
		//echo "<br><br><br><br>".$sql."<br><br>".$_SESSION["idpro"]."<br>".$filtro;

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
	public function selid($idfac,$idpro,$candf){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT iddf FROM detfac WHERE idfac=:idfac AND idpro=:idpro AND candf=:candf"; 

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$result->bindParam(':idfac',$idfac);
		$result->bindParam(':idpro',$idpro);
		$result->bindParam(':candf',$candf);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Método contar los registros de detalles de la factura
	public function sqlcount($filtro){
		$sql = "SELECT COUNT(d.iddf) AS Npe FROM detfac AS d INNER JOIN factura AS f ON d.idfac=f.idfac INNER JOIN usuario as u ON f.idusu=u.idusu";
		if($filtro){
			$sql.=" WHERE d.iddf='$filtro' OR u.docusu LIKE '%$filtro%' OR f.fecfac LIKE '%$filtro%';";
		}
		return $sql;
	}

//Método de mostrar un detalle de factura
	public function selent1($iddf){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT d.iddf, d.idfac,d.idpro, d.candf,f.idusu, f.fecfac, f.estfac , p.codval, p.nompro,p.descsp, p.preven, p.precom, p.tppro, u.nomusu, u.apeusu, u.docusu, v.nomval FROM detfac AS d LEFT JOIN factura AS f ON d.idfac=f.idfac LEFT JOIN producto AS p ON d.idpro=p.idpro LEFT JOIN usuario AS u On f.idusu=u.idusu LEFT JOIN valor AS v ON p.codval=v.codval WHERE d.iddf=:iddf ";

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddf',$iddf);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//Método de mostrar un detalle de factura por nro de documento
	/*public function selustu($idpro){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT count(:idpro) as can FROM entxsal WHERE idpro=:idpro ";

		$result = $conexion->prepare($sql);
		echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddf',$iddf);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}*/


//Método de eliminar detalles de factura
	public function deldet($iddf){
		//$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL deldet(:iddf);";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddf',$iddf);
		if(!$result)
			echo"<script>alert('Error al eliminar');</script>";
		else
			$result->execute();
	}



//Metodo muestre los productos
	public function selpro(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idpro, nompro,codval,tppro FROM producto ORDER BY nompro";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
//Metodo muestre los Usuarios
	public function selusu(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idusu, docusu, nomusu, apeusu FROM usuario ORDER BY nomusu";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
//Metodo muestre los Usuarios por documento
	public function selusu1(){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT idpro, docusu, nomusu, apeusu FROM usuario WHERE idpro=:idpro OR docusu=:idpro";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
		$sql ="SELECT p.idfac, p.idusu,l.docusu, l.nomusu, l.apeusu, l.dirusu, l.emausu, l.telusu, p.fecfac, p.estfac FROM factura AS p LEFT JOIN usuario AS l ON p.idusu=l.idusu WHERE p.idfac=:idfac";

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}


public function totfac($idfac){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT (SUM(d.candf*p.preven)/1.19) AS sub, (SUM(d.candf*p.preven)-(SUM(d.candf*p.preven)/1.19)) AS iva, SUM(d.candf*p.preven) AS tot FROM detfac AS d INNER JOIN producto AS p ON d.idpro=p.idpro WHERE d.idfac=:idfac";

		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
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
		//$result->bindParam(':idfac',$idfac);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

}
?>