<?php
$report_path = REPORT_PATH;
$user_type=$objAdminUser->user_type;
$user_cd	= $objAdminUser->user_cd;

$fromdate = $_REQUEST['fd'];
$todate = $_REQUEST['td'];

$extension = $_REQUEST['ext'];
$last_subcat="";
$sCondition = '';
$extensionn='';
if($extension!="")
{
	if($extension=="pdf")
	{
	$extensionn="'pdf' or extension='PDF'";
	}
	else if ($extension=="doc")
	{
	  $extensionn="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
	}
	else if ($extension=="img")
	{
	  $extensionn="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
	}
	else if ($extension=="dwg")
	{
	   $extensionn="'dwg' or extension='DWG'";
	}
	else if ($extension=="other")
	{
	   $extensionn="'pdf' and extension!='PDF' and extension!='doc' and extension!='DOC' and extension!='DOCX' and extension!='docx' and extension!='txt' and extension!='TXT' and extension!='xls' and extension!='xlsx' and extension!='XLS' and extension!='XLSX' and extension!='jpg' and extension!='jpeg' and extension!='JPG' and extension!='JPEG' and extension!='GIF' and extension!='gif' and extension!='png' and extension!='PNG' and extension!='dwg' and extension!='DWG'";
	}
	

	if($sCondition!="")
	{
		if ($extension=="other")
		{
		$sCondition.=" AND (extension!=$extensionn)";
		}
		else
		{
		$sCondition.=" AND (extension=$extensionn)";
		}
	}
	else
	{
	if ($extension=="other")
		{
		$sCondition=" (extension!=$extensionn)";
		}
		else
		{
		$sCondition=" (extension=$extensionn)";
		}
	}

}


/*if(($fromdate!="") && ($todate!=""))
{
$fromdate1 = date('Y-m-d',strtotime($fromdate));
$todate1 = date('Y-m-d',strtotime($todate));
	if($sCondition!="")
	{
	$sCondition.=" AND ((uploading_file_date>='$fromdate1') AND (uploading_file_date<='$todate1'))";
	}
	else
	{
	$sCondition=" ((uploading_file_date>='$fromdate1') AND (uploading_file_date<='$todate1'))";
	}
//	echo $sCondition;
}
else if(($fromdate!="") && ($todate==""))
{
$fromdate1 = date('Y-m-d',strtotime($fromdate));
$current_date=date('Y-m-d');
	if($sCondition!="")
	{
	$sCondition.=" AND ((uploading_file_date>='$fromdate1') AND (uploading_file_date<='$current_date'))";
	}
	else
	{
	$sCondition=" ((uploading_file_date>='$fromdate1') AND (uploading_file_date<='$current_date'))";
	}

}
else if(($fromdate=="") && ($todate!=""))
{
$doc_upload_datet1 = date('Y-m-d',strtotime($todate));
	if($sCondition!="")
	{
	$sCondition.=" AND  (uploading_file_date<='$todate1')";
	}
	else
	{
	$sCondition=" (uploading_file_date<='$todate1')";
	}

}*/
if($sCondition=="")
	{
$sCondition="1=1";
	}
$orderby = " order by report_id asc";

