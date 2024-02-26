<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mdka.php';
require_once 'modelo/mpagina.php';

$pg=5009;
$arc="home.php";
$mdka = new mdka();

$iddk = isset($_POST["iddk"]) ? $_POST["iddk"]:NULL;
if(!$iddk)
	$iddk = isset($_GET["iddk"]) ? $_GET["iddk"]:NULL;
$idkar = isset($_POST["idkar"]) ? $_POST["idkar"]:NULL;
if(!$idkar)
	$idkar = isset($_GET["idkar"]) ? $_GET["idkar"]:NULL;
$idpro = isset($_POST["idpro"]) ? $_POST["idpro"]:NULL;
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"]:NULL;
$cant = isset($_POST["cant"]) ? $_POST["cant"]:NULL;
$valor = isset($_POST["valor"]) ? $_POST["valor"]:NULL;
$des = isset($_POST["des"]) ? $_POST["des"]:NULL;
$iddf = isset($_POST["iddf"]) ? $_POST["iddf"]:NULL;
$iddo = isset($_POST["iddo"]) ? $_POST["iddo"]:NULL;
$fecdk = isset($_POST["fecdk"]) ? $_POST["fecdk"]:NULL;

$opera = isset($_POST["opera"]) ? $_POST["opera"]:NULL;
if(!$opera)
	$opera = isset($_GET["opera"]) ? $_GET["opera"]:NULL;

$filtro = isset($_POST["filtro"]) ? $_POST["filtro"]:NULL;
if(!$filtro)
	$filtro = isset($_GET["filtro"]) ? $_GET["filtro"]:NULL;

