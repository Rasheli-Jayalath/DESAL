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
if($_GET['mode'] == 'Delete')
{
	$user_cd = $_GET['user_cd'];
	
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->actAdminUser('D');
	$objCommon->setMessage('User\'s account deleted successfully.', 'Error');
	$activity="User deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
	redirect('./?p=user_mgmt');
	
}
if($_GET['mode'] == 'Suspend'){

	$user_cd = $_GET['user_cd'];
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->setProperty("is_active", "0");
	if($objAdminUser->actAdminUser("U")){
		$objAdminUserN = new AdminUser;
		$objAdminUserN->setProperty("user_cd", $user_cd);
		$objAdminUserN->lstAdminUser();
		$rows_c = $objAdminUserN->dbFetchArray();
		
		# Send mail to customer
		$content 		= $objTemplate->getTemplate('account_suspend','EN');
		$sender_name 	= $content['sender_name'];
		$sender_email 	= $content['sender_email'];
		$subject 		= $content['template_subject'];
		$content 		= $content['template_detail'];
		
		$content		= str_replace("[USER_NAME]", $rows_c['fullname'], $content);
		$content		= str_replace("[REASON]", '', $content);
		$content		= str_replace("[SITENAME]", SITE_NAME, $content);
		$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
		$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
		
		$body 			= file_get_contents(TEMPLATE_URL . "template.php");
		$body			= str_replace("[BODY]", $content, $body);
		
		$objMail		= new Mail;
		$objMail->IsHTML(true);
		$objMail->setSender($sender_email, $sender_name);
		$objMail->AddEmbeddedImage(TEMPLATE_PATH . "agro_email.jpg", 1, 'agro_email.jpg');
		$objMail->setSubject($subject);
		$objMail->setReciever($rows_c['email'], $rows_c['fullname']);
		$objMail->setBody($body);
		//$objMail->Send();
	
		$objCommon->setMessage('User\'s account suspended successfully.', 'Error');
		$activity="User suspended successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
		
		redirect('./?p=user_mgmt');
	}
}

if($_GET['mode'] == 'Activate'){
	$user_cd = $_GET['user_cd'];
	$newpwd = $objCommon->genPassword();
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->setProperty("password", md5($newpwd));
	$objAdminUser->setProperty("is_active", "1");
	if($objAdminUser->actAdminUser("U")){
		$objAdminUserN = new AdminUser;
		$objAdminUserN->setProperty("user_cd", $user_cd);
		$objAdminUserN->lstAdminUser();
		$rows_c = $objAdminUserN->dbFetchArray();
		
		# Send mail to customer
		$content 		= $objTemplate->getTemplate('account_activate','EN');
		$sender_name 	= $content['sender_name'];
		$sender_email 	= $content['sender_email'];
		$subject 		= $content['template_subject'];
		$content 		= $content['template_detail'];
		
		$content		= str_replace("[USER_NAME]", $rows_c['fullname'], $content);
		$content		= str_replace("[EMAIL_ADD]", $rows_c['email'], $content);
		$content		= str_replace("[PASSWORD]", $newpwd, $content);
		$content		= str_replace("[SITE_NAME]", SITE_NAME, $content);
		$content		= str_replace("[SENDER_NAME]", $sender_name, $content);
		
		$body 			= file_get_contents(TEMPLATE_URL . "template.php");
		$body			= str_replace("[BODY]", $content, $body);
		
		$objMail		= new Mail;
		$objMail->IsHTML(true);
		$objMail->setSender($sender_email, $sender_name);
		$objMail->AddEmbeddedImage(TEMPLATE_PATH . "agro_email.jpg", 1, 'agro_email.jpg');
		$objMail->setSubject($subject);
		$objMail->setReciever($rows_c['email'], $rows_c['fullname']);
		$objMail->setBody($body);
		//$objMail->Send();
		
		
		$objCommon->setMessage('User\'s account activated successfully.', 'Info');
		$activity="User activated successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
		redirect('./?p=user_mgmt');
	}
}

if(!empty($_GET['user_name'])){
	$user_name = urldecode($_GET['user_name']);
	$objAdminUser->setProperty("user_name", strtolower($user_name));
}
?>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.user_name.value != ""){
		qString += '&user_name=' + escape(frm.user_name.value);
	}
	document.location = '?p=user_mgmt' + qString;
}
</script>

