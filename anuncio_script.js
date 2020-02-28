// JavaScript Document

window.onload = ejecutaFunciones;

function ejecutaFunciones(){
	$("#wrap").css("z-index",0);	
}

$(document).ready(function(){
	$(".fancybox_anuncios").fancybox({'type' : 'image'});
	$("#wrap").css("z-index",0);
	
	//document.getElementById("thumb0").onclick = cambiaImagen;	
	//document.getElementById("thumb1").onclick = cambiaImagen;
	//document.getElementById("thumb2").onclick = cambiaImagen;
	//document.getElementById("thumb3").onclick = cambiaImagen;	
	
	//Atencion esto funciona en la web negotiablekite, en localhost no porque el substring quita letras de mas!!!
	$(".cloud-zoom-gallery img").click(function(){$(".fancybox_anuncios").attr("href",this.src.substring(64))});
	//document.getElementById("info_puntuacion").onmouseover=function() {return overlib("La puntuación se indica sobre 10, siendo un 10 la puntuación máxima y 0 la puntuación mínima. Entre paréntesis se indica el número total de puntos recibidos");}	
	//document.getElementById("info_puntuacion").onmouseout=function() {return nd();}    	
	
});
/*
function cambiaImagen(){
	var direccThumb=this.src.substring(51);
	document.getElementById("detalle_image").src="imagenes/redimensionar.php?anchura=377&hmax=333&imagen="+direccThumb;		
}*/



