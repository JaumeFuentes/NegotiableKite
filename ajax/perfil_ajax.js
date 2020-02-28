//ya no uso este archivo
$(window).load(
	function(){
	   $('#email').submit(
			function(){
				if($('#guarda_dato').data('dato')==true){
					$('#caja_email').fadeOut(
										500,
										function(){
											datos="mail_contacto="+encodeURIComponent($("form input[name='mail_contacto']").val())
												+"&asunto="+encodeURIComponent($("form input[name='asunto']").val())
												+"&mensaje="+encodeURIComponent($("#mensaje").val())
												+"&user="+encodeURIComponent($("form input[name='user']").val());
											$.ajax({
											   url:'func_ajax_php/perfil_ajax.php',
											   data:datos,
											   success:function(msg){
															 $('#caja_email').html(msg);
															 $('#caja_email').fadeIn(500);
														}
											});
										  }
					);
				}
				return false;
			}
		);
	   
	
	}
);
