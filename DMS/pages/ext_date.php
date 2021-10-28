
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
   </a></div>
  <div>
  <?php 

   $sql_ds="Select report_id,report_file,doc_creater from rs_tbl_documents";
   $res_ds=mysql_query($sql_ds);
	while($row_ds=mysql_fetch_array($res_ds))
	{
	$report_id_ds=$row_ds['report_id'];
	$report_file_ds=$row_ds['report_file'];
	if($report_file_ds!="")
	{
	
	$file_pathh=REPORT_PATH.$report_file_ds;
	echo $file_size=filesize($file_pathh);
	}
	$arr_file=explode(".",$report_file_ds);
	$get_ext=$arr_file[1];
	$sql_upd="update rs_tbl_documents set extension='".$get_ext."' where report_id=".$report_id_ds;
	mysql_query($sql_upd);
	$doc_creater_ds=$row_ds['doc_creater'];
	$arr_file_creater=explode("-",$doc_creater_ds);
	 $arr_year=$arr_file_creater[0];
	 $get_year=substr($arr_year, -4);
	$get_mon=$arr_file_creater[1];
	$arr_days=$arr_file_creater[2];
	$get_days=substr($arr_days, 0,2);
	$get_date=$get_year."-".$get_mon."-".$get_days;
	 $sql_upd_d="update rs_tbl_documents set uploading_file_date='$get_date' where report_id=".$report_id_ds;
	mysql_query($sql_upd_d);
			   
	}
?>

  
  </div>
		


	</div>
	<div class="clear"></div>