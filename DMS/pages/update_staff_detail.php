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
	//if(!$objValidate->checkEmail($email)){
	//	$flag 	= false;
	//	$objCommon->setMessage(USER_FLD_MSG_INVALID_EMAIL,'Error');
	//}    and inside email input  if(isset($_GET['member_cd'])){ readonly="" } 
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
	$objDb->dbCon->query($sSQLlog_log);		
			}
			else
			{
			$objCommon->setMessage("New Staff Member added successfully",'Info');
			$activity="Staff Member added successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
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

<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 20px;">
      <?php echo ($mode == "U") ? "Manage Staff &raquo; Update Staff Memeber" : "Manage Staff &raquo; Add new Staff Memeber";?>
</h4>

<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">

		<div id="pageContentRight">
				<p style="text-align:right; margin-right:10px; font-weight:bold"><a href="./?p=staff_dir" class="btn btn-primary" style="text-decoration: none;">  <i class="bi bi-chevron-double-left"></i> Back </a>	</p>
		</div>

		<div class="clear"></div>
	<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		<div class="NoteTxt"><?php echo _NOTE;?></div>
		<div id="tableContainer">
		
			<div class="clear"></div>			
	  	    <form name="frmProfile" id="frmProfile" action="" method="post" class="form-inline" onSubmit="return  
			frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="member_cd" id="member_cd" value="<?php echo $member_cd;?>" />
			

		 <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">First Name</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="First Name" name="first_name" id="first_name" value="<?php echo 
			$first_name;?>" size="50">
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>
        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Last Name</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Last Name" name="last_name" id=
			"last_name" value="<?php echo $last_name;?>" size="50">
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Position</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Position" name="position" id="position" value="<?php echo $position;?>" >
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Cell No</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Cell No" name="cell_no" id="cell_no" value
			="<?php echo $cell_no;?>" >
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Landline</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Landline" name="landline" id="landline" value
			="<?php echo $landline;?>">
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold"><?php echo USER_FLD_EMAIL;?></label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="E-mail" name="email" id="email" value="<?php echo $email;?>" >
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-4 regular" style="text-align: right; font-size: small; margin: auto;">
              <label  class="sr-only bold">Address</label>
            </div>

            <div class=" col-md-4" style="text-align: left; ">
                <input class="form-control commontextsize" type="text" placeholder="Address"  name="address" id="address" value="<?php echo $address;?>" >
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3"></div>

        </div>

        

        <div class="row">

            <div class=" regular commontextsize" style=" text-align: center; margin: auto; margin-top: 40px;">
                <button type="submit" class="btn btn-success" value="<?php echo ($mode == "U") ? " Update " : " Save ";?>" ><i class="bi bi-arrow-bar-up" style="margin-right: 10px;"></i>Save</button>
                <button type="button" class="btn btn-danger"> <a href="index.php?p=staff_dir" class="text-white" style="text-decoration: none;"> <i class="bi bi-x-circle" style="margin-right: 10px;" value="Cancel" onClick="document.location='./index.php';" ></i>Cancel</a></button>
            </div>

        </div>

			
			
            </form>
			<div class="clear"></div>
  	    </div>
	</div>

</body>
</html>