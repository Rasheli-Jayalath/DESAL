<style>
a
{
text-decoration:none
}

.report_tbl {
margin-right:-45px;
padding:0px;
width:100%;	box-shadow: 10px 10px 5px #888888;
border:1px solid #000000;

-moz-border-radius-bottomleft:0px;
-webkit-border-bottom-left-radius:0px;
border-bottom-left-radius:0px;

-moz-border-radius-bottomright:0px;
-webkit-border-bottom-right-radius:0px;
border-bottom-right-radius:0px;

-moz-border-radius-topright:0px;
-webkit-border-top-right-radius:0px;
border-top-right-radius:0px;

-moz-border-radius-topleft:0px;
-webkit-border-top-left-radius:0px;
border-top-left-radius:0px;
}.report_tbl table{
width:100%;
height:100%;
margin-left:50px;
padding:0px;
}.report_tbl tr:last-child td:last-child {
-moz-border-radius-bottomright:0px;
-webkit-border-bottom-right-radius:0px;
border-bottom-right-radius:0px;
}
.report_tbl table tr:first-child td:first-child {
-moz-border-radius-topleft:0px;
-webkit-border-top-left-radius:0px;
border-top-left-radius:0px;
}
.report_tbl table tr:first-child td:last-child {
-moz-border-radius-topright:0px;
-webkit-border-top-right-radius:0px;
border-top-right-radius:0px;
}.report_tbl tr:last-child td:first-child{
-moz-border-radius-bottomleft:0px;
-webkit-border-bottom-left-radius:0px;
border-bottom-left-radius:0px;
}.report_tbl tr:hover td{
background-color:#d3e9ff;
}
.report_tbl td{
vertical-align:middle;
	background:-o-linear-gradient(bottom, #ffffff 5%, #d3e9ff 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #d3e9ff) ); 	background:-moz-linear-gradient( center top, #ffffff 5%, #d3e9ff 100% );	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffffff", endColorstr="#d3e9ff");	background: -o-linear-gradient(top,#ffffff,d3e9ff);
background-color:#ffffff;
border:1px solid #000000;
border-width:0px 1px 1px 0px;
text-align:left;
padding:7px;
font-size:14px;
font-family:Arial;
font-weight:normal;
color:#000000;
}.report_tbl tr:last-child td{
border-width:0px 1px 0px 0px;
}.report_tbl tr td:last-child{
border-width:0px 0px 1px 0px;
}.report_tbl tr:last-child td:last-child{
border-width:0px 0px 0px 0px;
}
.report_tbl tr:first-child td{
	background:-o-linear-gradient(bottom, #0057af 5%, #007fff 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #007fff) );	background:-moz-linear-gradient( center top, #0057af 5%, #007fff 100% );	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#0057af", endColorstr="#007fff");	background: -o-linear-gradient(top,#0057af,007fff);
background-color:#0057af;
border:0px solid #000000;
text-align:center;
border-width:0px 1px 1px 0;
font-size:14px;
font-family:Arial;
font-weight:bold;
color:#ffffff;
}
.report_tbl tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #0057af 5%, #007fff 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #007fff) );	background:-moz-linear-gradient( center top, #0057af 5%, #007fff 100% );	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#0057af", endColorstr="#007fff");	background: -o-linear-gradient(top,#0057af,007fff);
background-color:#0057af;
}
.report_tbl tr:first-child td:first-child{
border-width:0px 1px 1px 0px;
}
.report_tbl tr:first-child td:last-child{
border-width:0px 0px 1px 0px;
}
</style>
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
<?php
 $user_cd	= $objAdminUser->user_cd;
$objAdminUser->setProperty("user_cd", $user_cd);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
 $user_type= $data['user_type'];


$report_path = REPORT_PATH;

$category_cd = $_REQUEST['category_cd'];
$subcategory_cd = $_REQUEST['subcategory_cd'];
$cid = $_REQUEST['cid'];
if(isset($_GET['mode']) && $_GET['mode'] == "delete"){
				$report_cd = $_GET['report_cd'];
				$cid_del = $_GET['cid'];
				$cat_cd_del = $_GET['cat_cd'];
				$category_cd_del = $_GET['category_cd'];
				$sql2d="Select * from rs_tbl_documents where report_id='$report_cd'";
				$res2d=mysql_query($sql2d);
				$row2d=mysql_fetch_array($res2d);				
				$file_report=$row2d['report_file'];
				if($file_report!=""){
									@unlink(REPORT_PATH . $file_report);
										
									}
				$objProduct->resetProperty();
				$objProduct->setProperty("report_id", $report_cd);
				$objProduct->actReport("D");
				$objCommon->setMessage("Record deleted Successfully", 'Info');
				$activity="File deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);	
				redirect('./?p=reports&category_cd='.$category_cd_del.'&cat_cd='.$cat_cd_del.'&cid='.$cid_del);
	
	
}
if(isset($_GET['mode']) && $_GET['mode'] == "cat_delete"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$category_cd_cat = $_GET['sel_category_cd'];
				 $sql2c="Select * from rs_tbl_category where parent_cd='$category_cd_cat'";
				$res2c=mysql_query($sql2c);
				if(mysql_num_rows($res2c)>=1)
				{
				
				$objCommon->setMessage("You should delete its sub category(s) first", 'Error');
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
				}
				else
				{
				
			
				
				
			   $sql2t="Select * from rs_tbl_documents where report_category='$category_cd_cat'";
				$res2t=mysql_query($sql2t);
				 $res2t=mysql_query($sql2t);
				$row2d=mysql_fetch_array($res2d);
					if(mysql_num_rows($res2t)>=1)
					{
					$objCommon->setMessage("You should delete its document(s) first", 'Error');
					redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
					}
					else
					{
					 $sdeletet= "Delete from rs_tbl_category_template where cat_id='$category_cd_cat'";
					   mysql_query($sdeletet);
						$objProduct->resetProperty();
						$objProduct->setProperty("category_cd", $category_cd_cat);
						$objProduct->actCategory("D");
						$objCommon->setMessage(PRD_DELETE_SUCCESS, 'Info');
						$activity="Category deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
						
						redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
					}				
				
				
				}
	
	
}
if(isset($_GET['mode']) && $_GET['mode'] == "task_delete"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$sel_task_id = $_GET['sel_task_id'];
				$delete_task_msg= "Delete from rs_tbl_threads where thread_no='$sel_task_id'";
				mysql_query($delete_task_msg);
				$delete_task_attach= "Delete from rs_tbl_attachments where thread_no='$sel_task_id'";
				mysql_query($delete_task_attach);				
				$delete_task= "Delete from rs_tbl_threads_titles where tt_id='$sel_task_id'";
				mysql_query($delete_task);
				$activity="Task deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);	
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
	
	
}

if(isset($_GET['mode']) && $_GET['mode'] == "lock"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$sel_task_id = $_GET['sel_task_id'];
				$status="0";
				echo $sql_pro="UPDATE rs_tbl_threads_titles SET status='$status' where tt_id='$sel_task_id'";
				mysql_query($sql_pro);
				$activity="Task has been locked";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);	
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
	
	
}
if(isset($_GET['mode']) && $_GET['mode'] == "active"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$sel_task_id = $_GET['sel_task_id'];
				$status="1";
				echo $sql_pro="UPDATE rs_tbl_threads_titles SET status='$status' where tt_id='$sel_task_id'";
				mysql_query($sql_pro);
				$activity="Task has been activated";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);	
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
	
	
}
///Filter
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["go_submit"])){
$report_sts = $_POST['report_status'];

if(isset($_GET['cat_cd']))
{
$cat_cd_new='&cat_cd='.$_GET['cat_cd'];
}
if($report_sts=='6')
{
redirect('./?p=reports&cid='.$_GET['cid'].'&category_cd='.$_GET['category_cd'].$cat_cd_new);
}
else
{
redirect('./?p=reports&cid='.$_GET['cid'].'&category_cd='.$_GET['category_cd'].$cat_cd_new.'&status='.$report_sts );
}
}
///Filter End


