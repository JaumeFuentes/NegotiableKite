derecha=false;
fin=false;
scrollando=0;
movida_cometa=false;

$(document).ready(function($){														
							//$('#logo2').mouseover(function(){scrollando=1;});						
							//window.setInterval(scroll,100);//ejecuta la funcion scroll cada 100 ms							
							colocaPie();//funcion para definir la posicion del pie de pagina		
							$(".fancybox").fancybox({'type' : 'image'});
						}						
					);


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



function scroll(){
	if(scrollando==0)
		
		return;
	else{
		if(scrollando==1 && movida_cometa!=true){
			scrollIzq();
			if(fin)
				scrollDer();
		}
	}
}
	


function scrollIzq(){
	margen=text2Num($('#logo2').css('margin-left'));
	if(margen<=0 || derecha){
		fin=true;
		return;
	}
	$('#logo2').animate(
						{"margin-left":"-=10px"},100);
	fin=false;
}

function scrollDer(){
	margen=text2Num($('#logo2').css('margin-left'));
	
	if(margen<55){
		derecha=true;
	$('#logo2').animate(
						{"margin-left":"+=5px"},100);
	}
	else{
		movida_cometa=true;		
		scrollando=0;	
		derecha=false;		
	}
}

function colocaPie(){
	altVent=$(window).height();
	altCuerpo=$("#cuerpo").height();
	//alert(altVent);
	//alert(altCuerpo);
	if(altCuerpo+105>altVent){
		$("#frame_pie").css("position","relative");
	}
	else
		$("#frame_pie").css("position","absolute");
}
			