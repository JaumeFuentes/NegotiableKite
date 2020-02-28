// JavaScript Document

window.onload = initForm;


function initForm() {
	for (var i=0; i< document.forms.length; i++) {
        document.forms[i].onsubmit = function() {return validForm();}		
	}	
	
}

function validForm(){
	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i=0; i<allTags.length; i++){	
		
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
					
					if((thisTag.name=="pw" || thisTag.name=="pw_chk") && thisTag.value.length<=5)
						classBack = "invalid ";
						
					if(thisTag.name=="pw_chk" && thisTag.value!=$("#pw").val()){
						$("#texto_pw_chk").html("la contrase&ntilde;a no coincide");
						$("#texto_pw_chk").css("color","red");
						classBack = "invalid ";
					}
					else{
						$("#texto_pw_chk").html("Introduce de nuevo la contrase&ntilde;a");
						$("#texto_pw_chk").css("color","#166D02");
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

