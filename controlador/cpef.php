<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mpef.php';
require_once 'modelo/mpagina.php';

$pg = 203;
$arc = "home.php";
$mpef = new mpef();

$pefid = isset($_POST['pefid']) ? $_POST['pefid']:NULL;
if(!$pefid)
	$pefid = isset($_GET['pefid']) ? $_GET['pefid']:NULL;
$pefnom = isset($_POST['pefnom']) ? $_POST['pefnom']:NULL;
$pagprin = isset($_POST['pagprin']) ? $_POST['pagprin']:NULL;
$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

$pagi[] = isset($_POST['pagi']) ? $_POST['pagi']:NULL;

//echo "<br><br><br>".$pefid."-".$pefnom."-".$pagprin."-".$filtro."-".$opera."<br><br>";
//Insertar
if($opera=="Insertar"){
	if($pefnom){
		$mpef->inspef($pefnom, $pagprin);
		echo "<script>alert('Datos insertados exitosamente');</script>";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Insertar PxP
if($opera=="Inspxp"){
	if($pefid){
		$mpef->delpxp($pefid);
		if($pagi){
			for ($i=0;$i<count($pagi[0]);$i++) {			
				$mpef->inspxp($pagi[0][$i], $pefid);
			}
		}
	}
}

//Actualizar
if($opera=="Actualizar"){
	if($pefid AND $pefnom){
		$mpef->updpef($pefid, $pefnom, $pagprin);
		echo "<script>alert('Datos actualizados exitosamente');</script>";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="Eliminar"){
	if($pefid){
		$mpef->delpef($pefid);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
}

//Paginacion parte 1
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mpef->sqlcount($filtro);

//Insertar datos
function insdatos($pefid,$pg,$arc){
	$mpef = new mpef();
	$dtpef = NULL;
	if($pefid) $dtpef = $mpef->selpef1($pefid);
	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Perfil</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($pefid AND $dtpef){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="text" name="pefid" readonly value="'.$pefid.'" class="form-control" />';
			}
			$txt .= '<label>Perfil</label>';
			$txt .= '<input type="text" name="pefnom" maxlength="50" class="form-control"';
				if($pefid AND $dtpef) $txt .= ' value="'.$dtpef[0]['pefnom'].'"';
			$txt .= ' required />';
			$txt .= '<label>Pagprin? </label>';
			$txt .= '<input type="text" name="pagprin" class="form-control"';
				if($pefid AND $dtpef) $txt .= ' value="'.$dtpef[0]['pagprin'].'"';
			$txt .= ' />';

			$txt .= '<input type="hidden" name="opera" value="';
			if($pefid AND $dtpef)
				$txt .= 'Actualizar';
			else
				$txt .= 'Insertar';
			$txt .= '">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" value="';
			if($pefid AND $dtpef)
				$txt .= 'Actualizar';
			else
				$txt .= 'Registrar';
			$txt .= '">';
			$txt .= '</div>';

		$txt .= '</form>';
	$txt .= '</div>';

	echo $txt;
}

//Mostrar datos
function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mpef = new mpef();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			//Filtro de busqueda
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Perfil" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .= '</td>';
			//Paginacion parte 2
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mpef->selpef($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div>';

	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark">Perfil</th>';
				$txt .= '<th class="table-dark">Páginas</th>';
				$txt .= '<th class="table-dark"></th>';
			$txt .= '</tr>';
			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
						$txt .= '<big><strong>';
							$txt .= $dt['pefid'].'. '.$dt['pefnom'];
						$txt .= '</strong></big><br>';
						$txt .= '<small>';
							$txt .= '<strong>Pagprin?: </strong>'.$dt['pagprin'];
						$txt .= '</small>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<button data-bs-toggle="modal" data-bs-target="#myModal'.$dt['pefid'].'" title="Mostrar Páginas">';
							$txt .= '<i class="fas fa-eye fa-2x ic2"></i>';
						$txt .= '</button>';
						$txt .= modal($dt['pefid'], $dt['pefnom'], $pg);
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Eliminar&pefid='.$dt['pefid'].'" onclick="return eliminar();">';
						$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
						$txt .= '</a>';
						$txt .= '<br><br>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&pefid='.$dt['pefid'].'">';
							$txt .= '<i class="fas fa-edit fa-2x ic2"></i>';
						$txt .= '</a>';
					$txt .= '</td>';
				$txt .= '</tr>';
			}
		$txt .= '</table>';
	}else{
		$txt .= '<h3>No existen datos para mostrar</h3>';
	}
	
	$txt .= '<br><br><br><br><br>';
	echo $txt;
}

function modal($pefid, $pefnom, $pg){
	$txt = '';
	$mpef = new mpef();
	$dtpg = $mpef->selpg();

	$txt .= '<div class="modal" id="myModal'.$pefid.'" tabindex="-1" role="dialog">';
		$txt .= '<div class="modal-dialog">';
			$txt .= '<div class="modal-content">';
				$txt .= '<div class="modal-header">';
					$txt .= '<h3 class="modal-title">Páginas</h3>';
					$txt .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
				$txt .= '</div>';
				$txt .= '<form name="frmpxp" action="home.php?pg='.$pg.'" method="POST">';
					$txt .= '<div class="modal-body">';
						$txt .= '<h5>Perfil: '.$pefnom.'</h5>';
						if($dtpg){
							foreach ($dtpg as $dpg) {
								$dtpxp = $mpef->selpxp($pefid,$dpg['pagid']);
								$txt .= '<div class="dpag';
								if($dpg['pagarc']=="#Espacio") $txt .= " dti";
								$txt .= '">';
									$txt .= '<input type="checkbox" name="pagi[]" value="'.$dpg['pagid'].'" ';
									if($dtpxp) $txt .= ' checked ';
									$txt .= '>';
									$txt .= "&nbsp;&nbsp;&nbsp;".$dpg['pagnom'];
								$txt .= '</div>';
							}
						}
						$txt .= '<input type="hidden" name="opera" value="Inspxp">';
						$txt .= '<input type="hidden" name="pefid" value="'.$pefid.'">';
					$txt .= '</div>';

					$txt .= '<div class="modal-footer">';
						$txt .= '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>';
	        			$txt .= '<input type="submit" class="btn btn-primary" value="Guardar">';
					$txt .= '</div>';
				$txt .= '</form>';
			$txt .= '</div>';
		$txt .= '</div>';
	$txt .= '</div>';

	return $txt;
}
?>