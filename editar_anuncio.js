// JavaScript Document
window.onload = initForm;

function initForm() {	
		
	document.getElementsByName("reparaciones")[0].onclick = cambiaEstado;
	document.getElementsByName("estado")[0].onclick = cambiaReparaciones;
	cambia();
	 
	for (var i=0; i< document.forms.length; i++) {
    	document.forms[i].onsubmit = function() {return validForm();}		
	}	 
}
	


//Función para cambiar el recuadro de medida según el tipo de artículo elegido
function cambia(){
	
	var clase_elegida= document.getElementById("clasejs").name;
	var tipo_elegido= document.getElementById("tipojs").name;
	
	if(clase_elegida=="Tablas")	
		document.getElementById("medida").className=document.getElementById("medida").className+" tablas";
			
	borra_input_medida();
	
	if(clase_elegida=="Cometas")
		crea_input_medida(1," m2","");
		
	if(tipo_elegido=="twin tip" || tipo_elegido=="race")
		crea_input_medida(2," longitud (cm)"," manga (cm)");
		
	if(tipo_elegido=="surf")
		crea_input_medida(2," pies"," pulgadas");
		
	if(clase_elegida=="Barras" || tipo_elegido=="aletas" || tipo_elegido=="bolsas")
		crea_input_medida(1," cm","");
		
	if(clase_elegida=="Arneses" || tipo_elegido=="neoprenos" || tipo_elegido=="cascos")
		crea_input_medida(0,"","");
		
	if(tipo_elegido=="lineas")
		crea_input_medida(1," mts","");
		
	if(tipo_elegido=="hinchadores" || tipo_elegido=="indorboard" || tipo_elegido=="leash" || tipo_elegido=="pads n straps" || tipo_elegido=="otros"){
		borra_input_medida();
		document.getElementById("medida").style.display="none";
	}		
}

//función para cambiar el campo de medida según el artículo.
function crea_input_medida(n_inputs,unidad1,unidad2){
	
	var medida1= document.getElementById("medida1js").name;
	var medida2= document.getElementById("medida2js").name;
	var medida3= document.getElementById("medida3js").name;
	
	var contenedor = document.createElement("span");
	var elem_input1 = document.createElement("input");
	var elem_input2 = document.createElement("input");	
	var elem_select = document.createElement("select");
	var elem_option = document.createElement("option");
	var texto1 = document.createTextNode(unidad1);
	var texto2 = document.createTextNode(unidad2);
	var espacio = document.createElement("br");
	
	contenedor.id="contenedor";
	elem_input1.id="input_medida1";
	elem_input1.type="text";
	elem_input1.name="medida1";
	elem_input1.size=3;
	elem_input1.value=medida1;
	elem_input2.id="input_medida2";
	elem_input2.type="text";
	elem_input2.name="medida2";
	elem_input2.size=3;
	elem_input2.value=medida2;
	elem_select.id="opciones_tallas";
	elem_select.name="medida3";
	
	document.getElementById("opciones_medida").appendChild(contenedor);
	
	if(n_inputs>0){
		document.getElementById("contenedor").appendChild(elem_input1);
		document.getElementById("contenedor").appendChild(texto1);
	}
	
	
	if(n_inputs==2){
		//document.getElementById("opciones_medida").appendChild(contenedor);
		document.getElementById("contenedor").appendChild(espacio);
		document.getElementById("contenedor").appendChild(elem_input2);
		document.getElementById("contenedor").appendChild(texto2);
	}
	
	if(n_inputs==0){
		
		document.getElementById("contenedor").appendChild(elem_select);
		document.getElementById("opciones_tallas").appendChild(elem_option);
		var tipos_tallas = new Array(medida3,"XXS","XS","S","M","L","XL","XXL");
		var numero_tipos_tallas = tipos_tallas.length;
			
			for(var i=0; i<numero_tipos_tallas;i++){
				document.getElementById("opciones_tallas").options[i] = new Option(tipos_tallas[i]);
				if(i==0)
					document.getElementById("opciones_tallas").options[i].value = medida3;
				else
					document.getElementById("opciones_tallas").options[i].value = tipos_tallas[i];
			}
	}
}

function borra_input_medida(){
	if(document.getElementById("contenedor")){		
		//para eliminar el elemento medida primero cremaos una variable que contenga el elemento:
		var el = document.getElementById("contenedor")
		//Obtenemos el padre de dicho elemento
		var padre = el.parentNode;
		//eliminamos el hijo el del padre
		padre.removeChild(el);
	}
}


//-----------Funciones para las imagenes--------------------------------
/*	
function actuar(peso, anchura, altura)	{
	this.peso.value = peso;
	this.ancho.value = anchura;
	this.alto.value = altura;
	
}*/

