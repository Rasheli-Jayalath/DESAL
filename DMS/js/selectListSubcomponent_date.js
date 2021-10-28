var xmlHttp;

/*    function   */
function showDate(str)
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
var url="getSubcomponent_date.php";
url=url+"?cid="+str;
xmlHttp.onreadystatechange=stateChangedSubtarikh;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}


/*    function   */
function stateChangedSubtarikh() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("Date").innerHTML=xmlHttp.responseText;
 }
 else 
 {
	 document.getElementById("Date").innerHTML="<img src='images/ajax-loader.gif' />";
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


