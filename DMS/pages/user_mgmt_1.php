<?php
if($_GET['mode'] == 'Delete')
{
	$user_cd = $_GET['user_cd'];
	
	$objAdminUser->setProperty("user_cd", $user_cd);
	$objAdminUser->actAdminUser('D');
	$objCommon->setMessage('User\'s account deleted successfully.', 'Error');
	$activity="User deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
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
	mysql_query($sSQLlog_log);		
		
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
	mysql_query($sSQLlog_log);		
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

<div id="wrapperPRight">
		<div id="pageContentName"><?php echo "User Management";?></div>
		<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=update_profile" class="lnkButton"><?php echo "Add New User";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<div class="clear"></div>
			<form name="frmCustomer" id="frmCustomer">
<div id="divfilteration">
    <div class="holder">
        
        <div>
        	<label>User Name</label>
			<input type="text" size="40" name="user_name" id="user_name" value="<?php echo $_GET['user_name'];?>" />
        </div>
    </div>
    <div class="holder">
       
        <div><input type="button" onClick="doFilter(this.form);" class="rr_buttonsearch" name="Submit" id="Submit" value=" GO " /></div>
    </div>
</div>
</form>
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<table id="tblList" width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
        <tr>
		<th style="text-align:left"><?php echo "User Name";?></th>
		<th style="text-align:left"><?php echo "Designation";?></th>
        <th style="text-align:left"><?php echo "Role";?></th>
		<!--<th><?php //echo "Right";?></th>-->
		<!--<th>CMS </th>-->
		<th colspan="3">Action</th>
		</tr>
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
					else
					{?>
			 <a href="./?p=update_rights&user_cd=<?php echo $rows['user_cd'];?>" title="Manage Rights"><img src="images/right.png" border="0" /></a><?php } ?></td>
		<td align="center">
			 <a href="./?p=update_profile&user_cd=<?php echo $rows['user_cd'];?>" title="Edit"><img src="images/iconedit.png" border="0" /></a></td>
			 <!--<td align="center">
					<?php if($rows['is_active'] != 1){?>
				<a href="./?p=user_mgmt&mode=Activate&user_cd=<?php echo $rows['user_cd'];?>" onClick="return doConfirm('Are you sure you want to activate the user?');" title="Activate Customer's Account"><img src="images/icons/action_download.gif" border="0" title="Activate" alt="Activate"  /></a>
				<?php }else{?>
				<a href="./?p=user_mgmt&mode=Suspend&user_cd=<?php echo $rows['user_cd'];?>" onClick="return doConfirm('Are you sure you want to suspend the user?');" title="Suspend Customer's Account">
					<img src="images/icons/action_block.gif" border="0" title="Suspend" alt="Suspend" /></a><?php }?></td>-->
					<td align="center">
				<a class="lnk" href="./?p=user_mgmt&amp;mode=Delete&amp;user_cd=<?php echo $rows['user_cd'];?>" onclick="return doConfirm('Are you sure you want to Delete Permanently this user ?');" title="Delete"><img src="<?php echo IMAGES_URL;?>icondelete.png" border="0" /></a>
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
	$objPaginate = new Paginate($Sql, PERPAGE, OFFSET, "./?p=user_mgmt");
	?>
	
	<div style="float:left;width:170px;font-weight:bold"><?php $objPaginate->recordMessage();?></div>
	<div id="paging" style="float:right;text-align:right; padding-right:5px;  font-weight:bold">
	    <?php $objPaginate->showpages();?>
	</div>
<?php }?>
			</div>
	</td></tr>
		 </table>
	  </form>
	</div>