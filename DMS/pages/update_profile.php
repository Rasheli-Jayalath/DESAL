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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table-styling.css" rel="stylesheet">



    <title>DMS</title>
</head>

<body>
<?php
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$flag 		= true;
	$first_name = trim($_POST['first_name']);
	$username= trim($_POST['username']);
	$last_name 	= trim($_POST['last_name']);
	$passwd 	= trim($_POST['passwd']);
	$email_old 	= trim($_POST['email_old']);
	$email 		= trim($_POST['email']);
	$designation= trim($_POST["designation"]);
	$phone 		= trim($_POST['phone']);
	$mode 		= trim($_POST['mode']);
	/*$designation= trim($_POST['designation']);*/
	if(isset($_POST['user_type'])&&$_POST['user_type']!="")
	 $user_type= trim($_POST['user_type']);
	
	if(empty($first_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_FIRSTNAME,'Error');
	}
	if(empty($last_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_LASTNAME,'Error');
	}
	if($mode=="I")
			{
	if(empty($username)){
		$flag 	= false;
		$objCommon->setMessage("User Name is a Required field",'Error');
	}
	if(empty($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_EMAIL,'Error');
	}
	if(!$objValidate->checkEmail($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_INVALID_EMAIL,'Error');
	}
	# Check user name should not be same.
	$sqlCN="select username from mis_tbl_users where username='$username' ";		
	$sqlrCN= $objDb->dbCon->query($sqlCN);
	if($sqlrCN->rowCount() >=1)
	{
	$flag 	= false;
			$objCommon->setMessage("User Name already exist",'Error');
	}
	# Check whether the email address is changed.
	if($email_old != $email){
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->checkAdminEmailAddress();		
		if($objAdminUser->totalRecords() >= 1){
			$flag 	= false;
			$objCommon->setMessage(USER_FLD_MSG_EXISTS_EMAIL,'Error');
		}
	}
	
	}
	if($flag != false){
		$user_cd = ($mode == "U") ? $_POST['user_cd'] : 
		$objAdminUser->genCode("mis_tbl_users", "user_cd");
		
		$objAdminUser->resetProperty();
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->setProperty("username", $username);
		$objAdminUser->setProperty("passwd", $passwd);
		$objAdminUser->setProperty("first_name", $first_name);
		/*$objAdminUser->setProperty("middle_name", $middle_name);*/
		$objAdminUser->setProperty("last_name", $last_name);
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->setProperty("phone", $phone);
		$objAdminUser->setProperty("designation", $designation);
		if($objAdminUser->user_type!=1)
		{
			$objAdminUser->setProperty("user_type", $objAdminUser->user_type);
		}
		else
		{
			
		$objAdminUser->setProperty("user_type", $user_type);
		}
		//$objAdminUser->setProperty("user_type", $user_type);
		if($objAdminUser->actAdminUser($_POST['mode'])){
			
			if($mode=="U")
			{
			$objCommon->setMessage(USER_FLD_MSG_SUCCESSFUL_UPDATE,'Update');
			$activity="User updated successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
			}
			else
			{
			
			$objCommon->setMessage("New User added successfully",'Info');
			$activity="User added successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
			}
			
				if($objAdminUser->user_type==1)
				redirect('./?p=user_mgmt');
				else
				redirect('./?p=my_profile');
				

		}
	}
	extract($_POST);
}
else{
if(isset($_GET['user_cd']) && !empty($_GET['user_cd']))
	{	
	 $user_cd = $_GET['user_cd'];
	if(isset($user_cd) && !empty($user_cd)){
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->lstAdminUser();
		$data = $objAdminUser->dbFetchArray(1);
		$mode	= "U";
		extract($data);

	}
	}
	
}
?>
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.first_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_FIRSTNAME;?>";
		flag = false;
	}

	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 20px;"><?php echo ($mode == "U") ? USER_UPDATE_BRD : USER_ADD_BRD;?></h4>
