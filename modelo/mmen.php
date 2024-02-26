<?php
class mmen{
	public function selmen($pagmen, $pefid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT g.pagid, g.pagnom, g.pagarc, g.pagmos, g.pagord, g.pagmen, e.pefid, g.icono FROM pagina AS g INNER JOIN pagper AS e ON g.pagid=e.pagid WHERE g.pagmen='$pagmen' AND e.pefid='$pefid' AND g.pagmos=1 ORDER BY g.pagord";
		$result = $conexion->prepare($sql);

		$result->execute();

		while($f=$result->fetch()){
			$resultado[] = $f;
		}
		return $resultado;
	}

	public function selpgact($pagid, $pefid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT a.pagid, a.pagnom, a.pagarc, a.pagmos, a.pagord, a.pagmen, a.icono FROM pagina AS a INNER JOIN pagper AS e ON a.pagid=e.pagid WHERE a.pagid=:pagid AND e.pefid=:pefid";
		$result = $conexion->prepare($sql);
		$result->bindParam(":pagid",$pagid);
		$result->bindParam(":pefid",$pefid);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[] = $f;
		}
		return $resultado;
	}

	public function selpgpf($pefid){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT pefid, pefnom, pagprin FROM perfil WHERE pefid=:pefid";
		$result = $conexion->prepare($sql);
		$result->bindParam(":pefid",$pefid);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[] = $f;
		}
		return $resultado;
	}

}
?>