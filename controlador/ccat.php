<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mcat.php';
require_once 'modelo/mpagina.php';

$pg = 78;
$arc = "home.php";
$mcon = new mcat();

$idcate= isset($_POST['idcate']) ? $_POST['idcate']:NULL;
if(!$idcate)
	$idcate = isset($_GET['idcate']) ? $_GET['idcate']:NULL;
$nomcate = isset($_POST['nomcate']) ? $_POST['nomcate']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

if($opera=="InsAct"){
	if($nomcate){
		$mcat->cateiu($idcate,$nomcate);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$idcate = "";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
	}
//Eliminar
if($opera=="Elim"){
	if($idcate){
		$mcat->catedel($idcate);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
}

//Paginación
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mcon->sqlcount($filtro);

function insdatos($idcate,$pg,$arc){
	$mcat = new mcat();
	if($idcate) $dtcn = $mcat->selcat1($idcate);

$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Categoria</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idcate && $dtcn){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="number" name="idcate" class="form-control" readonly value="'.$idcate.'">';
			}
			$txt .= '<label>Nombre</label>';
			$txt .= '<input type="text" name="nomcate" class="form-control" ';
			if($idcate && $dtcn) $txt .= 'value="'.$dtcn[0]['nomcate'].'"';
			$txt .= '>';

			$txt .= '<input type="hidden" name="opera" value="InsAct">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($idcate && $dtcn) $txt .= "Actualizar"; else $txt .= "Insertar";
				$txt .= '">';
			$txt .= '</div>';
			$txt .= '<br><br><br><br>';
		$txt .= '</form>';
	$txt .= '</div>';

	echo $txt;
}

function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mcat = new mcat();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Id o Nombre" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .= '</td>';
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mcat->selcat($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div>';

	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark"></th>';
				$txt .= '<th class="table-dark">Categoria</th>';
				$txt .= '<th class="table-dark"></th>';
			$txt .= '</tr>';
			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<big><strong>';
							$txt .= $dt['idcate'].' - '.$dt['nomcate'];
						$txt .= '</strong></big><br>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idcate='.$dt['idcate'].'" onclick="return eliminar();">';
							$txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
						$txt .= '</a>';
						$txt .= '<br><br>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&idcate='.$dt['idcate'].'">';
							$txt .= '<i class="fas fa-edit fa-2x"></i>';
						$txt .= '</a>';
					$txt .= '</td>';
				$txt .= '</tr>';
			}
		$txt .= '</table>';
		$txt .= '';
	}else{
		$txt .= '<h3>No existen datos para mostrar.</h3>';
	}

	$txt .= '<br><br><br><br>';
	echo $txt;
}
?>
