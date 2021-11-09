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
<?php
	$uno	= $_REQUEST['uno'];
  	$sSQL =  " Select count(user_id) as num_login,epname FROM rs_tbl_user_log where user_id =".$uno." and  url_capture=''";
   $sSQL1=$objDb->dbCon->query($sSQL);
  $sSQL3=  $sSQL1->fetch() ;
  $epname=$sSQL3['epname'];
  $num_login=$sSQL3['num_login'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo HOME_MAIN_TITLE?></title>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table-styling.css" rel="stylesheet">
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
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 40px;"><?php echo "Log Detail:  ".strtoupper($epname);  ?></h4>

<div id="wrapperPRight_log" class="container" style=" margin-top: 20px; margin-bottom: 50px;  ">
<div id="tableContainer_log"  >
<div id="containerContent"  class="table-responsive commontextsize">

		<div id="pageContentRight" style="margin-right:10px" class="float-end">
			<div class="menu1">
			<h6><b>Number of times login  </b><?php echo $num_login; ?> </h6>
					
				<br style="clear:left"/>
			</div>

		</div>


		<tr ><td colspan="9" align="right"></td></tr>
		
<table width="100%"   align="center"  id="customers" class="table" >
	<thead>
		<tr align="left" >
					<th  class="semibold"  width="2%" >Sr.#          </th> 
					<th  class="semibold"  width="4%" > U. ID        </th>
					<th  class="semibold"  width="10%" >User Name    </th>
					<th  class="semibold"  width="13%" >Name         </th>
					<th  class="semibold"  width="12%">Login         </th>
					<th  class="semibold"  width="13%">Log out       </th>
					<th  class="semibold"  width="12%">User IP       </th>
					<th  class="semibold"  width="13%">User PC Name  </th>
					<th  class="semibold"  width="20%" >Url Capture  </th>
		</tr>
	</thead>
             
            <?php
 		$prSQL_login = "SELECT * FROM rs_tbl_user_log where user_id=".$uno. " order by urid desc";
        $queryres=$objDb->dbCon->query($prSQL_login);
		$i=0;			
            while($abc_result= $queryres->fetch() )
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
        	$queryres_n=$objDb->dbCon->query($prSQL_n);
			$abc_result_n=  $queryres_n->fetch() ;
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
				   <?php
				  
					}
			
				?>
		   </table>

 
 </div>
 </div>
 </div>
 </div>
 </body>
</html>