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
<div id="wrap">
<?php include ('includes/saveurl.php');?>
<div id="wrapperPRight_log">
<div id="tableContainer_log"  style="border-left:1px;">
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo "Users Log Detail" ?></strong></div></div> 
		 <?php
        $prSQL = "select DISTINCT user_id, epname from rs_tbl_user_log where url_capture=''";
        $queryres=mysql_query($prSQL);
        $piCount = mysql_num_rows($queryres);
	
    ?> 
<table width="100%"  border="1"  align="center"  class="CSSTableGenerator" style="margin-top:60px;" >
<tr align="left" style="background-color:#666666" >
            <td width="5%" >Sr.#</td> 
            <td width="30%" >User Name</td>
			<td width="30%" >Name</td>
			<td width="35%" >Number of times login</td>
            </tr>
             
            <?
        if($piCount>0)
        {
			$i=0;
            while($abc_result=mysql_fetch_array($queryres))
            {
			$i=$i+1;
            $user_id  		= $abc_result['user_id'];
            $epname  		= $abc_result['epname'];
			$prSQL_w = "select count(user_id) as num_of_login from rs_tbl_user_log where user_id=".$user_id." and url_capture=''";
        	$queryres_w=mysql_query($prSQL_w);
        	$pres = mysql_fetch_array($queryres_w);
			$num_of_login=$pres['num_of_login'];		
			$prSQL_n = "select first_name, last_name from mis_tbl_users where user_cd=".$user_id;
        	$queryres_n=mysql_query($prSQL_n);
			$abc_result_n=mysql_fetch_array($queryres_n);
			$fullname=$abc_result_n['first_name']." ".$abc_result_n['last_name'];
            ?>
            
           <tr align="center">
            <td ><?=$i?></td>
            <td ><?=$epname?></td>
			<td ><?=$fullname?></td>
            <td ><a href="log_detail.php?uno=<?php echo $user_id; ?>" style="text-decoration:none" target="_blank"><?=$num_of_login;?></a></td>
            </tr>
				   <?
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