//echo "<br><br><br><br>".$opera."-".$iddk."-".$idpro."-".$tipo."-".$pefid."-".$cant."-".$valor."-".$des."-".$iddf."-".$iddo."-".$fecdk."<br><br>";
//Insertar
if($opera=="Insertar" OR $opera=="Actualizar"){
	if($idkar and $idpro and $tipo and $cant and $valor and $des){
		$fecdk = DATE("Y-m-d h:i:s");
		$mdka->insdka($iddk, $idkar, $idpro, $tipo, $cant, $valor, $des, $iddf, $iddo, $fecdk);
		echo "<script>alert('Datos insertados y/o actualizados existosamente');</script>";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
}

//Eliminar
if($opera=="ElMn"){
	if($iddk){
		$mdka->dkadel($iddk);
		echo "<script>alert('Registro eliminado existosamente');</script>";
		$iddk= "";
	}
}
if($iddk){
	$GLOBALS['nu'] = 1;
	$GLOBALS['alto'] = "380px";
}

//Paginación parte 1
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mdka->sqlcount($idkar,$filtro);

//Mostrar detalle de entrada
function moskar($idkar,$pg,$arc){
	$mdka = new mdka();
	$dtent = NULL;
	if($idkar) $dtent = $mdka->selkar($idkar);
	$txt = '';
	$txt .= '<div class="conte">';
		if($dtent){
			$txt .= '<table class="table table-hover">';
				foreach ($dtent as $dt) {
					$txt .= '<tr>';
						$txt .= '<th class="table-dark" style="text-align: center;" colspan="2">';
							$txt .= '<big><strong>';
									$txt .= "Kardex No.".$dt['idkar'];
							$txt .= '</strong></big>';
						$txt .= '</th>';
					$txt .= '</tr>';
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= '<small>';
							$txt .= "<strong>Fecha de inicio: </strong>".$dt['fecini'];
							$txt .= '</small>';
							$txt .= '<br>';
							$txt .= '<small>';
							$txt .= "<strong>Fecha fin: </strong>".$dt['fecfin'];
							$txt .= '</small>';
						$txt .= '</td>';
						$txt .= '<td class="table-active">';
							$txt .= '<a href="vkarpdf.php?idkar='.$dt['idkar'].'" target="_blank">';
								$txt .= '<button>';
									$txt .= '<i class="fas fa-print fa-2x"></i>';
								$txt .= '</button>';
							$txt .= '</a>';
							$txt .= '<a href="vkarpdf.php?idkar='.$dt['idkar'].'&pdf=1547" target="_blank">';
								$txt .= '<button>';
									$txt .= '<i class="fas fa-file-pdf fa-2x"></i>';
								$txt .= '</button>';
							$txt .= '</a>';
						$txt .= '</td>';
					$txt .= '</tr>';
				}
			$txt .= '</table>';
		}else{
			$txt .= '<h3>No existen datos para mostrar</h3>';
		}
	$txt .= '</div>';

	echo $txt;
}
function cargar($idkar,$pg,$arc){
	$mdka = new mdka();
	$dtdka = NULL;
	$dtpro = $mdka->selpro();
	$txt = '';
	$txt .= '<div class="conte">';
		$txt .= '<h2>Detalle kardex</h2>';
		$txt .= '<button id="mos" class="btn btn-primary" onclick="ocultar(1,\'380px\');"><i class="fas fa-user-plus ico"></i>Nuevo</button>';
		$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
			$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="X">';
		$txt .= '</a>';
		$txt .= '<div id="inser">';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
					$txt .= '<input type="hidden" name="idkar" class="form-control"';
					//if($iddk && $dtdka) $txt .= ' value="'.$dtdka[0]['iddk'].'"';
					$txt .= 'class="form-control" required>';
				$txt .= '<label>Producto</label>';
					$txt .= '<select name="idpro" class="form-control" required>';
					if($dtpro){
						foreach ($dtpro as $f) {
							$txt .= '<option value="'.$f['idpro'].'"';
								//if ($iddk && $dtdka && $f['idpro']==$dtdka[0]['idpro']) $txt .= " selected ";
							$txt .= '>'.$f['nompro'].'</option>';
						}
					}
					$txt .= '</select>';
				$txt .= '<label>Tipo</label>';
				$txt .= '<select name="tipo" class="form-control">';
				$txt .= '<option value="AE">Ajuste de entrada</option>';
				$txt .= '<option value="AS">Ajuste de salida</option>';
				$txt .= '</select>';
				$txt .= '<label>Cantidad</label>';
				$txt .= '<input type="number" name="cant" class="form-control"';
					//if($iddk && $dtdka) $txt .= ' value="'.$dtdka[0]['cant'].'"';
				$txt .= ' required>';
				$txt .= '<label>Valor</label>';
				$txt .= '<input type="number" max="9999999999" name="valor" class="form-control"';
					//if($iddk && $dtdka) $txt .= ' value="'.$dtdka[0]['valor'].'"';
				$txt .= ' required>';
				$txt .= '<label>Descripción</label>';
				$txt .= '<input type="text" name="des" class="form-control"';
					//if($iddk && $dtdka) $txt .= ' value="'.$dtdka[0]['des'].'"';
				$txt .= ' required>';
				$txt .= '<input type="hidden" name="idkar" value="'.$idkar.'">';
				$txt .= '<input type="hidden" name="opera" value="Insertar">';
				$txt .= '<div class="cen">';
					$txt .= '<input type="submit" class="btn btn-primary" value="Insertar">';
				$txt .= '</div>';
			$txt .= '<br><br><br><br>';
			$txt .= '</form>';
		$txt .= '</div>';
	$txt .= '</div>';
	echo $txt;
}

function mostrar($idkar,$conp,$nreg,$pg,$arc,$filtro,$bo){
	$mdka= new mdka();
	$pa = new mpagina($nreg);
	$txt = '';
	$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
	$result = $mdka->seldk($idkar,$filtro,$pa->rvalini(),$pa->rvalfin());
		if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-hover table-dark" rowspan="2" style="text-align: center;"
				valign="middle">Fecha</th>';
				$txt .= '<th class="table-hover table-dark" rowspan="2" style="text-align: center;"
				valign="middle">Producto</th>';
				$txt .= '<th class="table-hover table-dark" colspan="3" style="text-align: center;">Entradas</th>';
				$txt .= '<th class="table-hover table-dark" colspan="3" style="text-align: center;">Salidas</th>';
				$txt .= '<th class="table-hover table-dark" colspan="3" style="text-align: center;">Saldos</th>';
			$txt .= '</tr>';
			$txt .= '<tr>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Uni.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. U.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. Total</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Uni.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. U.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. Total</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Uni.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. U.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. Total</th>';
			$txt .= '</tr>';
			$vcan = 0;
			$vuni = 0;
			$vto = 0;
			foreach ($result as $dt) {
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
						$txt .= $dt['fecdk'];
					$txt .= '</td>';
					$txt .= '<td class="table-active">';
						$txt .= $dt['nompro'];
					$txt .= '</td>';
					if($dt['tipo']=="E" OR $dt['tipo']=="AE"){
						$txt .= '<td class="table-active" style="text-align: right;">';
							$txt .= $dt['cant'];
						$txt .= '</td>';
						$txt .= '<td class="table-active" style="text-align: right;">$ ';
							$txt .= number_format($dt['precom'], 0, ',', '.');
						$txt .= '°°</td>';
						$txt .= '<td class="table-active" style="text-align: right;">$ ';
							$txt .= number_format($dt['cant']*$dt['precom'], 0, ',', '.');
						$txt .= '°°</td>';
						$vcan += $dt['cant'];
						$vuni += $dt['precom'];
						$vto += ($dt['cant']*$dt['precom']);
					}else{
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
					}
					if($dt['tipo']=="S" OR $dt['tipo']=="AS"){
						$txt .= '<td class="table-active" style="text-align: right;">';
							$txt .= $dt['cant'];
						$txt .= '</td>';
						$txt .= '<td class="table-active" style="text-align: right;">$ ';
							$txt .= number_format($dt['preven'], 0, ',', '.');
						$txt .= '°°</td>';
						$txt .= '<td class="table-active" style="text-align: right;"$ >';
							$txt .= number_format($dt['cant']*$dt['preven'], 0, ',', '.');
						$txt .= '°°</td>';
						$vcan -= $dt['cant'];
						$vuni -= $dt['preven'];
						$vto -= ($dt['cant']*$dt['preven']);
					}else{
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
					}
					$txt .= '<td class="table-active" style="text-align: right;">';
						$txt .= $vcan;
					$txt .= '</td>';
					$txt .= '<td class="table-active" style="text-align: right;">$ ';
						$txt .= number_format($vuni, 0, ',', '.');
					$txt .= '°°</td>';
					$txt .= '<td class="table-active" style="text-align: right;">$ ';
						$txt .= number_format($vto, 0, ',', '.');
					$txt .= '°°</td>';
				$txt .= '</tr>';
			}
		$txt .= '</table>';
		$txt .= '</BR></BR></BR></BR></BR></BR>';
	}else{
		$txt = "<h3>No existen datos para mostrar</h3>";
		$txt .= '</BR></BR></BR></BR></BR></BR>';
	}
	echo $txt;
}


