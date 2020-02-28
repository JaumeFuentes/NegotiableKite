// JavaScript Document


$(document).ready(function() {	
	$(".fancybox").fancybox({'type' : 'image'});
	document.getElementById("incluye_barra").style.display="none";
	document.getElementById("reparaciones").style.display="none";
	cambiaOpciones();
	document.getElementById("opciones_tipo").onchange = cambia;
	document.getElementsByName("reparaciones")[0].onclick = cambiaEstado;
	document.getElementsByName("estado")[0].onclick = cambiaReparaciones;
	
	document.getElementById("info_bump").onmouseover=function() {return overlib("En la búsqueda aparecerán los primeros de la lista los últimos anuncios publicados y sobre los que se haya pinchado en el botón 'bump!'. Para pinchar sobre el boton 'bump!' de tu anuncio inicia sesión,encuentra tu anuncio en los resultados de búsqueda, pincha sobre el botón 'bump!' y tu anuncio subirá al primero de la lista");}	
	document.getElementById("info_bump").onmouseout=function() {return nd();}
	$(".tabla").mouseover(function(){
										 $(this).css("background","#EDEFF4");
										 });
	$(".tabla").mouseout(function(){
										 $(this).css("background","url(layout/block_topbg.gif) repeat-x top");
										 });
	 
	 for (var i=0; i< document.forms.length; i++) {
        document.forms[i].onsubmit = function() {return validForm();}		
	}
	
	
	 
	 
	});
	

//---------------------funciones para mostrar u ocultar bloques segun elecciones---------------------


function cambiaOpciones() {
	
	var claseArticulo=document.getElementById("clasejs").name;
		
	
	if(claseArticulo != ""){
		borra_input_medida();
		//ahora pongo que cuando se selecciona una clase de art aparecen los combos comunes a TODAS las clases
		//que son marca,año,estado,provincia,titulo anuncio,descripcion,precio,duracion,imagenes.
				
		if(claseArticulo=="Cometas"){
			document.getElementById("incluye_barra").style.display="block";
			document.getElementById("reparaciones").style.display="block";
			document.getElementById("opciones_tipo").options.length = 0;
			
			var opciones_cometas = new Array("-elige tipo-","bow","C-Shape","híbrida","delta","foil","otro");			
			var numero_opciones_cometas = opciones_cometas.length;
			
			for(var i=0; i<numero_opciones_cometas;i++){
				document.getElementById("opciones_tipo").options[i] = new Option(opciones_cometas[i]);
				if(i==0)
					document.getElementById("opciones_tipo").options[i].value = "";
				else
					document.getElementById("opciones_tipo").options[i].value = opciones_cometas[i];
			}
			//allTags = document.getElementsByTagName("*");
			cambia();
		}
		
		if(claseArticulo=="Tablas"){
			document.getElementById("reparaciones").style.display="block";
			document.getElementById("opciones_tipo").options.length = 0;
			
			var opciones_tablas = new Array("-elige tipo-","twin tip","surf","race");
			var numero_opciones_tablas = opciones_tablas.length;
			
			for(var i=0; i<numero_opciones_tablas;i++){
				document.getElementById("opciones_tipo").options[i] = new Option(opciones_tablas[i]);	
				if(i==0)
					document.getElementById("opciones_tipo").options[i].value = "";
				else
					document.getElementById("opciones_tipo").options[i].value = opciones_tablas[i];
			}
		}
		
		if(claseArticulo=="Arneses"){
			
			document.getElementById("opciones_tipo").options.length = 0;
			
			var opciones_arneses = new Array("-elige tipo-","cintura","asiento");
			var numero_opciones_arneses = opciones_arneses.length;
			
			for(var i=0; i<numero_opciones_arneses;i++){
				document.getElementById("opciones_tipo").options[i] = new Option(opciones_arneses[i]);
				if(i==0)
					document.getElementById("opciones_tipo").options[i].value = "";
				else
					document.getElementById("opciones_tipo").options[i].value = opciones_arneses[i];
			}
			cambia();
		}
		
		if(claseArticulo=="Accesorios"){
			
			document.getElementById("opciones_tipo").options.length = 0;
			
			var opciones_accesorios = new Array("-elige tipo-","aletas","bolsas","hinchadores","cascos","indorboard","leash","lineas","neoprenos","pads n straps","otros");			
			var numero_opciones = opciones_accesorios.length;
			
			for(var i=0; i<numero_opciones;i++){
				document.getElementById("opciones_tipo").options[i] = new Option(opciones_accesorios[i]);
				if(i==0)
					document.getElementById("opciones_tipo").options[i].value = "";
				else
					document.getElementById("opciones_tipo").options[i].value = opciones_accesorios[i];
			}
		}
		
		if(claseArticulo=="Barras"){
			document.getElementById("opciones_tipo").options.length = 0;
			document.getElementById("tipo").style.display="none";
			
			var val=document.getElementById("modelo_input").value="";
			cambia();
			
		}
	}
}
//Función para cambiar el recuadro de medida según el tipo de artículo elegido
function cambia(){
	//document.getElementById("medida").style.display="block";
	
	
	var clase_elegida= document.getElementById("clasejs").name;
	
	if(document.getElementById("opciones_tipo").options.length > 0){
		var elemento = document.getElementById("opciones_tipo");
		var tipo_elegido= elemento.options[elemento.selectedIndex].value;
	}
	
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
	elem_input2.id="input_medida2";
	elem_input2.type="text";
	elem_input2.name="medida2";
	elem_input2.size=3;
	elem_select.id="opciones_tallas";
	elem_select.name="medida3";
	
	document.getElementById("medidadeloscojones").appendChild(contenedor);
	
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
		var tipos_tallas = new Array("-medida-","XXS","XS","S","M","L","XL","XXL");
		var numero_tipos_tallas = tipos_tallas.length;
			
			for(var i=0; i<numero_tipos_tallas;i++){
				document.getElementById("opciones_tallas").options[i] = new Option(tipos_tallas[i]);
				if(i==0)
					document.getElementById("opciones_tallas").options[i].value = "";
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








//-----------------------comprobacion de campos obligatorios completos (clase, tipo, ubicacion,titulo,descripcion, precio)//

function validForm() 
{
	var allGood = true;
	var allTags = document.getElementsByTagName("*");	
	var claseElegida = document.getElementById("clasejs").name;
	//elementoClase.options[elementoClase.selectedIndex].value
	for (var i=0; i<allTags.length; i++){	
		if(allTags[i].name=="clase" || allTags[i].name=="tipo" && claseElegida != "Barras" || allTags[i].name=="ubicacion" 
		|| allTags[i].name=="titulo" || allTags[i].name=="descripcion" || allTags[i].name=="precio" || allTags[i].name=="ano"){			
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
	if(document.getElementsByName("reparaciones")[1].checked){
		document.getElementsByName("estado")[1].checked = true;
	}
}

//Funcion para cambiar radiobutton reparaciones segun  si esta nuevo o no.
function cambiaReparaciones(){
	if(document.getElementsByName("estado")[0].checked){
		document.getElementsByName("reparaciones")[2].checked = true;
	}
}


