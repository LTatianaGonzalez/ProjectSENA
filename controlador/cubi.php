<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mubi.php';
require_once 'modelo/mpagina.php';

$pg = 308;
$arc = "home.php";
$mubi = new mubi();

$codubi = isset($_POST['codubi']) ? $_POST['codubi']:NULL;
if(!$codubi){
	$codubi = isset($_GET['codubi']) ? $_GET['codubi']:NULL;
}
$nomubi = isset($_POST['nomubi']) ? $_POST['nomubi']:NULL;
$depubi = isset($_POST['depubi']) ? $_POST['depubi']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro){
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
}

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera){
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
}

//echo "<br><br>".$codubi."-".$nomubi."-".$depubi."-".$filtro."<br><br>";

//Insertar o Actualizar
if($opera=="InsAct"){
	if($codubi && $nomubi && $depubi){
		$mubi->ubiiu($codubi, $nomubi, $depubi);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$codubi = NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="Elim"){
	if($codubi){
		$mubi->ubidel($codubi);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
}

//1.OCULTAR
if($codubi){
	$GLOBALS['nu'] = 1;
	$GLOBALS['alto'] = "280px";	
}

//Paginacion
$bo = "";
$nreg = 17;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mubi->sqlcount($filtro);

function insdatos($codubi,$pg,$arc){
	$mubi = new mubi();
	$datdep = $mubi->selubi2();
	if($codubi) $dtubi = $mubi->selubi1($codubi);

	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Ubicacion</h2>';
		//2.OCULTAR: ICONO DE CANCELAR
		$txt .= '<button id="mos" class="btn btn-primary" onclick="ocultar(1,\'280px\');"><i class="fas fa-user-plus ico"></i>Nuevo</button>';
		$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
			$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="X">';
		$txt .= '</a>';

		$txt .= '<br>';

		$txt .= '<div id="inser">';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
				
				$txt .= '<label>Codigo Ubicacion</label>';
				$txt .= '<input type="number" name="codubi" value="'.$codubi.'" class="form-control" />';
				
				$txt .= '<label>Municipio</label>';
				$txt .= '<input type="text" name="nomubi" maxlength="70" class="form-control"';
					if($codubi and $dtubi) $txt .= ' value="'.$dtubi[0]['Nom'].'"';
				$txt .= ' required />';
				$txt .= '<label>Codigo - Departamento</label>';
				if($datdep){
					$txt .= '<select name="depubi" class="form-control">';
					foreach ($datdep as $ddp) {
						$txt .= '<option value="'.$ddp['codubi'].'" ';
						if($codubi && $dtubi && $dtubi[0]['Dep']==$ddp['codubi']) $txt .= ' selected ';
						$txt .= '>';
							$txt .= $ddp['codubi'].'   -   '.$ddp['nomubi'];
						$txt .= '</option>';
					}
					$txt .= '</select>';
				}

				$txt .= '<input type="hidden" name="opera" value="InsAct">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($codubi and $dtubi)
					$txt .= 'Actualizar';
				else
					$txt .= 'Registrar';
				$txt .= '">';
				//3.OCULTAR: BOTON DE CANCELAR
				$txt .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
					$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="Cancelar">';
				$txt .= '</a>';

				$txt .= '</div>';
			$txt .= '</form>';
		$txt .= '</div>';
	$txt .= '</div>';

	echo $txt;
}

//Mostrar datos
function mosdatos($pg,$arc){
	$mubi = new mubi();
	$datdep = $mubi->selubi2();
	$result = $mubi->selubi();
	$txt = '';

	$txt .= '<div class="contdat">';	
	if($result){
		$txt .= '<table id="example" class="table table-striped table-hover" style="width: 100%;">';
			$txt .= '<thead>';
				$txt .= '<tr>';
					$txt .= '<th class="table-dark">Ubicaciones</th>';
					$txt .= '<th class="table-dark"></th>';
				$txt .= '</tr>';
			$txt .= '</thead>';
			$txt .= '<tbody>';
				foreach ($result as $dt) {
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= '<big><strong>';
								$txt .= $dt['Nom'];
							$txt .= '</strong></big><br>';
							$txt .= '<small>';
								$txt .= '<strong>Codigo: </strong>';
								$txt .= $dt['codubi'].'<br>';
								$txt .= '<strong>Departamento: </strong>';
								if($datdep){
									foreach ($datdep as $ddp) {
										if($dt['Dep']==$ddp['codubi'])
											$txt .= $ddp['nomubi'].'<br>';
									}
								}
								$txt .= '<strong>Codigo del Departamento: </strong>';
								$txt .= $dt['Dep'];
							$txt .= '</small>';
						$txt .= '</td>';
						$txt .= '<td class="table-active">';
							$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&codubi='.$dt['codubi'].'" onclick="return eliminar();">';
							$txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
							$txt .= '</a>';
							$txt .= '<br><br>';
							$txt .= '<a href="'.$arc.'?pg='.$pg.'&codubi='.$dt['codubi'].'">';
								$txt .= '<i class="fas fa-edit fa-2x"></i>';
							$txt .= '</a>';
						$txt .= '</td>';
					$txt .= '</tr>';
				}
			$txt .= '</tbody>';
		$txt .= '</table>';
	}else{
		$txt .= '<h3>No existen datos para mostrar</h3>';
	}
	$txt .= '<br><br><br>';
	$txt .= '</div>';
	echo $txt;
}
?>