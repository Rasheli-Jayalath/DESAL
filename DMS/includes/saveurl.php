
<?php
$objDbs		= new Database;

$uid = $objAdminUser->user_cd;
$nameuser = $objAdminUser->username;
$urid = $_SESSION['urid'];


$ip = $_SERVER['REMOTE_ADDR'];
$ipadd = $ip;
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$nowdt = date("Y-m-d H:i:s");

function current_url(){
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$validURL = str_replace ("&","&amp;",$url);
Return $validURL;
}
$fullurl = current_url();
//echo "Page URL is :  ".$fullurl;

$sSQLlog = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname', '$fullurl')";
$objDbs->dbCon->query($sSQLlog);
	?>
