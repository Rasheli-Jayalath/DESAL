

<?php
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$flag 				= true;
	$current_password 	= trim($_POST['current_password']);
	$npassword 			= trim($_POST['npassword']);
	$cpassword 			= trim($_POST['c_password']);
	
	if(empty($current_password)){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_CURPWD,'Error');
	}
	if(empty($npassword)){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_NEWPWD,'Error');
	}
	if(empty($cpassword)){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_CNEWPWD,'Error');
	}
	if($npassword != $cpassword){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_DOESTMATCH,'Error');
	}
	$objAdminUser->setProperty("user_name", $objUser->user_name);
	$objAdminUser->setProperty("passwd", $current_password);
	$objAdminUser->lstAdminUser();
	if($objAdminUser->totalRecords() == 0){
		$flag 	= false;
		$objCommon->setMessage(CHANGEPWD_FLD_MSG_OLDPWDNOTMATCH,'Error');
	}
	if($flag != false){
		$user_cd = $_POST['user_cd'];
		$objAdminUser->resetProperty();
		$objAdminUser->setProperty("user_cd", $user_cd);
		$objAdminUser->setProperty("username", $objAdminUser->username);
		$objAdminUser->setProperty("passwd", $npassword);
		if($objAdminUser->changePassword()){
			$objCommon->setMessage('Password changed successfully.','Info');
			$activity="Password changed successfully";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
			redirect('./?p=change_password');
		}
	}
	extract($_POST);
}
else{
	$user_cd	= $objAdminUser->user_cd;
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->lstAdminUser();
	$data = $objAdminUser->dbFetchArray(1);
	$mode	= "U";
	extract($data);
}
?>
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.current_password.value == ""){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_CURPWD;?>";
		flag = false;
	}
	if(frm.npassword.value == ""){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_NEWPWD;?>";
		flag = false;
	}
	if(frm.c_password.value == ""){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_CNEWPWD;?>";
		flag = false;
	}
	if(frm.npassword.value != frm.c_password.value){
		msg = msg + "\r\n<?php echo CHANGEPWD_FLD_MSG_DOESTMATCH;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 20px;"> <?php echo CHANGEPWD_UPDATE_BRD;?> </h4>
<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">


		<div id="pageContentRight">
		
		</div>
		<div class="clear"></div>
	<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		
			<div class="clear"></div>

	  	    <form name="frmPassword" id="frmPassword" action="" method="post" onSubmit="return frmValidate(this);" class="form-inline">

            <input type="hidden" name="user_cd" id="user_cd" value="<?php echo $user_cd;?>" />

			<div class="row" >
                <div class="col-md-2">
                </div>

                    <div class="col-md-3 mobileclass" style="font-size: small; margin: auto;">
                      <label  class="sr-only semibold"> <?php echo CHANGEPWD_FLD_CPWD?> <span style="color:#FF0000;">*</span> </label>
                    </div>

                    <div class=" col-md-4 regular mobileclass2" style="font-size: small;">
                        <input class="form-control" placeholder="Current Password..." style="font-size: small;" type="password" name="current_password" id="current_password">
                     </div>   

                       <div class="col-md-3">
                       </div>
            </div>
			
			<div class="row" style="margin-top: 20px;">

                <div class="col-md-2">
                </div>

                    <div class="col-md-3 mobileclass" style="font-size: small; margin: auto;">
                      <label  class="sr-only semibold"> <?php echo CHANGEPWD_FLD_NPWD?> <span style="color:#FF0000;">*</span> </label>
                    </div>

                    <div class=" col-md-4 regular mobileclass2" style="font-size: small;">
                        <input class="form-control" placeholder="New Password..." style="font-size: small;"  type="password" name="npassword" id="npassword">
                    </div>   

                    <div class="col-md-3">
                    </div>

            </div>
			
			 <div class="row" style="margin-top: 20px;">

                <div class="col-md-2">
                </div>

                    <div class="col-md-3 mobileclass" style="font-size: small; margin: auto;">
                      <label  class="sr-only semibold"><?php echo CHANGEPWD_FLD_CNPWD?> <span style="color:#FF0000;">*</span></label>
                      </div>

                    <div class=" col-md-4 regular mobileclass2" style="font-size: small;">
                        <input class="form-control" type="text" placeholder="Confirm Password..." style="font-size: small;" type="password" name="c_password" id="c_password">
                       </div>   

                       <div class="col-md-3">
                        </div>

            </div>

			         <!-- Update Button -->
				<div class="row" style="margin-top: 20px;">

					<div class="col-md-2">
					</div>

					<div class="col-md-3">
					</div>

					<div class="col-md-4 regular" style="font-size: small;text-align: left;">
						<button id="submit"  type="submit" class="btn btn-warning mb-2" style="font-size: 13px;"  value="Save" >Update</button>
						<button id="submit2" type="button" class="btn btn-danger mb-2" style="font-size: 13px;" value=" Cancel " onclick="javascript: history.back(-1);" >Cancel</button>
					</div>   

					<div class="col-md-3">
					</div>

				</div>
			
			<div class="clear"></div>
			
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>