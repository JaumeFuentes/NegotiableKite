$(document).ready(function(){	
	/*
	 * Funcion para añadir marcas. Cuando se se selecciona una marca del menu option
	 * si ya esta introducida sale y no hace nada. Si no esta introducida se muestra
	 * en la pantalla la marca añadida y se introduce el codigo en el input
	 */
	$("#select_marcas").change(function(){
		cod_marca = $(this).val(); //es el codigo de la marca guardado en el value del select
		input_marcas = $("#input_marcas").val(); //son los codigos de las marcas en el input los cuales estan separados por comas
		exploded = input_marcas.split(','); //se genera un vector con los distintos codigos de marca
		
		// comprobamos que el codigo de marca seleccionado no se encuentra ya en el input
		// si ya esta introducido salimos de la funcion
		for(i=0;i<=exploded.length;i++)
			if(exploded[i] == cod_marca)
				exit;
				
		// si se selecciona "añade marcas" el codigo es -1 por lo que salimos de la funcion		
		if(cod_marca == -1)
			exit;
			
		marca = $('#select_marcas option:selected').text(); //nombre de la marca en el option
		
		//añadimos la cajita con el nombre de la marca 
		$("#addMarcas").append('<div id="marca'+cod_marca+'" class="marcas2">'+marca+'<span id="deleteMarca'+cod_marca+'"class="deleteMarca">X</span></div>');
		
		// introducimos el codigo de la marca en el input
		if(input_marcas == "")
			input_marcas = cod_marca;
		else		
			input_marcas = input_marcas+","+cod_marca;
		$("#input_marcas").val(input_marcas);		
	});
	
	
	$(".des_marc").on("click",".deleteMarca",function(){
		id = $(this).attr('id');
		cod_marca = id.substr(11);
		$("#marca"+cod_marca).remove();
		var input_marcas2 = "";
		
		input_marcas = $("#input_marcas").val(); //son los codigos de las marcas en el input los cuales estan separados por comas
		exploded = input_marcas.split(','); //se genera un vector con los distintos codigos de marca
		for(i=0;i<exploded.length;i++)
			if(exploded[i] != cod_marca){	
				if(input_marcas2 == "")
					input_marcas2 = exploded[i];	
				else		
					input_marcas2 = input_marcas2+","+exploded[i];
			}	
		$("#input_marcas").val(input_marcas2);
				
	});
	
		
});