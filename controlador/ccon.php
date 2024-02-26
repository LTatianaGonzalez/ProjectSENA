<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mcon.php';
require_once 'modelo/mpagina.php';

$pg = 303;
$arc = "home.php";
$mcon = new mcon();

$idconf = isset($_POST['idconf']) ? $_POST['idconf']:NULL;
if(!$idconf)
	$idconf = isset($_GET['idconf']) ? $_GET['idconf']:NULL;
$nit = isset($_POST['nit']) ? $_POST['nit']:NULL;
$nomemp = isset($_POST['nomemp']) ? $_POST['nomemp']:NULL;
$dircon = isset($_POST['dircon']) ? $_POST['dircon']:NULL;
$mosdir = isset($_POST['mosdir']) ? $_POST['mosdir']:2;
$telcon = isset($_POST['telcon']) ? $_POST['telcon']:NULL;
$mostel = isset($_POST['mostel']) ? $_POST['mostel']:2;
$celcon = isset($_POST['celcon']) ? $_POST['celcon']:NULL;
$moscel = isset($_POST['moscel']) ? $_POST['moscel']:2;
$emacon = isset($_POST['emacon']) ? $_POST['emacon']:NULL;
$mosema = isset($_POST['mosema']) ? $_POST['mosema']:2;
$logocon = isset($_POST['logocon']) ? $_POST['logocon']:NULL;
$consen = isset($_POST['consen']) ? $_POST['consen']:NULL;
$codubi = isset($_POST['codubi']) ? $_POST['codubi']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br>".$idconf."-".$nit."-".$nomemp."-".$dircon."-".$mosdir."-".$telcon."-".$mostel."-".$celcon."-".$moscel."-".$emacon."-".$mosema."-".$logocon."-".$consen."-".$codubi."-".$filtro."<br><br>";
//Insertar o Actualizar
if($opera=="InsAct"){
	if($nit && $nomemp && $dircon && $telcon && $celcon && $emacon && $codubi){
		$mcon->cofiu($idconf,$nit, $nomemp, $dircon, $mosdir, $telcon, $mostel, $celcon, $moscel, $emacon, $mosema, $logocon, $consen, $codubi);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$idconf = NULL;
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}
//Eliminar
if($opera=="Elim"){
	if($idconf){
		$mcon->cofdel($idconf);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
}

//Paginación
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mcon->sqlcount($filtro);

function insdatos($idconf,$pg,$arc){
	$mcon = new mcon();
	$datdep = $mcon->selubi();
	if($idconf) $dtcn = $mcon->selcon1($idconf);


	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Configuración</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idconf && $dtcn){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="number" name="idconf" class="form-control" readonly value="'.$idconf.'">';
			}
			$txt .= '<label>Nit</label>';
			$txt .= '<input type="text" name="nit" class="form-control" ';
			if($idconf && $dtcn) $txt .= 'value="'.$dtcn[0]['nit'].'"';
			$txt .= '>';
			$txt .= '<label>Nombre</label>';
			$txt .= '<input type="text" name="nomemp" class="form-control" ';
			if($idconf && $dtcn) $txt .= 'value="'.$dtcn[0]['nomemp'].'"';
			$txt .= '>';
			$txt .= '<label>Dirección</label>';
			$txt .= '<input type="text" name="dircon" class="form-control" ';
			if($idconf && $dtcn) $txt .= 'value="'.$dtcn[0]['dircon'].'"';
			$txt .= '>';
			$txt .= '<input type="checkbox" name="mosdir" value="1"';
			if($idconf && $dtcn & $dtcn[0]['mosdir']=='1') $txt .= ' checked ';
			$txt .= '>';
			$txt .= '<label>No. Teléfono</label>';
			$txt .= '<input type="number" name="telcon" class="form-control" ';
			if($idconf && $dtcn) $txt .= 'value="'.$dtcn[0]['telcon'].'"';
			$txt .= '>';
			$txt .= '<input type="checkbox" name="mostel" value="1"';
			if($idconf && $dtcn & $dtcn[0]['mostel']=='1') $txt .= ' checked ';
			$txt .= '>';
			$txt .= '<label>No. Celular</label>';
			$txt .= '<input type="number" name="celcon" class="form-control" ';
			if($idconf && $dtcn) $txt .= 'value="'.$dtcn[0]['celcon'].'"';
			$txt .= '>';
			$txt .= '<input type="checkbox" name="moscel" value="1"';
			if($idconf && $dtcn & $dtcn[0]['moscel']=='1') $txt .= ' checked ';
			$txt .= '>';;
			$txt .= '<label>E-mail</label>';
			$txt .= '<input type="email" name="emacon" class="form-control" ';
			if($idconf && $dtcn) $txt .= 'value="'.$dtcn[0]['emacon'].'"';
			$txt .= '>';
			$txt .= '<input type="checkbox" name="mosema" value="1"';
			if($idconf && $dtcn & $dtcn[0]['mosema']=='1') $txt .= ' checked ';
			$txt .= '>';
			$txt .= '<label>Logo de la empresa</label>';
			$txt .= '<input type="file" name="logocon" class="form-control" value="">';
			$txt .= '<label>Descripción</label>';
			$txt .= '<textarea name="consen" class="form-control">';
			if($idconf && $dtcn) $txt .= $dtcn[0]['consen'];
			$txt .= '</textarea>';
			$txt .= '<label>Departamento</label>';
			if($datdep){
				$txt .= '<select name="codubi" class="form-control">';
				foreach ($datdep as $ddp) {
					$txt .= '<option value="'.$ddp['codubi'].'" ';
					if($idconf && $dtcn & $dtcn[0]['codubi']==$ddp['codubi']) $txt .= ' selected ';
					$txt .= '>';
						$txt .= $ddp['nomubi'];
					$txt .= '</option>';
				}
				$txt .= '</select>';
			}
			$txt .= '<input type="hidden" name="opera" value="InsAct">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-secondary" value="';
				if($idconf && $dtcn) $txt .= "Actualizar"; else $txt .= "Insertar";
				$txt .= '">';
			$txt .= '</div>';
			$txt .= '<br><br><br><br>';
		$txt .= '</form>';
	$txt .= '</div>';

	echo $txt;
}

function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mcon = new mcon();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Nit o Nombre" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .= '</td>';
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mcon->selcon($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div>';
	
	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark"></th>';
				$txt .= '<th class="table-dark">Configuración</th>';
				$txt .= '<th class="table-dark"></th>';
			$txt .= '</tr>';
			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
					if($dt['logocon']){
						$txt .= '<img src="'.$dt['logocon'].'" width="80px">';
					}
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<big><strong>';
							$txt .= $dt['nit'].' - '.$dt['nomemp'];
						$txt .= '</strong></big><br>';
						$txt .= '<small>';
							$txt .= '<strong>Dirección: </strong>'.$dt['dircon'];
							$txt .= " ".$dt['Mun'];
							$txt .= " ".$dt['Dep'].'<br>';
							$txt .= '<strong>No. Teléfono: </strong>'.$dt['telcon'];
							$txt .= ' <strong>No. Celular: </strong>'.$dt['celcon'];
							$txt .= ' <strong>E-mail: </strong>'.$dt['emacon'].'<br>';
						$txt .= '</small>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idconf='.$dt['idconf'].'" onclick="return eliminar();">';
							$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
						$txt .= '</a>';
						$txt .= '<br><br>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&idconf='.$dt['idconf'].'">';
							$txt .= '<i class="fas fa-edit fa-2x ic2"></i>';
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