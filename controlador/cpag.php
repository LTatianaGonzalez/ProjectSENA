<?php 
	require_once 'modelo/conexion.php';
	require_once 'modelo/mpag.php';
	require_once 'modelo/mpagina.php';

	$pg = 308;
	$arc = "home.php";
	$mpag = new mpag();

	$pagid = isset($_POST['pagid']) ? $_POST['pagid']:NULL;
	if(!$pagid)
		$pagid = isset($_GET['pagid']) ? $_GET['pagid']:NULL;
	$pagnom = isset($_POST['pagnom']) ? $_POST['pagnom']:NULL;
	$pagarc = isset($_POST['pagarc']) ? $_POST['pagarc']:NULL;
	$pagmos = isset($_POST['pagmos']) ? $_POST['pagmos']:NULL;
	$pagord = isset($_POST['pagord']) ? $_POST['pagord']:NULL;
	$pagmen = isset($_POST['pagmen']) ? $_POST['pagmen']:NULL;
	$icono = isset($_POST['icono']) ? $_POST['icono']:NULL;


	$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
	if(!$filtro)
		$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
	if(!$opera)
		$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

	
	//Insertar o Actualizar
	//echo "<br>".$opera."-".$pagid."-".$pagnom."-".$pagarc."-".$pagmos."-".$pagord."-".$pagmen."-".$icono."<br>";
	if($opera=="InsAct"){
		if($pagnom && $pagarc && $pagmos && $pagord && $pagmen && $icono){
			$mpag->pagiu($pagid,$pagnom,$pagarc,$pagmos,$pagord,$pagmen,$icono);
			echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		}else{
			echo "<script>alert('Falta llenar algunos campos');</script>";
		}
		$pagid = "";
	}
	//Eliminar
	if($opera=="Elim"){
		if($pagid){
			$mpag->pagdel($pagid);
			echo "<script>alert('Datos eliminados exitosamente');</script>";
		}
		$pagid = "";
	}

	//Paginacion
	$bo = "";
	$nreg = 30;
	$pa = new mpagina();
	$preg = $pa->mpagin($nreg);
	$conp = $mpag->sqlcount($filtro);

	function insdatos($pagid,$pg,$arc){
		$mpag = new mpag();
		$idpagper = $mpag->selpper();
		if($pagid) $dtpag = $mpag->selpag1($pagid);
		$txt = '';
		$txt .= '<div class="conte">';
			$txt .= '<h2>Página</h2>';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
				$txt .= '<label>Código</label>';
				$txt .= '<input type="number" name="pagid" class="form-control" ';
				if($pagid && $dtpag) $txt .= ' readonly value="'.$pagid.'"';
				$txt .=	'>';
				$txt .= '<label>Nombre</label>';
				$txt .= '<input type="text" name="pagnom" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagnom'].'"';
				$txt .=	'>';

				$txt .= '<label>Archivo</label>';
				$txt .= '<input type="text" name="pagarc" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagarc'].'"';
				$txt .=	'>';
				
				$txt .= '<label>Mostrar</label>';
				/*$txt .= '<input type="text" name="pagarc" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagmos'].'"';
				$txt .=	'>';*/
				$txt .= '<select name="pagmos" class="form-control">';
					$txt .= '<option value="1"';
						if($pagid and $dtpag[0]['pagmos']==1){ $txt .= " selected "; }
					$txt .= '>Si</option>';
					$txt .= '<option value="2"';
						if($pagid and $dtpag[0]['pagmos']<>1){ $txt .= " selected "; }
					$txt .= '>No</option>';
				$txt .= '</select>';


				$txt .= '<label>Menu</label>';
				/*$txt .= '<input type="text" name="pagmen" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagmen'].'"';
				$txt .=	'>';*/
				$txt .= '<select name="pagmen" class="form-control">';
					$txt .= '<option value="Home"';
						if($pagid and $dtpag[0]['pagmen']=="Home"){ $txt .= " selected "; }
					$txt .= '>Home</option>';
					$txt .= '<option value="Index"';
						if($pagid and $dtpag[0]['pagmen']=="Index"){ $txt .= " selected "; }
					$txt .= '>Index</option>';
				$txt .= '</select>';
				
				
				$txt .= '<label>Orden</label>';
				$txt .= '<input type="text" name="pagord" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['pagord'].'"';
				$txt .=	'>';
				

				$txt .= '<label>Icono</label>';
				$txt .= '<input type="text" name="icono" class="form-control"';
				if($pagid && $dtpag) $txt .= 'value="'.$dtpag[0]['icono'].'"';
				$txt .=	'>';
				

				$txt .= '<input type="hidden" name="opera" value="InsAct">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-primary" value="Registrar">';

				$txt .= '</div>';
				$txt .= '<br><br><br><br>';
			$txt .= '</form>';
		$txt .= '</div>';

		echo $txt;

	}

	function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mpag = new mpag();
	$pa = new mpagina($nreg);
	$txt = '';
	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Nombre de página" onChange="this.form.submit();"/>';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'"/>';
				$txt .= '</form>';
			$txt .= '</td>';
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'">';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mpag->selpag($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
		$txt .= '</tr></table>';
	$txt .= '</div><br>';

	/*echo "<pre>";
	var_dump($result);
	echo "</pre>";*/ 


	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-dark" align="center">Ico.</th>';
				$txt .= '<th class="table-dark">Nombre</th>';
				$txt .= '<th class="table-dark"></th>';
				$txt .= '<th class="table-dark"></th>';
				$txt .= '<th class="table-dark"></th>';
			$txt .= '</tr>';

			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
						$txt .= '<i class="'.$dt['icono'].' " style="text-shadow: 0px 0px 4px #000;"></i>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<big><strong>';
							$txt.=$dt['pagid']." - ".$dt['pagnom'].'<br>';
							$txt .= '</strong></big>';
						$txt.=$dt['pagarc'].'<br>';
						$txt.= '<small><small><strong>Menú:</strong> '. $dt['pagmen'];
						$txt.= '<br><strong>Icono:</strong> '.$dt['icono']."</small></small>";
					$txt .= '</td>';

					$txt .= '<td class="table-active" align="center">';
						if($dt['pagmos']==1)
							$txt .= '<i class="far fa-check-circle ico" style="color: #32429e;"></i>';
						else
							$txt .= '<i class="far fa-times-circle" style="color: #ff0000;font-size: 21px;"></i>';
						$txt.= "<br>".$dt['pagord'];
					$txt .= '</td>';


					$txt .= '<td class="table-active">';
						
					$txt .= '</td>';

					$txt .= '<td class="table-active">';
						$txt.= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&pagid='.$dt['pagid'].'" onclick="return eliminar();">';
							$txt.= '<i class="fas fa-trash-alt fa-2x"></i>';
						$txt.= '</a>';
					$txt .= '<br><br>';
					/*$txt .= '</td>';

					$txt .= '<td class="table-active">';*/
						$txt.= '<a href="'.$arc.'?pg='.$pg.'&pagid='.$dt['pagid'].'">';
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
?>