<div id="wrapperPRight">
<div style="text-align:right; padding:10px; text-decoration:none">
<a  style="text-align:right; padding:10px; text-decoration:none" href="./?p=my_profile" title="header=[My Profile] body=[&nbsp;] fade=[on]">
<?php
echo  WELCOME." <b>".$objAdminUser->fullname_name."</b> ";?>
 
<?php 
echo   " [" ;
			if($objAdminUser->user_type==1)  
			echo "SuperAdmin";
			elseif($objAdminUser->user_type==2&&$objAdminUser->member_cd==0)
			echo "SubAdmin";
			else
			echo "User";
			echo "]";

	?> 
   </a>
   
   <br />
   <span   style="text-align:right; width:200px; padding-right:10px; padding-top:10px;">
<?php $sSQL_u = "select max(uploading_file_date) as last_updated from rs_tbl_documents";
$objDb		= new Database;
$max_date=$objDb->dbCon->query($sSQL_u);
$sSQL_r1=$max_date->fetch();
	?>
<b>Last Updated on:</b><?php echo $sSQL_r1['last_updated'];?></span>
   </div>
   
		<div id="tableContainer">		 
			<table width="100%"  align="center" border="0" >
			<?php $sql_cms="Select * from rs_tbl_cms where cms_cd=1";
			$cms_data=$objDb->dbCon->query($sql_cms);
			$sql_cms_r=$cms_data->fetch();
			 ?>
   <tr>
     <td height="40" colspan="5" align="left" style="color:#0E0989; font-size:21px" ><?php echo $sql_cms_r['title'];?></td>
   </tr>
   <tr>
     <td height="99" colspan="5"  style="line-height:18px; text-align:justify"><p><?php echo $sql_cms_r['details'];?></p>
   </td>
   </tr>
   <tr><td colspan="5" align="center"><img src="<?php echo CMS_URL; ?>/<?php echo $sql_cms_r['cmsfile'];?>"  width="727" /></td></tr>
    </table>
		
	  </div>
<div style="padding-bottom:20px; text-decoration:none">

<span style="text-align:right;padding-right:20px;width:200px; float:right">
<?php
if($objAdminUser->user_type==1)  
{
echo "<b>Number of users login:</b>";
}
else
{
echo  "<b>Number of times login:</b>";
}?>
 
<?php 
$usercd=$objAdminUser->user_cd;
if($objAdminUser->user_type==1)  
{
	$sSQL_d = "select distinct user_id as d_user_id from rs_tbl_user_log where url_capture=''";
	$user_count=$objDb->dbCon->query($sSQL_d);
			$total_num=$user_count->rowCount();
	
	?>
	<a href="users_log_detail.php" style="text-decoration:none" target="_blank"><?php echo $total_num; ?></a>
	<?php
}
else
{
	
	$sSQL_s = "select count(user_id) as no_user_ids from rs_tbl_user_log where user_id=".$usercd." and url_capture=''";
		$sSQL_q=$objDb->dbCon->query($sSQL_s);
			$sSQL_q1=$sSQL_q->fetch();
	echo $no_user_ids=$sSQL_q1['no_user_ids'];
} ?>
</span>
</div>

<div style="width:100%; height:10px; border:0px; background:#000066"></div>
<div style="width:100%; text-align:center;"><h3>Developed by: SJ-SMEC</h3><br />
<a href="http://www.egcpakistan.com/index.php?id=it" target="_blank" style="text-decoration:none"><img src="images/sj.png" width="100px" /></a>
</div>
	</div>
	<div class="clear"></div>