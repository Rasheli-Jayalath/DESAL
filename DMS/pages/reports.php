
<script src="lightbox/js/lightbox.min.js"></script>
  <link href="lightbox/css/lightbox.css" rel="stylesheet" /> 
<?php
$objDb		= new Database;

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
				$res2d=$objDb->dbCon->query($sql2d);
			    $row2d=$res2d->fetch();				
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
	$objDb->dbCon->query($sSQLlog_log);	
				redirect('./?p=reports&category_cd='.$category_cd_del.'&cat_cd='.$cat_cd_del.'&cid='.$cid_del);
	
	
}
if(isset($_GET['mode']) && $_GET['mode'] == "cat_delete"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$category_cd_cat = $_GET['sel_category_cd'];
				 $sql2c="Select * from rs_tbl_category where parent_cd='$category_cd_cat'";
				 $res2d=$objDb->dbCon->query($sql2c);
			   	if($res2d->rowCount()>=1)
				{
				
				$objCommon->setMessage("You should delete its sub category(s) first", 'Error');
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
				}
				else
				{
			   	$sql2t="Select * from rs_tbl_documents where report_category='$category_cd_cat'";
			   	$res2t=$objDb->dbCon->query($sql2t);
			   
			   
					if($res2t->rowCount()>=1)
					{
					$objCommon->setMessage("You should delete its document(s) first", 'Error');
					redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
					}
					else
					{
					 $sdeletet= "Delete from rs_tbl_category_template where cat_id='$category_cd_cat'";
					   $objDb->dbCon->query($sdeletet);
						$objProduct->resetProperty();
						$objProduct->setProperty("category_cd", $category_cd_cat);
						$objProduct->actCategory("D");
						$objCommon->setMessage(PRD_DELETE_SUCCESS, 'Info');
						$activity="Category deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	 $objDb->dbCon->query($sSQLlog_log);		
						
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
				 $objDb->dbCon->query($delete_task_msg);
				
				$delete_task_attach= "Delete from rs_tbl_attachments where thread_no='$sel_task_id'";
				$objDb->dbCon->query($delete_task_attach);
								
				$delete_task= "Delete from rs_tbl_threads_titles where tt_id='$sel_task_id'";
				$objDb->dbCon->query($delete_task);
				
				$activity="Task deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);
		
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
	
	
}

if(isset($_GET['mode']) && $_GET['mode'] == "lock"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$sel_task_id = $_GET['sel_task_id'];
				$status="0";
				 $sql_pro="UPDATE rs_tbl_threads_titles SET status='$status' where tt_id='$sel_task_id'";
				$objDb->dbCon->query($sql_pro);
				$activity="Task has been locked";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";	
				$objDb->dbCon->query($sSQLlog_log);
				redirect('./?p=reports&category_cd='.$category_cd_c.'&cat_cd='.$cat_cd_c.'&cid='.$cid_c);
	
	
}
if(isset($_GET['mode']) && $_GET['mode'] == "active"){
				$category_cd_c = $_GET['category_cd'];
				$cid_c = $_GET['cid'];
				$cat_cd_c = $_GET['cat_cd'];
				$sel_task_id = $_GET['sel_task_id'];
				$status="1";
				 $sql_pro="UPDATE rs_tbl_threads_titles SET status='$status' where tt_id='$sel_task_id'";
				$objDb->dbCon->query($sql_pro);
				$activity="Task has been activated";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);
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
	$objDb->dbCon->query($sdelete);
	
      $sdeletet= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
	  $objDb->dbCon->query($sdeletet);
	  
		$objProduct->resetProperty();
		$objProduct->setProperty("category_cd", $category_cd);
		$objProduct->actCategory("D");
		
		 $sql2c="Select * from rs_tbl_category where parent_cd='$category_cd'";
				$res2c=$objDb->dbCon->query($sql2c);
				if($res2c->rowCount()>=1)
				{
				while($row2c=$res2c->fetch())
				{
			 $sql2d="Select * from rs_tbl_documents";
			 $res2d=$objDb->dbCon->query($sSQLlog_log);
				
				while($row2d=$res2d->fetch())
				{
				$d_subcat=$row2d['report_subcategory'];
	
				$d_sub_cat=explode("_",$d_subcat);				
				$dl=count($d_sub_cat);
				for($h=0;$h<$dl;$h++)
				{
				$report_suby=$d_sub_cat[$h];
				if($report_suby==$row2c['category_cd'])
				{
				 $sdelete= "Delete from rs_tbl_documents where report_id='$row2d[report_id]'";
				 $objDb->dbCon->query($sdelete);
	 			
				}
				
				}
				//}
				
				}
				 $sdeletet= "Delete from rs_tbl_category_template where cat_id='$row2c[category_cd]'";
				 $objDb->dbCon->query($sdeletet);
	   
				$sdeletect= "Delete from rs_tbl_category where category_cd='$row2c[category_cd]'";
				$objDb->dbCon->query($sdeletect);
	 	 
		 		}
				}
				else
				{
				 $sql2d="Select * from rs_tbl_documents";
				 $res2d=$objDb->dbCon->query($sql2d);
				while($row2d=$res2d->fetch())
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
	 			 $objDb->dbCon->query($sdelete);
				}
				
				}
				
				}
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
 $result=$objDb->dbCon->query($getquery);
 
 $num_rows = $result->rowCount($result);

  $l = $result->fetch($result);
  
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

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["update_order"])){

	$category_order_list=$_POST["category_order"];
	$category_cd_list=$_POST["cat_cd"];
	$size_l=sizeof($category_cd_list);
	$size_a=sizeof($category_order_list);
	$msg="";
	if($size_l==$size_a)
	{
	for($i=0; $i<$size_a;$i++)
	{
		 $sq="Update rs_tbl_category SET category_order='".$category_order_list[$i]."' WHERE category_cd=".$category_cd_list[$i];
		 $result=$objDb->dbCon->query($sq);
	}
	$msg= "Order has been updated";
	}
	
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

<div id="" class="container" style="margin-top: 20px; margin-bottom: 50px;" >

<?php      
	
	$sqlss="select parent_group, category_status from rs_tbl_category where category_cd='$category_cd'";
	$sqlrwss=$objDb->dbCon->query($sqlss);
	$sqlrw1ss=$sqlrwss->fetch();
	$par_groups=$sqlrw1ss['parent_group'];
	$category_status=$sqlrw1ss['category_status'];
	$par_arr=explode("_",$par_groups);
	$lenns=count($par_arr);
	$category_name="";
	for($i=0;$i<$lenns;$i++)
	{
	 $sqlCN="select category_name,parent_cd,cid from rs_tbl_category where category_cd='$par_arr[$i]' ";
	$sqlrCN=$objDb->dbCon->query($sqlCN);
	$sqlCNrw=$sqlrCN->fetch();
	
	
	$category_name .='<a href="?p=reports&cid='.$sqlCNrw["cid"].'&cat_cd='.$sqlCNrw["parent_cd"].'&category_cd='.$par_arr[$i].'">'.$sqlCNrw["category_name"].'</a>';
	$category_name_heading = $sqlCNrw["category_name"];
	$category_name .="&nbsp;&raquo;&nbsp;";
	
	//$category_name .=$category_name;
	}
   $report_category=$category_name;
	$sql="Select * from rs_tbl_category where category_cd=".$category_cd;
	$res=$objDb->dbCon->query($sql);
	$row3=$res->fetch();
			
				//$report_category=$row3['category_name'];
				$parent_cd=$row3['parent_cd'];
				
			?>
         
    <?php echo $objCommon->displayMessage();?>
	<div id=""  > <!-- id tableContainer -->

    <div> <?php echo "<h5 class= \" semibold text-dark  text-center opacity-75 \" style=\" font-family: \"Gill Sans\", sans-serif;\"> ".$category_name_heading. "</h5>" ;?></div>  <!-- project name -->

		
<?php if($objAdminUser->user_type==1 || $objAdminUser->user_type==2)
{
  ?>
  <div style="text-align: right; "><!-- Action Buttons -->
<a class="btn btn-secondary commontextsize" href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" >
      <i class="bi bi-plus-square" style="margin-right: 10px;"></i>     Add Tasks</a> 
<a class="btn btn-secondary commontextsize" href="javascript:void(null);" onclick="window.open('category.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" > 
      <i class="bi bi-plus-square" style="margin-right: 10px;"></i>     Add Category</a> 	
<?php if($parent_cd!=0){?>
<a class="btn btn-secondary commontextsize" href="javascript:void(null);" onclick="window.open('upload_report.php?cat_cd=<?php echo $_REQUEST['cat_cd'];?>&category_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?> ', 'INV','width=550,height=400,scrollbars=yes');" >
      <i class="bi bi-plus-square" style="margin-right: 10px;"></i>     Add File</a>
<?php
}
?>
</div><!-- Action Buttons -->

<?php
}
else if($_REQUEST['category_cd'])
{
$cattid=$_REQUEST['category_cd'];
			$cqueryd = "select * from  rs_tbl_category  where category_cd='$cattid'";
			$cresultd=$objDb->dbCon->query($cqueryd);
			$cdatad=$cresultd->fetch();
			
			$p_cdd=$cdatad['parent_cd'];
			if($p_cdd==0)
			{
			?>
			<table width="100%"  align="center" border="0"  > 
			<tr>
<td height="40" colspan="2" align="center" style=" padding-bottom:15px;padding-left:125px;" width="50%"></td>
<td align="right" width="20%">
<!--<a href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Tasks</a> &nbsp;&nbsp;-->
</td>
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
		<td height="40" colspan="4" align="center" style=" padding-bottom:15px;padding-left:125px;" width="50%">
		</td>
		<td align="right" width="20%">
<!--<a href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Tasks</a> &nbsp;&nbsp;-->
<a href="javascript:void(null);" onclick="window.open('category.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
		width="32" height="32" />Add Category</a>&nbsp;&nbsp;
		<a href="javascript:void(null);" onclick="window.open('upload_report.php?cat_cd=<?php echo $_REQUEST["cat_cd"];?>&category_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=550,height=400,scrollbars=yes');" >
		<img src="<?php echo SITE_URL;?>images/doc.ico" border="0" width="32"/>Add File</a>	
</td>
		
		</tr>
							<?php
							}
							else if($aright[1]==3)
							{
							$read_right=3;
							?>
							<tr>
		<td height="40" colspan="4" align="center" style=" padding-bottom:15px;padding-left:125px;" width="50%">
		</td>
		<td align="right" width="20%">
<!--<a href="javascript:void(null);" onclick="window.open('threads_input.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
width="32" height="32" />Add Tasks</a> &nbsp;&nbsp;-->
<a href="javascript:void(null);" onclick="window.open('category.php?cat_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=870,height=550,scrollbars=yes');" ><img src="<?php echo SITE_URL;?>images/folder.ico" border="0" 
		width="32" height="32" />Add Category</a>
		<a href="javascript:void(null);" onclick="window.open('upload_report.php?cat_cd=<?php echo $_REQUEST["cat_cd"];?>&category_cd=<?php echo $category_cd;?>&cid=<?php echo $cid;?>', 'INV','width=550,height=400,scrollbars=yes');" >
		<img src="<?php echo SITE_URL;?>images/doc.ico" border="0" width="32"/>Add File</a>
</td>
		 
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
	
			  
	$sql2="Select * from rs_tbl_category where parent_cd=".$category_cd. " order by category_order asc";
	$res2=$objDb->dbCon->query($sql2);
	$total_num=$res2->rowCount();
		
			if($total_num>=1)
			{
			?>
			<tr>
<td height="99" colspan="5"   style="line-height:18px;"  >

<span style="font-size:16px; font-weight:bold">Folders</span>
<form name="form_order" id="form_order" method="post" > 
<div class="table-responsive commontextsize">
<table class="report_tbl table " id="customers"  cellspacing="0" style="margin-top:5px; margin-bottom:20px" >
<thead>
<tr >

<th class="semibold" scope="col"  width="2%">S#</th>
<?php
 $temp2="select * from rs_tbl_category_template where cat_id='$category_cd' order by cat_temp_order asc";
 $res_temp=$objDb->dbCon->query($temp2);
$res_temp2=$res_temp->fetch();
 $res_temp2['cat_title_text'];
?>
<th class="semibold" scope="col"  width="30%"><?php echo $res_temp2['cat_title_text'] ?></th>
<th class="semibold " scope="col" width="25%">Created By</th>
<th class="semibold" scope="col"  width="25%">Last Modified By</th>
<?php 
if($user_type=='1' || $user_type=='2')
{				
?>
 <th class="semibold text-center" width="8%" >  <button class="hover-zoom" type="submit" id="update_order" name="update_order"  value="Order" style= " background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;"> 
	Order by <i class="bi bi-caret-down-fill"></i> </button> </th>
 <?php
 }
 ?>
<th class="semibold text-center" width="5%" scope="col"  colspan="2">Actions</th>
<?php

?>

 </tr>
</thead>
 <?php
 $y=1;
 while($row2=$res2->fetch())
			 {
				$report_subcategory=$row2['category_name'];
				$category_order=$row2['category_order'];
				$subcategory_id=$row2['category_cd'];
			$sub_folder="Select * from rs_tbl_category where parent_cd=".$subcategory_id;
			$sub_folders=$objDb->dbCon->query($sub_folder);
			$total_subfolder=$sub_folders->rowCount();
		    $files="Select * from rs_tbl_documents where report_category=".$subcategory_id;
			$files1=$objDb->dbCon->query($files);
			$total_files=$files1->rowCount();
			
				if($user_type=='1' || $user_type=='2')
				{
				?>
				<tr>
<td style="color:#000066"><?php echo $y;?><input type="hidden" id="cat_cd[]" name="cat_cd[]" value="<?php echo $subcategory_id;?>" /></td>
<td style="color:#000066"><i class="bi bi-folder-fill iconblue" style="margin-right: 5px;"></i><a href="?p=reports&category_cd=<?php echo $subcategory_id; ?>&cat_cd=<?php echo $category_cd; ?>&cid=<?php echo $cid; ?>"><?php echo $report_subcategory?></a></td>
<td><?php echo $row2['creater'];?><br /><font size="-5"><?php echo "folders: ".$total_subfolder."&nbsp;&nbsp; Files: ".$total_files; ?></font></td>
<td><?php echo $row2['last_modified_by'];?></td>
<td ><input class="form-control d-flex justify-content-center" type="text" value="<?php echo $category_order;?>"  id="category_order[]" name="category_order[]" style="width:90%; padding: 0; margin 0; padding-right:30%; text-align : right;" /></td> 
<td class="text-center" style="color:#000066" align="right"><a href="javascript:void(null);" onclick="window.open('category.php?category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $cid;?>', 'INV','width=850,height=700,scrollbars=yes');" >
<i class="bi bi-pencil-fill iconorange" style="margin-right: 10px;"></i></a>
 <a href="?p=reports&sel_category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=cat_delete"  onclick="return confirm('Are you sure, You want to delete category?')"><i class="bi bi-trash-fill iconred"></i> </a></td>

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
							else if($arightr[1]==3)
							{
							$read_right=3;
							}					
				?>
				<tr>
<td style="color:#000066"><?php echo $y;?></td> <!-- user's view -->
<td style="color:#000066"><i class="bi bi-folder-fill iconblue" style="margin-right: 5px;"></i>&nbsp;<a href="?p=reports&category_cd=<?php echo $subcategory_id; ?>&cat_cd=<?php echo $category_cd; ?>&cid=<?php echo $cid; ?>"><?php echo $report_subcategory?></a></td>
<td><?php echo $row2['creater'];?><br /><font size="-5"><?php echo "folders: ".$total_subfolder."&nbsp;&nbsp; Files: ".$total_files; ?></font></td>
<td><?php echo $row2['last_modified_by'];?></td>
<?php if($read_right==1)
{ ?>
<td colspan="2" style="color:#000066" align="right"><a href="javascript:void(null);" onclick="window.open('category.php?category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $cid;?>', 'INV','width=850,height=700,scrollbars=yes');" >
<i class="bi bi-pencil-fill iconorange" style="margin-right: 10px;"></i> </a></td>
<?php
}
if($read_right==3)
{ ?>
<td  class="text-center" style="color:#000066" align="right"><a href="javascript:void(null);" onclick="window.open('category.php?category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $cid;?>', 'INV','width=850,height=700,scrollbars=yes');" >
<i class="bi bi-pencil-fill iconorange" style="margin-right: 10px;"></i></a><a style ="text-decoration: none; " href="?p=reports&sel_category_cd=<?php echo $subcategory_id; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=cat_delete"  onclick="return confirm('Are you sure, You want to delete category?')"> <i class="bi bi-trash-fill iconred"></i> </a></td>
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
		</div>
</form>
</td>
</tr>
			<?php
			}
			
				
	?>
	
<tr>	

<td  colspan="5"  style="line-height:18px; text-align:justify">
<form name="reports_cat" class="mt-4 " id="reports_cat" method="post" action="" onsubmit="return atleast_onecheckbox(event)"> </form>
<span class=" bold ">Files</span>
<?php if($category_status==1){ ?>
<span style="font-size:16px; font-weight:bold; float:right">
<?php if(isset($_GET['cat_cd']))
{
$cat_cd1="&cat_cd=".$_GET['cat_cd'];
} ?>
<form name="filter_1" id="filter_1" method="post" action="?p=reports&cid=<?php echo $_GET['cid']; ?>&category_cd=<?php echo $_GET['category_cd']?><?php echo $cat_cd1; ?>"> 
<select name="report_status" class="form-select-sm" >
		<option value="6" <?php if(!isset($_GET['status']))echo "selected"; ?>>All Files			</option>
		<option value="1" <?php if($_GET['status']=='1')echo "selected"; 	?>>Initiated			</option>
  		<option value="2" <?php if($_GET['status']=='2')echo "selected";	?>>Approved				</option>
  		<option value="3" <?php if($_GET['status']=='3')echo "selected";	?>>Not Approved			</option>
  		<option value="4" <?php if($_GET['status']=='4')echo "selected";	?>>Under Review			</option>
 	    <option value="5" <?php if($_GET['status']=='5')echo "selected";	?>>Response Awaited 	</option>
		<option value="7" <?php if($_GET['status']=='7')echo "selected";	?>>Responded			</option>
        <option value="8" <?php if($_GET['status']=='8')echo "selected";	?>>For Information Only	</option>
</select> 
		
		<input type="submit" class="btn btn-primary btn-sm commontextsize" form="filter_1" name="go_submit" id="go_submit" value="GO" /> </form>
</span>
<?php
}
?>
<?php if($category_status==1){?> <span style="float:right; padding-right:50px;"><?php } else { ?>
<span style="font-size:16px; font-weight:bold; float:right"><?php } ?>     <button type="submit" class="btn btn-success commontextsize" id="download_submit" name="download_submit"  value="Download Files"  form="reports_cat" > 
<i class="bi bi-download" style="margin-right: 10px;"  ></i> Download Files  </button>     </span>

<div style="margin-top: 20px; margin-bottom: 50px;">
<div class="table-responsive commontextsize ">
<table class="report_tbl table " id="customers"  cellspacing="0" style="margin-top:5px; margin-bottom:20px" >
<thead>
<tr >

<th class="semibold"  width="2%">S#</th>
<th class="semibold"  width="2%"><input  type="checkbox" name="chkAll" id=
          "chkAll" value="1" form="reports_cat" onclick="selectAllUnSelectAll(this,'file_download[]',reports_cat);"/></th>

<?php
$templ="select * from rs_tbl_category_template where cat_id='$category_cd' order by cat_temp_order asc";
$res_temp=$objDb->dbCon->query($templ);
$total=$res_temp->rowCount();
while($res_temp1=$res_temp->fetch())
{
//echo $cat_field_namee. $res_temp1['cat_field_name'];
?>
<?php if(isset($_GET['status']))
{
$stats="&status=".$_GET['status'];
} ?>
<th class="semibold"  width="12%"><?php echo $res_temp1['cat_title_text'] ?> 
 <a href="?p=reports&category_cd=<?php echo $category_cd; ?>&<?php if($cat_cd=="")
{
}
else
{ ?>cat_cd=<?php echo $cat_cd;}?>&cid=<?php echo $cid;?><?php echo $stats; ?>&field=<?php echo $res_temp1['cat_field_name'];?>&sort=<?php echo $order;?>"><?php if($order=="asc"){?><img src="images/asc.png" title="Ascending" alt="Ascending"/><?php }else{?> <img src="images/desc.png" title="Descending" alt="Descending"/><?php } ?> </a></th>

<?php
}

?>
<th class="semibold"  width="10%">Uploaded Date</th>
<th class="semibold"  width="12%">Created By</th>
<th class="semibold"  width="12%">Last Modified By</th>
<?php if($category_status==1){ ?>
<th class="semibold"  width="14%">Status</th>
<?php
}
?>
<th class="semibold text-center" width="1.6%" colspan="2">Action </th>
 </tr>
 </thead>
 
 <?php
	$objProduct->resetProperty();
	$objProduct->setProperty("limit", PERPAGE);
	//$objProduct->setProperty("report_status", "1");
	if(isset($_GET['cat_cd']))
	{
	 $cat_cd=$_GET['cat_cd'];
	 
	$sqls="select parent_group from rs_tbl_category where category_cd='$category_cd' and parent_cd='$cat_cd'";
	$sqlrws=$objDb->dbCon->query($sqls);
	$sqlrw1s=$sqlrws->fetch();
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
$res_temp5=$objDb->dbCon->query($temp5);
$total=$res_temp5->rowCount();
while($ress_temp5=$res_temp5->fetch())
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
				else if($cat_field_namee=="received_date")
				{
					
					if($rows['received_date']=="" || $rows['received_date']==NULL || $rows['received_date']=="0000-00-00" || $rows['received_date']=="1970-01-01")
					{
					echo "";
					}
					else
					{
					echo date('d F Y',strtotime($rows['received_date']));
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
<td style="color:#000066" ><?php echo date('d F Y',strtotime($rows['uploading_file_date'])); ?></td>
<td style="color:#000066" ><?php echo $rows['doc_creater']; ?></td>
<td style="color:#000066" ><?php echo $rows['doc_last_modified_by']; ?></td>
<?php 
$sqldoc="Select * from rs_tbl_category where category_cd=".$_REQUEST['category_cd'];
$res2doc=$objDb->dbCon->query($sqldoc);
$total_numdd=$res2doc->rowCount();
			if($total_numdd>=1)
			{
				 $f=1;
 			while($row2doc=$res2doc->fetch())
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
					}
					
					else if($rows['report_status']=='8')
					{
					echo "For Information Only<span style='float:right'><img width='15' height='15'  src='./images/info.png'  alt='For Information Only' /></span>";
					}?></td>
					<?php
					}
					?>
<?php /*?><td><a href="javascript:void(null);" onclick="window.open('send_file.php?report_id=<?php echo $rows['report_id']; ?>', 'Email','width=550,height=400,scrollbars=yes');" ><img  src="./images/send_mail.png" title="Send Email"/></a></td><?php */?>
<?php	
			 if($user_type==1 || $user_type==2)
			 {
			 ?>
			 <td class="text-center"><a href="javascript:void(null);" style= "text-decoration: none;" onclick="window.open('upload_report.php?report_id=<?php echo $rows['report_id']; ?>', 'INV','width=870,height=550,scrollbars=yes');" ><i class="bi bi-pencil-fill iconorange" ></i> </a>
			 <a href="?p=reports&report_cd=<?php echo $rows['report_id']; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd']) 
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 echo $cat;
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=delete"  onclick="return confirm('Are you sure, You want to delete this record?')"> <i class="bi bi-trash-fill iconred" style="margin-left: 10px;" ></i> </a></td>
			 <?php
			 }
			 else if($row2doc['parent_cd']==0)
			 {
			 ?>
			<td colspan="2"></td> 
			 <!--<td colspan="2"><a href="javascript:void(null);" onclick="window.open('upload_report.php?report_id=<?php //echo $rows['report_id']; ?>', 'INV','width=550,height=400,scrollbars=yes');" > <i class="bi bi-pencil-fill iconorange" style="margin-right: 10px;"></i> </a></td>--> 
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
<td colspan="2"><a href="javascript:void(null);" onclick="window.open('upload_report.php?report_id=<?php echo $rows['report_id']; ?>', 'INV','width=870,height=550,scrollbars=yes');" > <i class="bi bi-pencil-fill iconorange" style="margin-right: 10px;"></i></a></td>
						
<?php
}
							else if($aright_doc[1]==3)
							{
							
							
?>
<td class="text-center"><a href="javascript:void(null);" onclick="window.open('upload_report.php?report_id=<?php echo $rows['report_id']; ?>', 'INV','width=870,height=550,scrollbars=yes');" > <i class="bi bi-pencil-fill iconorange" style="margin-right: 10px;"></i></a></td>
  <a href="?p=reports&report_cd=<?php echo $rows['report_id']; ?>&cid=<?php echo $_REQUEST['cid']; ?>&cat_cd=<?php if($_REQUEST['cat_cd'])
			 {
			 echo $_REQUEST['cat_cd'];
			 }
			 else
			 {
			 $cat=0;
			 echo $cat;
			 } ?>&category_cd=<?php echo $_REQUEST['category_cd']; ?>&mode=delete"  onclick="return confirm('Are you sure, You want to delete this record?')"> <i class="bi bi-trash-fill iconred"></i> </a></td>
						
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
	<?php $colspn=$total+7;?>
    	<td colspan="<?php echo $colspn; ?>" align="center" style="background-color:white"><?php echo "No record Found";?></td>
    </tr>
		<?php
        }
        ?>
</table>
	</div>
	</div>
</td>
</tr>
<?php


$temp_t="Select * from rs_tbl_threads_titles where category_cd=".$_GET['category_cd']."  order by tt_id";
$temp_t1=$objDb->dbCon->query($temp_t);
if($temp_t1->rowCount()>=1)
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
<select name="task_status" class="form-select-sm" >
		<option value="7" <?php  if(!isset($_GET['t_status'])) echo "selected";?>>All Files			</option>
		<option value="1" <?php if($_GET['t_status']=='1')     echo "selected";?>>Initiated			</option>
  	    <option value="2" <?php if($_GET['t_status']=='2')     echo "selected";?>>Approved			</option>
  	    <option value="3" <?php if($_GET['t_status']=='3')     echo "selected";?>>Not Approved		</option>
  		<option value="4" <?php if($_GET['t_status']=='4')     echo "selected";?>>Under Review		</option>
 		<option value="5" <?php if($_GET['t_status']=='5')     echo "selected";?>>Response Awaited	</option>
		<option value="6" <?php if($_GET['t_status']=='6'     )echo "selected";?>>Replied			</option>
</select> 
		
		<input type="submit" class="btn btn-primary btn-sm commontextsize" name="go_submit1" id="go_submit1" value="GO" /> </form></span>
<div class=" commontextsize" >
<table align="right" id="customers" class="table" >
	<thead>
		<tr>
			<th class="semibold"             width="10%">               Task Code/Sr. #	</th>
			<th class="semibold" 			 width="40%"  colspan="2" > Title			</th>
			<th class="semibold"             width="15%">				Created By		</th>
			<th class="semibold"			 width="15%">				Date-Time		</th>
			<th class="semibold text-center" width="10%">				Status			</th>
			<th class="semibold text-center" width="8%" >				Action 			</th>
		</tr>
	</thead>

<?php
while($res_t=$temp_t1->fetch())
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
<tr >
<td style="background:none;" align="center"><?php echo $res_t['thread_code'];?></td>

<td style="background:none; border-right:0; width:30%" > <?php echo $res_t['thread_heading']; ?></td>
<td style="background:none; width:10%" ><?php if($res_t['status']==1){
if(($read_right_task==1) || ($user_type=='1'))
{ 
 ?> <a href="javascript:void(null);" class="btn btn-sm btn-success commontextsize" onclick="window.open('tasks_messages.php?task_id=<?php echo $res_t['tt_id']; ?>&cat_cd=<?php echo $res_t['category_cd']; ?>&cid=<?php echo $_GET['cid'];?>&p_mess_id=0', 'INV2','width=550,height=400,scrollbars=yes');" ><i class="bi bi-plus-square" >&ensp; Add Item</a><?php }} ?></td>
<td style="background:none;"><?php echo $res_t['thread_created_by']; ?></td>
<td style="background:none;"><?php echo $res_t['date_time'];?></td>
<td class="text-center" style="background:none;">
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
				if($user_type=='1' || $user_type=='2')
				{
				?>	
					
					
					 <td class ="text-center" colspan="2" style="background:none;"><a href="javascript:void(null);" onclick="window.open('threads_input.php?task_id=<?php echo $res_t['tt_id']; ?>&cat_cd=<?php echo $res_t['category_cd']; ?>', 'INV','width=870,height=550,scrollbars=yes');" > <i class="bi bi-pencil-fill iconorange " ></i> </a></td>
		 <?php
			 }
			 
			
			
				
						
						
					
			if($read_right_task==1)
{ 
				?>
				<td colspan="2" style="background:none;">
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
   </div>
</td>
</tr>
<?php
}
?>
</table>
		
		</div>
 			
		
		
  
</div>

</body>

</html>
      