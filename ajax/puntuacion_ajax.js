// JavaScript Document

$(window).load(
			   function(){
				   $('#vendedor').submit(
									function(){
										var rellenado=validForm_vendedor();
										if(rellenado){
											datos="puntos_vendedor="+$("form input[name='puntos_vendedor']:checked").val()
											+"&comentario_vendedor="+encodeURIComponent($("form input[name='comentario_vendedor']").val())
											+"&votado="+$("form input[name='votado']").val()
											+"&votador="+$("form input[name='votador']").val()
											+"&nick_votado="+$("form input[name='nick_votado']").val();
											
											$.ajax({
												   url:'func_ajax_php/puntuacion_ajax.php',
												   data:datos,
												   success:function(msg){
															 $('#vendedor').html(msg);
															}
												   });												  
											
											return false;
										}
										else return false;
										
										
									}
								);
				   $('#comprador').submit(
									function(){
										var rellenado=validForm_comprador();
										if(rellenado){
											datos="puntos_comprador="+$("form input[name='puntos_comprador']:checked").val()
											+"&comentario_comprador="+encodeURIComponent($("form input[name='comentario_comprador']").val())
											+"&votado="+$("form input[name='votado']").val()
											+"&votador="+$("form input[name='votador']").val()
											+"&nick_votado="+$("form input[name='nick_votado']").val();
											
											$.ajax({
												   url:'func_ajax_php/puntuacion_ajax.php',
												   data:datos,
												   success:function(msg){
															 $('#comprador').html(msg);
															}
												   });												  
											
											return false;
										}
										else return false;
									}
								);
			   }
			  );

//-----------------------comprobacion de que se ha puntuado al vendedor //

function validForm_vendedor() 
{
	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i=0; i<allTags.length; i++){	
		if(allTags[i].name=="puntos_vendedor" ){			
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
				
				case "radio":
					if (!radioPicked (thisTag.name))
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

//-----------------------comprobacion de que se ha puntuado al comprador //

function validForm_comprador() 
{
	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i=0; i<allTags.length; i++){	
		if(allTags[i].name=="puntos_comprador" ){			
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
				
				case "radio":
					if (!radioPicked (thisTag.name))
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


function radioPicked(radioName) {
	 var radioSet = "";
	
	 for (var k=0; k<document.forms.length; k++) {
		if (!radioSet) {
		   radioSet = document.forms [k][radioName];
		}
	 }
	 if (!radioSet) return false;
	 for (k=0; k<radioSet.length; k++) {
		if (radioSet[k].checked) {
		   return true;
		}
	 }
	 return false;
}

			 


