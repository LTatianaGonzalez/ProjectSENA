<?php
//require_once 'modelo/conexion.php';
require_once 'modelo/mdfa.php';
require_once 'modelo/mdka.php';
require_once 'modelo/mpagina.php';
$pg=5003;
$arc ="home.php";
$mdfa = new mdfa();
$mdka = new mdka();


$kardex = $mdfa->karact();
	if($kardex){
		$idkar = $kardex[0]['idkar'];
	}else{
		echo '<script>alert("No se puede crear factura sino se tiene un kardex activo.Por favor cree un kardex.");</script>';
		echo '<script>window.location="home.php?pg=5008";</script>';
	}

$iddf = isset($_POST["iddf"]) ? $_POST["iddf"]:NULL;
if(!$iddf) $iddf = isset($_GET["iddf"]) ? $_GET["iddf"]:NULL;
$idfac = isset($_POST["idfac"]) ? $_POST["idfac"]:NULL;
	if(!$idfac) $idfac = isset($_GET["idfac"]) ? $_GET["idfac"]:NULL;
$idpro = isset($_POST["idpro"]) ? $_POST["idpro"]:NULL;
$candf = isset($_POST["candf"]) ? $_POST["candf"]:NULL;


$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;

$opera = isset($_POST["opera"]) ? $_POST["opera"]:NULL;
if(!$opera) $opera = isset($_GET["opera"]) ? $_GET["opera"]:NULL;

//echo $tentxsal;
if($opera=="InsAct"){
	if($idpro && $idfac && $candf){
		$mdfa->iudet($iddf, $idfac, $idpro, $candf);
		$ifd = $mdfa->selid($idfac,$idpro,$candf);
		$fecdk = date('Y-m-d h:i:s');
		$mdka->insdka("", $idkar, $idpro, "S", $candf, "0", "",$ifd[0]['iddf'], "", $fecdk);
		


		echo "<script>alert('Datos insertados y/o actualizados exitosamente');</script>";
	}
}
//Eliminar
if($opera=="Elim"){
	if($iddf){
		$mdfa->deldet($iddf);
		echo "<script>alert('Registro eliminado existosamente');</script>";
	}
}
if($opera=="buscar"){
	if($iddf){
		echo "Le entra'".$iddf."'";
	}
}

//Buscar
/*if($opera=="buscar"){
	if($iddf){
		$usu = $mentxsal->selusu1($idpro);
	}if($usu){
		$texs = $mentxsal->selustu($usu[0]['idpro']);
		if($texs[0]['can']%2==0)
			$tipexs = "Ingreso";
		else
			$tipexs = "Salio";
		$fec = date('Y-m-d h:i:s');
	}
}*/
$bo = "";
$nreg = 25 ;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mdfa->sqlcount($filtro);

//Insertar detalle de factura
function inses($iddf,$pg,$arc){
	$mdfa = new mdfa();
	$dtpro = $mdfa->selpro();
	$idfac = isset($_GET["idfac"]) ? $_GET["idfac"]:NULL;
	$dtdf = NULL;
	if($iddf) $dtdf = $mdfa->selent1($iddf);
	$pf = isset($_SESSION["pefid"]) ? $_SESSION["pefid"]:NULL;
	if($idfac){
	$txt = '';
	$txt .= '<div class="conte">';
			$txt .= '<h2>Detalle de Factura</h2>';
				$txt .= '<button id="mos" class="btn btn-primary" onclick="ocultar(1,\'450px\');" ><i class="fas fa-eye ico"></i> Ver</button>';
				$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
					$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="Cancelar">';
				$txt .= '</a>';
		$txt.='<div id="inser">';
			$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
				
					$txt .= '<input type="hidden" name="idfac" readonly value="'.$idfac.'" class="form-control" required>';
				$txt .= '<label>Producto</label>';
					$txt .= '<select name="idpro" class="form-control" required>';
					if($dtpro){
						foreach ($dtpro as $f) {
							$txt .= '<option value="'.$f['idpro'].'"';
								if ($iddf && $dtdf && $f['idpro']==$dtdf[0]['idpro']) $txt .= " selected ";
							$txt .= '>'.$f['nompro'].'</option>';
						}
					}
					$txt .= '</select>';
					$txt .= '<label>Cantidad</label>';
				$txt .= '<input type="number" name="candf" class="form-control"';
					if($iddf && $dtdf) $txt.= ' value="'.$dtdf[0]['candf'].'"';
				$txt .= 'required>';
							
				$txt .= '<input type="hidden" name="opera" value="InsAct">';
						$txt .= '<div class="cen">';
							$txt .= '<input type="submit" class="btn btn-primary" value="';
								if($iddf && $dtdf) $txt .= "Actualizar"; else $txt .="Insertar";
							$txt .= '">';
							$txt.='&nbsp;&nbsp;&nbsp;&nbsp;';
				$txt .= '<a href="'.$arc.'?pg='.$pg.'" id="ocu">';
					$txt .= '<input type="button" id="ocu" class="btn btn-secondary" value="Cancelar">';
				$txt .= '</a>';
						$txt .= '</div>';
						$txt.='<br><br><br>';
			$txt .= '</form>';
		$txt.='</div>';
	$txt .= '</div>';
	echo $txt;
	}
}
//Mostrar todos los detalles
function mosent($conp,$nreg,$pg,$arc,$filtro,$bo){
	$mdfa = new mdfa();
	$pa = new mpagina($nreg);

	$txt = '';

	$txt .= '<div align="center">';
		$txt .= '<table><tr>';
			//Filtro de busqueda
			$txt .= '<td>';
				$txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
					$txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="ID producto" onChange="this.form.submit();" />';
					$txt .= '<input type="hidden" name="pg" value="211" />';
				$txt .= '</form>';
			$txt .= '</td>';

			//Paginación parte 2
			$txt .= '<td>';
				$bo = '<input type="hidden" name="filtro" value="'.$filtro.'" />';
				$txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);
				$result = $mdfa->seldetalle($filtro, $pa->rvalini(), $pa->rvalfin());
			$txt .= '</td>';
			
		$txt .= '</tr></table>';
	$txt .= '</div>';

	
	$txt .= '<br><br><br>';
	echo $txt;
}

