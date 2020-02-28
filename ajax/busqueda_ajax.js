

$(window).load(
	function(){		
		var i;
		var numElem;
		var claseArticulo=document.getElementById("clasejs").name;
		var numElem = $('.tabla').size();
		
		
	   $('.bump').submit(
			function(){
				
				
				bump=$(this).attr('id'); 				
				tabla='tabla'+bump.substring(4,5);
				posicion_elem=$('#'+tabla).position();				
				posicion_arriba=$('#tabla0').position();
				
				
					
				$('#'+tabla).css({				   
				   "position": "absolute",				  
				   "top": posicion_elem.top,
				   "left": posicion_elem.left
				}) 
				
				
				$('#pagi_navegacion').fadeOut(200);
				$(this).fadeOut(800);
				
				for(i=0;i<=numElem;i++){
					if(i!=bump.substring(4,5))
						//$('#tabla'+i).fadeOut(500);
						$('#tabla'+i).addClass('borra');						
				}
				
				if(numElem>1){
					$('.tabla.borra').fadeOut(800,
											 function(){
												 datos="clase="+claseArticulo
												+"&codan="+$("form#"+bump+" input[name='codan']").val();																
												$.ajax({
												   url:'func_ajax_php/busqueda_ajax.php',
												   data:datos,
												   success:function(msg){
													$('#'+tabla).animate({"top": posicion_arriba.top}, 700,
														function(){
															$('#contenedor_anuncios').html(msg);
															$('#pagi_navegacion').fadeIn(500);
														});
													}
												});//cierro ajax
					});
				}
				if(numElem==1){
					datos="clase="+claseArticulo
											+"&codan="+$("form#"+bump+" input[name='codan']").val();																
											$.ajax({
											   url:'func_ajax_php/busqueda_ajax.php',
											   data:datos,
											   success:function(msg){
											   	$('#'+tabla).animate({"top": posicion_arriba.top}, 700,
													function(){
											   			$('#contenedor_anuncios').html(msg);
													});
												}
											});//cierro ajax
				}
										 
											  				
											 
															
				
														
															
										return false;
										});//cierro clik
				
	   
	
	});//cierro load
