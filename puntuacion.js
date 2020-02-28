// JavaScript Document
window.onload = initForm;


function initForm() {
	if(document.forms["vendedor"])
		document.forms["vendedor"].onsubmit = function() {return validForm_vendedor();}	
	if(document.forms["comprador"])
		document.forms["comprador"].onsubmit = function() {return validForm_comprador();}	
}
	
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

			 


