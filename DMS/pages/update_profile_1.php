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
	$sqlrCN=mysql_query($sqlCN);
	if(mysql_num_rows($sqlrCN)>=1)
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
		$objAdminUser->setProperty("user_type", $user_type);
		if($objAdminUser->actAdminUser($_POST['mode'])){
			
			if($mode=="U")
			{
			$objCommon->setMessage(USER_FLD_MSG_SUCCESSFUL_UPDATE,'Update');
			$activity="User updated successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
			}
			else
			{
			
			$objCommon->setMessage("New User added successfully",'Info');
			$activity="User added successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
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
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? USER_UPDATE_BRD : USER_ADD_BRD;?></div>
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
			
			<div class="formfield b shadowWhite"><?php echo "First Name";?>:</div>
			<div class="formvalue">
			<input class="rr_input" type="text" name="first_name" id="first_name" value="<?php echo 
			$first_name;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Last Name";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="last_name" id=
			"last_name" value="<?php echo $last_name;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "User Name";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="username" id="username"
			 value="<?php echo $username;?>" size="50" <?php if(isset($_GET['user_cd'])){?> readonly=""<?php } ?>/></div>
			<div class="clear"></div>
		<?php if($_SESSION['user_type']==1){?>
			<div class="formfield b shadowWhite"><?php echo "Password";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="passwd" id="passwd" 
			value="<?php echo $passwd;?>" size="50"/></div>
			<div class="clear"></div>
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
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_EMAIL;?>:</div>
			<div class="formvalue"><input type="hidden" name="email_old" id="email_old" value="<?php 
			echo $email;?>" />
        <input class="rr_input" type="text" name="email" id="email" value="<?php echo $email;?>" 
		<?php if(isset($_GET['user_cd'])){?> readonly=""<?php } ?> style="width:200px;" /></div>
			<div class="clear"></div>
            <div class="formfield b shadowWhite"><?php echo "Designation";?>:</div>
			<div class="formvalue">
        <input class="rr_input" type="text" name="designation" id="designation" value="<?php echo $designation;?>" 
		style="width:200px;" /></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo USER_FLD_PHONE;?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="phone" id="phone" value
			="<?php echo $phone;?>" /></div>
			<div class="clear"></div>
			<?php if($objAdminUser->user_type==1&&$objAdminUser->member_cd==0)
			{?>
			<div class="formfield b shadowWhite"><?php 
			echo USER_FLD_DESIGNATION;?>:</div>
			<div class="formvalue" style="width:400px">
		<input type="radio" id="user_type" name="user_type" value="1" checked="checked"/>
			 SuperAdmin 
			 
             <input type="radio" 
			 id="user_type" name="user_type" value="3" <?php echo ($user_type==3) ? 'checked="checked"' : "";?>/>
			User</div>
			<div class="clear"></div>
			<?php }?>
			<div id="submit">
			
			  <input type="submit" class="SubmitButton" value="<?php echo ($mode == "U") ? " Update " : " Save ";?>" /></div>
              &nbsp;
			  <div id="submit2">
            <input type="button" class="SubmitButton" value="Cancel" onClick="document.location='./index.php';" />
			</div>
			
			<div class="clear"></div>
			
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>