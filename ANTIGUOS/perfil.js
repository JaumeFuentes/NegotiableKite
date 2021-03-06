// JavaScript Document
window.onload = initForm;


function initForm() {
	document.forms["email"].onsubmit = function() {return validForm();}	
	
	document.getElementById("enviado_ok_anuncio2").onmouseover=function() {return overlib("Email enviado correctamente");}	
	document.getElementById("enviado_ok_anuncio2").onmouseout=function() {return nd();}
}
	
//-----------------------comprobacion de campos obligatorios completos //

function validForm() 
{
	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i=0; i<allTags.length; i++){	
		if(allTags[i].name=="mail_contacto" || allTags[i].name=="asunto"  || allTags[i].name=="mensaje" ){			
			if (!validTag(allTags[i])) {
				allGood = false;
			}
		}
	}
	$('#guarda_dato').data('dato',allGood);	
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
				case "email":
                    if (!validEmail (thisTag.value)) 
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