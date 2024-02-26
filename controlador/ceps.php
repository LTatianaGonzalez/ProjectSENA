<?php
require_once 'modelo/conexion.php';
require_once 'modelo/meps.php';
require_once 'modelo/mpagina.php';
require_once 'controlador/optimg.php';

$pg = 304;
$arc = "home.php";
$meps = new meps();

$epsnit = isset($_POST['epsnit']) ? $_POST ['epsnit']:NULL;
if(!$epsnit)
	$epsnit = isset($_GET['epsnit']) ? $_GET ['epsnit']:NULL;
$nomeps = isset($_POST['nomeps']) ? $_POST ['nomeps']:NULL;
$logoeps = isset($_POST['logoeps']) ? $_POST ['logoeps']:'';
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"]:NULL;
if(!$filtro)
	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;
$opera = isset($_POST["opera"]) ? $_POST["opera"]:NULL;
if(!$opera)
	$opera = isset($_GET["opera"]) ? $_GET["opera"]:NULL;
$arch = isset($_FILES['arch']["name"]) ? $_FILES['arch']["name"]:NULL;

if($arch && $epsnit){
	$logoeps = opti($_FILES['arch'], $epsnit, "foteps","logo");
}

//echo "<br><br><br><br>".$opera."-".$epsnit."-".$nomeps."-".$logoeps."<br><br>";
//Insertar
if($opera=="Insertar" OR $opera=="Actualizar"){
	if($epsnit && $nomeps){
		$meps->epsiu($epsnit, $nomeps, $logoeps);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$epsnit = "";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="Eliminar"){
	if($epsnit){
		$meps->epsdel($epsnit);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
		$epsnit = "";
	}
}

//1.OCULTAR
if($epsnit){
	$GLOBALS['nu'] = 1;
	$GLOBALS['alto'] = "255px";	
}

//Paginación parte 1
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $meps->sqlcount($filtro);

function cargar($epsnit,$pg,$arc){
	$meps = new meps();
	$dteps = NULL;
	if($epsnit) $dteps = $meps->seleps1($epsnit);
	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>EPS</h2>';
		//2.OCULTAR: ICONO DE CANCELAR
		$txt .= '<button id="mos" class="btn btn-primary" onclick="ocultar(1,\'255px\');"><i class="fas fa-user-plus ico"></i> Nuevo</button>';
		$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
			$txt .= '<i class="fas fa-window-close ic2"></i>';
			//$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="Cancelar">';
		$txt .= '</a>';

		$txt .= '<div id="inser">';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST" enctype="multipart/form-data">';

				$txt .= '<label>NIT</label>';
				$txt .= '<input type="number" name="epsnit" class="form-control"';
					if($epsnit && $dteps) $txt .= ' value="'.$dteps[0]['epsnit'].'"';
				$txt .= ' required>';
				
				$txt .= '<label>Nombre</label>';
				$txt .= '<input type="text" name="nomeps" class="form-control"';
					if($epsnit && $dteps) $txt .= ' value="'.$dteps[0]['nomeps'].'"';
				$txt .= ' required>';

				$txt .= '<label>Logotipo</label>';
				$txt .= '<input type="file" name="arch" class="form-control" accept="image/jpeg, image/png">';
				if($epsnit && $dteps)
					$txt .= '<input type="hidden" name="logoeps" value="'.$dteps[0]['logoeps'].'">';
				if($epsnit && $dteps && $dteps[0]['logoeps'])
					$txt .= '<img src="'.$dteps[0]['logoeps'].'" class="imglogoedit">';

				$txt .= '<input type="hidden" name="opera" value="';
				if($epsnit && $dteps)
					$txt .= 'Actualizar';
				else
					$txt .= 'Insertar';
				$txt .= '">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-primary" value="';
				if($epsnit && $dteps)
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

function mostrar($conp,$nreg,$pg,$arc,$filtro,$bo){
	$meps = new meps();
	$pa = new mpagina($nreg);
	$txt = '';
	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
//Filtro de busqueda
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="EPS" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .= '</td>';
//Paginación parte 2
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $meps->seleps($filtro,$pa->rvalini(),$pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div>';

	
	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark" width="100px"></th>';
				$txt .= '<th class="table-dark">EPS</th>';
				$txt .= '<th class="table-hover table-dark"></th>';
			$txt .= '</tr>';
		foreach ($result as $dt) {
			$txt .= '<tr>';
				$txt .= '<td class="table-active" width="100px">';
				if($dt['logoeps'])
					$txt .= '<img src="'.$dt['logoeps'].'" width="100px">';
				$txt .= '</td>';
				$txt .= '<td class="table-active">';
					$txt .= "<big><strong>";
					$txt .= $dt['nomeps'];
					$txt .= "</strong></big>";
					$txt .= '<small>';
						$txt .= "<br><strong>NIT:</strong> ".$dt['epsnit'];
					$txt .= '</small>';
				$txt .= '</td>';

				$txt .= '<td class="table-active" align="center">';
					$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Eliminar&epsnit='.$dt['epsnit'].'" onclick="return eliminar();">';
						$txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
					$txt .= '</a>';
					$txt .= '<br><br>';
					$txt .= '<a href="'.$arc.'?pg='.$pg.'&epsnit='.$dt['epsnit'].'">';
						$txt .= '<i class="fas fa-edit fa-2x"></i>';
					$txt .= '</a>';
				$txt .= '</td>';
			$txt .= '</tr>';
		}
		$txt .= '</table>';
		$txt .= '</BR></BR></BR>';
	}else{
		$txt = "<h3>No existen datos para mostrar</h3>";
		$txt .= '</BR></BR></BR>';
	}
	echo $txt;	
}
?>