function ini()	{	
alert("hola");
	//document.forms.formu.actualizar = actuar;	
	window.frames.ver.location.href = "previsor.php";	
	//document.forms.formu.actualizar(0, 0, 0);
	
	

}

function validar(f)	{
	enviar = /\.(gif|jpg|png|ico|bmp)$/i.test(f.archivo.value);
	if (!enviar)	alert("seleccione imagen");
	return enviar;
}
/*
function limpiar()	{
	document.forms.formu.actualizar(0, 0, 0);
	f = document.getElementById("archivo");
	nuevoFile = document.createElement("input");
	nuevoFile.id = f.id;
	nuevoFile.type = "file";
	nuevoFile.name = "archivo";
	nuevoFile.value = "";
	nuevoFile.onchange = f.onchange;
	nodoPadre = f.parentNode;
	nodoSiguiente = f.nextSibling;
	nodoPadre.removeChild(f);
	(nodoSiguiente == null) ? nodoPadre.appendChild(nuevoFile):
		nodoPadre.insertBefore(nuevoFile, nodoSiguiente);
}*/

function checkear(f,num_img){	
		
	function no_prever() {			
		alert("El fichero seleccionado no es válido...");
		//limpiar();
	}
	function prever() {
		$('#'+num_img).attr('src','cargando.html');
		alert("Espera a que cargue la foto porfavor. El tiempo de carga depende de la velocidad de tu conexion");
		var campos = new Array("maxpeso", "maxalto", "maxancho");
		var accion = num_img;
		for (i = 0, total = campos.length; i < total; i ++)
			f.form[campos[i]].disabled = false;
		actionActual = f.form.action;
		targetActual = f.form.target;
		f.form.action = "previsor.php?num_imagen="+accion;
		f.form.target = accion;		
		f.form.submit();
		for (i = 0, total = campos.length; i < total; i ++)
			f.form[campos[i]].disabled = true;
		f.form.action = actionActual;
		f.form.target = targetActual;
	}
	if(	(/\.(gif|jpg|png|ico|bmp|jpeg)$/i.test(f.value)) )
		prever() 
	else
		no_prever();
}
function borrar(num_img){
	var accion = num_img;
	actionActual = document.forms[0].action;
	targetActual = document.forms[0].target;
	document.forms[0].action = "previsor.php?num_imagen_a_borrar="+accion;
	document.forms[0].target = accion;
	document.forms[0].submit();
	document.forms[0].action = actionActual;
	document.forms[0].target = targetActual;
	numero=num_img.substring(3,4);	
	$('#imagen'+numero).val('');
}

function datosImagen(peso, ancho, alto, error)	{
	function mostrar_error()	{
		enviar = false;					
		mensaje = "Ha habido un error (error nº " + error + "):";
		if (error % 2 == 1) // tipo incorrecto
			mensaje += "\nel fichero no es válido";
		error = parseInt(error / 2);
		if (error % 2 == 1) // excede en peso
			mensaje += "\nla imagen pesa mogollón (" + peso + ").";
		error = parseInt(error / 2);
		if (error % 2 == 1) // excede en anchura
			mensaje += "\nla imagen excede en anchura (" + ancho + ").";
		error = parseInt(error / 2);
		if (error % 2 == 1) // excede en altura
			mensaje += "\nla imagen excede en altura (" + alto + ").";
		error = parseInt(error / 2);
		if (error % 2 == 1) // excede en altura
			mensaje += "\nnombre de archivo muy largo (max 40 caracteres)";
		error = parseInt(error / 2);
		alert (mensaje);
		//limpiar();
	}
	if (error !== 0)
		//document.forms.formu.actualizar(peso, ancho, alto);
		
	//else
		mostrar_error();
}







//-----------------------comprobacion de campos obligatorios completos (clase, tipo, ubicacion,titulo,descripcion, precio)//

function validForm() 
{
	var allGood = true;
	var allTags = document.getElementsByTagName("*");	
	var claseElegida = document.getElementById("clasejs").name;
	//elementoClase.options[elementoClase.selectedIndex].value
	for (var i=0; i<allTags.length; i++){	
		if(allTags[i].name=="titulo" || allTags[i].name=="precio"   
		  || allTags[i].name=="descripcion" || allTags[i].name=="ano"){			
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
					if (thisTag.value == "") 
					{
						classBack = "invalid ";
					}
					classBack += movida;
					break;
				case "isNum":
					if (!isNum (thisTag.value)) 
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
//Funcion para cambiar radiobutton estado según si tiene reparaciones o no
function cambiaEstado(){
	if(document.getElementsByName("reparaciones")[0].checked){
		document.getElementsByName("estado")[1].checked = true;
	}
}

//Funcion para cambiar radiobutton reparaciones segun  si esta nuevo o no.
function cambiaReparaciones(){
	if(document.getElementsByName("estado")[0].checked){
		document.getElementsByName("reparaciones")[1].checked = true;
	}
}


