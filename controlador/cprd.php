<?php 
require_once 'modelo/conexion.php';
require_once 'modelo/mprd.php';
require_once 'modelo/mpagina.php';
require_once 'controlador/optimg.php';

$pg = 305;
$arc = "home.php";
$mprd = new mprd();

$idpro = isset($_POST['idpro']) ? $_POST['idpro']:NULL;
if(!$idpro)
	$idpro = isset($_GET['idpro']) ? $_GET['idpro']:NULL;
$codval = isset($_POST['codval']) ? $_POST['codval']:NULL;
$nompro = isset($_POST['nompro']) ? $_POST['nompro']:NULL;
$descsp = isset($_POST['descsp']) ? $_POST['descsp']:NULL;
$preven = isset($_POST['preven']) ? $_POST['preven']:NULL;
$precom = isset($_POST['precom']) ? $_POST['precom']:NULL;
$imgpro = isset($_POST['imgpro']) ? $_POST['imgpro']:NULL;
$tppro = isset($_POST['tppro']) ? $_POST['tppro']:NULL;

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br>".$idpro."-".$codval."-".$nompro."-".$descsp."-".$preven."-".$precom."-".$imgpro."-".$tppro."-".$filtro."<br><br>";
//Insertar o Actualizar
if($opera=="InsAct"){
	if($codval && $nompro && $descsp && $preven && $precom && $imgpro && $tppro){
		$mprd->proiu($idpro,$codval,$nompro,$descsp,$preven,$precom,$imgpro,$tppro);
		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
		$idpro = " ";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="Elim"){
	if($idpro){
		$mprd->prodel($idpro);
		echo "<script>alert('Datos eliminados exitosamente');</script>";
	}
}

//Paginación 
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mprd->sqlcount($filtro);

function insdatos($idpro,$pg,$arc){
	$mprd = new mprd();
	$dtdr = NULL;
	$dtval = $mprd->selval();
	if($idpro) $dtdr = $mprd->selpro1($idpro);

	$txt = '';
		$txt .= '<div class="conte">';
			$txt .= '<h2>Producto</h2>';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			if($idpro && $dtdr){
				$txt .= '<label>Id</label>';
				$txt .= '<input type="number" name="idpro" class="form-control" readonly value="'.$idpro.'">';
			}
			//Categoria 
			$txt .= '<label>Categoria </label>';
			if($dtval){
				$txt .= '<select name="codval" class="form-control">';
				foreach ($dtval AS $id) {
					$txt .= '<option value="'.$id['codval'].'" ';
					if($idpro && $dtdr && $dtdr[0]['codval']==$id['codval']) $txt.='selected ';
					$txt .= '>';
						$txt .= $id['nomval'];
					$txt .= '</option>';
				}
				$txt .= '<select>';
			}
			$txt .= '<label>Nombre del Producto</label>';
			$txt .= '<input type="text" name="nompro" class="form-control" ';
			if($idpro && $dtdr) $txt .= 'value="'.$dtdr[0]['nompro'].'"';
			$txt .= '>';
			$txt .='<label>Descripción del producto</label>';
			$txt .='<textarea name="descsp" class="form-control">';
			if($idpro && $dtdr) $txt .= $dtdr[0]['descsp'];
			$txt .='</textarea>';

			$txt .='<label>Precio de Venta:</label>';
			$txt .='<input type="number" name="preven" class="form-control" ';
			if($idpro && $dtdr) $txt .= 'value"'.$dtdr[0]['preven'].'" ';
			$txt .= '>';

			$txt .='<label>Precio de Compra:</label>';
			$txt .='<input type="number" name="precom" class="form-control" ';
			if($idpro && $dtdr) $txt .= 'value"'.$dtdr[0]['precom'].'" ';
			$txt .='>';

			$txt .= '<label>Imagen del producto</label>';
			$txt .= '<input type="file" name="arch" class="form-control" accept="image/jpeg, image/png">';
			if($idpro && $dtdr)
				$txt .= '<input type="hidden" name="imgpro" value="'.$dtdr[0]['imgpro'].'">';
			if($idpro && $dtdr && $dtdr[0]['imgpro'])
				$txt .= '<img src="'.$dtdr[0]['imgpro'].'" class="imglogoedit">';

			$txt .='<label>Cantidad</label>';
			$txt .='<input type="number" name="tppro" class="form-control" ';
			if($idpro && $dtdr) $txt .= 'value="'.$dtdr[0]['tppro'].'"';
			$txt .='>';
			$txt .='<input type="hidden" name="opera" value="InsAct">';
			$txt.='<div class="cen">';
				$txt.='<input type="submit" class="btn btn-secondary" value="';
				if($idpro && $dtdr) $txt .= "Actualizar"; else $txt .= "Insertar";
				$txt .='">';
			$txt .='</div>';
			$txt .='<br><br><br><br>';
		$txt .='</form>';
	$txt .= '</div>';

	echo $txt;
}
function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mprd = new mprd();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .='<div align="center">';
		$txt .= '<table><tr>';
//Filtro de busqueda
			$txt .='<td>';
				$txt .='<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Id o Nombre" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="'.$pg.'" />';
				$txt .= '</form>';
			$txt .='</td>';
//Paginacion parte 2
			$txt .='<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mprd->selpro($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
		$txt .='</tr></table>';
	$txt .= '</div>';

	if($result){
		$txt .= '<table class="table table-hover">';
			$txt .='<tr>';
				$txt .='<th class="table-dark" width="100px"></th>';
				$txt .='<th class="table-dark">Producto</th>';
				$txt .='<th class="table-dark"></th>';
			$txt .='</tr>';
			foreach ($result as $dt) {
				$txt .='<tr>';
					$txt .= '<td class="table-active">';
					if($dt['imgpro']){
						$txt .= '<img src="'.$dt['imgpro'].'" width="80px">';
					}
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .='<big><strong>';
							$txt .= $dt['idpro']. ' - '.$dt['nompro'];
							$txt .='</strong></big><br>';
							$txt .='<small>';
								$txt .='<strong>Cantidad:</strong>'.$dt['tppro'].'<br>';
								$txt .='<strong>Categoria: </strong>'.$dt['nomval'].'<br>';
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idpro='.$dt['idpro'].'" onclick="return eliminar();">';
						$txt .= '<i class="fas fa-trash-alt fa-2x ic2"></i>';
						$txt .= '</a>';
						$txt .= '<br><br>';
						$txt .= '<a href="'.$arc.'?pg='.$pg.'&idpro='.$dt['idpro'].'">';
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