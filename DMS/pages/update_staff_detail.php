<?php
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$flag 		= true;
	$first_name = trim($_POST['first_name']);
	$last_name 	= trim($_POST['last_name']);
	$position= trim($_POST["position"]);
	$cell_no 		= trim($_POST['cell_no']);
	$landline 		= trim($_POST['landline']);
	$email 		= trim($_POST['email']);
	$address 		= trim($_POST['address']);
	$mode 		= trim($_POST['mode']);
		
	if(empty($first_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_FIRSTNAME,'Error');
	}
	if(empty($last_name)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_LASTNAME,'Error');
	}
	if(empty($cell_no)){
		$flag 	= false;
		$objCommon->setMessage("Cell Number is required field",'Error');
	}
	if($mode=="I")
			{
	
	if(empty($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_EMAIL,'Error');
	}
	if(!$objValidate->checkEmail($email)){
		$flag 	= false;
		$objCommon->setMessage(USER_FLD_MSG_INVALID_EMAIL,'Error');
	}
	}
	if($flag != false){
	$member_cd = ($mode == "U") ? $_POST['member_cd'] : $objAdminUser->genCode("mis_tbl_staff_directory", "member_cd");
		
		$objAdminUser->resetProperty();
		$objAdminUser->setProperty("member_cd", $member_cd);
		$objAdminUser->setProperty("first_name", $first_name);
		$objAdminUser->setProperty("last_name", $last_name);
		$objAdminUser->setProperty("position", $position);
		$objAdminUser->setProperty("cell_no", $cell_no);
		$objAdminUser->setProperty("landline", $landline);
		$objAdminUser->setProperty("email", $email);
		$objAdminUser->setProperty("address", $address);
		if($objAdminUser->actStaffMember($_POST['mode'])){
			
			if($mode=="U")
			{
			$objCommon->setMessage("Staff Member updated successfully",'Update');
			$activity="Staff Member updated successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
			}
			else
			{
			$objCommon->setMessage("New Staff Member added successfully",'Info');
			$activity="Staff Member added successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
			}
			redirect('./?p=staff_dir');
		}
	}
	extract($_POST);
}
else{
if(isset($_GET['member_cd']) && !empty($_GET['member_cd']))
	{	
	 $member_cd = $_GET['member_cd'];
	if(isset($member_cd) && !empty($member_cd)){
		$objAdminUser->setProperty("member_cd", $member_cd);
		$objAdminUser->lstStaffMember();
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
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? "Manage Staff &raquo; Update Staff Memeber" : "Manage Staff &raquo; Add new Staff Memeber";?></div>
		<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=staff_dir" class="lnkButton"><?php echo "Back";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<div class="clear"></div>
	<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		
			<div class="clear"></div>			
	  	    <form name="frmProfile" id="frmProfile" action="" method="post" onSubmit="return 
			frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="member_cd" id="member_cd" value="<?php echo $member_cd;?>" />
			
			<div class="formfield b shadowWhite"><?php echo "First Name";?>:</div>
			<div class="formvalue">
			<input class="rr_input" type="text" name="first_name" id="first_name" value="<?php echo 
			$first_name;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Last Name";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="last_name" id=
			"last_name" value="<?php echo $last_name;?>" size="50"/></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Position";?>:</div>
			<div class="formvalue">
        	<input class="rr_input" type="text" name="position" id="position" value="<?php echo $position;?>" 
			style="width:200px;" /></div>
			<div class="clear"></div>
			
			<div class="formfield b shadowWhite"><?php echo "Cell No.";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="cell_no" id="cell_no" value
			="<?php echo $cell_no;?>" /></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Landline";?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="landline" id="landline" value
			="<?php echo $cell_no;?>" /></div>
			<div class="clear"></div>						
			<div class="formfield b shadowWhite"><?php echo USER_FLD_EMAIL;?>:</div>
			<div class="formvalue">
			<input class="rr_input" type="text" name="email" id="email" value="<?php echo $email;?>" 
			<?php if(isset($_GET['member_cd'])){?> readonly=""<?php } ?> style="width:200px;" /></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo "Address";?>:</div>
			<div class="formvalue"><textarea name="address" id="address"><?php echo $address;?></textarea>
			</div>
			<div class="clear"></div>	
            
			
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