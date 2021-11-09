<?php
require_once("config/config.php");
$objDb		    = new Database;
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
require_once('requires/rs_lang.admin.php');
require_once('requires/rs_lang.website.php');
require_once('requires/rs_lang.eng.php');

?>
<?php
$user_cd	= $objAdminUser->user_cd;
if($objAdminUser->is_login== false){
	header("location: index.php");
}
$user_type	= $objAdminUser->user_type;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo HOME_MAIN_TITLE?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table-styling.css" rel="stylesheet">
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

	<!---// load jQuery from the GoogleAPIs CDN //--->
	<?php /*?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script><?php */?>
</head>
<body>
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 100px;">Users Log Detail</h4>
<div id="wrap" class="container" style=" margin-top: 20px; margin-bottom: 50px;  ">
<?php include ('includes/saveurl.php');?>
<div id="wrapperPRight_log">
<div id="tableContainer_log"  style="border-left:1px;">
<div id="containerContent"  class="table-responsive commontextsize">

		 <?php
        $prSQL = "select DISTINCT user_id, epname from rs_tbl_user_log where url_capture=''";
        $queryres=$objDb->dbCon->query($prSQL);
        $piCount =  $queryres->rowCount();
	
    ?> 
	<table width="100%" id="customers" class="table"  >
		<thead>
			<tr align="left" style="background-color:#666666" >
						<th  class="semibold" width="5%" >Sr.#                   </th> 
						<th  class="semibold" width="30%" >User Name             </th>
						<th  class="semibold" width="30%" >Name                  </th>
						<th  class="semibold" width="35%" >Number of times login </th>
			</tr>
		</thead>
            <?php
        if($piCount>0)
        {
			$i=0;
            while($abc_result= $queryres->fetch() )
            {
			$i=$i+1;
            $user_id  		= $abc_result['user_id'];
            $epname  		= $abc_result['epname'];
			$prSQL_w = "select count(user_id) as num_of_login from rs_tbl_user_log where user_id=".$user_id." and url_capture=''";
        	$queryres_w=$objDb->dbCon->query($prSQL_w);
        	$pres =  $queryres_w->fetch() ; 
			$num_of_login=$pres['num_of_login'];		
			$prSQL_n = "select first_name, last_name from mis_tbl_users where user_cd=".$user_id;
        	$queryres_n=$objDb->dbCon->query($prSQL_n);
			$abc_result_n= $queryres_n->fetch() ; 
			$fullname=$abc_result_n['first_name']." ".$abc_result_n['last_name'];
            ?>
            
           <tr align="center">
            <td ><?=$i?></td>
            <td ><?=$epname?></td>
			<td ><?=$fullname?></td>
            <td ><a href="log_detail.php?uno=<?php echo $user_id; ?>" style="text-decoration:none" target="_blank"><?=$num_of_login;?></a></td>
            </tr>
				   <?php
					}
				}
				?>
		   </table>

 
 </div>
 </div>
 </div>
 </div>
 </body>
</html>