<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mkar.php';
require_once 'modelo/mpagina.php';


$pg = 5008;
$arc = "home.php";
$mkar = new mkar();

$idkar = isset($_POST['idkar']) ? $_POST['idkar']:NULL;
if($idkar)
	$idkar = isset($_GET['idkar']) ? $_GET['idkar']:NULL;
$fecini = isset($_POST['fecini']) ? $_POST['fecini']:NULL;
$fecfin = isset($_POST['fecfin']) ? $_POST['fecfin']:NULL;
$act = isset($_POST['act']) ? $_POST['act']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br>".$idkar."-".$fecini."-".$fecfin."-".$act."-".$filtro."<br><br>";
//Insertar o Actualizar
if($opera=="InsAct"){
	if($fecini && $fecfin){
		$mkar->kardact();
		$mkar->kariu($idkar,$fecini,$fecfin,"1");
		$kar = $mkar->selkar2($fecini, $fecfin, "1");
		echo '<script> window.location="home.php?pg=5009&idkar='.$kar[0]['idkar'].'";</script>';
		$idkar = NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
//Eliminar 
if($opera=="Elim"){
	if($idkar){
		$mkar->kardel($idkar);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
}
//Paginacion 
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mkar->sqlcount($filtro);

function insdatos($idkar,$pg,$arc){
	$mkar = new mkar();
	if($idkar) $dtkar = $mkar->selkar1($idkar);

	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Kardex</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idkar && $dtkar){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="number" name="idkar" class="from-control" readonly value="'.$idkar.'">';
			}
			$txt .= '<label>Fecha inicio</label>';
			$feci = date("Y-m-01");
			$fecf = date("Y-m-28");
			
			$txt .= '<input type="date" name="fecini" class="form-control" ';
				if($idkar && $dtkar) 
					$txt .= 'value="'.$dtkar[0]['fecini'].'"';
				else $txt .='value="'.$feci.'"';
			$txt .='>';
			$txt .= '<label>Fecha fin</label>';
			$txt .= '<input type="date" name="fecfin" class="form-control" ';
			if($idkar && $dtkar) $txt .= 'value="'.$dtkar[0]['fecfin'].'"';
			else $txt .='value="'.$fecf.'"';
			$txt .='>';
			/*$txt .= '<label>Activo</label>';
			$txt .= '<input type="number" name="act" class="form-control" ';
			if($idkar && $dtkar) $txt .= 'value="'.$dtkar[0]['act'].'"';
			$txt .='>';*/
			$txt .= '<input type="hidden" name="opera" value="InsAct">';
			$txt .='<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" value="';
				if($idkar && $dtkar) $txt .= "Actualizar"; else $txt .= "Insertar";
				$txt .= '">';
			$txt .= '</div>';
			$txt .= '<br>';
		$txt .= '</form>';
	$txt .= '</div>';

	echo $txt;
}
function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mkar = new mkar();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .='<div align="center">';
		$txt .= '<table><tr>';
				$txt .='<td>';
					$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
							$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Id o Fecha" onChange="this.form.submit();" />';
							$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
						$txt .='</form>';
				$txt .= '</td>';
				$txt .= '<td>';
					$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
					$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
					$result = $mkar->selkar($filtro, $pa->rvalini(), $pa->rvalfin());
				$txt .='</td>';
			$txt .= '</tr></table>';
	$txt .= '</div>';

		if($result){
			$txt .= '<table class="table table-hover">';
				$txt .= '<tr>';
					$txt .= '<th class="table-dark">Kardex</th>';
					$txt .= '<th class="table-dark"></th>';
					$txt .= '<th class="table-dark"></th>';
				$txt .= '</tr>';
				foreach ($result as $dt) {
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt.= '<big><strong>';
								$txt .= $dt['idkar'];
							$txt .= '</strong></big><br>';
							$txt .= '<small>';
								$txt .= '<strong>Fecha inicio: </strong>'.$dt['fecini']."<br>";
								$txt .= '<strong>Fecha fin: </strong>'.$dt['fecfin']."<br>";
								$txt .= '<strong>Activo: </strong>'.$dt['act'];
							$txt .= '</small>';
						$txt .= '</td>';
							$txt .='<td class="table-active">';
								/*$txt .='<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idkar='.$dt['idkar'].'" onclick="return eliminar();">';
									$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
								$txt .= '</a>';
								$txt .= '<br><br>';*/
								$txt .= '<a href="'.$arc.'?pg='."5009".'&idkar='.$dt['idkar'].'">';
									$txt .= '<i class="fas fa-edit fa-2x ic2"></i>';    
								$txt .= '</a>';
							$txt .= '</td>';
							$txt .='<td class="table-active">';
							$txt .= '</td>';
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