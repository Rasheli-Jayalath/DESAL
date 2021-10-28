var xmlHttp;

/*    function   */
function showActivity(str)
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
var url="getActivity.php";
url=url+"?s_id="+str;
xmlHttp.onreadystatechange=stateChangedactivity;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}


/*    function   */
function stateChangedactivity() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("Action").innerHTML=xmlHttp.responseText;
 }
 else 
 {
	 document.getElementById("Action").innerHTML="<img src='images/ajax-loader.gif' />";
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


