<?php
$objDb		= new Database;
if($_SERVER['REQUEST_METHOD'] == "POST"){
	 $username 	= trim($_POST['username']);
	 $passwd 	= trim($_POST['password']);
	//$user_type	= trim($_POST['user_type']);
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("username", LOGIN_FLD_VAL_USERNAME, "S");
	$objValidate->setCheckField("password", LOGIN_FLD_VAL_PASSWD, "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$objAdminUser->setProperty("username", $username);
//		$objAdminUser->setProperty("passwd", md5($passwd));
		$objAdminUser->setProperty("passwd", $passwd);
		
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){
			
		//$objAdminUser->setProperty("user_type", $user_type);
		$objAdminUser->lstAdminUser();
		if($objAdminUser->totalRecords() >= 1){
			$rows = $objAdminUser->dbFetchArray(1);
			$fullname = $rows['first_name'] . " " . $rows['last_name'];
			$objAdminUser->setProperty("user_cd", $rows['user_cd']);
			$objAdminUser->setProperty("username", $rows['username']);
			$objAdminUser->setProperty("fullname_name", $fullname);
			$objAdminUser->setProperty("user_type", $rows['user_type']);
			$log_time= date('Y-m-d H:i:s');
			$objAdminUser->setProperty("logged_in_time", date('Y-m-d H:i:s'));
			$objAdminUser->setProperty("member_cd", $rows['member_cd']);
			$objAdminUser->setProperty("designation", $rows['designation']);
			$objAdminUser->setAdminLogin();
		/***** Log Entry *****/
		
			$ip = $_SERVER['REMOTE_ADDR'];
			$ipadd = $ip;
			$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$nowdt = date("Y-m-d H:i:s");
			$sSQLlog = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname) VALUES ('$rows[user_cd]', '$rows[username]', '$nowdt', '$ipadd', '$hostname')";
			$idres=$objDb->dbCon->query($sSQLlog);
			//$urid=$idres->lastInsertId();
			//$_SESSION['urid']=$urid;
		
		/*
		 //$this->dbCon->$sSQLlog->query();
			 //echo "test";
			echo $urid=$this->dbCon->lastInsertId();
			$_SESSION['urid']=$urid;*/
	/*	$log_desc 	= "User <strong>" . $fullname . "</strong> is login at.". $log_time;
			$log_module = "Login";
			$log_title 	= "User Login";
			doLog($log_module, $log_title, $log_desc,$rows['user_cd']);*/
				if(isset($_SERVER["REQUEST_URI"]))
			{
			$url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			header("location:".$url);
			}
			else
			{
			header("location: index.php");
			}
			
		}
		else
		{
			$objCommon->setMessage("Invalid User Accesss Rights! Please try again", 'Error');
		}
		}
		else{
			$objCommon->setMessage(LOGIN_FLD_INVALID, 'Error');
		}
	}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/loginstyle.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>DMS</title>
</head>
<body >

<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.username.value == ""){
		msg = msg + "\r\n<?php echo LOGIN_FLD_VAL_USERNAME;?>";
		flag = false;
	}
	if(frm.password.value == ""){
		msg = msg + "\r\n<?php echo LOGIN_FLD_VAL_PASSWD;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
	
}
</script>
<script type="text/javascript">
function toggleDiv(divId) {
   $("#"+divId).hide(800);
}
</script>




<div class="wrapper" style="   position:absolute;" >

<div class="container" style="margin-top: 30px; margin-bottom: 30px;">

	<div class="row">

		<div  style="text-align: center; margin: auto;">
			<a class="navbar-brand" href="#"><img src="img/smec-logo-white.png" height="70px" alt="smec logo"></a>
		</div>

		</div>
   
	<div class="row" style="margin-top: 25px;">

		<div style="text-align: center;margin: auto;">
			<h3 class="semibold" style="color: #fff;">DOCUMENT MANAGEMENT SYSTEM</h3>
		
		</div>
	</div>
</div>

<?php echo $objCommon->displayMessage();?>      
	<form name="frmlogin" onsubmit="return frmValidate(this);" method="post" action="" class="login" >


<p class="title">	<?php echo LOGIN_H1;?></p>
  <input name="username" id="username" type="text" placeholder="Username" style="font-size: 13px;"  value="<?php echo $_POST['username'];?>" autofocus/>
  <input type="password" placeholder="Password" style="font-size: 13px;" name="password" id="password" />
  <a href="#">Forgot your password?</a><br><br>

  

  <div style="text-align: center;" id="userLogin"> 
	<button class="btn btn-warning" name="Submit" type="submit" value="<?php echo LOGIN_BTN_LOGIN;?>" id="uLogin" > Log in</button>
  </div>


 
</form>
<footer><a target="blank" href="https://www.smec.com/en_lk">Developed by SJ-SMEC © 2021</a></footer>
</p>
</div>

</body>
</html>