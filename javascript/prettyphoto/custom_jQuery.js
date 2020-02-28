$(document).ready(function(){	
	$("a[rel^='prettyPhoto']").prettyPhoto({		
		theme: 'light_rounded' /* light_rounded / dark_rounded / light_square / dark_square / facebook */	});	
	//$("#eng_flag").click(function(){
		//$("#content").slideUp("slow");
		//return false;
		//alert("hola");
	//});
});
		
function checkWindowSize() {		
	if ( $(window).height() < 620 ) {		
		$('#contenedor').removeClass('fixed');	}	
	else {		$('#contenedor').addClass('fixed');	}	
}

$(window).resize(checkWindowSize);	

jQuery(document).ready(function(){
	$('#contactform').submit(function(){	
		var action = $(this).attr('action');			
		$('#submit').before('<img src="/images/ajax-loader.gif" class="loader" />').attr('disabled','disabled');	
		$.post(action, { name: $('#name').val(),email: $('#email').val(),message: $('#message').val()},
			function(data){	
				$('#contactform #submit').attr('disabled','');			
				$('.response').remove();			
				$('#contactform').before('<span class="response">'+data+'</span>');			
				$('.response').fadeIn('fast');			
				$('#contactform img.loader').fadeOut(500,function(){$(this).remove()});			
				if(data=='Mensaje Enviado!') 
					$('#contactform').slideUp(3000,
						function(){
							$('.form_contacto').
							html('<span style="color:#666; font-size:14px; font-family:Arial Black;">GRACIAS POR CONTACTAR CON NOSOTROS,<br/>EN BREVE NOS PONDREMOS EN CONTACTO CONTIGO</span><br/><br/><span style="color:#666;">Buen Viento!</span>')
						}
					);		
			}	
		);	
		return false;
	});	
	checkWindowSize()	
});