///Task Filter
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["go_submit1"])){
$task_sts = $_POST['task_status'];

if(isset($_GET['cat_cd']))
{
$cat_cd_new='&cat_cd='.$_GET['cat_cd'];
}
if($task_sts=='7')
{
redirect('./?p=reports&cid='.$_GET['cid'].'&category_cd='.$_GET['category_cd'].$cat_cd_new);
}
else
{
redirect('./?p=reports&cid='.$_GET['cid'].'&category_cd='.$_GET['category_cd'].$cat_cd_new.'&t_status='.$task_sts );
}
}
///Task Filter End


if(isset($_GET['mode']) && $_GET['mode'] == "dgfDelete"){
	$report_cd = $_GET['report_cd'];
	
	$sdelete= "Delete from rs_tbl_documents where report_id='report_cd'";
	 mysql_query($sdelete);
      $sdeletet= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
	   mysql_query($sdeletet);
		$objProduct->resetProperty();
		$objProduct->setProperty("category_cd", $category_cd);
		$objProduct->actCategory("D");
		
		 $sql2c="Select * from rs_tbl_category where parent_cd='$category_cd'";
				$res2c=mysql_query($sql2c);
				if(mysql_num_rows($res2c)>=1)
				{
				while($row2c=mysql_fetch_array($res2c))
				{
		/**/
			 $sql2d="Select * from rs_tbl_documents";
				$res2d=mysql_query($sql2d);
				while($row2d=mysql_fetch_array($res2d))
				{
				$d_subcat=$row2d['report_subcategory'];
				/*if($d_subcat=="")
				{
				$sdelete= "Delete from rs_tbl_documents where report_id='$row2d[report_id]'";
	 			  mysql_query($sdelete);

				}
				else
				{*/
				$d_sub_cat=explode("_",$d_subcat);				
				$dl=count($d_sub_cat);
				for($h=0;$h<$dl;$h++)
				{
				$report_suby=$d_sub_cat[$h];
				if($report_suby==$row2c['category_cd'])
				{
				 $sdelete= "Delete from rs_tbl_documents where report_id='$row2d[report_id]'";
	 			  mysql_query($sdelete);
				}
				
				}
				//}
				
				}
				 $sdeletet= "Delete from rs_tbl_category_template where cat_id='$row2c[category_cd]'";
	   mysql_query($sdeletet);
				$sdeletect= "Delete from rs_tbl_category where category_cd='$row2c[category_cd]'";
	 	 mysql_query($sdeletect);
		 		}
				}
				else
				{
				 $sql2d="Select * from rs_tbl_documents";
				$res2d=mysql_query($sql2d);
				while($row2d=mysql_fetch_array($res2d))
				{
				$d_subcat=$row2d['report_subcategory'];
				$d_sub_cat=explode("_",$d_subcat);				
				$dl=count($d_sub_cat);
				for($h=0;$h<$dl;$h++)
				{
				$report_suby=$d_sub_cat[$h];
				if($report_suby==$category_cd)
				{
				 $sdelete= "Delete from rs_tbl_documents where report_id='$row2d[report_id]'";
	 			  mysql_query($sdelete);
				}
				
				}
				
				}
				/* $sdeletet= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
	   mysql_query($sdeletet);*/
				}
		
		
		$objCommon->setMessage(PRD_DELETE_SUCCESS, 'Info');
		redirect('./?p=category');
	
	
}
if(isset($_GET['cat_cd']))
	{
	 $cat_cd=$_GET['cat_cd'];
	}
	if(isset($_REQUEST['sort']))
	{
	 
	 if($_REQUEST['sort']=="asc")
	 {
	 $sort="asc";
	 $order="desc";
	 }
	 else if($_REQUEST['sort']=="desc")
	 {
	 $sort="desc";
	 $order="asc";
	 }
	 
	}
	else
	{
	$order="asc";
	}
	
	
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_submit"])){

	 	$files_download =$_POST['file_download'];
		$category=$_GET['category_cd'];
		 if(isset($files_download)){ 
		$files_count=count($files_download); 
		 for($i=0;$i<$files_count;$i++)
		 {
		 $all_download[]=$files_download[$i];		
		 }
		 $out = '';
   $out .="category_name".",";
   $out .="report_title".",";
   $out .="report_file".",";
   $out .="doc_issue_date".",";
   $out .="report_status".",";
   $out .="doc_upload_date".",";
   $out .="doc_creater".",";
   $out .="doc_last_modified_by".",";
   $out .="\n";
		foreach ($all_download as $selected_file_id) {

 $getquery="SELECT category_cd,category_name,report_title,report_file,doc_issue_date,report_status,doc_upload_date,doc_creater,doc_last_modified_by FROM rs_tbl_documents INNER JOIN rs_tbl_category ON 
 (rs_tbl_documents.report_category = rs_tbl_category.category_cd) where report_category=$category and report_id=$selected_file_id";
 $result=mysql_query($getquery);
 $num_rows = mysql_num_rows($result);

  $l = mysql_fetch_array($result);
  
	$results[] = $l['report_file'];
    $cat_name=preg_replace('/\s+/','_',$l['category_name']);
    $out.=$l['category_name'].",";
    $out.=str_replace(',','',$l['report_title']).",";	
	$out.="<a href='" .$l['report_file'] . "'>".$l['report_file']."</a> ,";
    $out.=$l['doc_issue_date'].",";
	$out.=$l['report_status'].",";
    $out.=$l['doc_upload_date'].",";
	$out.=$l['doc_creater'].",";
    $out.=$l['doc_last_modified_by'].",";
    $out .="\n";
 

}
}
 $td = date('Y-m-d-h-m-s',time());
 $filename1 = $cat_name.$td.".zip";
 // $f = fopen ("data/".$filename,'w+');
 // fputs($f, $out);
  //fclose($f);
  
  
  $zip = new ZipArchive();
