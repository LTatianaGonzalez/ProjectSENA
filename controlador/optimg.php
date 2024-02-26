<?php
function opti($pict, $nomimg, $rut, $pre){
	ini_set('memory_limit', '512M');
	$nombre = '';
	if($pict){
		$max_ancho = 1024;
		$max_alto = 800;
		$docext = pathinfo($pict["name"], PATHINFO_EXTENSION);
		if($docext=="png" or $docext=="jpg" or $docext=="jpeg" or $docext=="jfif"){
			$medidasimagen = getimagesize($pict['tmp_name']);
			//echo $medidasimagen[0]."-".$pict['size'];
			if($medidasimagen[0]<=$max_ancho && $pict['size']<1048576){
				$nombre = $rut.'/'.$nomimg."_".$pre.".".$docext;
				move_uploaded_file($pict['tmp_name'], $nombre);
			}else{
				$nombre = $rut.'/'.$nomimg."_".$pre.".".$docext;
				$rtOriginal=$pict['tmp_name'];
				if($pict['type']=='image/jpeg'){
					$original = imagecreatefromjpeg($rtOriginal);
				}else if($pict['type']=='image/png'){
					$original = imagecreatefrompng($rtOriginal);
				}else if($pict['type']=='image/gif'){
					$original = imagecreatefromgif($rtOriginal);
				}
				list($ancho,$alto)=getimagesize($rtOriginal);
				$x_ratio = $max_ancho / $ancho;
				$y_ratio = $max_alto / $alto;
				if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
	    			$ancho_final = $ancho;
	    			$alto_final = $alto;
				}elseif (($x_ratio * $alto) < $max_alto){
	    			$alto_final = ceil($x_ratio * $alto);
	    			$ancho_final = $max_ancho;
				}else{
	    			$ancho_final = ceil($y_ratio * $ancho);
	    			$alto_final = $max_alto;
				}
				$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 
				imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	 			$cal=8;
	 			if($pict['type']=='image/jpeg'){
					imagejpeg($lienzo,$nombre);
				}else if($pict['type']=='image/png'){
					imagepng($lienzo,$nombre);
				}else if($pict['type']=='image/gif'){
					imagegif($lienzo,$nombre);
				}
			}
		}elseif ($docext=="mp4" or $docext=="mov" or $docext=="avi") {
			echo $pict['name']."-".$pict['tmp_name']."-".$pict['size'];
			if($pict['size']<100741824){
				$nombre = $rut.'/'."Vid_".$nomimg.".".$docext;
				move_uploaded_file($pict['tmp_name'], $nombre);
			}else{
				echo "<script>alert('Los archivos de video debe tener un peso maximo de 97Mb');</script>";
			}	
		}else{
			echo "<script>alert('Solo se permiten archivos de extensiones: png, jpg, jpeg, mp4, mov, avi.');</script>";
		}
	}
	return $nombre;
}
?>