<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 25PX;">User Management</h4>
<div id="wrapperPRight"class="container" style="margin-top: 20px; margin-bottom: 50px;  padding-bottom: 30px ; ">
		
		<div id="pageContentRight" class="container" style="text-align: right;">
			
			<a href="./?p=update_profile" class="btn btn-warning commontextsize"><i class="bi bi-person-plus-fill" style="margin-right: 10px;"></i>Add New User
					</a>
				<br style="clear:left"/>
		
		</div>
		<div class="clear"></div>
			<form name="frmCustomer" id="frmCustomer" class="form-inline">
				<div class="row" id="divfilteration" style ="border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; text-align: center; margin: auto; margin-bottom: 20px; margin-top: 25PX;">
				
						
						<div class="col-md-4 regular" style="text-align: right; margin: auto; font-size: small;">
							<label  class="sr-only">User Name</label>
						</div>

						<div class=" col-md-4 regular" style="text-align: center; margin: auto; margin-top: 10px;">
						<input type="text" size="40" name="user_name" id="user_name" value="<?php echo $_GET['user_name'];?>" style="font-size: small;" class="form-control" placeholder="User Name"/>
                      </div>
				
					
					  <div class=" col-md-4 regular" style="text-align: left;  margin-top: 8px;">
                        <button type="button" onClick="doFilter(this.form);"  name="Submit" id="Submit" value=" GO "  class="btn btn-primary mb-2 commontextsize"><i class="bi bi-search" style="margin-right: 10px;"></i>Search</button>
                      </div>
	
				
				</div>
			</form>
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<div class="table-responsive commontextsize      ">
		<table id="customers" class="table" style= "">
		<thead>
			<tr>
			<th class="semibold" style="text-align:left"><?php echo "User Name";?></th>
			<th class="semibold" style="text-align:left"><?php echo "Designation";?></th>
			<th class="semibold" style="text-align:left"><?php echo "Role";?></th>
			<!--<th><?php //echo "Right";?></th>-->
			<!--<th>CMS </th>-->
			<th class="semibold" colspan="3" style="text-align:center">Action</th>
			</tr>
       </thead>
		<?php
	//$objAdminUser->setProperty("ORDER BY", "a.first_name");
	$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "b.user_cd");
	$objAdminUser->setProperty("GROUP BY", "b.user_cd");
	$objAdminUser->lstAdminUser();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<!-- Start Your Php Code her For Display Record's -->
			<tr style="background-color:<?php echo $bgcolor;?>">
				<td><?php echo $rows['fullname'];?></td>
                <td><?php echo $rows['designation'];?></td>
				<td>
				<?php if($rows['user_type']==1) echo "Super Admin";
				elseif($rows['user_type']==2)
				echo "Sub Admin";
				else
				echo "User";?>
				</td>
				<!--<td>
				<?php /*if($rows['user_type']!=1)
				{?>
				<a href="./?p=user_rights&user_cd=<?php echo $rows['user_cd'];?>">Manage Rights</a>
				<?php }
				else
				{
				echo "Complete Rights";
				}*/?>
				</td>-->
				<?php /*?><td><?php if($rows['user_type']!=1)
				{?>
				<a href="./?p=user_cms_rights&user_cd=<?php echo $rows['user_cd'];?>">Manage CMS Rights</a>
				<?php }
				else
				{
				echo "Complete Rights";
				}?></td><?php */?>
				
				<td align="center">
					<?php 
					if($rows['user_type']==1)
					{ 
					echo "Full Rights";
					}
					else if($rows['user_type']==2)
					{ 
					echo "All Folder Rights";
					}
					else
					{?>
			 <a href="./?p=update_rights&user_cd=<?php echo $rows['user_cd'];?>" title="Manage Rights"><i class="bi bi-gear-fill" style="color:#000" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Manage Right"></i></a><?php } ?></td>
		<td align="center">
			 <a href="./?p=update_profile&user_cd=<?php echo $rows['user_cd'];?>" title="Edit"><i class="bi bi-pencil-fill iconorange" style="padding-right:10px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"></i> </a>
			 <!--<td align="center">
					<?php if($rows['is_active'] != 1){?>
				<a href="./?p=user_mgmt&mode=Activate&user_cd=<?php echo $rows['user_cd'];?>" onClick="return doConfirm('Are you sure you want to activate the user?');" title="Activate Customer's Account"><img src="images/icons/action_download.gif" border="0" title="Activate" alt="Activate"  /></a>
				<?php }else{?>
				<a href="./?p=user_mgmt&mode=Suspend&user_cd=<?php echo $rows['user_cd'];?>" onClick="return doConfirm('Are you sure you want to suspend the user?');" title="Suspend Customer's Account">
					<img src="images/icons/action_block.gif" border="0" title="Suspend" alt="Suspend" /></a><?php }?></td>-->
					
				<a class="lnk" href="./?p=user_mgmt&amp;mode=Delete&amp;user_cd=<?php echo $rows['user_cd'];?>" onclick="return doConfirm('Are you sure you want to Delete Permanently this user ?');" title="Delete"><i class="bi bi-trash-fill iconred" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"></i></a>
				</td>
				</tr>
			<?php
			
		}
    }
	else{
	?>
	<tr>
	<td colspan="7">
  <div align="center" style="padding:5px 5px 5px 5px"> <?php echo NOT_FOUND_CUST;?></div>
   </td></tr>
    <?php
	}
	?>
	<tr>
	<td colspan="7" style="padding:0">		
	<div id="tblFooter">
			<?php
if($objAdminUser->totalRecords() >= 1){
	//$objPaginate = new Paginate($Sql, PERPAGE, OFFSET, "./?p=user_mgmt");
	?>
	
	<div style="float:left;width:170px;font-weight:bold">
	     <?php //$objPaginate->recordMessage();?>
   </div>
	<div id="paging" style="float:right;text-align:right; padding-right:5px;  font-weight:bold">
	<!--  <?php// $objPaginate->showpages(); ?> -->
	</div>
<?php }?>
			</div>
	</td></tr>
		 </table>
</div>
	  </form>
	  
	</div>



</body>
</html>