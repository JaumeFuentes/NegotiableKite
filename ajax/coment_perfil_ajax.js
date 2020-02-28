// JavaScript Document

$(window).load(
			   function(){
				   $('#formOpinion').submit(
									function(){
										var rellenado=validForm_coment();
										if(rellenado){
											datos="puntos="+$("form select[name='puntos']").val()
											+"&tit_coment="+$("form input[name='tit_coment']").val()
											+"&comentario="+$("#idOpinion").val().replace(/\n/g,'<br />')											
											+"&nick_votado="+$("form input[name='nick_votado']").val();
											
											$.ajax({
												   url:'func_ajax_php/coment_perfil_ajax.php',
												   data:datos,
												   success:function(msg){													
												     $('#formOpinion').slideUp('slow', function(){
														 $('#conoces_a').css('display','none');
												   	 	$('#formOpinion').html(msg);
														$('#formOpinion').slideDown('slow');														
													 });													 
												   }
											});												  
											
											return false;
										}
										else return false;
										
										
									}
								);
				   
			   }
			  );


//-----------------------comprobacion de que se ha puntuado al comprador //

function validForm_coment() 
{
	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i=0; i<allTags.length; i++){	
		if(allTags[i].name=="puntos" || allTags[i].name=="tit_coment" || allTags[i].name=="comentario" ){			
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
					if (thisTag.value == "" || thisTag.value == -1) 
					{
						classBack = "invalid ";
					}
					classBack += movida;
					break;
					
				default:
					classBack = movida;
			}
			return classBack;
		}
	}
}



			 


