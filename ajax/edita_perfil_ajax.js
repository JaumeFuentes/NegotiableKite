// JavaScript Document

$(document).ready(function(){
	// Este bloque se encarga de el aparatado de fotos. Chequea que el formato es correcto
	// envia el formulario al script php correspondiente y carga la respuesta de este en el preview.	
		
		// Bloque para foto perfil 1
		var thumb1 = $('#thumb1');	
		new AjaxUpload('imageUpload1', {
			action: $('#newHotnessForm1').attr('action'),
			name: 'imagen1',
			onSubmit: function(file, extension) {				
				if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				//$('#preview1').addClass('loading');
				thumb1.attr('src', '../iconos/cargando.gif');
			},
			onComplete: function(file, response) {
				thumb1.load(function(){
					$('#preview1').removeClass('loading');
					thumb1.unbind();
				});
				thumb1.attr('src', response);
			}
		});		
		
		// Bloque para foto perfil 2
		var thumb2 = $('#thumb2');	
		var href2 = $('#href2');
		new AjaxUpload('imageUpload2', {
			action: $('#newHotnessForm2').attr('action'),
			name: 'imagen2',
			onSubmit: function(file, extension) {
				if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				//$('#preview2').addClass('loading');
				thumb2.attr('src', '../iconos/cargando.gif');
			},
			onComplete: function(file, response) {
				thumb2.load(function(){
					$('#preview2').removeClass('loading');
					thumb.unbind();
				});
				thumb2.attr('src', response);
				href2.attr('href', response);
			}
		});		
		
		// Bloque para foto perfil 3
		var thumb3 = $('#thumb3');	
		var href3 = $('#href3');
		new AjaxUpload('imageUpload3', {
			action: $('#newHotnessForm3').attr('action'),
			name: 'imagen3',
			onSubmit: function(file, extension) {
				if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				//$('#preview2').addClass('loading');
				thumb3.attr('src', '../iconos/cargando.gif');
			},
			onComplete: function(file, response) {
				thumb3.load(function(){
					$('#preview3').removeClass('loading');
					thumb.unbind();
				});
				thumb3.attr('src', response);
				href3.attr('href', response);
			}
		});		
		
		// Bloque para foto perfil 4
		var thumb4 = $('#thumb4');	
		var href4 = $('#href4');
		new AjaxUpload('imageUpload4', {
			action: $('#newHotnessForm4').attr('action'),
			name: 'imagen4',
			onSubmit: function(file, extension) {
				if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				//$('#preview2').addClass('loading');
				thumb4.attr('src', '../iconos/cargando.gif');
			},
			onComplete: function(file, response) {
				thumb4.load(function(){
					$('#preview4').removeClass('loading');
					thumb.unbind();
				});
				thumb4.attr('src', response);
				href4.attr('href', response);
			}
		});
		
		
		$("#editaPerfil").submit(function() {			
			if($("form input[name='es_tienda']").val() == 1){						
				var datos="descripcion="+$("#descripcion").val().replace(/\n/g,'<br />')
						+"&marcas="+$("form input[name='marcas']").val()
						+"&direccion="+$("form input[name='direccion']").val()
						+"&localidad="+$("form input[name='localidad']").val()
						+"&provincia="+$("form select[name='provincia']").val()
						+"&telefono="+$("form input[name='telefono']").val()
						+"&web="+$("form input[name='web']").val()
						+"&facebook="+$("form input[name='facebook']").val()
						+"&twitter="+$("form input[name='twitter']").val();	
			}
			else
				var datos="&provincia="+$("form select[name='provincia']").val()						
						+"&web="+$("form input[name='web']").val()
						+"&facebook="+$("form input[name='facebook']").val()
						+"&twitter="+$("form input[name='twitter']").val();	
			
			$.ajax({
			   url:'func_ajax_php/edita_perfil_ajax.php',
			   data:datos,
			   success:function(msg){
						 $('#respuesta2').html(msg);
						 $('#respuesta2').fadeIn(500,function(){
							  							 $('#respuesta2').fadeOut(3000)
						  							});						 
													
						}
			   });		
			return false;											
		});	
		
	
});