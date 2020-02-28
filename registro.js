// JavaScript Document

window.onload = initForm;


function initForm() {
	$('#box_tienda').click(function(){
		if(this.checked){
			$('#nombre_tienda').css('display','block');
		}
		else{
			$('#nombre_tienda').css('display','none');		
		}
	});
		
	$('#nick').alphanumeric();
	$('#password').alphanumeric();
	$('#passwordcheck').alphanumeric();
	for (var i=0; i< document.forms.length; i++) {
        document.forms[i].onsubmit = function() {
											formValido=validForm();
											if(formValido==true){
												datos="ubicacion="+$("form select[name='ubicacion']").val()
												+"&email="+encodeURIComponent($("form input[name='email']").val())
												+"&nick="+encodeURIComponent($("form input[name='nick']").val())
												+"&password="+encodeURIComponent($("form input[name='password']").val())
												+"&nombre_tienda="+encodeURIComponent($("form input[name='nombre_tienda']").val())
												+"&aleatorio="+$("form input[name='aleatorio']").val()
												+"&condiciones="+$("form input[name='condiciones']").val();
												$.ajax({
												   url:'func_ajax_php/registro_ajax_enviar.php',
												   data:datos,
												   success:function(msg){
															 $('#busqueda2').html(msg);
															}
												   });												  
											
												return false;
											}
											return formValido;
										}	
	
	}
	
	/*alert("ATENCION: la web se encuentra en fase de pruebas, no encontrandose el archivo correspondiente al almacenamiento de datos de registro del usuario inscrito en el registro de protección de datos. Introducir en el formulario de inscripción únicamente datos falsos. Cualquier dato proporcionado sobre vuestra persona será bajo vuestra propia responsabilidad no haciéndose responsable, el titular del dominio www.jaumefuentes.com, de estas acciones. Ale, ahi queda eso");*/
	
}

function validForm(){
	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i=0; i<allTags.length; i++){	
		//if(allTags[i].name=="clase" || allTags[i].name=="tipo" && claseElegida != "Barras" || allTags[i].name=="ubicacion" 
		//|| allTags[i].name=="titulo" || allTags[i].name=="descripcion" || allTags[i].name=="precio" || allTags[i].name=="ano")
			{			
			if (!validTag(allTags[i])) {
				allGood = false;
			}
		}
	}
	return allGood;

	function validTag(thisTag) 
	{
		var outClass = "";
		var allClasses = thisTag.className.split(" ");
			
		for (var j=0; j<allClasses.length; j++) 
		{	if(j==allClasses.length-1)
				outClass += validBasedOnClass(allClasses[j]) + "";
			else
				outClass += validBasedOnClass(allClasses[j]) + " ";
		}
	
		thisTag.className = outClass;
		//alert(outClass.indexOf("invalid"));
					
		if (outClass.indexOf("invalid") > -1) 
		{
			//thisTag.focus();
			//if (thisTag.nodeName == "INPUT") 
				return false;
		}
		return true;
		
		function validBasedOnClass(movida) 
		{
			var classBack = "";
			
			//if (thisTag.nodeName == "INPUT") 
			//alert(movida);
		
			switch(movida) 
			{
				case "":
				
				case "invalid":
					break;
				case "reqd":
					if (thisTag.value == "" || thisTag.value ==-1 ) 					
						classBack = "invalid ";	
						
					if(thisTag.name=="nick" && thisTag.value.length<=3 
					   || thisTag.name=="password" && thisTag.value.length<=5
					   || thisTag.name=="passwordcheck" && thisTag.value.length<=5)					
						classBack = "invalid ";		
						
					if(thisTag.name=="password" && thisTag.value!=$('#passwordcheck').val()){
						$('#ic').html('<span style="color:red">La contrase&ntilde;a no coincide</span>');
						classBack = "invalid ";
					}
					if(thisTag.name=="password" && thisTag.value==$('#passwordcheck').val())
						$('#ic').html('Vuelve a escribir la contrase&ntilde;a');	
					classBack += movida;
					break;
				case "isNum":
					if (!isNum (thisTag.value)) 
						classBack = "invalid ";
					classBack += movida;
					break;
				case "email":
                    if (!validEmail (thisTag.value) || $('#email_existe').val()=='true') 
						classBack = "invalid ";
					classBack += movida;
					break;
				case "email_ch":
					if (!validEmail (thisTag.value)) 
						classBack = "invalid ";
					if(thisTag.value!=$('#email').val()){
						classBack = "invalid ";
						$('#iec').html('<span style="color:red">El email no coincide</span>');
					}	
					else
						$('#iec').html
							('<span style="color:black">Vuelve a introducir la direcci&oacute;n de correo electr&oacute;nico</span>');
						
					classBack += movida;
					break;
				case "box":
					if(!checkBox(thisTag))
						classBack = "invalid ";
					classBack += movida;
					break;
				case "nick":
					if($('#nick_existe').val()=='true')
						classBack = "invalid ";
					classBack += movida;
					break;
				default:
					classBack = movida;
			}
			return classBack;
		}
	}
}

//función para comprobar que el valor introducido es un número
/*
function isNum(passedVal) {
   if (passedVal == "") {
	  return true;
   }
   for (var k=0; k<passedVal.length; k++) {
	  if (passedVal.charAt(k) < "0") {
		 return false;
	  }
	  if (passedVal.charAt(k) > "9") {
		 return false;
	  }
   }
   return true;
}
*/

function validEmail(email) {
	var invalidChars = " /:,;";

           if (email == "") {
              return false;
           }
           for (var k=0; k<invalidChars.length; k++) {
              var badChar = invalidChars. charAt(k);
              if (email.indexOf(badChar) > -1) {
                 return false;
              }
           }
           var atPos = email.indexOf("@",1);
           if (atPos == -1) {
              return false;
           }
           if (email.indexOf("@",atPos+1) != -1) {
              return false;
           }
           var periodPos = email.indexOf(".",atPos);
           if (periodPos == -1) {
              return false;
           }
           if (periodPos+3 > email.length) {
              return false;
           }
           return true;

}

//función para comprobar que se aceptan condiciones de uso

function checkBox(thisTag){	
	if(thisTag.checked){
		$("#condiciones a").css("color","#000");
		return true;
	}
	else{
		$("#condiciones a").css("color","#FF0000");
	}
		return false;
}
			 