?>
	<?php
	
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_submit"])){

	 	$files_download =$_POST['file_download'];
		//$category=$_GET['category_cd'];
		 if(isset($files_download)){ 
		$files_count=count($files_download); 
		 for($i=0;$i<$files_count;$i++)
		 {
		 $all_download[]=$files_download[$i];		
		 }
		 $out = '';
	//$out .="category_name".",";
   $out .="report_title".",";
   $out .="report_file".",";
   $out .="doc_issue_date".",";
   $out .="report_status".",";
   $out .="doc_upload_date".",";
   $out .="doc_creater".",";
   $out .="doc_last_modified_by".",";
   $out .="\n";
		foreach ($all_download as $selected_file_id) {

$getquery="SELECT report_title,report_file,doc_issue_date,report_status,doc_upload_date,doc_creater,doc_last_modified_by FROM rs_tbl_documents where report_id=$selected_file_id";
 $result=mysql_query($getquery);
$num_rows = mysql_num_rows($result);

  $l = mysql_fetch_array($result);
  
	$results[] = $l['report_file'];
  //  $cat_name=preg_replace('/\s+/','_',$l['category_name']);
    //$out.=$l['category_name'].",";
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
 $filename1 = $td.".zip";
  //$filename1 = $cat_name.$td.".zip";
 // $f = fopen ("data/".$filename,'w+');
 // fputs($f, $out);
  //fclose($f);
  
  
  $zip = new ZipArchive();
$filename = SITE_PATH."Zip/".$filename1;

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}
//$zip->addFromString("list-".$cat_name.$td.".csv", $out);
$zip->addFromString("list-".$td.".csv", $out);
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
  $(function() {
    $( "#doc_issue_date" ).datepicker();
	
  });
  $(function() {
    $( "#doc_upload_datef" ).datepicker();
	
  });
   $(function() {
    $( "#doc_upload_datet" ).datepicker();
	
  });
   $(function() {
    $( "#received_date" ).datepicker();
	
  });
 
  </script>
  
<div id="wrapperPRight">

<div id="containerContent" style="min-height:80px;padding:0px">

<h2 align="center">Complete Documents Summary <br /> All Files (PDF,DOC,XLSX,TXT,JPG,GIF,PNG,DWG and Others)</h2>
<div id="weeklysearch"><?php 

$sSQL1 = "SELECT * FROM rs_tbl_documents WHERE ".$sCondition.$orderby;
$sSQL12=mysql_query($sSQL1);
$iCount = mysql_num_rows($sSQL12);
if($iCount>0)
{
?>
<form action="" method="post"  name="report_cat" id="report_cat" onsubmit="return atleast_onecheckbox(event)">

<p style="text-align:right; margin-right:10px; font-weight:bold"><a href="./?p=document_summary" class="lnkButton"><?php echo "Back";?>	</a></p>   
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th  width="4%" style="text-align:center"><strong>Sr. No.</strong></th>
	  <th  width="36%" style="text-align:center"><strong>Title</strong></th>
	  <th  width="5%" style="text-align:center"><strong>Type</strong></th>
      <th  width="10%" style="text-align:center"><strong>Document No.</strong></th>
	  <th  width="25%" style="text-align:center"><strong>Reference No.</strong></th>
      <th  width="10%" style="text-align:center"><strong>Uploaded Date</strong></th>
	 <th  width="10%" style="text-align:center"><strong>Size (MBs)</strong></th>
    </tr>
  


<?php
$i=0;
	while($sSQL3=mysql_fetch_array($sSQL12))
	{
		$report_category 			= $sSQL3['report_category'];
		$report_id 					= $sSQL3['report_id'];
		$report_title  				= $sSQL3['report_title'];
		$file  						= $sSQL3['report_file'];
		$extension  				= $sSQL3['extension'];
		$document_no  				= $sSQL3['document_no'];
		$reference_no  				= $sSQL3['reference_no'];
		$uploading_file_date  		= $sSQL3['uploading_file_date'];
		$file_size  				= $sSQL3['file_size'];
		
		if($last_subcat==0 || $last_subcat=="")
	{
	$sSQL2 = "SELECT * FROM rs_tbl_category WHERE category_cd=".$report_category;
	}
	else
	{
		
	$sSQL2 = "SELECT * FROM rs_tbl_category WHERE category_cd=".$report_category." and INSTR(parent_group, '$parent_group_p')>0";
	}
	$sSQL13=mysql_query($sSQL2);
	$sSQL4=mysql_fetch_array($sSQL13);
	$category_name=$sSQL4['category_name'];
	$user_ids=$sSQL4['user_ids'];
	$parent_cd=$sSQL4['parent_cd'];
	$cid=$sSQL4['cid'];
	$parent_group=$sSQL4['parent_group'];
		if($user_type==1)
		{
		if(mysql_num_rows($sSQL13)>=1)	
		{	
		?>
		<tr <?php echo $style; ?>>
		
<td ><center> <?php echo $i=$i+1;?> </center> </td>
<td ><a href="?p=reports&category_cd=<?php echo $report_category;?>&cid=<?php echo $cid; ?>&cat_cd=<?php echo $parent_cd; ?>" style=" font-weight:bold"><?php echo $category_name?></a> &raquo; <a href="<?php echo REPORT_URL.$file ;?>" target="_blank"><?=$report_title;?></a></td>
<td ><?=$extension;?></td>
<td ><?=$document_no;?></td>
<td ><?=$reference_no;?></td>
<td style="text-align:center" ><?=$uploading_file_date;?></td>
<td style="text-align:center"><?=round($file_size/(1024*1024),3);?></td>


</tr>

		<?php
		}
		}
		else
		{
		

	if($user_ids=="" && $parent_cd==0)
	{
	if(mysql_num_rows($sSQL13)>=1)	
	{
	?>
	<tr <?php echo $style; ?>>
<td ><center> <?php echo $i=$i+1;?> </center> </td>
<td ><a href="?p=reports&category_cd=<?php echo $report_category;?>&cid=<?php echo $cid; ?>&cat_cd=<?php echo $parent_cd; ?>" style=" font-weight:bold"><?php echo $category_name?></a> &raquo; <a href="<?php echo REPORT_URL.$file ;?>" target="_blank"><?=$report_title;?></a></td>
<td ><?=$extension;?></td>
<td ><?=$document_no;?></td>
<td ><?=$reference_no;?></td>
<td style="text-align:center"><?=$uploading_file_date;?></td>
<td style="text-align:center" ><?=round($file_size/(1024*1024),3);?></td>


</tr>
	<?php
	}
	}else
	{
	$group_arr=explode("_",$parent_group);
	$count_group_arr= count($group_arr);
	$sign=1;
	for($k=1;$k<$count_group_arr;$k++)
	{
	$cat_id=$group_arr[$k];
	$sSQL_loop = "SELECT * FROM rs_tbl_category WHERE category_cd=".$cat_id;
	$sSQLloop=mysql_query($sSQL_loop);
	$sSQLloop1=mysql_fetch_array($sSQLloop);

	$user_p_ids=$sSQLloop1['user_ids'];
	
	
	
	
	$exp_arr=explode(",", $user_p_ids);
	$count_exp_arr= count($exp_arr);
	$flg="";
		for($j=0; $j<$count_exp_arr; $j++)
		{
		
			if($exp_arr[$j]==$user_cd)
			{
			$flg=1;
			}
			
		}
	if($flg==1)
		{
		
		$sign=$sign+1;
		continue;
		}
	else
		{
		
		$sign=1;
		break;
		}	
	
?>

<?php 
}
if($count_group_arr==$sign)
{
if(mysql_num_rows($sSQL13)>=1)	
{
?>
<tr <?php echo $style; ?>>
<td ><center> <?php echo $i=$i+1;?> </center> </td>
<td ><a  href="?p=reports&category_cd=<?php echo $report_category;?>&cid=<?php echo $cid; ?>&cat_cd=<?php echo $parent_cd; ?>" style=" font-weight:bold"><?php echo $category_name?></a> &raquo; <a href="<?php echo REPORT_URL.$file ;?>" target="_blank"><?=$report_title;?></a></td>
<td ><?=$extension;?></td>
<td ><?=$document_no;?></td>
<td ><?=$reference_no;?></td>
<td style="text-align:center"><?=$uploading_file_date;?></td>
<td style="text-align:center"><?=round($file_size/(1024*1024),3);?></td>


</tr>
<?php
}
}
}
}       
	}
?>
</table>
</form>

<?php
} else { echo "<br />","<center> No Report Found..... </center> <br /><br />"; }

?></div>
	
  </div> 
	</div>

      