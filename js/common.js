function SetCookie(name,value)//两个参数，一个是cookie的名子，一个是值
{
    var minute = 30; //此 cookie 将被保存 2 m
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
function set_empty(objID)
{
		var obj = document.getElementById(objID);
		obj.innerHTML = "";
}
function expendByName(name)
{
	document.getElementById(name).style.display=(document.getElementById(name).style.display =='none')?'':'none'
}
function chooseAnwser(id)
{
	document.getElementById(id)
}
function getFocus(id)
{
	//document.getElementById(id).style.color='orange';
	document.getElementById(id).style.background='#99CC99';
	//document.getElementById(id).style.
	//this.style.font-size='16px';
}
//监测刷新和关闭事件
window.onbeforeunload = onbeforeunload_handler;   
window.onunload = onunload_handler;   
function onbeforeunload_handler(){   
	var n = window.event.screenX - window.screenLeft;    
	var b = n > document.documentElement.scrollWidth-20;    
	if(b && window.event.clientY < 0 || window.event.altKey)    
	{    
		 alert("是关闭而非刷新");    
		 window.event.returnValue = "这里可以放置你想做的操作代码 "; //这里可以放置你想做的操作代码    
	}    

}   
//刷新时存储cookie   
function onunload_handler(){ 

	SetCookie('time',iTime); 
	/*var t = getCookie('time');
	alert("time="+t);*/
} 

//计算剩余时间
function RemainTime()
{
	var iDay,iHour,iMinute,iSecond;
	var sDay="",sHour="",sMinute="",sSecond="",sTime="";
	if (iTime >= 0)
	{
		iDay = parseInt(iTime/24/3600);
		if (iDay > 0)
		{
			sDay = iDay + "天";
		}
		iHour = parseInt((iTime/3600)%24);
		if (iHour > 0){
			sHour = iHour + "小时";
		}
		iMinute = parseInt((iTime/60)%60);
		if (iMinute > 0){
			sMinute = iMinute + "分钟";
		}
		iSecond = parseInt(iTime%60);
		if (iSecond >= 0){
			sSecond = iSecond + "秒";
		}
		if ((sDay=="")&&(sHour=="")&&iMinute<40){
			sTime="<span style='color:darkorange'>" + sMinute+sSecond + "</font>";
		}
		else
		{
			sTime=sDay+sHour+sMinute+sSecond;
		}
		if(iTime==0){
			clearTimeout(Account);
			  sTime="<span style='color:green'>时间到了！</span>";
		}
		else
		{
			Account = setTimeout("RemainTime()",1000);
		}
		iTime=iTime-1;
	}
	else
	{
			sTime="<span style='color:red'>倒计时结束！</span>";
	}
	document.getElementById(CID).innerHTML = sTime;
}

function BeginExam(ExamTime)
{
	var CID = "endtime";
	if(window.CID != null)
	{
		var iTime = getCookie('time');
		if(iTime==null)
			iTime = ExamTime;
		var Account;
		RemainTime();
	}
}