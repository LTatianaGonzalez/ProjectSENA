<?php
require_once 'modelo/conexion.php';
require_once 'modelo/mval.php';
require_once 'modelo/mpagina.php';

$pg = 307;
$arc = "home.php";
$mval = new mval();

$codval = isset($_POST['codval']) ? $_POST['codval']:NULL; 
if(!$codval)
$codval = isset($_GET['codval']) ? $_GET['codval']:NULL;
$iddom = isset($_POST['iddom']) ? $_POST['iddom']:NULL; 
$nomval = isset($_POST['nomval']) ? $_POST['nomval']:NULL; 
$parval = isset($_POST['parval']) ? $_POST['parval']:NULL; 
$iddom = isset($_POST['iddom']) ? $_POST['iddom']:NULL; 

$filtro = isset($_POST['filtro']) ? $_POST['filtro']:NULL; 
if(!$filtro)
$filtro = isset($_GET['filtro']) ? $_GET['filtro']:NULL;

$opera = isset($_POST['opera']) ? $_POST['opera']:NULL; 
if(!$opera)
$opera = isset($_GET['opera']) ? $_GET['opera']:NULL;

echo "<br><br>".$codval."-".$iddom."-".$nomval."-".$parval."-".$filtro."<br><br>";
//Insertar o Actualizar
if ($opera=="InsAct"){
    if($codval && $iddom && $nomval){
         $mval->valiu ($codval, $iddom, $nomval, $parval);
      echo "<script>alert('Datos insertados y/o Actualizados exitosamente');</script>";

    }else{
       echo "<script>alert('Falta llenar algunos campos');</script>";
    }
}

//Eliminar
if ($opera=="Elim"){
   if($codval){
    $mval->valdel ($codval);
    echo "<script>alert('Datos Eliminados exitosamente');</script>";  
    }
}

//Paginacion
$bo = "";
$nreg = 30;
$pa = new mpagina();
$preg = $pa->mpagin($nreg);
$conp = $mval->sqlcount($filtro);

function insdatos($codval,$pg,$arc){
    $mval = new mval();
    $datdom = $mval->seldom ();
    if ($codval) $dtvl = $mval->selval1 ($codval);

    $txt = '';
    $txt .= '<div class="conte">';
        $txt .= '<h2>Valor</h2>';
        $txt .= '<form name= "frm1" action="'.$arc.'?pg='.$pg.'" method="POST">';
           $txt .= '<label>Código</label>';
           $txt .= '<input type="number" name ="codval" class="form-control" value="'.$codval.'">';
            $txt .= '<label>Nombre</label>';
            $txt .= '<input type="text" name ="nomval" class="form-control" value="">';
            $txt .= '<label>Parámetro</label>';
            $txt .= '<input type="text" name ="parval" class="form-control" value="">';
            $txt .= '<label>Idominio</label>';
            if ($datdom){
                 $txt .= '<select name ="iddom" class="form-control">';
                 foreach ($datdom as $ddv) {
                  $txt .= '<option value="'.$ddv['iddom'].'">'; 
                      $txt .= $ddv['iddom']; 
                  $txt .= '</option>';
                 }
                 $txt .= '</select>';
            }
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
    $mval = new mval();
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
        $result = $mval->selval ($filtro, $pa->rvalini(), $pa->rvalfin());
       $txt .= '</td>';
       $txt .= '</tr></table>';
    $txt .= '</div>';

    if($result){
       $txt .= '<table class="table table-hover">';
        $txt .= '<tr>';
        $txt .= '<th class="table-dark"></th>';
        $txt .= '<th class="table-dark">Valor</th>';
        $txt .= '<th class="table-dark"></th>';
        $txt .= '</tr>';
        foreach ($result as $dv) {
        $txt .= '<tr>';
               $txt .= '<td class="table-active">';
               $txt .= '<big><strong>';
               $txt .= $dv['codval'].'-'.$dv['nomval'];
               $txt .= '</strong></big><br>';
                 $txt .= '<small>';
                $txt .= '<strong>Dominio: </strong>'.$dv['nomdom'];
               $txt .= '</small>';
        $txt .= '</td>';
         $txt .= '<td class="table-active">';
         $txt .= '<a href="'.$arc.'?pg='.$pg.'&opera=Elim&codval='.$dv['codval'].'" onclick="return Eliminar();">';
         $txt .= '<i class="fas fa-trash-alt fa-2x"></i>';
         $txt .= '</a>';
          $txt .= '<br><br>';
    $txt .= '<a href="'.$arc.'?pg='.$pg.' &codval='.$dv['codval'].'">';
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