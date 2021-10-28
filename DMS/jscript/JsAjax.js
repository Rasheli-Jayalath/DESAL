/**
* @filename JsAjax.js
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, Author  
* @package AJAX Collection
* @date Dec 31, 2007
**/
/* Loading script */
var strLoading = '<div style="padding:2px;color:#FF0000;"><img src="images/ajax-loader.gif" /> Loading...</div>';

/****************** AJAX GET Start **************************/
/*
* This is the function to send the request to the server
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, 
* @date Dec 31, 2007
**/
function sendGetRequest(para_url, contentDiv, divLoading){
	var url = "";
	var xmlHttp = GetXmlHttpObject();
	if(para_url.indexOf('?')) url = para_url + "&rand=" + Math.random();
	else url = para_url + "?rand=" + Math.random();
	
	xmlHttp.onreadystatechange = function(){
		afterStateChange(xmlHttp, contentDiv, divLoading);
	}
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);
}

/* This is the function to used to show the response text from server
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, 
* @date Dec 31, 2007
**/
function afterStateChange(xmlHttp, contentDiv, divLoading){ 
	if(xmlHttp.readyState < 4){
		document.getElementById(divLoading).innerHTML 	= strLoading;
		//document.getElementById(contentDiv).innerHTML = strLoading;
	}
	if(xmlHttp.readyState == 4 || xmlHttp.readyState == "complete"){
		document.getElementById(divLoading).innerHTML 	= '';
		document.getElementById(contentDiv).innerHTML 	= xmlHttp.responseText
	}
}

/*
* This is the function to create a new XML HTTP object GET Request
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, 
* @date Dec 31, 2007
**/
function GetXmlHttpObject(){
	var xmlHttp;
	try{
		/* Firefox, Opera 8.0+, Safari */
		xmlHttp = new XMLHttpRequest();
	}
	catch (e){
		/* Internet Explorer */
		try{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return xmlHttp;
}
/****************** AJAX GET End **************************/

/******************* AJAX POST Start **********************
* This is the function to send the POST request to the server
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, 
* @date Dec 31, 2007
**/
function sendPostRequest(url, param, contentDiv, divLoading){
	var HttpRequest = PostXmlHttpObject();
	if(url != ""){
		HttpRequest.onreadystatechange = function(){
			afterPostStateChange(HttpRequest, contentDiv, divLoading);
		}
	}
	HttpRequest.open('POST', url, true);
	HttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	HttpRequest.setRequestHeader("Content-length", param.length);
	HttpRequest.setRequestHeader("Connection", "close");
	HttpRequest.send(param);
}

/**
* This is the function to used to show the response text from server
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, 
* @date Dec 31, 2007
**/
function afterPostStateChange(HttpRequest, contentDiv, divLoading){ 
	if(HttpRequest.readyState < 4){
		document.getElementById(divLoading).innerHTML 	= strLoading;
		//document.getElementById(contentDiv).innerHTML = strLoading;
	}
	if(HttpRequest.readyState == 4 || HttpRequest.readyState == "complete"){
		if(HttpRequest.status == 200){
			document.getElementById(divLoading).innerHTML 	= '';
			document.getElementById(contentDiv).innerHTML 	= HttpRequest.responseText
		}
	}
}

/**
* This is the function to create new XML HTTP object for an AJAX Request
* @author 
* @version 0.1
* @copyright Copyright (c) 2007, 
* @date Dec 31, 2007
**/
function PostXmlHttpObject(){
	var HttpRequest = false;
	if(window.XMLHttpRequest){ // Mozilla, Safari,...
		HttpRequest = new XMLHttpRequest();
		if(HttpRequest.overrideMimeType){
			// set type accordingly to anticipated content type
			HttpRequest.overrideMimeType('text/html');
		}
	}
	else if(window.ActiveXObject){ // IE
		try{
			HttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e){
			try{
				HttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){}
		}
	}
	if(!HttpRequest) {
		alert('Cannot create XMLHTTP instance');
		return false;
	}
	return HttpRequest;
}
/****************** AJAX POST End **************************/

