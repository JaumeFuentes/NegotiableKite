// JavaScript Document
$(document).ready(function(){
				//$('#boton_carga').click(
									//function(){	
											$('#carga_grupos').slideDown('slow');
											datos="";								
											$.ajax({
												   url:'func_ajax_php/afb_ajax.php',
												   data:datos,
												   success:function(msg){													  		 
															 $('#carga_grupos').html(msg);
															 $('#carga_grupos').slideUp('slow');
															}
												   });	
										//	return false;
								//	}
								//);
				
						   });

