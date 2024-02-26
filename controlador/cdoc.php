<?php
require_once 'modelo/mdoc.php';
require_once 'modelo/mdka.php';
require_once 'modelo/conexion.php';
require_once 'modelo/mpagina.php';

$pg = 5006;
$arc = "home.php";
$mdoc = new mdoc();
$mdka = new mdka();
$kardex = $mdoc->selkar();

if($kardex){
	$idkar = $kardex[0]['idkar'];
}else{
	echo'<script>alert("No se puede crear una orden de compra si no se tiene un kardex activo. Por favor cree un kardex primero.");</script>';
	echo'<script>window.location="home.php?pg=5008";</script>';
}

//iddo,idoco,idpro,cando
$iddo = isset($_POST['iddo']) ? $_POST['iddo']:NULL;
if(!$iddo)
	$iddo = isset($_GET['iddo']) ? $_GET['iddo']:NULL;
$idoco = isset($_POST['idoco']) ? $_POST['idoco']:NULL;
if(!$idoco)
	$idoco = isset($_GET['idoco']) ? $_GET['idoco']:NULL;
$idpro = isset($_POST['idpro']) ? $_POST['idpro']:NULL;
$cando = isset($_POST['cando']) ? $_POST['cando']:NULL;
$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL;
if(!$filtro)
	$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;
$opera = isset($_POST['opera']) ? $_POST['opera']:NULL;
if(!$opera)
	$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br><br>".$iddo."-".$idoco."-".$idpro."-".$cando."-".$filtro."-".$opera."<br><br>";

//Insertar
if($opera=="INSACT"){
	if($idpro && $cando){
		$mdoc->dociu($iddo,$idoco,$idpro,$cando);
		$iddo = $mdoc->seldetoc3($idoco,$cando,$idpro);
		$fecdk=date("Y-m-d h:i:s");
		$mdka->insdka("",$idkar, $idpro, "E", $cando, "0", "", "", $iddo[0]['iddo'], $fecdk);
		echo "<script>alert('Datos insertados y/o actualizados existosamente');</script>";
	}else{
		echo "<script>alert('Falta llenar algunos campos');</script>";
	}
	$iddo=" ";
}

//eliminar
if($opera=="Elimi"){
	if($iddo){
		$mdoc->deldoc($iddo);
		echo "<script>alert('Datos eliminados existosamente');</script>";
	}
	$iddo=" ";
}


//Paginación parte 1
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mdoc->sqlcount($filtro);

//iddo,idoco,idpro,cando

//cabezote orden de compra
function cabezote($idoco,$pg,$arc){
	$mdoc = new mdoc();
	$dtordc = NULL;
	$dtordc = $mdoc->selordcom($idoco);
	$txt='';
	if($dtordc){
		foreach ($dtordc as $dtorcom) {
			$txt .= '<br><br>';
				$txt .= '<table class="table table-hover">';
					$txt .= '<tr>';
						$txt .= '<th scope="row" class="table-dark">Orden de compra</th>';
						$txt .= '<td colspan="3" class="table-active">'.$dtorcom['idoco'].'</td>';
					$txt .= '</tr>';
					$txt .= '<tr>';
      					$txt .= '<th scope="row" class="table-dark">fecha</th>';
      					$txt .= '<td colspan="3" class="table-active">'.$dtorcom['fecoco'].'</td>';
    				$txt .= '</tr>';
    				$txt .= '</tbody>';
				$txt.='</table>';
		}
	}
	echo $txt;
}



