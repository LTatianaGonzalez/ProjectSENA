<?php
	require_once 'modelo/conexion.php';
	require_once 'modelo/mfac.php';
	require_once 'modelo/mpagina.php';
	require_once 'controlador/optimg.php';

	$pg=5002;
	$arc = "home.php";
	$mfac = new mfac();

	$kardex = $mfac->karact();
	if($kardex){
		$idkar = $kardex[0]['idkar'];
	}else{
		echo '<script>alert("No se puede crear factura sino se tiene un kardex activo.Por favor cree un kardex.");</script>';
		echo '<script>window.location="home.php?pg=5008";</script>';
	}



	$idfac = isset($_POST['idfac']) ? $_POST['idfac']:NULL;
	if(!$idfac)
		$idfac = isset($_GET['idfac']) ? $_GET['idfac']:NULL;
		$idusu = isset($_POST['idusu']) ? $_POST['idusu']:3; 	
		$fecfac = isset($_POST['fecfac']) ? $_POST['fecfac']:NULL;
		$estfac = isset($_POST['estfac']) ? $_POST['estfac']:NULL;
		$formed = isset($_POST['formed']) ? $_POST['formed']:NULL;

	$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
	if(!$filtro)
		$filtro= isset($_GET['filtro']) ? $_GET['filtro']:NULL; 

	$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
	if(!$opera)
		$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

	//echo $idfac.'-'.$idusu.'-'.$fecfac.'-'.$estfac.'-'.$formed.'-'.$opera;
	//Insertar o actualizar
	if($opera=="InsAct"){
		if($idusu){
			$fecfac = Date('Y-m-d h:i:s:');
			$mfac->faciu($idfac, $idusu, $fecfac, 1, $formed);
			$fac = $mfac->selfac2($idusu, $fecfac, 1, $formed);
			echo '<script>window.location="home.php?pg=5003&idfac='.$fac[0]['idfac'].'";</script>';
			$idfac = NULL;
		}else{
			echo "<script>alert('Falta llenar algunos campos');</script>";
		}
	}
	//Eliminar
	if($opera=="Elim"){
		if($idfac){
			$mfac->facdel($idfac);
			echo "<script>alert('Datos eliminados correctamente');</script>";
		}
	}

	//Paginacion
	$bo ="";
	$nreg = 30;
	$pa = new mpagina();
	$preg = $pa->mpagin($nreg);
	$conp = $mfac->sqlcount($filtro);

	 function insdatos($idfac,$pg,$arc){
		$mfac = new mfac();
		$idusu = $mfac->selusu();
		$dtfac = NULL;
		if($idfac) $dtfac = $mfac->selfac1($idfac);
		$txt = '';
		$txt .= '<div class="conte">';
			$txt .= '<h2>Factura</h2>';
			$txt .= '<form name="frm1" class="form-control" action="'.$arc.'?pg='.$pg.'" method="POST">';
		

				$txt.= '<label>Usuario</label>';
				if($idusu){
					$txt .= '<select name="idusu" class="form-control">';
					foreach ($idusu as $dil) {
						$txt .= '<option value="'.$dil['idusu'].'" ';
						if($idfac && $dtfac && $dtfac[0]['idusu']==$dil['idusu']) $txt.= 'selected';
						$txt .= '>';
							$txt .= $dil['nomusu'];
						$txt .= '</option>';
					}
					$txt .= '</select>';
				}
				$txt.='<label>Formula medica</label>';
				$txt .= '<input type="file" name="formed" class="form-control" value="">';

					$txt .= '<input type="hidden" name="opera" value="InsAct">';
					$txt .= '<div class="cen">';
						$txt .= '<input type="submit" class="btn btn-primary" value="';
						if($idfac && $dtfac) $txt .= "Actualizar"; else $txt .="Insertar";
						$txt .= '">';
					$txt .= '</div>';
					$txt.='<br><br><br>';
			$txt .= '</form>';
		$txt .= '</div>';

		echo $txt;

	}
	function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
		$mfac = new mfac();
		$pa = new mpagina($nreg);
		$txt = '';
		$txt .= '<div align="center">';
			$txt .= '<table><tr>';
				$txt .= '<td>';
					$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
						$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Id o Nombre" onChange="this.form.submit();">';
						$txt .= '<input type="hidden" name="pg" value="'.$pg.'">';
					$txt .= '</form>';
				$txt .= '</td>';
				$txt .= '<td>';
					$bo .= '<input type="hidden" name="filtro" value="'.$filtro.'">';
					$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
					$result = $mfac->selfac($filtro, $pa->rvalini(), $pa->rvalfin());
				$txt .= '</td>';

			$txt .= '</tr></table>';
		$txt .= '</div>';
		if($result){
			$txt .= '<table class="table table-hover">';
				$txt .= '<tr>';
					$txt .= '<th class="table-dark">Facturas</th>';
					$txt .= '<th class="table-dark"></th>';
				$txt .= '</tr>';
				foreach ($result as $dt) {
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt.= '<big><strong>';
								$txt.=' <strong>Usuario: </strong>'.$dt['nomusu'].' '.$dt['apeusu'];
							$txt.= '</strong></big><br>';
							$txt.= '<small>';
								$txt.=$dt['idfac'].' - '.$dt['fecfac'].'<br>';
								$txt.=' <strong>Estado: </strong>';
									if($dt['estfac']==1) $txt .= "Abierto";
									else $txt .= "Cerrado";
								$txt.='<br>'; 
								$txt.= '<strong>Formula medica:</strong>'.$dt['formed'];
								$txt.='<br>'; 
							$txt.= '</small>';
						$txt .= '</td>';
						$txt .= '<td class="table-active">';
							
							$txt.= '<a href="'.$arc.'?pg=5003&idfac='.$dt['idfac'].'">';
								$txt.='<i class="fas fa-edit fa-2x"></i>';
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