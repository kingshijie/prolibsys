function getxmlhttp(){
	var xmlhttp = false;
	
	try{
		xmlhttp = new ActiveXObject("Msxml.XMLHTTP");
	}catch(e){
		try{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;	
		}
	}
	
	//if not the IE
	if(!xmlhttp && typeof XMLHttpRequest != 'undefined'){
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function makerequest(serverPage, objID){
	var xmlhttp = getxmlhttp();
	var obj = document.getElementById(objID);
	xmlhttp.open("GET",serverPage);
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			obj.innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);
}

//用来处理XMLHttpRequest的函数
function processajax(serverPage, obj, getOrPost, str){
	//获取一个XMLHTTPREQUEST对象
	xmlhttp = getxmlhttp();
	if (getOrPost == "get"){
		xmlhttp.open("GET",serverPage);
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				obj.innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.send(null);
	}else{
		xmlhttp.open("POST",serverPage,true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				obj.innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.send(str);
	}
}

//用来提交表单的函数
function getformvalues(fobj,valfunc){
	var str = "";
	aok = true;
	var val;
	//遍历包含表单中所有对象的列表
	for(var i = 0; i< fobj.elements.length; i++){
		if(valfunc){
			if (aok == true){
				val = valfunc(fobj.elements[i].value,fobj.elements[i].name);
				if(val == false){
					aok = false;	
				}	
			}	
		}	
		if(fobj.elements[i].type != "radio" && fobj.elements[i].type != "checkbox")
			str += fobj.elements[i].name + "=" + fobj.elements[i].value + "&";
		else if(fobj.elements[i].checked)
			str += fobj.elements[i].name + "=" + fobj.elements[i].value + "&";
			
	}
	return str;
}

function submitform (theform, serverPage, objID, valfunc){
	var file = serverPage;
	var str = getformvalues(theform,valfunc);
	//如果验证成功
	if (aok == true){
		obj = document.getElementById(objID);
		processajax(serverPage, obj, "post", str);	
	}	
}