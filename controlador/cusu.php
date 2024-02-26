<?php
require_once 'modelo/conexion.php';
require_once 'modelo/musu.php';
require_once 'modelo/mpagina.php';

$pg=401;
$arc="home.php";
$musu = new musu();

$idusu = isset($_POST["idusu"]) ? $_POST["idusu"]:NULL;
if(!$idusu)
	$idusu = isset($_GET["idusu"]) ? $_GET["idusu"]:NULL;
$tdocusu = isset($_POST["tdocusu"]) ? $_POST["tdocusu"]:NULL;
$docusu = isset($_POST["docusu"]) ? $_POST["docusu"]:NULL;
$nomusu = isset($_POST["nomusu"]) ? $_POST["nomusu"]:NULL;
$apeusu = isset($_POST["apeusu"]) ? $_POST["apeusu"]:NULL;
$dirusu = isset($_POST["dirusu"]) ? $_POST["dirusu"]:NULL;
$codubi = isset($_POST["codubi"]) ? $_POST["codubi"]:NULL;
$telusu = isset($_POST["telusu"]) ? $_POST["telusu"]:NULL;
$emausu = isset($_POST["emausu"]) ? $_POST["emausu"]:NULL;
$pefid = isset($_POST["pefid"]) ? $_POST["pefid"]:2;
$epsnit = isset($_POST["epsnit"]) ? $_POST["epsnit"]:NULL;
$pasusu = isset($_POST["pasusu"]) ? $_POST["pasusu"]:NULL;

$opera = isset($_POST["opera"]) ? $_POST["opera"]:NULL;
if(!$opera)
	$opera = isset($_GET["opera"]) ? $_GET["opera"]:NULL;

$filtro = isset($_POST["filtro"]) ? $_POST["filtro"]:NULL;
if(!$filtro)
	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;

