<?php
require_once 'modelo/conexion.php';
require_once 'modelo/minv.php';
require_once 'modelo/mpagina.php';

$pg = 201;
$arc = "home.php";
$minv = new minv();

$idinv = isset($_POST['idinv']) ? $_POST['idinv']:NULL; 
if(!$idinv)
$idinv = isset($_GET['idinv']) ? $_GET['idinv']:NULL;
$iddro = isset($_POST['iddro']) ? $_POST['iddro']:NULL; 
$fecininv = isset($_POST['fecininv']) ? $_POST['fecininv']:NULL; 
$fecfininv = isset($_POST['fecfininv']) ? $_POST['fecfininv']:NULL;
$act = isset($_POST['act']) ? $_POST['act']:NULL; 
$iddro = isset($_POST['iddro']) ? $_POST['iddro']:NULL; 

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL; 
if(!$filtro)
$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL; 
if(!$opera)
$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

//echo "<br><br>".$idinv."-".$iddro."-".$fecininv."-".$fecfininv."-".$act."-".$filtro."<br><br>";

//Insertar o Actualizar
if ($opera=="InsAct"){
    if($idinv && $iddro && $fecininv && $fecfininv && $act){
         $minv->valiu ($idinv, $iddro, $fecininv, $fecfininv, $act);
      echo "<script>alert('Datos insertados y/o Actualizados exitosamente');</script>";

    }else{
       echo "<script>alert('Falta llenar algunos campos');</script>";
    }
}

//Eliminar
if ($opera=="Elim"){
	 if($idinv){
    $minv->invdel ($idinv);
    echo "<script>alert('Datos Eliminados exitosamente');</script>";	
    }
}

//Paginacion
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $minv->sqlcount($filtro);

function insdatos($idinv,$pg,$arc){
    $minv = new minv();
    $datdro = $minv->seldro();
    if ($idinv) $dtvl = $minv->selinv1($idinv);

    $txt = '';
    $txt .= '<div class="conte">';
        $txt .= '<h2>Inventario</h2>';
        $txt .= '<form name= "frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
            
            if($idinv && $dtvl){
              $txt .= '<label>Id Inventario</label>';
              $txt .= '<input type="number" name ="idinv" class="form-control" value="'.$dtvl[0]['idinv'].'" readonly required>';
            }
            
            $txt .= '<label>Drogueria</label>';
            if ($datdro){
                 $txt .= '<select name ="iddro" class="form-control">';
                 foreach ($datdro as $ddv) {
                  $txt .= '<option value="'.$ddv['iddro'].'"';
                  if($idinv && $dtvl && $dtvl[0]['iddro']==$ddv['iddro']) $txt .= ' selected '; 
                  $txt .= '>'; 
                      $txt .= $ddv['nomdro']; 
                  $txt .= '</option>';
                 }
                 $txt .= '</select>';
            }
            
            $txt .= '<label>Fecha de inicio</label>';
            $txt .= '<input type="date" name ="fecininv" class="form-control" ';
            if($idinv && $dtvl) $txt .= ' value="'.$dtvl[0]['fecininv'].'" ';
            $txt .= '>';
            
            $txt .= '<label>Fecha de fin</label>';
            $txt .= '<input type="date" name ="fecfininv" class="form-control" ';
            if($idinv && $dtvl) $txt .= ' value="'.$dtvl[0]['fecfininv'].'" ';
            $txt .= '>';
                       
            
            $txt .= '<input type="hidden" name="opera" value="InsAct">';
            $txt .= '<div class="cen">';
            $txt .= '<input type="submit" class="btn btn-primary" value="Insertar">';
            $txt .= '</div>';
            $txt .= '<br><br><br><br><br>';
        $txt .= '</form>';
    $txt .= '</div>';
    echo $txt; 
}

function mosdatos($conp,$nreg,$pg,$arc,$filtro,$bo){
    $minv = new minv();
    $pa = new mpagina($nreg);

    $txt = '';

    $txt .= '<div.align="center"';
       $txt .= '<table><tr>';
       $txt .= '<td>';
           $txt .= '<form name="frmfil" method="POST" action="'.$arc.'">';
       $txt .= '<input type="text" name="filtro" value="'.$filtro.'" class="form-control" placeholder="Código o Nombre" onchange="this.form-submit();" />';
$txt .= '<input type="hidden" name="pg" value="'.$pg.'"/>';
       $txt .= '</form>';
       $txt .= '</td>';
       $txt .= '<td>';
           $bo .= '<input type="hidden" name="filtro" value="'.$filtro.'"/>';
        $txt .= $pa->spag($conp,$nreg,$pg,$bo,$arc);    
        $result = $minv->selinv($filtro, $pa->rvalini(), $pa->rvalfin());
       $txt .= '</td>';
       $txt .= '</tr></table>';
    $txt .= '</div>';

    if($result){
       $txt .= '<table class="table table-hover">';
        $txt .= '<tr>';
        $txt .= '<th class="table-dark"></th>';
        $txt .= '<th class="table-dark">Inventario</th>';
        $txt .= '<th class="table-dark"></th>';
        $txt .= '</tr>';
        foreach ($result as $dv) {
        $txt .= '<tr>';
               $txt .= '<td class="table-active">';
               $txt .= '<big><strong>';
               $txt .= $dv['idinv'].'-'.$dv['iddro'].'-'.$dv['fecininv'].'-'.$dv['fecfininv'].'-'.$dv['act'];
               $txt .= '</strong></big><br>';
                 $txt .= '<small>';
                $txt .= '<strong>Drogueria: </strong>'.$dv['nomdro'];
               $txt .= '</small>';
        $txt .= '</td>';
         $txt .= '<td class="table-active">';
         $txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&idinv='.$dv['idinv'].'" onclick="return Eliminar();">';
         $txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
         $txt .= '</a>';
          $txt .= '<br><br>';
    $txt .= '<a href="'.$arc.'?pg='.$pg.' &idinv='.$dv['idinv'].'">';
         $txt .= '<i class="fas fa-edit fa-2x"></i>';
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