function mostrar2($idkar,$pg,$arc){
	$mdka= new mdka();
	$txt = '';
	$result = $mdka->selpro();
		if($result){
		$txt .= '<table class="table table-hover">';
			$txt .= '<tr>';
				$txt .= '<th class="table-hover table-dark" rowspan="2" style="text-align: center;"
				valign="middle">Producto</th>';
				$txt .= '<th class="table-hover table-dark" colspan="3" style="text-align: center;">Entradas</th>';
				$txt .= '<th class="table-hover table-dark" colspan="3" style="text-align: center;">Salidas</th>';
				$txt .= '<th class="table-hover table-dark" colspan="3" style="text-align: center;">Saldos</th>';
			$txt .= '</tr>';
			$txt .= '<tr>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Uni.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. U.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. Total</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Uni.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. U.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. Total</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Uni.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. U.</th>';
				$txt .= '<th class="table-hover table-dark" style="text-align: center;">Vlr. Total</th>';
			$txt .= '</tr>';
			foreach ($result as $dt) {
				$dte = $mdka->selcpkt($idkar,$dt['idpro'],'E','AE');
				$dts = $mdka->selcpkt($idkar,$dt['idpro'],'S','AS');
				$txt .= '<tr>';
					$txt .= '<td class="table-active">';
						$txt .= $dt['nompro'];
					$txt .= '</td>';
					if($dte){
						$txt .= '<td class="table-active" style="text-align: right;">';
							$txt .= $dte[0]['can'];
						$txt .= '</td>';
						$txt .= '<td class="table-active" style="text-align: right;">$ ';
							$txt .= number_format($dt['precom'], 0, ',', '.');
						$txt .= '°°</td>';
						$txt .= '<td class="table-active" style="text-align: right;">$ ';
							$txt .= number_format($dte[0]['can']*$dt['precom'], 0, ',', '.');
						$txt .= '°°</td>';
					}else{
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
					}
					if($dts){
						$txt .= '<td class="table-active" style="text-align: right;">';
							$txt .= $dts[0]['can'];
						$txt .= '</td>';
						$txt .= '<td class="table-active" style="text-align: right;">$ ';
							$txt .= number_format($dt['preven'], 0, ',', '.');
						$txt .= '°°</td>';
						$txt .= '<td class="table-active" style="text-align: right;"$ >';
							$txt .= number_format($dts[0]['can']*$dt['preven'], 0, ',', '.');
						$txt .= '°°</td>';
					}else{
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
						$txt .= '<td class="table-active"></td>';
					}
					$vcan = $dte[0]['can']-$dts[0]['can'];
					$vuni = $dt['preven']-$dt['precom'];
					$vto = ($dte[0]['can']*$dt['precom'])-($dts[0]['can']*$dt['preven'])+($dt['preven']-$dt['precom'])*$dts[0]['can'];;
					$txt .= '<td class="table-active" style="text-align: right;">';
						$txt .= $vcan;
					$txt .= '</td>';
					$txt .= '<td class="table-active" style="text-align: right;">$ ';
						$txt .= number_format($vuni, 0, ',', '.');
					$txt .= '°°</td>';
					$txt .= '<td class="table-active" style="text-align: right;">$ ';
						$txt .= number_format($vto, 0, ',', '.');
					$txt .= '°°</td>';
				$txt .= '</tr>';
			}
		$txt .= '</table>';
		$txt .= '</BR></BR></BR></BR></BR></BR>';
	}else{
		$txt = "<h3>No existen datos para mostrar</h3>";
		$txt .= '</BR></BR></BR></BR></BR></BR>';
	}
	return $txt;
}
?>

