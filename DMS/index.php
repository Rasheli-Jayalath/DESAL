<?php 

require_once("config/config.php");
$objCommon 		= new Common;
?>
<?php 
$objMenu 		= new Menu;
$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objManageLang 	= new ManageLang;
$objProduct 	= new Product;
$objValidate 	= new Validate;
$objOrder 		= new Order;
$objLog 		= new Log;
require_once('requires/rs_lang.admin.php');
require_once('requires/rs_lang.website.php');
require_once('requires/rs_lang.eng.php');

if($_REQUEST['lang']=="4")
{

require_once('requires/rs_lang.rus.php');
}
else
{
require_once('requires/rs_lang.eng.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>

<link href="css/style.css" rel="stylesheet">


    <title><?php echo HOME_MAIN_TITLE?></title>

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
<?php

echo '<link rel="stylesheet" type="text/css" media="all" href="'.SITE_URL.'cal-skins/aqua/theme.css" title="Aqua" />' . "\n";
echo '<link rel="shortcut icon" href="favicon.ico">' . "\n";

echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/genral_new.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery_tooltip.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/main_tooltip.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/multifile_compressed.js"></script>';

echo '<script type="text/javascript" src="' . $_CONFIG['editor_path'] . 'ckeditor/ckeditor.js"></script>';
echo '<script type="text/javascript" src="' . $_CONFIG['editor_path'] . 'ckeditor/config.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/popbox.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jqueryMain.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/leftmenu.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery.min.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery.colorbox.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery-1.9.1.js"></script>';
echo '<script type="text/javascript" src="' . SITE_URL . 'jscript/jquery-ui.js"></script>';
echo '<link rel="stylesheet" type="text/css" media="all" href="'.SITE_URL.'css/jquery-ui.css" />' . "\n";
?>

<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
  
  <script>
  $(function() {
	  var pickerOpts = {
		dateFormat:"yy-mm-dd"
	};
    $( "#start_date" ).datepicker(pickerOpts);
	$( "#end_date" ).datepicker(pickerOpts);
	$( "#pdate" ).datepicker(pickerOpts);
  });
 
  $(function() {
    $( "#activity_start_date" ).datepicker();
  });
  $(function() {
    $( "#activity_end_date" ).datepicker();
  });
  
   $(function() {
    $( "#activity_act_start_date" ).datepicker();
  });
  $(function() {
    $( "#activity_act_end_date" ).datepicker();
  });

  </script>

</head>
<body>
<div id="wrap">
<?php
    
	 if($objAdminUser->is_login == true){?>
     <?php  include 'includes/headerMainHome.php'; ?>
     <?php
	 }
   
	 if($objAdminUser->is_login == true){?>
     <?php include("includes/menu.php");
	?>
	 <div id="content"  class="container" style="margin-top: 20px; margin-bottom: 50px;"> </div>
     <?php
	 }
   ?>
   
  
  <?php  if($_GET['p'] == "logout"){
	require_once("./pages/logout.php");
}

if(isset($_GET['forgot']) && $_GET['forgot'] == "forgot"){ 
	require_once("pages/forgot.passwd.php"); 
}
else{
	if($objAdminUser->is_login == true){
		
		require_once("pages/default.php");	
    
		include ("includes/footer.php"); 
	}
	else{
		$refurl = $_SERVER['QUERY_STRING'];
		require_once("pages/login-form.php");
	}
}
?>


</div>
</body>
</html>