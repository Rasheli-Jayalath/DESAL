// JavaScript Document
function ManagePageValidation()
{
		var frm = document.frmManagePage;
		if(frm.txtname.value == "")
		{
			alert("Please enter page name.");
			frm.txtname.focus();
			return false;
			}
		else if(frm.txttitle.value == "")
		{
			alert("Please enter page title.");
			frm.txttitle.focus();
			return false;
			}
}
function checkedAll() 
	{
     if(document.frm1.checkall.checked)
	 	var allchecked = true;
	 else
	 	var allchecked = false;
	for (var i = 0; i < document.getElementById('frm1').elements.length; i++)
		document.getElementById('frm1').elements[i].checked = allchecked;
	}
function confirmDelete(msg)
{
	if(confirm(msg))
		return true;
	else
		return false;
}

function personalSetting()
{
	var frm = document.PersonalSetting;
	if(frm.txtfname.value == "")
	{
		alert("Please enter your first name.");
		frm.txtfname.focus();
		return false;
					
	}else if(frm.txtlname.value == "")
	{
		alert("Please enter your last name");
		frm.txtlname.focus();
		return false;
		}
var email = frm.email.value;
		var exp=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
		if (!exp.test(email))
		{
			alert("Please enter a valid Email Address.");
			frm.email.focus();
			return false;
		}
	if(frm.txtpword.value == "")
	{
		alert("Please enter your current password to change personal information.");
		frm.txtpword.focus();
		return false;
		
		}
if(frm.txtnpword.value != frm.txtcpword.value)
{
	alert("New password and confirm password missmatched.");
	return false;
	}
}//function close
