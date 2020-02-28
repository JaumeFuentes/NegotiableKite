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
					{
						classBack = "invalid ";
					}
					
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
			 
