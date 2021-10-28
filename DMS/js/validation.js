
function validEmail(field, txt){
	var a = document.getElementById(field);
	var str = a.value;
	var patt= /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/;
	var check = patt.test(str);	
	if(check){
		return false;
	}else{
		showErrorMesasge(txt);
		a.focus();
		a.select();
		return true;
	}
}

function checkPassword(field){
	var a = document.getElementById(field)
	var pass = a.value
	var length = pass.length;
	var patetn = /\W/g;
	var ans = patetn.test(pass);
	if(length < 7)
	{
		showErrorMesasge("Password must be greater than or equal to 8 Characters");
		a.focus();
		a.select();
		return true
	}
	
	else if(ans == true)
	{
		showErrorMesasge("Password Should be Alphanumeric. No Sysmbols and Spcaes are allowed in Password");
		a.focus();
		a.select();
		return true
	}
}

function checkImage(field, txt){
	var comp = document.getElementById(field);
	if(comp.disabled == false){
		if(comp.value == ""){
			showErrorMesasge(txt);
			comp.focus();		
			return true;	
		}
	}
}

function validFile(fileName, fileTypes, txt) {
	var comp = document.getElementById(fileName);
	var a = comp.value;
	dots = a.split(".")
	fileType = "." + dots[dots.length-1];
	if(fileTypes.join(".").indexOf(fileType) != -1) 
	{ 
		// if value Matches with given inputs
		return false;
	}else{
		// Wrong File
		comp.focus();
		showErrorMesasge(txt);
		return true;
	}
}

function checkEmpty(field, txt){
	var comp = document.getElementById(field);
	if(comp.value == ""){
		showErrorMesasge(txt);
		comp.focus();		
		return true;		
	}else{
		return false;
	}
}

function showErrorMesasge(txt){
	var div = document.getElementById('error');
	div.style.display='block';
	//var msg = document.getElementById('error_message');
	//alert(msg);
	div.innerHTML = txt;		
}

function clearMessage(){
	var div = document.getElementById('error');
	div.style.display='none';
//	var div2 = document.getElementById('msg');
//	div2.style.display='none';

}

function isAnySpace(field, txt){
	var a = document.getElementById(field);
	var str = a.value;
	var patt= /\s/;
	var check = patt.test(str);	
	if(!check){
		return false;
	}else{
		showErrorMesasge(txt);
		a.focus();
		a.select();
		return true;
	}
}

function checkSelectBox(field, txt){
	var a = document.getElementById(field);
	var dropdownIndex = a.selectedIndex;
	if(dropdownIndex == 0){
		showErrorMesasge(txt);
		return true;
		
	}else{
		return false;
	}
}
function checkNumber(field,txt)
{

	var a = document.getElementById(field);
	var str = a.value;
	if(str != "")
	{
	var patt= /\D/;
	var check = patt.test(str);	
	if(!check){
		return false;
	}else{
		showErrorMesasge(txt);
		a.focus();
		a.select();
		return true;
	}
	}
	else 
	{
		return false;
		}
}