<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">
	
		<!--<div id="pageContentRight">
			<div class="menu">
				<ul>
					<li><a href="./?p=my_profile" class="lnkButton"><?php //echo "My Profile";?></a></li>				
				</ul>
				<br style="clear:left"/>
			</div>
		</div>-->
		<div class="clear"></div>
	<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		
			<div class="clear"></div>			
	  	    <form name="frmProfile" id="frmProfile" action="" method="post" onSubmit="return 
			frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="user_cd" id="user_cd" value="<?php echo $user_cd;?>" />
			
        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">First Name</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="First Name" name="first_name" id="first_name" value="<?php echo $first_name;?>" size="50">
                <!-- <label class="commontextsize">* Please avoid special characters</label> -->
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Last Name</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Last Name" name="last_name" id="last_name" value="<?php echo $last_name;?>" size="50">
                <!-- <label class="commontextsize">* Please avoid special characters</label> -->
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">User Name</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="User Name" name="username" id="username"
			 value="<?php echo $username;?>" <?php if(isset($_GET['user_cd'])){?> readonly=""<?php } ?> size="50">
                <!-- <label class="commontextsize">* Please avoid special characters</label> -->
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

		<?php if($_SESSION['user_type']==1){?>
			<div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Password</label>
            </div>
			<div class=" col-md-4" style="text-align: left; "> <input class="form-control commontextsize" placeholder="Password" type="password" name="passwd" id="passwd" 
			value="<?php echo $passwd;?>" size="50"/></div>
			
			<?php
			}
			else
			{
			?>
			<input class="rr_input" type="hidden" name="passwd" id="passwd" 
			value="<?php echo $passwd;?>" size="50"/>
			<?php
			}
			?>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">E-mail</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" placeholder="E-mail" type="hidden" name="email_old" id="email_old" value="<?php echo $email;?>">
				<input class="form-control commontextsize" placeholder="E-mail" type="text" name="email" id="email" value="<?php echo $email;?>" <?php if(isset($_GET['user_cd'])){?> readonly=""<?php } ?> style="width:200px;" />
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Designation</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Designation"  name="designation" id="designation" value="<?php echo $designation;?>" >
                <!-- <label class="commontextsize">* Please avoid special characters</label> -->
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Phone</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Phone" name="phone" id="phone" value="<?php echo $phone;?>" >
                <!-- <label class="commontextsize">* Please avoid special characters</label> -->
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">




		<?php if($objAdminUser->user_type==1&&$objAdminUser->member_cd==0)
			{?>
			
            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold"><?php echo USER_FLD_DESIGNATION;?></label>
            </div>

			<div class="btn-group col-md-4 " role="group" aria-label="Basic radio toggle button group">
			<div class="form-check" style="margin-right: 30px;">
		<input class="form-check-input" type="radio" id="user_type" name="user_type" value="1" checked="checked"/>
			    <label class="form-check-label" for="user_type">SuperAdmin</label>
				</div>
				<div class="form-check" style="margin-right: 30px;">
			  <input type="radio" class="form-check-input"
			 id="user_type" name="user_type" value="2" <?php echo ($user_type==2) ? 'checked="checked"' : "";?>/>
			 <label class="form-check-label" for="user_type">SubAdmin</label> </div>
			 <div class="form-check" style="margin-right: 30px;">
             <input type="radio" class="form-check-input"
			 id="user_type" name="user_type" value="3" <?php echo ($user_type==3) ? 'checked="checked"' : "";?>/>
			 <label class="form-check-label" for="user_type">User</label> </div>
			
			</div>
		
			<?php }
			else
			{
				?>
                 <input type="hidden" name="user_type" id="user_type" value="<?php echo $user_type;?>" />
                <?php
				
			}?>



            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        

        <div class="row">

            <div class=" regular commontextsize" style=" text-align: center; margin: auto; margin-top: 40px;">
                <button id="submit"  type="submit" class="btn btn-success"><i class="bi bi-arrow-bar-up" style="margin-right: 10px;" value="<?php echo ($mode == "U") ? " Update " : " Save ";?>"></i>Save  </button>
                <button id="submit2" type="button" class="btn btn-danger"> <a href="javascript:history.go(-1)" class="text-white" style="text-decoration: none;"><i class="bi bi-x-circle"     style="margin-right: 10px;" value="Cancel" onClick="document.location='./index.php';"   ></i>Cancel </a></button>
            </div>

        </div>

			
			<div class="clear"></div>
			
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>

</body>
</html> 