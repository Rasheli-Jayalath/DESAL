var xmlHttp;

/*    function   */
function showData(str)
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
var url="getSubcomponent_data .php";
url=url+"?bid="+str;
xmlHttp.onreadystatechange=stateChangedSub;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}


/*    function   */
function stateChangedSub() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("Data1").innerHTML=xmlHttp.responseText;
 }
 else 
 {
	 document.getElementById("Data1").innerHTML="<img src='images/ajax-loader.gif' />";
 }

}

/*    function   */
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}