//Mostrar detalle de factura
function mosdent($idfac,$pg,$arc){
	$mdfa = new mdfa();
	$dtent = NULL;
	if($idfac) $dtent = $mdfa->selfac1($idfac);

	$txt = '';
	$txt .= '<div class="conte">';
		if($dtent){
			$txt .= '<table class="table table-hover">';
				foreach ($dtent as $dt) {
					$txt .= '<tr>';
						$txt .= '<th class="table-dark" style="text-align: center;" colspan="2">';
							$txt .= '<big><strong>';
									$txt .= "Factura No.".$dt['idfac'];
								$txt .= " Fecha: </strong>".$dt['fecfac'];
							$txt .= '</strong></big>';
						$txt .= '</th>';
					$txt .= '</tr>';
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= '<small>';
							$txt .= "<strong>Usuario: </strong>".$dt['nomusu']." ".$dt['apeusu'];
							$txt .= '</small>';
							$txt .= '<td class="table-active">';
							$txt .= '<small>';
							$txt .= "<strong>Email: </strong>".$dt['emausu'];
							$txt .= '</small>';
							$txt .= '</td>';
						$txt .= '</td>';
					$txt .= '</tr>';
						$txt .= '</tr>';
					$txt .= '<tr>';
						$txt .= '<td class="table-active">';
							$txt .= '<small>';
							$txt .= "<strong>Direccion: </strong>".$dt['dirusu'];
							$txt .= '</small>';
							$txt .= '<td class="table-active">';
							$txt .= '<small>';
							$txt .= "<strong>Telefono: </strong>".$dt['telusu'];
							$txt .= '</small>';
							$txt .= '</td>';
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




function mosdatos($idfac,$pg,$arc){
	$mdfa = new mdfa();
	$txt = '';
	$result = $mdfa->seldetalle($idfac);
	$total = $mdfa->totfac($idfac);
	$txt .='<div class="contdat">';
	if($result){
		$txt .='<table class="table table-hover>"';
			$txt .= '<tr>';
				$txt .='<th class="table-dark">Producto</th>';
				$txt .='<th class="table-dark">Total</th>';
				$txt .='<th class="table-dark"></th>';
			$txt .='</tr>';
			foreach ($result as $dv) {
				$txt .='<tr>';
					$txt .='<td class="table-active">';
						$txt .='<big><strong>';
							$txt .= $dv['idpro'].'-'.$dv['nompro'];
						$txt .='</strong></big><br>';
						$txt .='<small>';
							$txt .='<strong>Cantidad:</strong>'.$dv['candf'];
							$txt .='<strong> Valor unitario:</strong> $'.number_format($dv['preven'], 0, ',', '.').'°°';
						$txt .='</small>';
					$txt .='</td>';

					$txt .='<td class="table-active style="text-align: right">';
						$txt .='<big><strong>';
							$txt .="$ ".number_format($dv['preven']*$dv['candf'], 0, ',', '.').'°°';
						$txt .='</strong></big><br>';
						
					$txt .='</td>';


					$txt .='<td class="table-active">';
						$txt .='<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idfac='.$idfac.'&iddf='.$dv['iddf'].'" onclick="return Eliminar();">';
							$txt .='<i class="fas fa-trash-alt fa-2x ic2"></i>';
						$txt .='</a>';
					$txt .='</td>';
				$txt .='</tr>';
			}
			$txt .= '<tr>';
				$txt .='<th class="table-dark" style="text-align: right">Subtotal</th>';
				$txt .='<th class="table-dark" style="text-align: right">$ '.number_format($total[0]['sub'], 0, ',', '.').'°°</th>';
				$txt .='<th class="table-dark"></th>';
			$txt .='</tr>';

			$txt .= '<tr>';
				$txt .='<th class="table-dark" style="text-align: right">Iva 19%</th>';
				$txt .='<th class="table-dark" style="text-align: right">$ '.number_format($total[0]['iva'], 0, ',', '.').'°°</th>';
				$txt .='<th class="table-dark"></th>';
			$txt .='</tr>';

			$txt .= '<tr>';
				$txt .='<th class="table-dark" style="text-align: right">Total a pagar</th>';
				$txt .='<th class="table-dark" style="text-align: right">$ '.number_format($total[0]['tot'], 0, ',', '.').'°°</th>';
				$txt .='<th class="table-dark"></th>';
			$txt .='</tr>';
		$txt .='</table>';
	}else{
		$txt .='<h4>No existen datos para mostrar</h4>';
	}
	$txt .='</div>';
	echo $txt;
		
}


?>