$filename = SITE_PATH."Zip/".$filename1;

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

$zip->addFromString("list-".$cat_name.$td.".csv", $out);
$zip->addFromString("instructions.txt", " The list of downloaded files is provided as csv in this archive.\n");

foreach ($results as $file) {
//echo $file
$zip->addFile("project_reports/".$file,"/".$file);
}

echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();	


header('Content-Type: application/octet-stream');
header('Content-disposition: attachment; filename='.basename($filename1));
header('Content-Length: ' . filesize("Zip/".$filename1));
ob_clean();
flush();
readfile("Zip/".$filename1);
unlink("Zip/".$filename1);			


	
}




?>
<script>
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
<script>
function selectAllUnSelectAll(chkAll, strSelecting, frm){
if(chkAll.checked == true){
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = true;
			}
		}
	}
	else{
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = false;
			}
		}
	}
}

</script>

<div id="wrapperPRight">
<!--<div id="wrapperPRight">-->


<?php      $sqlss="select parent_group, category_status from rs_tbl_category where category_cd='$category_cd'";
	$sqlrwss=mysql_query($sqlss);
	$sqlrw1ss=mysql_fetch_array($sqlrwss);
	$par_groups=$sqlrw1ss['parent_group'];
	$category_status=$sqlrw1ss['category_status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$category_name="";
	for($i=0;$i<$lenns;$i++)
	{
	 $sqlCN="select category_name,parent_cd,cid from rs_tbl_category where category_cd='$par_arr[$i]' ";
		
	$sqlrCN=mysql_query($sqlCN);
	$sqlCNrw=mysql_fetch_array($sqlrCN);
	
	$category_name .='<a href="?p=reports&cid='.$sqlCNrw["cid"].'&cat_cd='.$sqlCNrw["parent_cd"].'&category_cd='.$par_arr[$i].'">'.$sqlCNrw["category_name"].'</a>';
	
	$category_name .="&nbsp;&raquo;&nbsp;";
	
	//$category_name .=$category_name;
	}
   $report_category=$category_name;
	$sql="Select * from rs_tbl_category where category_cd=".$category_cd;
			$res=mysql_query($sql);
			$row3=mysql_fetch_array($res);
			
				//$report_category=$row3['category_name'];
				$parent_cd=$row3['parent_cd'];
				
			?>
         
		
	<div style="text-align:right; padding:10px; text-decoration:none">
<a  style="text-align:right; padding:10px; text-decoration:none" href="./?p=my_profile" title="header=[My Profile] body=[&nbsp;] fade=[on]">
<?php 
echo  "Welcome ".$objAdminUser->fullname_name." ".$objAdminUser->designation;   ?>
 
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
    <?php echo $objCommon->displayMessage();?>
	<div id="tableContainer"  >
	
    <div  class="shadowWhite" style="padding-left:25px;margin-left:45px;">
    <div align="left"><?php echo $report_category;?></div></div>
    <table width="100%"  align="center" border="0" >

<?php if($objAdminUser->user_type==1)
{
  ?>
<tr>
<td height="40" colspan="2" align="center" style=" padding-bottom:15px;padding-left:125px;" width="50%">
</td>
<td align="right" width="20%">
<a href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Tasks</a> &nbsp;&nbsp;
</td>
<td align=" right" width="18%">
<a href="javascript:void(null);" onclick="window.open('category.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Category</a></td>
<td align="right" width="12%" style="margin-left:45px" ><a href="javascript:void(null);" onclick="window.open('upload_report.php?cat_cd=<?php echo $_REQUEST["cat_cd"];?>&category_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=550,height=400,scrollbars=yes');" >
<img src="<?php echo SITE_URL;?>images/doc.ico" border="0" width="32"/>Add File</a></td> 
</tr>
<?php
}
else if($_REQUEST['category_cd'])
{
$cattid=$_REQUEST['category_cd'];
			$cqueryd = "select * from  rs_tbl_category  where category_cd='$cattid'";
			$cresultd = mysql_query($cqueryd);
			$cdatad = mysql_fetch_array($cresultd);
			$p_cdd=$cdatad['parent_cd'];
			if($p_cdd==0)
			{
			?>
			<tr>
<td height="40" colspan="2" align="center" style=" padding-bottom:15px;padding-left:125px;" width="50%"></td>
<td align="right" width="20%">
<!--<a href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Tasks</a> &nbsp;&nbsp;-->
</td>
<!--<td align="right" width="18%">
<a href="javascript:void(null);" onclick="window.open('category.php?cat_cd=<?php /*echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Category</a></td>
<td align="right" width="12%"><a href="javascript:void(null);" onclick="window.open('upload_report.php?cat_cd=<?php echo $_REQUEST["cat_cd"];?>&category_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=550,height=400,scrollbars=yes');" >
<img src="<?php echo SITE_URL;*/?>images/doc.ico" border="0" width="32"/>Add File</a></td> -->
</tr>
			<?php
			}
			else if($p_cdd!=0)
			{
			
			$u_right=$cdatad['user_right'];
			$arruright= explode(",",$u_right);
			$arr_right_users=count($arruright);		
			 foreach($arruright as $key => $val) 
			 	{
			   $arruright[$key] = trim($val);
			   $aright= explode("_", $arruright[$key]);
			    if($aright[0]==$user_cd)
						{
							if($aright[1]==1)
							{
							$read_right=1;
							?>
							<tr>
		<td height="40" colspan="2" align="center" style=" padding-bottom:15px;padding-left:125px;" width="50%">
		</td>
		<td align="right" width="20%">
<!--<a href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Tasks</a> &nbsp;&nbsp;-->
</td>
		<td align="right" width="18%">
		<a href="javascript:void(null);" onclick="window.open('category.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
		width="32" height="32" />Add Category</a>		
		</td>		
		<td align="right" width="12%"><a href="javascript:void(null);" onclick="window.open('upload_report.php?cat_cd=<?php echo $_REQUEST["cat_cd"];?>&category_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=550,height=400,scrollbars=yes');" >
		<img src="<?php echo SITE_URL;?>images/doc.ico" border="0" width="32"/>Add File</a></td> 
		</tr>
							<?php
							}
							else if($aright[1]==2)
							{
							$read_right=2;
							
							
							}
					     }
				}
			
			}
}
?>


	
	<?php
	
			  
	$sql2="Select * from rs_tbl_category where parent_cd=".$category_cd;
			$res2=mysql_query($sql2);
		$total_num=mysql_num_rows($res2);
			if($total_num>=1)
			{
			?>
			<tr>
<td height="99" colspan="5"   style="line-height:18px; text-align:justify;"  >

<span style="margin-left:45px; font-size:16px; font-weight:bold">Folders</span>
<table class="report_tbl" border="1px"  align="right" cellspacing="0" style="margin-top:5px; margin-bottom:20px" >

<tr >

<td style="color:#000066" width="2%">S#</td>
<?php
 $temp2="select * from rs_tbl_category_template where cat_id='$category_cd' order by cat_temp_order asc";
$res_temp2=mysql_query($temp2);
$res_temp2=mysql_fetch_array($res_temp2);
 $res_temp2['cat_title_text'];
?>
<td style="color:#000066" width="40%"><?php echo $res_temp2['cat_title_text'] ?></td>
<td style="color:#000066" width="25%">Created By</td>
<td style="color:#000066" width="25%">Last Modified By</td>
<td style="color:#000066" colspan="2">Actions</td>
<?php

?>

 </tr>
 <?php
 $y=1;
 while($row2=mysql_fetch_array($res2))
			 {
				$report_subcategory=$row2['category_name'];
				$category_cd."<br/>";
				$subcategory_id=$row2['category_cd'];
			$sub_folder="Select * from rs_tbl_category where parent_cd=".$subcategory_id;
			$sub_folders=mysql_query($sub_folder);
		    $total_subfolder=mysql_num_rows($sub_folders);
		    $files="Select * from rs_tbl_documents where report_category=".$subcategory_id;
			$files1=mysql_query($files);
		    $total_files=mysql_num_rows($files1);
				if($user_type=='1')
				{
				?>
				<tr>
<td style="color:#000066"><?php echo $y;?></td>
<td style="color:#000066"><img  src="./images/folder1.png"/>&nbsp;<a href="?p=reports&category_cd=<?php echo $subcategory_id; ?>&cat_cd=<?php echo $category_cd; ?>&cid=<?php echo $cid; ?>"><?php echo $report_subcategory?></a></td>
<td><?php echo $row2['creater'];?><br /><font size="-5"><?php echo "folders: ".$total_subfolder."&nbsp;&nbsp; Files: ".$total_files; ?></font></td>
<td><?php echo $row2['last_modified_by'];?></td>
<td style="color:#000066" align="right"><a href="javascript:void(null);" onclick="window.open('category.php?category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $cid;?>', 'INV','width=750,height=700,scrollbars=yes');" >
<img src="./images/edit.gif" border="0" /></a></td>
<td style="color:#000066" align="right">&nbsp;<a href="?p=reports&sel_category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=cat_delete"  onclick="return confirm('Are you sure, You want to delete category?')"><img  src="./images/delete.gif"/></a></td>

 </tr>
				<?php
				$y++;
				}
				else
				{
			
				$u_rightr=$row2['user_right'];
			$arrurightr= explode(",",$u_rightr);
			$arr_right_usersr=count($arrurightr);		
			 foreach($arrurightr as $key => $val) 
			 	{
			   $arrurightr[$key] = trim($val);
			   $arightr= explode("_", $arrurightr[$key]);
			    if($arightr[0]==$user_cd)
						{
							if($arightr[1]==1)
							{
							$read_right=1;
							}
							else if($arightr[1]==2)
							{
							$read_right=2;
							}
						
						
					
			
				?>
				<tr>
<td style="color:#000066"><?php echo $y;?></td>
<td style="color:#000066"><img  src="./images/folder1.png"/>&nbsp;<a href="?p=reports&category_cd=<?php echo $subcategory_id; ?>&cat_cd=<?php echo $category_cd; ?>&cid=<?php echo $cid; ?>"><?php echo $report_subcategory?></a></td>
<td><?php echo $row2['creater'];?><br /><font size="-5"><?php echo "folders: ".$total_subfolder."&nbsp;&nbsp; Files: ".$total_files; ?></font></td>
<td><?php echo $row2['last_modified_by'];?></td>
<?php if($read_right==1)
{ ?>
<td colspan="2" style="color:#000066" align="right"><a href="javascript:void(null);" onclick="window.open('category.php?category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $cid;?>', 'INV','width=750,height=700,scrollbars=yes');" >
<img src="./images/edit.gif" border="0" /></a></td>
<?php
}
else if($read_right==2)
{
?>
<td colspan="2"></td>
<?php
}
?>


 </tr>
				<?php
				$y++;
				}
				}
				}
				
			}
 ?>
</table>

</td>
</tr>
			<?php
			}
			
				
	?>
	
<tr>	

<td  colspan="5"  style="line-height:18px; text-align:justify">
<form name="reports_cat" id="reports_cat" method="post" action="" onsubmit="return atleast_onecheckbox(event)"> </form>
<span style="margin-left:45px;  font-size:16px; font-weight:bold">Files</span>
<?php if($category_status==1){?> <span style="margin-left:350px;"><?php } else { ?>
<span style="font-size:16px; font-weight:bold; float:right"><?php } ?><input type="submit" name="download_submit" id="download_submit" value="Download Files" form="reports_cat" /></span>
<?php if($category_status==1){ ?>
<span style="font-size:16px; font-weight:bold; float:right">
<?php if(isset($_GET['cat_cd']))
{
$cat_cd1="&cat_cd=".$_GET['cat_cd'];
} ?>
<form name="filter_1" id="filter_1" method="post" action="?p=reports&cid=<?php echo $_GET['cid']; ?>&category_cd=<?php echo $_GET['category_cd']?><?php echo $cat_cd1; ?>"> 
<select name="report_status" >
		<option value="6" <?php if(!isset($_GET['status']))echo "selected";?>>All Files</option>
		 <option value="1" <?php if($_GET['status']=='1')echo "selected";?>>Initiated</option>
  		<option value="2" <?php if($_GET['status']=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($_GET['status']=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($_GET['status']=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($_GET['status']=='5')echo "selected";?>>Response Awaited</option>
		 <option value="7" <?php if($_GET['status']=='7')echo "selected";?>>Responded</option>
</select> 
		
		<input type="submit" form="filter_1" name="go_submit" id="go_submit" value="GO" /> </form>
</span>
<?php
}
?>

<table class="report_tbl" align="right" cellspacing="0" style="margin-top:5px; margin-bottom:20px"  >

<tr>
<td style="color:#000066" width="2%">S#</td>
<td style="color:#000066" width="2%"><input  type="checkbox" name="chkAll" id=
          "chkAll" value="1" form="reports_cat" onclick="selectAllUnSelectAll(this,'file_download[]',reports_cat);"/></td>

<?php
$templ="select * from rs_tbl_category_template where cat_id='$category_cd' order by cat_temp_order asc";
$res_temp=mysql_query($templ);
while($res_temp1=mysql_fetch_array($res_temp))
{
//echo $cat_field_namee $res_temp1['cat_field_name'];
?>
<?php if(isset($_GET['status']))
{
$stats="&status=".$_GET['status'];
} ?>
<td style="color:#000066"><?php echo $res_temp1['cat_title_text'] ?> 
 <a href="?p=reports&category_cd=<?php echo $category_cd; ?>&<?php if($cat_cd=="")
{
}
else
{ ?>cat_cd=<?php echo $cat_cd;}?>&cid=<?php echo $cid;?><?php echo $stats; ?>&field=<?php echo $res_temp1['cat_field_name'];?>&sort=<?php echo $order;?>"><?php if($order=="asc"){?><img src="images/asc.png" title="Ascending" alt="Ascending"/><?php }else{?> <img src="images/desc.png" title="Descending" alt="Descending"/><?php } ?> </a></td>

<?php
}

?>
<td style="color:#000066" width="15%">Created By</td>
<td style="color:#000066" width="15%">Last Modified By</td>
<?php if($category_status==1){ ?>
<td style="color:#000066" width="20%">Status</td>
<?php
}
?>
<td width="2%" colspan="2">Action </td>
 </tr>
 
 <?php
	$objProduct->resetProperty();
	$objProduct->setProperty("limit", PERPAGE);
	//$objProduct->setProperty("report_status", "1");
	if(isset($_GET['cat_cd']))
	{
	 $cat_cd=$_GET['cat_cd'];
	 
	$sqls="select parent_group from rs_tbl_category where category_cd='$category_cd' and parent_cd='$cat_cd'";
	$sqlrws=mysql_query($sqls);
	$sqlrw1s=mysql_fetch_array($sqlrws);
	$par_group=$sqlrw1s['parent_group'];
	$par_arr=explode("_",$par_group);
	$lenns=count($par_arr);
	$cat_cds=$par_arr[0];
	$str_ids1="";
	for($i=1;$i<$lenns;$i++)
	{
	if($i==($lenns-1))
	{
	$str_ids=$par_arr[$i];
	}
	else
	{
	$str_ids=$par_arr[$i]."_";
	}
	$str_ids1=$str_ids1.$str_ids;
	
	}
	//echo $str_ids1;
	$objProduct->setProperty("report_category", $_REQUEST["category_cd"]);
	if(isset($_REQUEST["status"]))
	{
	$objProduct->setProperty("report_status", $_REQUEST["status"]);
	}
	//$objProduct->setProperty("report_subcategory", $cat_cds);
	if(isset($sort) && isset($_REQUEST['field']))
	{
	$column_name=$_REQUEST['field'];
	$objProduct->setProperty("column_name", $column_name);
	$objProduct->setProperty("sort", $sort);
	$objProduct->lstReportSort();
	}
	else
	{
	$objProduct->lstReport();
	}
	//echo $objProduct->getSQL();
	}
	else
	{
	$report_subcategory12='is NULL';
	$objProduct->setProperty("report_category", $category_cd);
	$objProduct->setProperty("report_subcategory", $report_subcategory12);
	if(isset($_REQUEST["status"]))
	{
	$objProduct->setProperty("report_status", $_REQUEST["status"]);
	}
	if(isset($sort) && isset($_REQUEST['field']))
	{
	$column_name=$_REQUEST['field'];
	$objProduct->setProperty("column_name", $column_name);
	$objProduct->setProperty("sort", $sort);
	$objProduct->lstReportsub_nullSort();
	}
	else
	{
	$objProduct->lstReportsub_null();
	}
	}
	
	$i=0;
	$isno=0;
	$Sql = $objProduct->getSQL();
	$objProduct->totalRecords();
	
	if($objProduct->totalRecords() >= 1){
		while($rows = $objProduct->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			$i++;
			
			?>
			<tr>

<td><?php $isno=$isno+1; echo  $isno;?></td>
<td><input type="checkbox"    name="file_download[]"  value="<?php echo $rows['report_id'];?>" form="reports_cat" /></td>
<?php
$temp5="select * from rs_tbl_category_template where cat_id='$category_cd'order by cat_temp_order asc";
$res_temp5=mysql_query($temp5);
while($ress_temp5=mysql_fetch_array($res_temp5))
{
 $cat_field_namee =$ress_temp5['cat_field_name'];
?>
<td>

				<?php
				if ($cat_field_namee=="report_title")
				{
					if($rows['report_file']!="")
					{
					?>
					<a href="<?php echo REPORT_URL.$rows['report_file'] ;?>" target="_blank"><?php echo $rows['report_title'];?></a>
					<?php
					}
					else
					{
					echo $rows['report_title'];
					}
				}
				else if($cat_field_namee=="doc_issue_date")
				{
					if($rows['doc_issue_date']=="" || $rows['doc_issue_date']==NULL || $rows['doc_issue_date']=="0000-00-00" || $rows['doc_issue_date']=="1970-01-01")
					{
					echo "";
					}
					else
					{
					echo date('d F Y',strtotime($rows['doc_issue_date']));
					}
				}
				else if($cat_field_namee=="doc_closing_date")
				{
					
					if($rows['doc_closing_date']=="" || $rows['doc_closing_date']==NULL || $rows['doc_closing_date']=="0000-00-00" || $rows['doc_closing_date']=="1970-01-01")
					{
					echo "";
					}
					else
					{
					echo date('d F Y',strtotime($rows['doc_closing_date']));
					}
				}
				else if($cat_field_namee=="doc_upload_date")
				{
					
					if($rows['doc_upload_date']=="" || $rows['doc_upload_date']==NULL || $rows['doc_upload_date']=="0000-00-00" || $rows['doc_upload_date']=="1970-01-01")
					{
					echo "";
					}
					else
					{
					echo date('d F Y',strtotime($rows['doc_upload_date']));
					}
				}
				/*else if($cat_field_namee=="report_status")
				{
					if($rows['report_status']==1)
					{
					echo "Active";
					}
					else if($rows['report_status']==2)
					{
					echo "Inactive";
					}
				}*/
				else
				{
				echo $rows[$cat_field_namee];
				}
				 
				 ?></td>
<?php }?>
<td style="color:#000066" ><?php echo $rows['doc_creater']; ?></td>
<td style="color:#000066" ><?php echo $rows['doc_last_modified_by']; ?></td>
<?php 
$sqldoc="Select * from rs_tbl_category where category_cd=".$_REQUEST['category_cd'];
			$res2doc=mysql_query($sqldoc);
			$total_numdd=mysql_num_rows($res2doc);
			if($total_numdd>=1)
			{
				 $f=1;
 			while($row2doc=mysql_fetch_array($res2doc))
			 {
			
			 ?>
			 <?php if($category_status==1){ ?>
			  <td><?php
			 		if($rows['report_status']=='1')
					{
					echo "Initiated <span style='float:right'><img width='15' height='15'  src='./images/initiated.png'  alt='Initiated' />";
					} 
					else if($rows['report_status']=='2')
					{
					echo "Approved <span style='float:right'><img width='15' height='15'  src='./images/approved.png'  alt='Approved' /></span>";
					}
					else if($rows['report_status']=='3')
					{
					echo  "Not Approved <span style='float:right'><img width='15' height='15'  src='./images/not_approved.png'  alt='Not Approved' /></span>";
					}
					else if($rows['report_status']=='4')
					{
					echo "Under Review <span style='float:right'><img width='15' height='15'  src='./images/under_review.png'  alt='Under Review' /></span>";
					}
					else if($rows['report_status']=='5')
					{
					echo "Response Awaited <span style='float:right'><img width='15' height='15'  src='./images/awaiting_decision.png'  alt='Awaiting Decision' /></span>";
					}
					else if($rows['report_status']=='7')
					{
					echo "Responded<span style='float:right'><img width='15' height='15'  src='./images/responded.png'  alt='Responded' /></span>";
					}?></td>
					<?php
					}
			 if($user_type==1)
			 {
			 ?>
			 <td><a href="javascript:void(null);" onclick="window.open('upload_report.php?report_id=<?php echo $rows['report_id']; ?>', 'INV','width=550,height=400,scrollbars=yes');" ><img src="./images/edit.gif" border="0" /></a></td>
			 <td style="color:#000066" align="right">&nbsp;<a href="?p=reports&report_cd=<?php echo $rows['report_id']; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 echo $cat;
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=delete"  onclick="return confirm('Are you sure, You want to delete this record?')"><img  src="./images/delete.gif"/></a></td>
			 <?php
			 }
			 else if($row2doc['parent_cd']==0)
			 {
			 ?>
			<td colspan="2"></td> 
			 <!--<td colspan="2"><a href="javascript:void(null);" onclick="window.open('upload_report.php?report_id=<?php //echo $rows['report_id']; ?>', 'INV','width=550,height=400,scrollbars=yes');" ><img src="./images/edit.gif" border="0" /></a></td>--> 
			 <?php
			 }
			
			 else
			 {
			$u_rightdoc=$row2doc['user_right'];
			$arruright_doc= explode(",",$u_rightdoc);
			$arr_right_docu=count($arruright_doc);		
			 foreach($arruright_doc as $key => $val) 
			 	{
			   $arruright_doc[$key] = trim($val);
			   $aright_doc= explode("_", $arruright_doc[$key]);
			    if($aright_doc[0]==$user_cd)
						{
							if($aright_doc[1]==1)
							{
							
							
?>
<td colspan="2"><a href="javascript:void(null);" onclick="window.open('upload_report.php?report_id=<?php echo $rows['report_id']; ?>', 'INV','width=550,height=400,scrollbars=yes');" ><img src="./images/edit.gif" border="0" /></a></td>
<?php
}
							else if($aright_doc[1]==2)
							{
							?>
							<td></td>
							<?php
							}
					}
				}
				}
				$f++;
				}
			}
?>
</tr>
			
			
			
	<?php		
			
		
			
		}
    }
	else{
	?>
    <tr>
    	<td colspan="8" align="center" style="background-color:white"><?php echo "No record Found";?></td>
    </tr>
		<?php
        }
        ?>
</table>
</td>
</tr>
<?php


$temp_t="Select * from rs_tbl_threads_titles where category_cd=".$_GET['category_cd']."  order by tt_id";
$temp_t1=mysql_query($temp_t);
if(mysql_num_rows($temp_t1)>=1)
{
?>
<tr>
<td  colspan="5"   style="line-height:18px; text-align:justify">


<span style="margin-left:45px;  font-size:16px; font-weight:bold">Threads</span>
<span style="font-size:16px; font-weight:bold; float:right">
<?php if(isset($_GET['cat_cd']))
{
$cat_cd12="&cat_cd=".$_GET['cat_cd'];
} ?>
<form name="filter_12" id="filter_12" method="post" action="?p=reports&cid=<?php echo $_GET['cid']; ?>&category_cd=<?php echo $_GET['category_cd']?><?php echo $cat_cd12; ?>"> 
<select name="task_status" >
		<option value="7" <?php if(!isset($_GET['t_status']))echo "selected";?>>All Files</option>
		 <option value="1" <?php if($_GET['t_status']=='1')echo "selected";?>>Initiated</option>
  		<option value="2" <?php if($_GET['t_status']=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($_GET['t_status']=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($_GET['t_status']=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($_GET['t_status']=='5')echo "selected";?>>Response Awaited</option>
		 <option value="6" <?php if($_GET['t_status']=='6')echo "selected";?>>Replied</option>
</select> 
		
		<input type="submit" name="go_submit1" id="go_submit1" value="GO" /> </form></span>

<table class="report_tbl" align="right" cellspacing="0" style="margin-top:5px;"  >

<tr>
<td style="color:#000066" width="2%">Task Code/Sr. #</td>
<td width="40%"  colspan="2" style="color:#000066">Title</td>
<td style="color:#000066" width="13%">Created By</td>
<td style="color:#000066" width="15%">Date-Time</td>
<td style="color:#000066" width="22%">Status</td>
<td width="8%" colspan="2">Action </td>
 </tr>

<?php
while($res_t=mysql_fetch_array($temp_t1))
{


$u_rightr_task=$res_t['user_right'];
			$arrurightr_task= explode(",",$u_rightr_task);
			$arr_right_usersr_task=count($arrurightr_task);		
			 foreach($arrurightr_task as $key2 => $val2) 
			 	{
			   $arrurightr_task[$key2] = trim($val2);
			   $arightr_task= explode("_", $arrurightr_task[$key2]);
			    if(($arightr_task[0]==$user_cd))
						{
							if($arightr_task[1]==1)
							{
							$read_right_task=1;
							}
							else if($arightr_task[1]==2)
							{
							$read_right_task=2;
							}
						$has_right=1;
						}
					}
?>
<?php
if(($has_right==1) || ($user_type=='1'))
{
?>
<tr style=" background-color: #FFFF00">
<td style="background:none;" align="center"><?php echo $res_t['thread_code'];?></td>

<td style="background:none; border-right:0; width:30%" > <?php echo $res_t['thread_heading']; ?></td>
<td style="background:none; width:10%" ><?php if($res_t['status']==1){
if(($read_right_task==1) || ($user_type=='1'))
{ 
 ?> <a href="javascript:void(null);" onclick="window.open('tasks_messages.php?task_id=<?php echo $res_t['tt_id']; ?>&cat_cd=<?php echo $res_t['category_cd']; ?>&cid=<?php echo $_GET['cid'];?>&p_mess_id=0', 'INV2','width=550,height=400,scrollbars=yes');" >Add Item</a><?php }} ?></td>
<td style="background:none;"><?php echo $res_t['thread_created_by']; ?></td>
<td style="background:none;"><?php echo $res_t['date_time'];?></td>
<td style="background:none;">
<?php if($res_t['status']=='1')
{
?>
<a href="?p=reports&sel_task_id=<?php echo $res_t['tt_id']; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=lock"  onclick="return confirm('Are you sure, You want to Lock this task?')">Active</a>	


<?php 
					} 
					else if($res_t['status']=='0')
					{
					?>
					<a href="?p=reports&sel_task_id=<?php echo $res_t['tt_id']; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=active"  onclick="return confirm('Are you sure, You want to Active this task?')">Locked</a>	
					<?php
					}
					?></td>

				<?php
				if($user_type=='1')
				{
				?>	
					
					
					 <td colspan="2" style="background:none;"><a href="javascript:void(null);" onclick="window.open('threads_input.php?task_id=<?php echo $res_t['tt_id']; ?>&cat_cd=<?php echo $res_t['category_cd']; ?>', 'INV','width=550,height=400,scrollbars=yes');" ><img src="images/edit.gif" border="0" /></a></td>
			 <!--<td style="background:none;"><a href="?p=reports&sel_task_id=<?php /*echo $res_t['tt_id']; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd'];*/ ?>&mode=task_delete"  onclick="return confirm('Are you sure, You want to delete this task?')"><img  src="./images/delete.gif"/></a>		 </td>-->
			 <?php
			 }
			 
			
			
				
						
						
					
			if($read_right_task==1)
{ 
				?>
				<td colspan="2" style="background:none;">
				<!--<a href="javascript:void(null);" onclick="window.open('threads_input.php?task_id=<?php //echo $res_t['tt_id']; ?>&cat_cd=<?php //echo $res_t['category_cd']; ?>', 'INV','width=550,height=400,scrollbars=yes');" ><img src="images/edit.gif" border="0" /></a>--></td>
<?php
}
else if($read_right_task==2)
{
?>
<td colspan="2" style="background:none;"></td>
<?php
}
?>	
	 
</tr>



<?php

include_once("example.php");
$all_childs=array();
$all_childs=sorted_data($res_t['tt_id'], $_GET['t_status']);

$thread = 0;
$count=0;
	foreach($all_childs as $x =>$chld) {
	
	//$message_id= $chld["message_id"];
	$parent_message_id=$chld["parent_message_id"];	
 	$cat_cd= $chld["cat_cd"];
	$thread_no= $chld["thread_no"];
 	$thread_title= $chld["thread_title"];
 	$thread_comments= $chld["thread_comments"];
 	$created_date_time= $chld["created_date_time"];
 	$thread_created_by= $chld["thread_created_by"]; 
	$creator_id= $chld["creator_id"]; 
	$thread_status= $chld["thread_status"]; 
	$meassage_sent_by= $chld["meassage_sent_by"]; 
	$meassage_sent_email= $chld["meassage_sent_email"]; 


$count=$count+1;
$mess_id=$chld['message_id'];
if($res_temp1['parent_message_id']==0)
{
$colorr="#F5F5F5";
}
else
{
$colorr="#FFFFFF";
}

?>
<tr style=" background-color: <?php echo $colorr; ?>">
<td style="background:none; text-align:center"><?php echo $count;?></td>

<td style="background:none;" colspan="2" >
<a href="javascript:void(null);" onclick="window.open('thread_detail1.php?mess_id=<?php echo $mess_id; ?>&category_cd=<?php echo $_GET['category_cd']; ?>&cid=<?php echo $_GET['cid']; ?>', 'INV','left=5,top=60,width=550,height=400,scrollbars=yes');"> <?php echo $thread_title; ?></a></td>
<td style="background:none;"><?php echo $thread_created_by; ?></td>
<td style="background:none;"><?php echo $created_date_time;?></td>
<td style="background:none;"><?php if($thread_status=='1')
					{
					echo "Initiated <img width='15' height='15'  src='./images/initiated.png'  alt='Initiated' />";
					} 
					else if($thread_status=='2')
					{
					echo "Approved <img width='15' height='15'  src='./images/approved.png'  alt='Approved' />";
					}
					else if($thread_status=='3')
					{
					echo  "Not Approved <img width='15' height='15'  src='./images/not_approved.png'  alt='Not Approved' />";
					}
					else if($thread_status=='4')
					{
					echo "Under Review <img width='15' height='15'  src='./images/under_review.png'  alt='Under Review' />";
					}
					else if($thread_status=='5')
					{
					echo "Response Awaited <img width='15' height='15'  src='./images/awaiting_decision.png'  alt='Awaiting Decision' />";
					}
					else if($thread_status=='6')
					{
					echo "Replied";
					}?></td>
					 <td style="background:none;"></td>
			 <td style="background:none;"> </td>
</tr>
<?php 
}
?>
 
<?php

	}
	}
					
?>
</table>
</td>
</tr>
<?php
}
?>
</table>
		
		</div>
 			
		
		
  
</div>

      