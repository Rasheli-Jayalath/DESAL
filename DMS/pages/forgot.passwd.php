<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$email 	= trim($_POST['email']);
	# 21232f297a57a5a743894a0e4a801fc3
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("email", _VLD_EMAIL, "E");
	$vResult = $objValidate->doValidate();

	if(!$vResult){
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->checkAdminEmailAddress();
		if($objAdminUser->totalRecords() >= 1){
			$rows = $objAdminUser->dbFetchArray(1);
			$fullname = $rows['fullname'];
			
			$newpwd = $objCommon->genPassword();
			
			$objAdminUserN = new AdminUser;
			$objAdminUserN->setProperty("user_cd", $rows['user_cd']);
			$objAdminUserN->setProperty("username", $rows['username']);
			$objAdminUserN->setProperty("passwd", $newpwd);
			$objAdminUserN->changePassword();
			
			# Send mail to customer
			$content 		= $objTemplate->getTemplate('forgot_password','EN');
			$sender_name 	= $content['sender_name'];
			$sender_email 	= $content['sender_email'];
			$subject 		= $content['template_subject'];
			$content 		= $content['template_detail'];
			
			$content		= str_replace("[USER_NAME]", $fullname, $content);
			$content		= str_replace("[USERNAME]", $rows['username'], $content);
			$content		= str_replace("[PASSWORD]", $newpwd, $content);
			
			$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
			$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
			
			$body 			= file_get_contents(TEMPLATE_URL . "template.php");
			$body			= str_replace("[BODY]", $content, $body);
			
			
			$objMail		= new Mail;
			$objMail->IsHTML(true);
			$objMail->setSender($sender_email, $sender_name);
			$objMail->AddEmbeddedImage(TEMPLATE_PATH . "logo.gif", 1, 'logo.gif');
			$objMail->setSubject($subject);
			$objMail->setReciever($email, $fullname);
			$objMail->setBody($body);
			$objMail->Send();
			$objCommon->setMessage('Your new login information has been sent to your E-mail address. Please check your mail for further details.', 'Info');
			redirect('./?forgot=forgot');
		}
		else{
			$objCommon->setMessage(_VLD_EMAIL_NOT_VALID, 'Error');
			
		}
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo LOGIN_H1;?></title>
<?php importCss("Login");?>
<?php importCss("Messages");?>
<?php echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery.min.js"></script>';?>
<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo _VLD_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		frm.email.focus();
		return false;
	}
	
}
</script>
<script type="text/javascript">
function toggleDiv(divId) {
 /*  $("#"+divId).toggle();*/
   $("#"+divId).hide(800);
/*   $("p").hide("slow");*/

}
</script>
</head>
<body onLoad="document.frmForgot.email.focus();" style="font-family:Verdana;font-size:11px;">
<div id="wrapper_MemberLogin">
<?php
				echo $objCommon->displayMessage();
				if($vResult['email']){
					echo $vResult['email'];
				}
			  ?>
	<h1><?php echo LOGIN_H2;?></h1>
	<div class="clear"></div>
	<div class="message">Please enter your username or e-mail address. You will receive a new password via e-mail.<br></div>
	<div id="forgetBox" class="borderRound borderShadow">
		 <form name="frmForgot" onsubmit="return frmValidate(this);" method="post" action="" id="frmForgot">
	  
	  	<div class="loginboxContainer borderRound borderShadow">
			<div id="username1">
			  <input size="30" name="email" type="text" id="email" value="<?php echo $_POST['email'];?>" class="userinbox"/>
			</div>
		</div>
	  <div id="userLogin">
	  <input type="button" name="cancel" id="uLogin"  value="Cancel" onClick="javascript: history.back(-1);" />
		
	    <input type="submit" name="btnSubmit"  id="uLogin" value="<?php echo _BTN_FORGOT_PWD;?>" />
		
	  </div>
	
	  <div class="clear"></div>	  
      </form>
	</div>
			<a href="./" id="forgotPass">« Back to Login</a>

</div>

</body>
</html>