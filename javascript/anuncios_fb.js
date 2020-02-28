// JavaScript Document
$(document).ready(function(){
				$(".fancybox").fancybox({'type' : 'image'});
				$(".anun_fb").mouseover(function(){
													 $(this).css("background","#EDEFF4");
													 });
				$(".anun_fb").mouseout(function(){
													 $(this).css("background","#FFFFFF");
													 });
				$(".fancybox").css("display","block");
													 
				
	 });
						   
						   
function text2Num(t){
	resultado="";
	for(i=0;i<t.length;i++){
		switch(t.charAt(i)){
			case '0':
			case '1':
			case '2':
			case '3':
			case '4':
			case '5':
			case '6':
			case '7':
			case '8':
			case '9':
			case '+':
			case '-':
			case '.':
			
			resultado +=t.charAt(i);
		}
	}
	return eval(resultado);
}

document.getElementById("text_busq_fb").onmouseover=function() {return overlib("Introducir las palabras a buscar separadas por comas. Por ejemplo: north,vegas");}	
document.getElementById("text_busq_fb").onmouseout=function() {return nd();}
document.getElementById("todos_grupos").onmouseover=function() {return overlib("Al buscar en todos los grupos disponibles puede tardar unos 30 segundos dado que hay que hacer varias conexiones a Facebook");}	
document.getElementById("todos_grupos").onmouseout=function() {return nd();}


$('#select_grupo').change(function() {
					alto_bloque1_1=text2Num($("#bloque1_1").css("height"));	
					$("#cargando_fb").css("height",alto_bloque1_1);
				    $("#cargando_fb").css("display","block");
				    return false;				 
				});
				
$('#buscar_grupos_fb input[type=submit]').click(function() {
					alto_bloque1_1=text2Num($("#bloque1_1").css("height"));	
					$("#cargando_fb").css("height",alto_bloque1_1);
				    $("#cargando_fb").css("display","block");	
				  		 			 
				});		