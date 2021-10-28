/*Monthly Progress*/

var xmlHttp;
/*    function   */
function showDscription(str)
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
var url="Monthly_progress.php";
url=url+"?aid="+str;
xmlHttp.onreadystatechange=statechangemon;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}


/*    function   */
function statechangemon() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("Progress").innerHTML=xmlHttp.responseText;
 }
 else 
 {
	 document.getElementById("Progress").innerHTML="<img src='images/ajax-loader.gif' />";
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