//Insertar datos
function insdatos($iddo,$idoco,$pg,$arc){
	$mdoc = new mdoc();
	$dtdoc = NULL;
	$dtorco =$mdoc->selordcom($idoco);
	$dtprod = $mdoc->selprod();
	$txt = '';
	$txt .= '<div class="conte">';//iddo,idoco,idpro,cando
		$txt .= '<h2>Detalle de orden de compra</h2>';
		$txt .= '<form name="frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
			$txt .= '<input type="hidden" name="iddo" readonly value="'.$iddo.'" class="form-control" />';
			$txt .= '<input type="hidden" name="idoco" readonly value="'.$idoco.'" class="form-control" />';
			$txt .= '<label>Producto</label>';
				if($dtprod){
				$txt .= '<select name="idpro" class="form-control">';
				foreach($dtprod as $dprod) {
					$txt .= '<option value="'.$dprod['idpro'].'" ';
					if ($iddo && $dtdoc && $dtdoc[0]['idpro']==$dprod['idpro']) $txt .= ' selected ';
					$txt.= '>';
						$txt .= $dprod['nompro'].' - '.$dprod['nomval'];
					$txt .= '</option>';
					}
					$txt .='</select>';
				}
			$txt .= '<label>Cantidad</label>';
			$txt .= '<input type="number" name="cando" class="form-control"';
				if($iddo and $dtdoc) $txt .= ' value="'.$dtdoc[0]['cando'].'"';
			$txt .= ' required />';
			$txt .= '<input type="hidden" name="opera" value="INSACT">';
			$txt .= '<div class="cen">';
				$txt .= '<input type="submit" class="btn btn-primary" value="';
			if($iddo && $dtdoc)
				$txt .= 'Actualizar';
			else
				$txt .= 'Registrar';
			$txt .= '">';
			$txt .= '</div>';

		$txt .= '</form>';
	$txt .= '</div>';
	$txt .= '<br><br><br>';

	echo $txt;
}


//mostrar registros
function mostrar($idoco,$pg,$arc)
{
    $mdoc = new mdoc();
    $txt = '';
    $tot = $mdoc->totdoc($idoco);
    $result = $mdoc->seldetoc2($idoco);
    if ($result) {
        $txt .= '<table class="table table-hover">';
        $txt .= '<tr>';
        $txt .= '<th class="table-dark" colspan="2">Detalle de orden de compra</th>';
        $txt .= '</tr>';
        foreach ($result as $dt) {
            $txt .= '<tr>';
            $txt .= '<td class="table-active" colspan="2">';
            $txt .= "<big><strong>";
            $txt .= 'No. '.$dt['iddo'];
            $txt .= "</strong></big>";
            $txt .= "<small>";
            $txt .= "<br><strong>Nombre producto:</strong> ".$dt['nompro'];
            $txt .= "<br><strong>tipo de producto:</strong> ".$dt['nomval'];
            $txt .= "<br><strong>orden de compra:</strong> ".'No. '.$dt['idoco']." - ".$dt['fecoco'];
            $txt .= "&nbsp;&nbsp;<br> <strong>Cantidad:</strong> ".$dt['cando'];
            $txt .= "&nbsp;&nbsp;<br> <strong>precio:</strong> ".$dt['precom'];
            $txt .= '</td>';
            $txt .= '</tr>';
        }
        foreach ($tot as $dtot){
	        $txt .='<tr>';
	        $txt .='<th class="table-dark" style="text-align:right;">Subtotal</th>';
	        $txt .='<th class="table-dark" style="text-align:right;">$'.number_format($dtot['sub'], 0, ',', '.').'°°'.'</th>';
	        $txt .='</tr>';
	         $txt .='<tr>';
	        $txt .='<th class="table-dark" style="text-align:right;">Iva 19%</th>';
	        $txt .='<th class="table-dark" style="text-align:right;">$'.number_format($dtot['iva'], 0, ',', '.').'°°'.'</th>';
	        $txt .='</tr>';
	         $txt .='<tr>';
	        $txt .='<th class="table-dark" style="text-align:right;">Total</th>';
	        $txt .='<th class="table-dark" style="text-align:right;">$'.number_format($dtot['tot'], 0, ',', '.').'°°'.'</th>';
	        $txt .='</tr>';
	       }
        $txt .= '</table>';
        $txt .= '</BR></BR></BR></BR></BR></BR>';
    } else {
        $txt .= "<h3>No existen datos para mostrar</h3>";
        $txt .= '</BR></BR></BR></BR></BR></BR>';
    }
    echo $txt;
}

  ?>