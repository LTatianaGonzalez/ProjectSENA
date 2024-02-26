<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mpro.php';
require_once 'modelo/mpagina.php';

$pg=305;
$arc = "home.php";
$mpro = new mpro();
$idpro = isset($_POST['idpro']) ? $_POST['idpro']:NULL;
if(!$idpro)
	$idpro = isset($_GET['idpro']) ? $_GET['idpro']:NULL;
$codval = isset($_POST['codval']) ? $_POST['codval']:NULL;
$nompro = isset($_POST['nompro']) ? $_POST['nompro']:NULL;
$descsp = isset($_POST['descsp']) ? $_POST['descsp']:NULL;
$preven = isset($_POST['preven']) ? $_POST['preven']:NULL;
$precom = isset($_POST['precom']) ? $_POST['precom']:NULL;
$imgpro = isset($_POST['imgpro']) ? $_POST['imgpro']:NULL;
$tppro = isset($_POST['tppro']) ? $_POST['vlrprd']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro= isset($_GET['filtro']) ? $_GET['filtro']:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
//Insertar o actualizar
if($opera=="InsAct"){
	if($nompro && $descsp && $preven && $precom && $imgpro && $tppro){
		$mpro->proiu($nompro, $descsp, $preven, $precom, $imgpro, $tppro);
		echo "<script>alert('Datos insertados y/o actualizados correctamente');</script>";
		$idpro = NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
//Eliminar
if($opera=="Elim"){
	if($idpro){
		$mpro->prodel($idpro);
		echo "<script>alert('Datos eliminados correctamente');</script>";
	}
}

//Paginacion
$bo ="";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mpro->sqlcount($filtro);

 function insdatos($idpro,$pg,$arc){
	$mpro = new mpro();
	if($idpro) $dtpro = $mpro->selpro1($idpro);
	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Producto</h2>';
		$txt .= '<form name="frm1" class="form-control" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idpro && $dtpro){
				$txt.= '<label>Id</label>';
				$txt .= '<input type="number" name="idprd" class="form-control" readonly value="'.$idpro.'">';
			}
			$txt.= '<label>Nombre del Producto</label>';
			$txt.= '<input type="text" name="nompro" class="form-control"';
				if($idpro && $dtprdo) $txt .= 'value="'.$dtpro[0]['nompro'].'"';
			$txt .= ' />';

			$txt.= '<label>Descripcion del producto</label>';
			$txt.= '<textarea name="descsp" class="form-control">';
				if($idpro && $dtpro) $txt .= $dtpro[0]['descsp'];
			$txt .='</textarea>';

			$txt.= '<label>Precio de venta: </label>';
			$txt.= '<textarea name="preven" class="form-control">';
				if($idpro && $dtpro) $txt .= $dtpro[0]['preven'];
			$txt .= '</textarea>';

			$txt.= '<label>Precio de compra</label>';
			$txt.= '<textarea name="precom" class="form-control">';
				if($idpro && $dtpro) $txt .= $dtpro[0]['precom'];
			$txt .= '</textarea>';

			$txt .= '<label>Imagen del producto</label>';
			$txt .= '<input type="file" name="arch" class="form-control" accept="image/jpeg, image/png">';
			if($idpro && $dtpro)
				$txt .= '<input type="hidden" name="imgpro" value="'.$dtpro[0]['imgpro'].'">';
			if($idpro && $dtpro && $dtpro[0]['imgpro'])
				$txt .= '<img src="'.$dtpro[0]['imgpro'].'" class="imgproedit">';
				$txt .= '<input type="hidden" name="opera" value="InsAct">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-primary" value="';
					if($idpro && $dtpro) $txt .= "Actualizar"; else $txt .="Insertar";
					$txt .= '">';
				$txt .= '</div>';
				$txt.='<br><br><br>';
		$txt .= '</form>';
	$txt .= '</div>';

	echo $txt;

}
function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mpro = new mpro();
	$pa = new mpagina($nreg);
	$txt = '';
	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Id o Nombre" onChange="this.form.submit();">';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'">';
				$txt .= '</form>';
			$txt .= '</td>';
			$txt .= '<td>';
				$bo .= '<input type="hidden" name="filtro" value="'.$filtro.'">';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mpro->selpro($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';

		$txt .= '</tr></table>';
	$txt .= '</div>';
	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark">Productos</th>';
				$txt .= '<th class="table-dark"></th>';
			$txt .= '</tr>';
			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
						$txt.= '<big><strong>';
							$txt.=$dt['idpro'].' - '.$dt['nompro'];
						$txt.= '</strong></big><br>';
						$txt.= '<small>';
						    $txt.='<strong>Nombre del producto: </strong>'.$dt['nompro'].'<br>';
							$txt.='<strong>Descripcion: </strong>'.$dt['descsp'].'<br>';
							$txt.=' <strong>Preven: </strong>'.$dt['preven'].'<br>';
							$txt.=' <strong>Precom: </strong>'.$dt['precom'].'<br>';
							$txt.=' <strong>imagen del poducto: </strong>'.$dt['imgpro'].'<br>';
						$txt.= '</small>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt.= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idprd='.$dt['idpro'].'" onclick="return eliminar();">';
							$txt.= '<i class="fas fa-trash-alt fa-2x"></i>';
						$txt.= '</a>';
						$txt.= '<br><br>';
						$txt.= '<a href="'.$arc.'?pg='.$pg.'&idprd='.$dt['idpro'].'">';
							$txt.= '<i class="fas fa-edit fa-2x"></i>';
						$txt.= '</a>';

					$txt .= '</td>';
				$txt .= '</tr>';
			}
		$txt .= '</table>';
		$txt .= '';
	}else{
		$txt .= '<h3>No existen datos para mostrar</h3>';
	}
	$txt .= '<br><br><br><br><br>';
	echo $txt;
	

}
/*?>
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
	}*/