<?php
$objDb		= new Database;
$user_cd = $objAdminUser->user_cd;
$uname = $objAdminUser->username;
//session_name(PNAME);
//session_start();
$objAdminUser->setLogout();
$ip = $_SERVER['REMOTE_ADDR'];
 		$ipadd = $ip;
		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$nowdt1 = date("Y-m-d H:i:s");
$sSQLlogout = "INSERT INTO rs_tbl_user_log(user_id, epname, logouttime, user_ip, user_pcname,url_capture) VALUES ('$user_cd', '$uname', '$nowdt1', '$ipadd', '$hostname','Logout')";
$objDb->dbCon->query($sSQLlogout);

redirect('./');
?>