<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mdro.php';
require_once 'modelo/mpagina.php';

$pg = 203;
$arc = "home.php";
$mdro = new mdro();

$iddro = isset($_POST['iddro']) ? $_POST['iddro']:NULL;
if(!$iddro)
	$iddro = isset($_GET['iddro']) ? $_GET['iddro']:NULL;
$nomdro = isset($_POST['nomdro']) ? $_POST['nomdro']:NULL;
$codubi = isset($_POST['codubi']) ? $_POST['codubi']:NULL;
$dirdro = isset($_POST['dirdro']) ? $_POST['dirdro']:NULL;
$teldro = isset($_POST['teldro']) ? $_POST['teldro']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br>".$iddro."-".$codubi."-".$dirdro."-".$teldro."-".$filtro."<br><br>";
//Insertar o Actualizar
if($opera=="InsAct"){
	if($nomdro && $codubi && $dirdro && $teldro){
		$mdro->drogiu($iddro,$nomdro,$codubi,$dirdro,$teldro);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$iddro = '';
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
} 

//Eliminar
if($opera=="Elim"){
	if($iddro){
		$mdro->drogdel($iddro);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
		$iddro = '';
	}
}

//Paginación
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mdro->sqlcount($filtro);

function insdatos($iddro,$pg,$arc){
	$mdro = new mdro();
	//$dtubi = $mdro->selubi();
	$dtdto = $mdro->seldep();
	$dtdr = NULL;
	if($iddro) 
		$dtdr = $mdro->seldrog1($iddro);

	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Drogueria</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($iddro && $dtdr){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="number" name="iddro" class="form-control" readonly value="'.$iddro.'">';
			}
			$txt .= '<label>Nombre de la droguería</label>';
			$txt .= '<input type="text" name="nomdro" class="form-control" ';
			if($iddro && $dtdr) $txt .= 'value="'.$dtdr[0]['nomdro'].'"';
			$txt .= '>';
			$txt .= '<label>Dirección</label>';
			$txt .= '<input type="text" name="dirdro" class="form-control" ';
			if($iddro && $dtdr) $txt .= 'value="'.$dtdr[0]['dirdro'].'"';
			$txt .= '>';
			$txt .= '<label>Departamento</label>';
			$txt .= '<select name="depto" class="form-control" required onChange="javascript:recCiudad(this.value);">';
					$txt .= '<option value=0>Seleccione el departamento</option>';
			if($dtdto){
				foreach ($dtdto as $dubi) {
					$txt .= '<option value="'.$dubi['codubi'].'">'.$dubi['nomubi'].'</option>';
				}
			}	
				$txt .= '</select>';
			$txt .= '<label>Municipio</label>';
			$txt .= '<div id="reloadMun">';
				$txt .= '<select name="codubi" class="form-control" required>';
					$txt .= '<option value=0>Seleccione Municipio</option>';
				if($dtdr){
						$txt .= '<option value="'.$dtdr[0]['codubi'].'" selected ">'.$dtdr[0]['nomubi'].'</option>';
				}
				$txt .= '</select>';
			$txt .= '</div>';
			$txt .= '<label>No. Teléfono</label>';
			$txt .= '<input type="number" name="teldro" class="form-control" ';
			if($iddro && $dtdr) $txt .= 'value="'.$dtdr[0]['teldro'].'"';
			$txt .= '>';
			$txt .= '<input type="hidden" name ="opera" value="InsAct">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($iddro && $dtdr) $txt .="Actualizar"; else $txt .= "Insertar";
				$txt .= '">';
			$txt .= '</div>';
			$txt .= '<br><br><br><br>';
		$txt .= '</form>';
	$txt .='</div>';

	echo $txt;
}
function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mdro = new mdro();
	$pa = new mpagina($nreg);

	$txt = '';
		$txt .= '<div align="center">';
			$txt .= '<table><tr>';
				$txt .= '<td>';
					$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
						$txt .= '<input type="text" name="filtro" value"'.$filtro.'" class="form-control" placeholder="Id o Nombre de la drogueria" onChange="this.form.submit();" />';
						$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
					$txt .= '</form>';
				$txt .= '</td>';
				$txt .= '<td>';
					$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
					$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
					$result = $mdro->seldrog($filtro, $pa->rvalini(), $pa->rvalfin());
				$txt .= '</td>';
			$txt .= '</tr></table>';
		$txt .= '</div>';

		if($result){
			$txt .= '<table class="table table-hover">';
				$txt .= '<tr>';
					$txt .= '<th class="table-dark">Drogueria</th>';
					$txt .= '<th class="table-dark"></th>';
					$txt .= '<th class="table-dark"></th>';
					$txt .= '<th class="table-dark"></th>';
				$txt .= '</tr>';
				foreach ($result as $dt) {
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= '<big><strong>';
								$txt .= $dt['iddro'].' - '.$dt['nomdro'];
								$txt .= '</strong></big><br>';
								$txt .= '<small>';
									$txt .= '<strong>Dirección: </strong>'.$dt['dirdro'];
									$txt .= " ".$dt['Mun'];
									$txt .= " ".$dt['Dep'].'<br>';

									$txt .= '<strong>No. Teléfono: </strong>'.$dt['teldro'].'<br>';
								$txt .= '</small>';
						$txt .= '</td>';
							$txt .= '<td class="table-active">';
									$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&iddro='.$dt['iddro'].'" onclick="return eliminar();">';
										$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
									$txt .= '</a>';
									$txt .= '<br><br>';
									$txt .= '<a href="'.$arc.'?pg='.$pg.'&iddro='.$dt['iddro'].'">';
								$txt .= '<i class="fas fa-edit fa-2x ic2"></i>';
							$txt .= '</a>';
						$txt .= '</td>';
					$txt .= '<td class="table-active">';
					$txt .= '</td>';	
					$txt .= '<td class="table-active">';
					$txt .= '</td>';
					$txt .= '</tr>';
				}
			$txt .= '</table>';
			$txt .= '';
		}else{
			$txt .= '<h3>No existen datos para mostrar.<h3>';
		}
		$txt .= '<br><br><br><br>';
		echo $txt;
}
?>