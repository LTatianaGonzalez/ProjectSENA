<?php 
	require_once 'modelo/conexion.php';
	require_once 'modelo/mord.php';
	require_once 'modelo/mpagina.php';

	$pg = 5005;
	$arc = "home.php";
	$mord = new mord();


	$kardex = $mord->karact();
	if($kardex){
		$idkar = $kardex[0]['idkar'];
	}else{
		echo '<script>alert("No se puede crear factura sino se tiene un kardex activo.Por favor cree un kardex.");</script>';
		echo '<script>window.location="home.php?pg=5008";</script>';
	}

	$idoco = isset($_POST['idoco']) ? $_POST['idoco']:NULL;
	if(!$idoco)
		$idoco = isset($_GET['idoco']) ? $_GET['idoco']:NULL;
	$fecoco = isset($_POST['fecoco']) ? $_POST['fecoco']:NULL;

	$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
	if(!$filtro)
		$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
	$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
	if(!$opera)
		$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;
	//echo "<br>".$opera."-".$idoco."-".$fecoco."-".$filtro."<br>";

	//Insertar o Actualizar
	if($opera=="InsAct"){	
		$fecoco = date('Y-m-d h:i:s');
		$mord->ordiu($idoco, $fecoco);
		$orden = $mord->selord2($fecoco);
		echo '<script>window.location="home.php?pg=5006&idoco='.$orden[0]['idoco'].'";</script>';
		$idoco = NULL;
	}

	//Paginacion
	$bo = "";
	$nreg = 17;
	$pa = new mpagina();
	$preg = $pa->mpagin($nreg);
	$conp = $mord->sqlcount($filtro);

	function insdatos($idoco,$pg,$arc){
		$mord = new mord();
		if($idoco) $dtord = $mord->selord1($idoco);

		$txt = '';
		$txt .= '<div class="conte">';
			$txt .= '<h2>Orden de Compra</h2>';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
				if($idoco && $dtord){
					$txt .= '<label>Id</label>';
					$txt .= '<input type="number" name="idoco" class="form-control" ';
					if($idoco && $dtord) $txt .= ' readonly value="'.$idoco.'"';
					$txt .=	'>';
				}

				if($idoco && $dtord){
				$txt .= '<label>Fecha</label>';
				$txt .= '<input type="text" name="fecoco" class="form-control"';
					if($idoco && $dtord) $txt .= ' value="'.$dtord[0]['fecoco'].'"';
					$txt .= ' readonly />';
				}

				$txt .= '<input type="hidden" name="opera" value="InsAct">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-primary" value="';
					if($idoco && $dtord)
						$txt .= 'Actualizar Orden';
					else
						$txt .= 'Nueva Orden';
					$txt .= '">';
				$txt .= '</div>';
			$txt .= '</form>';
		$txt .= '</div>';

		echo $txt;
	}

//Mostrar datos
	function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
		$mord = new mord();
		$pa = new mpagina($nreg);
		
		$txt = '';
		$txt .= '<div align="center">';
			$txt .= '<table><tr>';

//Filtro de busqueda
				$txt .= '<td>';
					$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
						$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Fecha" onChange="this.form.submit();" />';
						$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
					$txt .= '</form>';
				$txt .= '</td>';

//Paginación parte 2
				$txt .= '<td>';
					$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
					$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
					$result = $mord->selord($filtro, $pa->rvalini(), $pa->rvalfin());
				$txt .= '</td>';
			$txt .= '</tr></table>';
		$txt .= '</div>';

		if($result){
			$txt .= '<table class="table table-hover">';
				$txt .= '<tr>';
					$txt .= '<th class="table-dark">Orden de Compra</th>';
					$txt .= '<th class="table-dark"></th>';
				$txt .= '</tr>';

				foreach ($result as $dt) {
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= '<small>';
								$txt .= '<strong>ID Orden </strong>';
								$txt .= $dt['idoco'].'<br>';
								$txt .= '<strong>Fecha: </strong>';
								$txt .= $dt['fecoco'].'<br>';
							$txt .= '</small>';
						$txt .= '</td>';
						$txt .= '<td class="table-active">';
							$txt .= '<a href="'.$arc.'?pg=5006&idoco='.$dt['idoco'].'">';
								$txt .= '<i class="fas fa-edit fa-2x"></i>';
							$txt .= '</a>';
						$txt .= '</td>';
					$txt .= '</tr>';
				}
			$txt .= '</table>';
		}else{
			$txt .= '<h3>No existen datos para mostrar</h3>';
		}
		$txt .= '<br><br><br>';
		echo $txt;
	}
?>