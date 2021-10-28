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
<?php
	$uno	= $_REQUEST['uno'];
  	$sSQL =  " Select count(user_id) as num_login,epname FROM rs_tbl_user_log where user_id =".$uno." and  url_capture=''";
   $sSQL1=mysql_query($sSQL);
  $sSQL3= mysql_fetch_array($sSQL1);
  $epname=$sSQL3['epname'];
  $num_login=$sSQL3['num_login'];

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
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo "Log Detail:".$epname;  ?></strong></div></div> 
		<div id="pageContentRight" style="margin-right:10px">
			<div class="menu1">
				<ul>
				<li><b>Number of times login:</b><?php echo $num_login; ?></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<tr ><td colspan="9" align="right"></td></tr>
		
<table width="100%"  border="1"  align="center"  class="CSSTableGenerator" style="margin-top:60px" >

<tr align="left" style="background-color:#666666">
              <td width="2%" >Sr.#</td> 
            <td width="5%" >User ID</td>
            <td width="10%" >User Name</td>
			<td width="13%" >Name</td>
            <td width="12%">Login </td>
            <td width="13%">Log out</td>
            <td width="12%">User IP</td>
            <td width="13%">User PC Name</td>
            <td width="20%" >Url Capture</td>
            </tr>
             
            <?php
 		$prSQL_login = "SELECT * FROM rs_tbl_user_log where user_id=".$uno. " order by urid desc";
        $queryres=mysql_query($prSQL_login);
		$i=0;			
            while($abc_result=mysql_fetch_array($queryres))
            {
			$i=$i+1;
            $user_id  		= $abc_result['user_id'];
			 $epname  		= $abc_result['epname'];
			 $logintime  	= $abc_result['logintime'];
            $logouttime  	= $abc_result['Logouttime'];
            $user_ip  		= $abc_result['user_ip'];
            $user_pcname  	= $abc_result['user_pcname'];
            $url_capture 	= $abc_result['url_capture'];
            $urid  		= $abc_result['urid'];
			$prSQL_n = "select first_name, last_name from mis_tbl_users where user_cd=".$user_id;
        	$queryres_n=mysql_query($prSQL_n);
			$abc_result_n=mysql_fetch_array($queryres_n);
			$fullname=$abc_result_n['first_name']." ".$abc_result_n['last_name'];
			
			?>
           
           <tr align="center">
            <td ><?=$i?></td>
			 <td ><?=$user_id?></td>
            <td ><?=$epname?></td>
			<td ><?=$fullname?></td>
			<td ><?=$logintime?></td>
			 <td ><?=$logouttime?></td>
            <td ><?=$user_ip?></td>
			<td ><?=$user_pcname?></td>
			<td align="left"> <? if ($url_capture=="") {echo '<span style="color: green;" /> <strong>Login Successful!! </strong> </span>';
}
			else if ($url_capture=="Logout") {echo '<span style="color: red;" /> <strong>Logout!! </strong> </span>';
}
			else if (strpos($url_capture, 'http://') === false) {echo '<span style="color:blue;" /> <strong>'.$url_capture.'</strong> </span>';
			}
 else {echo $url_capture;} ?></td>
            </tr>
				   <?
				  
					}
			
				?>
		   </table>

 
 </div>
 </div>
 </div>
 </div>
 </body>
</html>