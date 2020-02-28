$(window).load(
			   function(){
				   $('#email').keyup(
									function(){	
											datos="email="+encodeURIComponent($("#email").val());
																						
											$.ajax({
												   url:'func_ajax_php/registro_ajax.php',
												   data:datos,
												   success:function(msg){
															 $('#im').html(msg);
															}
												   });	
											return false;
									}
								);
				   $('#nick').keyup(
									function(){
											datos="nick="+encodeURIComponent($("#nick").val());
																						
											$.ajax({
												   url:'func_ajax_php/registro_ajax.php',
												   data:datos,
												   success:function(msg){
															 $('#in').html(msg);
															}
												   });	
											return false;
									}
								);
	
			   }
			  );
