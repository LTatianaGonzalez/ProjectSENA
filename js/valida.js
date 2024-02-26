$(document).ready(function() {
    $('#example').DataTable();
} );

function solonum(e){
    key=e.keyCode || e.which;
    teclado=String.fromCharCode(key);
    numeros="0123456789";
    var especiales=["8","45"];
    teclado_especial=false;
    for(var i in especiales){
        if(key==especiales[i]){
            teclado_especial=true;
        }
    }
    if(numeros.indexOf(teclado)==-1 && !teclado_especial ){
        return false;
    }
}
function sololet(f){
    key=f.keyCode || f.which;
    teclado=String.fromCharCode(key);
    letras=" abcdefghijklmnñopqrstuvwxyzáéíóú"+" ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ";
    especiales="8-37-38-46";
    teclado_especial=false;
    for(var u in especiales){
        if(key==especiales[u]){
            teclado_especial=true;break;
        }
    }
    if(letras.indexOf(teclado)==-1 && !teclado_especial ){
        return false;
    }
}
function eliminar(){
	var v = confirm("¿Está seguro de eliminar este registro?");
	return v;
}

function ocultar(nu,alto){
    if(nu==1){
    	document.getElementById("inser").style.position = "relative";
        document.getElementById("inser").style.width = "100%";
        document.getElementById("inser").style.height = alto;
        document.getElementById("inser").style.transition = "all 1s";
        document.getElementById("inser").style.opacity = "1";
        document.getElementById("inser").style.left = "0px";
        document.getElementById("ocu").style.display = "block";
        document.getElementById("mos").style.display = "none";
    }else{
    	document.getElementById("inser").style.position = "absolute";
    	document.getElementById("inser").style.width = "0px";
    	document.getElementById("inser").style.height = alto;
    	document.getElementById("inser").style.transition = "all 2s";
    	document.getElementById("inser").style.opacity = "0";
    	document.getElementById("inser").style.left = "-1000px";
    	document.getElementById("ocu").style.display = "none";
        document.getElementById("mos").style.display = "block";
        window.scroll(0,0);
    }
}
function recCiudad(value){
	//alert("Si le llega "+value);
	var parametros ={
		"valor" : value,
	};
	$.ajax({
		data: parametros,
		url: 'selmun.php',
		type: 'post',
		success: function(response){
			$("#reloadMun").html(response);
		}

	});
}