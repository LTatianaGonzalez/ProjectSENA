<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mdom.php';
require_once 'modelo/mpagina.php';

$pg = 301;
$arc = "home.php";
$mdom = new mdom();

$iddom = isset($_POST['iddom']) ? $_POST['iddom']:NULL;
if(!$iddom)
	$iddom = isset($_GET['iddom']) ? $_GET['iddom']:NULL;
$nomdom = isset($_POST['nomdom']) ? $_POST['nomdom']:NULL;
$pardom = isset($_POST['pardom']) ? $_POST['pardom']:NULL;
$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br><br>".$iddom."-".$nomdom."-".$pardom."-".$filtro."-".$opera."<br><br>";
//Insertar
if($opera=="Insertar" OR $opera=="Actualizar"){
	if($nomdom){
		$mdom->domver($iddom, $nomdom, $pardom);
		echo "<script>alert('Datos insertados y/o actualizados existosamente');</script>";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="Eliminar"){
	if($iddom){
		$mdom->deldom($iddom);
		echo "<script>alert('Datos eliminados existosamente');</script>";
	}
}

//Paginación parte 1
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mdom->sqlcount($filtro);

//Insertar datos
function insdatos($iddom,$pg,$arc){
	$mdom = new mdom();
	$dtdom = NULL;
	if($iddom) $dtdom = $mdom->seldom1($iddom);
	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Dominio</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($iddom and $dtdom){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="text" name="iddom" readonly value="'.$iddom.'" class="form-control" />';
			}
			$txt .= '<label>Dominio</label>';
			$txt .= '<input type="text" name="nomdom" maxlength="70" class="form-control"';
				if($iddom and $dtdom) $txt .= ' value="'.$dtdom[0]['nomdom'].'"';
			$txt .= ' required />';
			$txt .= '<label>Parametro</label>';
			$txt .= '<input type="text" name="pardom" maxlength="50" class="form-control"';
				if($iddom and $dtdom) $txt .= ' value="'.$dtdom[0]['pardom'].'"';
			$txt .= ' />';

			$txt .= '<input type="hidden" name="opera" value="';
			if($iddom and $dtdom)
				$txt .= 'Actualizar';
			else
				$txt .= 'Insertar';
			$txt .= '">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" value="';
			if($iddom and $dtdom)
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
	$mdom = new mdom();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			//Filtro de busqueda
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Dominio" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .= '</td>';
			//Paginación parte 2
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mdom->seldom($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div>';

	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark">Dominio</th>';
				$txt .= '<th class="table-dark"></th>';
			$txt .= '</tr>';
			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
						$txt .= '<big><strong>';
							$txt .= $dt['iddom'].'. '.$dt['nomdom'];
						$txt .= '</strong></big><br>';
						$txt .= '<small>';
							$txt .= '<strong>Parametros: </strong>'.$dt['pardom'];
						$txt .= '</small>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Eliminar&iddom='.$dt['iddom'].'" onclick="return eliminar();">';
						$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
						$txt .= '</a>';
						$txt .= '<br><br>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&iddom='.$dt['iddom'].'">';
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

?>