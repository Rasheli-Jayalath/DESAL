<?php 
require_once("config/config.php");
$objCommon 		= new Common;
$objMenu 		= new Menu;
//$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
//$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
//$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
require_once('rs_lang.website.php');
require_once('rs_lang.eng.php');
?><?php 
$user_cd	= $objAdminUser->user_cd;
if($objAdminUser->is_login== false){
	header("location: index.php");
}?>
<?php include ('includes/saveurl.php');?>
<?php

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['send_email'])){
	$file_send_from = trim($_POST['file_send_from']);
	$from_name = trim($_POST['from_name']);
	$file_send_to 	= trim($_POST['file_send_to']);	
	$report_title= trim($_POST['report_title']);
	$report_file= trim($_POST['report_file']);
	$email_title=EMAIL_TITLE;
	$path="project_reports/".$report_file; 
	//include_once "PHPMailer-6.0.1/src/sendemail1.php";
	include_once "phpmailer1/sendemail1.php";
//$email		= "tahiramkw@gmail.com";
	$subject = $report_title;
//$to = $email;
//$cc = "tahira.najeeb@egcpakistan.com";
	$message = "Hi, <br/>Please find attached file.<br/><b> Regards, </b><br/> ".$from_name."<br/>".$file_send_from."<br/>".$email_title;
 sendemail($subject,$message,$file_send_from,$file_send_to,$path,$report_file,$email_title);
	
	}

?>
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.category_name.value == ""){
		msg = msg + "\r\n<?php echo PRD_FLD_MSG_CATNAME;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo HOME_MAIN_TITLE?></title>
<head>

<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="menu/chromestyle.css"/>
<?php 
# JS file
importJs("Menu");
importJs("Common");
importJs("Ajax");
importJs("Calendar");
importJs("Lang-EN");
importJs("ShowCalendar");?>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<?php importCss("Login");?>
<?php importCss("Messages");
if($objAdminUser->is_login == true){
	importCss("PjStyles");
}?>


	<script type='text/javascript'>
			function refreshpage()
			{	
				window.opener.location.reload();
				<?php if(isset($_SESSION['ptest'])){?>
				self.close();
				<?php
				unset($_SESSION['ptest']);
				}
				
				?>
				
			}
	</script>
	<script language="javascript" type="text/javascript">
function frmValidate1(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;

	if(frm.file_send_to.value=="")
	{
	msg = msg + "\r\n<?php echo "Please enter atleast one email id";?>";
	flag = false;
	}	
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
</head>
<body onLoad="refreshpage()">
    <?php echo $objCommon->displayMessage();?>
<div id="wrapperPRight">


<?php
 $user_query="Select first_name,last_name,email from mis_tbl_users where user_cd=". $user_cd;
$user_query1=mysql_query($user_query);
$user_res=mysql_fetch_array($user_query1);
$from_email= $user_res['email'];
$from_name= $user_res['first_name']." ".$user_res['last_name'] ;



if(isset($_GET['report_id']))
{
$report_id= $_GET['report_id'];

 $messl="Select * from rs_tbl_documents where report_id=". $report_id;
$res_messl=mysql_query($messl);
$res_mess=mysql_fetch_array($res_messl);
$report_title= $res_mess['report_title'];
$report_file= $res_mess['report_file'];
			?>
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo "Send Email"?></strong></div></div>
         
		
		<div class="clear"></div>
				<form name="frmCategory" id="frmCategory" action="" method="post" onSubmit="return frmValidate1(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="category_cd" id="category_cd" value="<?php echo $category_cd;?>" />
        <input type="hidden" name="parent_cd" id="parent_cd" value="<?php echo $parent_cd;?>" />
         <input type="hidden" name="cid" id="cid" value="<?php echo $_REQUEST["cid"];?>" />
         <div id="tableContainer" class="table" style="border-left:1px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr><td >
	    To <span style="color:#FF0000;">*</span>:		
        </td>
        <td>
        <div class="frmElement">
		<input type="hidden" id="file_send_from" name="file_send_from" value="<?php echo $from_email; ?>"/>
		<input type="hidden" id="from_name" name="from_name" value="<?php echo $from_name; ?>"/>
		<input type="text" id="file_send_to" name="file_send_to" value=""  style="width:700px" />&nbsp;comma separated email ids</div>
		</td>
        </tr>		
   <tr><td >
	    Subject <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input type="text" id="report_title" name="report_title" value="<?php echo $report_title;?>"  style="width:700px"  readonly=""/></div>
		</td>
        </tr>
		<tr>		
		<td >
	    Attachments <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><table>
		
 <input type="hidden" name="report_file" id="report_file" value="<?php echo $report_file; ?>" />
		<tr>
		
		<td><a href="<?php echo "project_reports/".$report_file;?>" target="_blank"><?php echo $report_file?></a></td>
		</tr>
		
		</table></div>
		
		</td>
        </tr>
		<tr >
		<td colspan="2" align="center">
		<div id="div_button">
			<input type="submit" id="send_email" name="send_email"  class="rr_button" value="<?php echo "Send";?>" />
		</div>
		</td>
		</tr>
        </table>
      
      </div>
	  
	</form>
	</div> 
<?php
}
?>
</div>

</body>
</html>
        