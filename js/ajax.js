var xmlhttp = false;

try{
	xmlhttp = new ActiveXObject("Msxml.XMLHTTP");
	//alert("You are using Microsoft IE");
}catch(e){
	try{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		//alert ("Your are using Microsoft IE");	
	}catch(E){
		xmlhttp = false;	
	}
}

//if not the IE
if(!xmlhttp && typeof XMLHttpRequest != 'undefined'){
	xmlhttp = new XMLHttpRequest();
	//alert ("You are not using Microsoft IE");
}

function makerequest(serverPage, objID){
	var obj = document.getElementById(objID);
	xmlhttp.open("GET",serverPage);
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			obj.innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);
}