//echo "<br><br><br><br>".$opera."-".$idusu."-".$tdocusu."-".$docusu."-".$nomusu."-".$apeusu."-".$dirusu."-".$codubi."-".$telusu."-".$emausu."-".$pefid."-".$epsnit."-".$pasusu."<br><br>";
//Insertar
if($opera=="InsAct"){
	if($tdocusu and $docusu and $nomusu and $apeusu and $dirusu and $codubi and $pefid and $epsnit and $pasusu){
		$musu->insusu($idusu, $tdocusu, $docusu, $nomusu, $apeusu, $dirusu, $codubi, $telusu, $emausu, $pefid, $epsnit, $pasusu);
		$pg = isset($_GET['pg']) ? $_GET['pg']:NULL;
		if($pg==100){
			echo "<script>alert('Datos insertados. Por favor ingrese a la plataforma');</script>";
			echo '<script>window.location="index.php";</script>';
		}else{
			echo "<script>alert('Datos insertados y/o actualizados existosamente');</script>";
		}
		$idusu = "";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="ElMn"){
	if($idusu){
		$musu->usudel($idusu);
		echo "<script>alert('Datos eliminados existosamente');</script>";
		$idusu ="";
	}
}

//1.OCULTAR
if($idusu){
	$GLOBALS['nu'] = 1;
	$GLOBALS['alto'] = "820px";	
}

//Paginación parte 1
$bo = "";
$nreg = 100;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $musu->sqlcount($filtro);

function cargar($idusu,$pg,$arc){ 
	$musu = new musu();
	$dtdoc = $musu->seldoc();
	$dtdto = $musu->seldep();
	$dtpef = $musu->selpef();
	$dteps = $musu->seleps();
	$dtusu = NULL;
	$perfil = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
	if($idusu){
		$dtusu = $musu->selusu1($idusu);
	}
	$txt = '';
	$txt .= '<div class="conte">';

		$txt .= '<h2>Usuario</h2>';
		//2.OCULTAR: ICONO DE CANCELAR
		$txt .= '<button id="mos" class="btn btn-primary" onclick="ocultar(1,\'820px\');"><i class="fas fa-user-plus ico"></i>Nuevo</button>';
		$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
			$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="X">';
		$txt .= '</a>';

		$txt .= '</BR>';

		$txt .= '<div id="inser">';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
				if($idusu && $dtusu){
					$txt .= '<label>Id</label>';
					$txt .= '<input type="text" name="idusu" class="form-control"';
					if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['idusu'].'"';
					$txt .= 'class="form-control" readonly required>';
				}
				$txt .= '<label>Tipo de Documento</label>';
				if($dtdoc){
					$txt .= '<select name="tdocusu" class="form-control">';
					$txt .= '<option value=0>Seleccione Tipo de documento</option>';
					foreach ($dtdoc as $doc) {
						$txt .= '<option value="'.$doc['codval'].'" ';
						if($idusu && $dtusu && $dtusu[0]['codval']==$doc['codval']) $txt .= 'selected';
						$txt .= '>';
							$txt .= $doc['nomval'];
						$txt .= '</option>';
					}
					$txt .= '</select>';
				}

				$txt .= '<label>Número de Documento</label>';
				$txt .= '<input type="number" name="docusu" class="form-control"';
					if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['docusu'].'"';
				$txt .= ' required>';

				$txt .= '<label>Nombre</label>';
				$txt .= '<input type="text" name="nomusu" class="form-control" maxlength="50" onkeypress="return sololet(event);"';
					if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['nomusu'].'"';
				$txt .= ' required>';

				$txt .= '<label>Apellidos</label>';
				$txt .= '<input type="text" name="apeusu" class="form-control" maxlength="50" onkeypress="return sololet(event);"';
					if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['apeusu'].'"';
				$txt .= ' required>';

				$txt .= '<label>Dirección</label>';
				$txt .= '<input type="text" name="dirusu" class="form-control"';
					if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['dirusu'].'"';
				$txt .= ' required>';

			//UBICACION
			$txt .= '<label>Departamento</label>';
			$txt .= '<select name="depto" class="form-control" required onChange="javascript:recCiudad(this.value);">';
				$txt .= '<option value=0>Seleccione Departamento</option>';
			if($dtdto){
				foreach ($dtdto as $f) {
					$txt .= '<option value="'.$f['codubi'].'">'.$f['nomubi'].'</option>';
				}
			}	
			$txt .= '</select>';
			$txt .= '<label>Municipio</label>';
			$txt .= '<div id="reloadMun">';
				$txt .= '<select name="codubi" class="form-control" required>';
					$txt .= '<option value=0>Seleccione Municipio</option>';
				if($dtusu){
						$txt .= '<option value="'.$dtusu[0]['codubi'].'" selected >'.$dtusu[0]['nomubi'].'</option>';
				}
				$txt .= '</select>';
			$txt .= '</div>';

			$txt .= '<label>Teléfono</label>';
			$txt .= '<input type="number" max="9999999999" name="telusu" class="form-control"';
				if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['telusu'].'"';
			$txt .= ' required>';

				$txt .= '<label>E-mail</label>';
				$txt .= '<input type="email" name="emausu" class="form-control"';
					if($idusu && $dtusu) $txt .= ' value="'.$dtusu[0]['emausu'].'"';
				$txt .= ' required>';

				//Perfil
				if($perfil==1){
					$txt .= '<label>Perfil</label>';
					$txt .= '<select name="pefid" class="form-control" required>';
					if($dtpef){
						foreach ($dtpef as $f) {
							$txt .= '<option value="'.$f['pefid'].'"';
								if ($idusu && $dtusu && $f['pefid']==$dtusu[0]['pefid']) $txt .= " selected ";
							$txt .= '>'.$f['pefnom'].'</option>';
						}
					}
					$txt .= '</select>';
				}

				//Nombre EPS
				$txt .= '<label>EPS</label>';
				if($dteps){
					$txt .= '<select name="epsnit" class="form-control">';
					$txt .= '<option value=0>Seleccione el nombre de la EPS</option>';
					foreach ($dteps as $nit) {
						$txt .= '<option value="'.$nit['epsnit'].'" ';
						if($idusu && $dtusu && $dtusu[0]['epsnit']==$nit['epsnit']) $txt .= 'selected';
						$txt .= '>';
							$txt .= $nit['nomeps'];
						$txt .= '</option>';
					}
					$txt .= '</select>';
				}

				$txt .= '<label>Contraseña</label>';
				$txt .= '<input type="password" name="pasusu" class="form-control" >';
				
				$txt .= '<input type="hidden" name="opera" value="InsAct">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-secondary" value="';
				if($idusu && $dtusu)
					$txt .= 'Actualizar';
				else
					$txt .= 'Insertar';
				$txt .= '">';
				
				$txt .= '</div>';
			$txt .= '</form>';
		$txt .= '</div>';
	$txt .= '</div>';
	echo $txt;
}


function mostrar($conp,$nreg,$pg,$arc,$filtro,$bo){
	$musu= new musu();
	$pa = new mpagina($nreg);
	$txt = '';

	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
//Filtro de busqueda
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Nombre o Apellido" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .= '</td>';
//Paginación parte 2
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $musu->selusu($filtro,$pa->rvalini(),$pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div>';

	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark">Usuario</th>';
				$txt .= '<th class="table-hover table-dark"></th>';
			$txt .= '</tr>';
		foreach ($result as $dt) {
			$txt .= '<tr>';
				$txt .= '<td class="table-active">';
					$txt .= "<big><strong>";
					$txt .= $dt['idusu'].' - '.$dt['nomusu'].' '.$dt['apeusu'];
					$txt .= "</strong></big>";
					$txt .= "<small>";
					$txt .= "<br><strong>Documento:</strong> ".$dt['tdocusu'].". ".$dt['docusu'];
					$txt .= "<br><strong>Dirección:</strong> ".$dt['dirusu']." ".$dt['nomubi'];
					/*$txt .= " ".$dt['Mun'];
					$txt .= " ".$dt['Dep'].'<br>';*/
					$txt .= "<br><strong>Teléfono:</strong> ".$dt['telusu'];
					$txt .= "&nbsp;&nbsp; <strong>E-mail:</strong> ".$dt['emausu'];
					$txt .= "<br><strong>Perfil:</strong> ".$dt['pefnom'];
					$txt .= "</small>";
				$txt .= '</td>';

				$txt .= '<td class="table-active" align="center">';
					$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=ElMn&idusu='.$dt['idusu'].'" onclick="return eliminar();">';
						$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
					$txt .= '</a>';
					$txt .= '<br><br>';
					$txt .= '<a href="'.$arc.'?pg='.$pg.'&idusu='.$dt['idusu'].'">';
						$txt .= '<i class="fas fa-edit fa-2x ic2"></i>';
					$txt .= '</a>';
				$txt .= '</td>';
			$txt .= '</tr>';
		}
		$txt .= '</table>';
		$txt .= '</BR></BR></BR>';
	}else{
		$txt .= "<h3>No existen datos para mostrar</h3>";
		//$txt .= '</BR></BR></BR></BR></BR></BR>';
	}
	echo $txt;	
}

function mostrarusers($pg,$arc){
	$musu= new musu();
	$result = $musu->selusers();

	$txt = '';

	if($result){
		$txt .= '<table id="example" class="table table-striped table-hover" style="width:100%;">';
			$txt .= '<thead>';
				$txt .= '<tr>';
					$txt .= '<th class="table-dark">Usuario</th>';
					$txt .= '<th class="table-hover table-dark"></th>';
				$txt .= '</tr>';
			$txt .= '</thead>';
			$txt .= '<tbody>';
				foreach ($result as $dt) {
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= "<big><strong>";
							$txt .= $dt['idusu'].' - '.$dt['nomusu'].' '.$dt['apeusu'];
							$txt .= "</strong></big>";
							$txt .= "<small>";
							$txt .= "<br><strong>Documento:</strong> ".$dt['tdocusu'].". ".$dt['docusu'];
							$txt .= "<br><strong>Dirección:</strong> ".$dt['dirusu']." ".$dt['nomubi'];
							/*$txt .= " ".$dt['Mun'];
							$txt .= " ".$dt['Dep'].'<br>';*/
							$txt .= "<br><strong>Teléfono:</strong> ".$dt['telusu'];
							$txt .= "&nbsp;&nbsp; <strong>E-mail:</strong> ".$dt['emausu'];
							$txt .= "<br><strong>Perfil:</strong> ".$dt['pefnom'];
							$txt .= "</small>";
						$txt .= '</td>';

						$txt .= '<td class="table-active" align="center">';
							$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=ElMn&idusu='.$dt['idusu'].'" onclick="return eliminar();">';
								$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
							$txt .= '</a>';
							$txt .= '<br><br>';
							$txt .= '<a href="'.$arc.'?pg='.$pg.'&idusu='.$dt['idusu'].'">';
								$txt .= '<i class="fas fa-edit fa-2x ic2"></i>';
							$txt .= '</a>';
						$txt .= '</td>';
					$txt .= '</tr>';
				}
			$txt .= '</tbody>';
		$txt .= '</table>';
		$txt .= '</BR></BR></BR>';
	}else{
		$txt .= "<h3>No existen datos para mostrar</h3>";
		//$txt .= '</BR></BR></BR></BR></BR></BR>';
	}
	echo $txt;	
}
?>