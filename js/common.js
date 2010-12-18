function SetCookie(name,value)//两个参数，一个是cookie的名子，一个是值
{
    var minute = 2; //此 cookie 将被保存 2 m
    var exp  = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime() + minute*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
     if(arr != null) return unescape(arr[2]); return null;

}
function delCookie(name)//删除cookie
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
function show_hidden(objID)
{
	var obj = document.getElementById(objID);
	if(obj.style.visibility == "hidden")
		obj.style.visibility = "visible";	
	else
		obj.style.visibility = "hidden";
}