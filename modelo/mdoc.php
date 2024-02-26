<?php 
//capos de la tabla detoc(detalle de orden de compra): iddo,idoco,idpro,cando
class mdoc{
//mostrar datos con filtro de busqueda
	public function seldetoc($filtro, $rvalini, $rvalfin){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT d.iddo,d.idoco,d.idpro,d.cando,o.fecoco,p.nompro,p.preven,p.precom,p.tppro,v.nomval FROM detoc AS d INNER JOIN producto AS p ON d.idpro=p.idpro INNER JOIN ordcom AS o ON d.idoco=o.idoco INNER JOIN valor AS v ON p.tppro=v.codval";
		if($filtro){
			$filtro = "%".$filtro."%";
			$sql .= " WHERE d.idoco LIKE :filtro";
		}
		$sql .= " ORDER BY iddo LIMIT $rvalini, $rvalfin";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($filtro){
			$result->bindParam(':filtro',$filtro);
		}
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}

//seleccionar un detalle de orden de compra
	public function seldetoc2($idoco){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT d.iddo,d.idoco,d.idpro,d.cando,o.fecoco,p.nompro,p.preven,p.precom,p.tppro,v.nomval FROM detoc AS d INNER JOIN producto AS p ON d.idpro=p.idpro INNER JOIN ordcom AS o ON d.idoco=o.idoco INNER JOIN valor AS v ON p.tppro=v.codval WHERE o.idoco=:idoco";
		//echo "<br><br><br><br>".$sql."<br>".$idoco."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idoco',$idoco);
		
		$result->execute();
			while($f=$result->fetch()){
				$resultado[]=$f;
			}
			return $resultado;
	}


//contar registros
	public function sqlcount($filtro){
		$sql = "SELECT count(iddo) AS Npe FROM detoc";
		if($filtro)
			$sql .= " WHERE iddo LIKE '%$filtro%'";
		//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
		return $sql;
	}

//Actualizar y/o Insertar iddo,idoco,idpro,cando
	public function dociu($iddo,$idoco,$idpro,$cando){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL dociu(:iddo,:idoco,:idpro,:cando);";
		//echo "<br><br><br><br>".$sql."<br>".$iddo."-".$idoco."-".$idpro."-".$cando."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddo',$iddo);
		$result->bindParam(':idoco',$idoco);
		$result->bindParam(':idpro',$idpro);
		$result->bindParam(':cando',$cando);
		
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

//probando si funciona lo de detalle de kardex
	public function detkariu($idkar, $idpro, $tipo, $cant, $valor, $des, $iddf, $iddo, $fecdk){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL detkariu(:idkar,:idpro,:tipo,:cant,:valor,:des,:iddf,:iddo,:fecdk);";
		//echo "<br><br><br><br>".$sql."<br>".$iddo."-".$idoco."-".$idpro."-".$cando."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}



//Eliminar un registro
	public function deldoc($iddo){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL deldoc(:iddo);";
		//echo "<br><br><br><br>".$sql."<br>".$iddo."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':iddo',$iddo);
		
		if(!$result)
			echo "<script>alert('ERROR AL REGISTRAR');</script>";
		else
			$result->execute();
	}

//mostrar ordenes de compra 
	public function selordcom($idoco){# $idoco-> pues pensando si se tendria que subir el id del orden de compra.
			$resultado = null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql ="SELECT idoco, fecoco FROM ordcom";
			$sql.=" WHERE idoco=:idoco";
				//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
			$result = $conexion->prepare($sql);
			$result->bindParam(':idoco',$idoco);
				//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->execute();
			while($f=$result->fetch()){
				$resultado[]=$f;
			}
			return $resultado;
	}

//seleccionar un producto
	public function selprod(){
				$resultado = null;
				$modelo = new conexion();
				$conexion = $modelo->get_conexion();
				$sql ="SELECT v.codval, v.iddom, v.nomval, p.idpro, p.nompro, p.tppro,p.precom FROM valor AS v INNER JOIN producto AS p ON v.codval=p.tppro";
					//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
				$result = $conexion->prepare($sql);
					//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$result->execute();
				while($f=$result->fetch()){
					$resultado[]=$f;
				}
				return $resultado;
		}


//total detorc
	//SELECT (SUM(d.cando*p.precom)/1.19) AS sub, (SUM(d.cando*p.precom)-(SUM(d.cando*p.precom)/1.19)) AS iva, SUM(d.cando*p.preven) AS tot FROM detoc AS d INNER JOIN producto AS p ON d.idpro=p.idpro WHERE d.idoco=1
	public function totdoc($idoco){
				$resultado = null;
				$modelo = new conexion();
				$conexion = $modelo->get_conexion();
				$sql ="SELECT (SUM(d.cando*p.precom)/1.19) AS sub, (SUM(d.cando*p.precom)-(SUM(d.cando*p.precom)/1.19)) AS iva, SUM(d.cando*p.precom) AS tot FROM detoc AS d INNER JOIN producto AS p ON d.idpro=p.idpro WHERE d.idoco=:idoco";
					//echo "<br><br><br><br>".$sql."<br>"."<br>";
				$result = $conexion->prepare($sql);
				$result->bindParam(':idoco',$idoco);
					//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$result->execute();
				while($f=$result->fetch()){
					$resultado[]=$f;
				}
				return $resultado;
		}



//seleccionar un kardex activo(osease igual donde el act=1)SELECT idkar, fecini, fecfin, act FROM kardex WHERE act=1
	public function selkar(){
				$resultado = null;
				$modelo = new conexion();
				$conexion = $modelo->get_conexion();
				$sql ="SELECT idkar, fecini, fecfin, act FROM kardex WHERE act=1";
					//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
				$result = $conexion->prepare($sql);
					//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$result->execute();
				while($f=$result->fetch()){
					$resultado[]=$f;
				}
				return $resultado;
		}


	public function seldetoc3($idoco,$cando,$idpro){
			$resultado=null;
			$modelo = new conexion();
			$conexion = $modelo->get_conexion();
			$sql = "SELECT iddo FROM detoc WHERE idoco=:idoco AND cando=:cando AND idpro=:idpro";
			//echo "<br><br><br><br>".$sql."<br>".$filtro."<br>";
			$result = $conexion->prepare($sql);
			//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result->bindParam(':idoco',$idoco);
			$result->bindParam(':cando',$cando);
			$result->bindParam(':idpro',$idpro);
			
			$result->execute();
				while($f=$result->fetch()){
					$resultado[]=$f;
				}
				return $resultado;
		}
}
 ?>