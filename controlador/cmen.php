<?php
require_once('modelo/conexion.php');
require_once('modelo/mmen.php');


function mosmen($pagmen, $pefid){
	$mmen = new mmen();
	$result = $mmen->selmen($pagmen, $pefid);
	$pm = strtolower($pagmen);
	$txt = '';
	if($result){
		$txt .= '<div class="container">';
			$txt .= '<ul id="gn-menu" class="gn-menu-main">';
				$txt .= '<li class="gn-trigger">';
					$txt .= '<a class="gn-icon gn-icon-menu"><span>Menú</span></a>';
					$txt .= '<nav class="gn-menu-wrapper">';
					$txt .= '<div class="gn-scroller">';
					$txt .= '<ul class="gn-menu">';
						foreach ($result as $f) {
							$txt .= '<li ';
							if($f['pagarc']=="#Espacio")
								$txt .= 'class="fonmtit"';
							$txt .= '>';
							if($f['pagarc']=="#Espacio"){
								$txt .= '<i class="'.$f['icono'].' ajico"></i>';
								$txt .= '<strong>'.$f['pagnom'].'</strong>';
							}else{
								$txt .= '<a href="'.$pm.'.php?pg='.$f['pagid'].'"  class="btnm">';
									$txt .= '<i class="'.$f['icono'].' ajico"></i>';
									$txt .= ' <span>'.$f["pagnom"].'</span>';
								$txt .= '</a>';
							}
							$txt .= '</li>';
						}
					$txt .= '</ul>';
					$txt .= '</div>';
					$txt .= '</nav>';
				$txt .= '</li>';
				//$txt .= '<li class="smen">';
					/*$txt .= '<strong>Bienvenido, '.$_SESSION["nomusu"].'</strong>';*/
				$txt .= '<li style="padding-left: 10px;padding-right: 10px;line-height: 20px;text-align: left;">';
					$txt .= '<strong><big>Bienvenido, '.$_SESSION["nomusu"].'</big></strong>';
					$txt .= '<br>';
					$txt .= '<strong>Perfil: </strong>'.$_SESSION["pefnom"];
					//$txt .= $_SESSION["pefnom"];

					if($_SESSION["nomeps"]){
						$txt .= '&nbsp;&nbsp;&nbsp;';
						$txt .= '<strong>EPS: </strong>'.$_SESSION["nomeps"];
					}
				$txt .= '</li>';
				$txt .= '<li class="smen">';
					$txt .= '<a href="'.$pm.'.php?pg=1070">';
						$txt .= '<i class="fas fa-sign-out-alt ico"></i>';
						$txt .= ' <span>Salir</span>';
					$txt .= '</a>';
				$txt .= '</li>';
			$txt .= '</ul>';
		$txt .= '</div>';
		echo $txt;
	}

	function moscon($pefid,$pg){
		$mmen = new mmen();
		$datpgpf = $mmen->selpgpf($pefid);

		if($pefid)
			if(!$pg) $pg = $datpgpf[0]['pagprin'];
		else
			if(!$pg) $pg = 5555;

		$result = $mmen->selpgact($pg, $pefid);
		if($result){
			foreach ($result as $f) {
				require_once($f['pagarc']);
			}
		}else{
			$txt = "<div class='textinf'>";
				$txt .= "Usted no tiene permisos para ver esta página. Comuniquese con su administrador.";
			$txt .= "</div>";
			echo $txt;
		}
	}
}
?>