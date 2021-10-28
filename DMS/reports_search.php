<?php    
require_once("config/config.php");

$objCommon 		= new Common;
$objMenu 		= new Menu;
//$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
//$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
//$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
require_once('rs_lang.website.php');
require_once('rs_lang.eng.php');
?>
<?php
$user_cd	= $objAdminUser->user_cd;
$user_type	= $objAdminUser->user_type;

	$catid = $_REQUEST['catid'];
	$last_subcat = $_REQUEST['last_subcat'];
	if($last_subcat==0 || $last_subcat=="")
	{
	}
	else
	{
	$sSQL_p = "SELECT parent_group FROM rs_tbl_category WHERE category_cd=".$last_subcat;
	$sSQL_p1=mysql_query($sSQL_p);
	$sSQL_p2=mysql_fetch_array($sSQL_p1);
	$parent_group_p=$sSQL_p2['parent_group'];
	}

//$category = $_REQUEST['category'];
$titlee = $_REQUEST['titlee'];
$document_no = $_REQUEST['document_no'];
$reference_no = $_REQUEST['reference_no'];
$rep_reference_no = $_REQUEST['rep_reference_no'];
$revision = $_REQUEST['revision'];
$file_from = $_REQUEST['file_from'];
$file_to = $_REQUEST['file_to'];
$file_no = $_REQUEST['file_no'];
$file_category = $_REQUEST['file_category'];
$drawing_series = $_REQUEST['drawing_series'];
$doc_issue_date = $_REQUEST['doc_issue_date'];
$received_date = $_REQUEST['received_date'];
$doc_upload_datef = $_REQUEST['doc_upload_datef'];
$doc_upload_datet = $_REQUEST['doc_upload_datet'];
$remarks = $_REQUEST['remarks'];
//$valuei = date('Y-m-d',strtotime($valueidate));

$now = new DateTime();
$nowyear = $now->format("Y");


$sCondition = '';

if($document_no!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (document_no LIKE '%".$document_no."%')";
	}
	else
	{
	$sCondition=" (document_no LIKE '%".$document_no."%')";
	}
//	echo $sCondition;
}
if($reference_no!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (reference_no LIKE '%".$reference_no."%')";
	}
	else
	{
	$sCondition=" (reference_no LIKE '%".$reference_no."%')";
	}
//	echo $sCondition;
}

if($rep_reference_no!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (rep_reference_no LIKE '%".$rep_reference_no."%')";
	}
	else
	{
	$sCondition=" (rep_reference_no LIKE '%".$rep_reference_no."%')";
	}
//	echo $sCondition;
}

if($revision!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (revision LIKE '%".$revision."%')";
	}
	else
	{
	$sCondition=" (revision LIKE '%".$revision."%')";
	}
//	echo $sCondition;
}
if($file_from!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (file_from LIKE '%".$file_from."%')";
	}
	else
	{
	$sCondition=" (file_from LIKE '%".$file_from."%')";
	}
//	echo $sCondition;
}
if($file_to!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (file_to LIKE '%".$file_to."%')";
	}
	else
	{
	$sCondition=" (file_to LIKE '%".$file_to."%')";
	}
//	echo $sCondition;
}
if($file_no!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (file_no LIKE '%".$file_no."%')";
	}
	else
	{
	$sCondition=" (file_no LIKE '%".$file_no."%')";
	}
//	echo $sCondition;
}
if($file_category!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (file_category LIKE '%".$file_category."%')";
	}
	else
	{
	$sCondition=" (file_category LIKE '%".$file_category."%')";
	}
//	echo $sCondition;
}
if($drawing_series!="")
{

	if($sCondition!="")
	{
	$sCondition.=" AND (drawing_series LIKE '%".$drawing_series."%')";
	}
	else
	{
	$sCondition=" (drawing_series LIKE '%".$drawing_series."%')";
	}
//	echo $sCondition;
}

if($titlee!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (report_title LIKE '%".$titlee."%')";
	}
	else
	{
	$sCondition=" (report_title LIKE '%".$titlee."%')";
	}
//	echo $sCondition;
}
if($doc_issue_date!="")
{
$doc_issue_date1 = date('Y-m-d',strtotime($doc_issue_date));

	if($sCondition!="")
	{
	$sCondition.=" AND (doc_issue_date='$doc_issue_date1')";
	}
	else
	{
	$sCondition=" (doc_issue_date='$doc_issue_date1')";
	}
//	echo $sCondition;
}
if($received_date!="")
{
$received_date1 = date('Y-m-d',strtotime($received_date));

	if($sCondition!="")
	{
	$sCondition.=" AND (received_date='$received_date1')";
	}
	else
	{
	$sCondition=" (received_date='$received_date1')";
	}
//	echo $sCondition;
}

if($remarks!="")
{
	if($sCondition!="")
	{
	$sCondition.=" AND (remarks LIKE '%".$remarks."%')";
	}
	else
	{
	$sCondition=" (remarks LIKE '%".$remarks."%')";
	}
//	echo $sCondition;
}
if(($doc_upload_datef!="") && ($doc_upload_datet!=""))
{

$doc_upload_datef1 = date('Y-m-d',strtotime($doc_upload_datef));
$doc_upload_datet1 = date('Y-m-d',strtotime($doc_upload_datet));
	if($sCondition!="")
	{
	$sCondition.=" AND ((uploading_file_date>='$doc_upload_datef1') AND (uploading_file_date<='$doc_upload_datet1'))";
	}
	else
	{
	$sCondition=" ((uploading_file_date>='$doc_upload_datef1') AND (uploading_file_date<='$doc_upload_datet1'))";
	}
//	echo $sCondition;
}
else if(($doc_upload_datef!="") && ($doc_upload_datet==""))
{
$doc_upload_datef1 = date('Y-m-d',strtotime($doc_upload_datef));
$current_date=date('Y-m-d');
	if($sCondition!="")
	{
	$sCondition.=" AND ((uploading_file_date>='$doc_upload_datef1') AND (uploading_file_date<='$current_date'))";
	}
	else
	{
	$sCondition=" ((uploading_file_date>='$doc_upload_datef1') AND (uploading_file_date<='$current_date'))";
	}
//	echo $sCondition;
}
else if(($doc_upload_datef=="") && ($doc_upload_datet!=""))
{
$doc_upload_datet1 = date('Y-m-d',strtotime($doc_upload_datet));
	if($sCondition!="")
	{
	$sCondition.=" AND  (uploading_file_date<='$doc_upload_datet1')";
	}
	else
	{
	$sCondition=" (uploading_file_date<='$doc_upload_datet1')";
	}
//	echo $sCondition;
}


$orderby = " order by report_id asc";

/*if($valueo!="")
{
	$orderby = " order by ".$valueo." ".$valueos;
	
} else {
	$orderby = " order by report_id"." ".$valueos;	
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Interactive Search</title>
<link rel="stylesheet" type="text/css" href="css/style.css">

<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('cvcheck[]');
  for each(var checkbox in checkboxes)
    checkbox.checked = source.checked;
}
</script>


</head>

<body>
<?php include ('includes/saveurl.php');?>
<?php 
if($titlee=="" && $document_no==""&& $reference_no=="" && $rep_reference_no=="" && $revision==""&& $file_from==""&& $file_to==""&& $file_no==""&& $file_category==""&& $drawing_series=="" && $doc_issue_date==""&& $received_date=="" && $doc_upload_datef=="" && $doc_upload_datet==""&& $remarks=="")
{
}
else
{
$sSQL1 = "SELECT * FROM rs_tbl_documents WHERE ".$sCondition.$orderby;
$sSQL12=mysql_query($sSQL1);
$iCount = mysql_num_rows($sSQL12);
if($iCount>0)
{
?>
<form action="" method="post"  name="report_cat" id="report_cat" onsubmit="return atleast_onecheckbox(event)">




 <input type="submit" name="download_submit" id="download_submit" value="Download Files" form="report_cat" />
   
	<table class="reference" style="width:100%" > 
    <tr bgcolor="#333333" style="text-decoration:inherit; color:#CCC">
    
      <th align="center" width="2%"><strong>Sr. No.</strong></th>
	   <th align="center" width="2%"><input  type="checkbox"  name="chkAll" id=
          "chkAll" value="1"   onclick="selectAllUnSelectAll_1(this,'file_download[]',report_cat);" /></th>
      <th align="center" width="15%"><strong>Title</strong></th>
      <th align="center" width="10%"><strong>Document No.</strong></th>
	  <th align="center" width="10%"><strong>Reference No.</strong></th>
	  <th align="center" width="10%"><strong>Reply Reference No.</strong></th>
      <th align="center" width="5%"><strong>Revision No.</strong></th>
	  <th align="center" width="5%"><strong>From</strong></th>
	  <th align="center" width="5%"><strong>To</strong></th>
	  <th align="center" width="5%"><strong>File No.</strong></th>
	  <th align="center" width="10%"><strong>File Category</strong></th>
	  <th align="center" width="10%"><strong>Drawing Series</strong></th>
	 <th align="center" width="5%"><strong>Issue Date</strong></th>
	 <th align="center" width="5%"><strong>Received Date</strong></th>
	 <th align="center" width="6%"><strong>Document Upload Date</strong></th>
	 <th align="center" width="10%"><strong>Remarks</strong></th>
    </tr>
  


<?php
$i=0;
	while($sSQL3=mysql_fetch_array($sSQL12))
	{
		$report_category 			= $sSQL3['report_category'];
		$report_id 					= $sSQL3['report_id'];
		$report_title  				= $sSQL3['report_title'];
		$file  						= $sSQL3['report_file'];
		$document_no  				= $sSQL3['document_no'];
		$reference_no  				= $sSQL3['reference_no'];
		$rep_reference_no  				= $sSQL3['rep_reference_no'];
		$file_from 					= $sSQL3['file_from'];
		$file_to 					= $sSQL3['file_to'];
		$file_no					= $sSQL3['file_no'];
		$file_category 				= $sSQL3['file_category'];
		$drawing_series 			= $sSQL3['drawing_series'];
		$doc_issue_date  			= $sSQL3['doc_issue_date'];
		$received_date  			= $sSQL3['received_date'];
		$revision  					= $sSQL3['revision'];
		$doc_upload_date  			= $sSQL3['uploading_file_date'];
		$remarks  					= $sSQL3['remarks'];
		
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
<td><input type="checkbox" class="checkbox"    name="file_download[]"  value="<?php echo $report_id;?>" form="report_cat"  onclick="selectUnSelect_top(this,report_cat);"/></td>
<td ><a href="?p=reports&category_cd=<?php echo $report_category;?>&cid=<?php echo $cid; ?>&cat_cd=<?php echo $parent_cd; ?>" style=" font-weight:bold"><?php echo $category_name?></a> &raquo; <a href="<?php echo REPORT_URL.$file ;?>" target="_blank"><?=$report_title;?></a></td>
<td ><?=$document_no;?></td>
<td ><?=$reference_no;?></td>
<td ><?=$rep_reference_no;?></td>
<td ><?=$revision;?></td>
<td ><?=$file_from;?></td>
<td ><?=$file_to;?></td>
<td ><?=$file_no;?></td>
<td ><?=$file_category;?></td>
<td ><?=$drawing_series;?></td>
<td ><?=$doc_issue_date;?></td>
<td ><?=$received_date;?></td>
<td ><?=$doc_upload_date;?></td>
<td ><?=$remarks;?></td>


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
<td><input type="checkbox" class="checkbox"    name="file_download[]"  value="<?php echo $report_id;?>" form="report_cat"  onclick="selectUnSelect_top(this,report_cat);"/></td>
<td ><a href="?p=reports&category_cd=<?php echo $report_category;?>&cid=<?php echo $cid; ?>&cat_cd=<?php echo $parent_cd; ?>" style=" font-weight:bold"><?php echo $category_name?></a> &raquo; <a href="<?php echo REPORT_URL.$file ;?>" target="_blank"><?=$report_title;?></a></td>
<td ><?=$document_no;?></td>
<td ><?=$reference_no;?></td>
<td ><?=$rep_reference_no;?></td>
<td ><?=$revision;?></td>
<td ><?=$file_from;?></td>
<td ><?=$file_to;?></td>
<td ><?=$file_no;?></td>
<td ><?=$file_category;?></td>
<td ><?=$drawing_series;?></td>
<td ><?=$doc_issue_date;?></td>
<td ><?=$received_date;?></td>
<td ><?=$doc_upload_date;?></td>
<td ><?=$remarks;?></td>


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
<td><input type="checkbox" class="checkbox"    name="file_download[]"  value="<?php echo $report_id;?>" form="report_cat"  onclick="selectUnSelect_top(this,report_cat);"/></td>
<td ><a  href="?p=reports&category_cd=<?php echo $report_category;?>&cid=<?php echo $cid; ?>&cat_cd=<?php echo $parent_cd; ?>" style=" font-weight:bold"><?php echo $category_name?></a> &raquo; <a href="<?php echo REPORT_URL.$file ;?>" target="_blank"><?=$report_title;?></a></td>
<td ><?=$document_no;?></td>
<td ><?=$reference_no;?></td>
<td ><?=$rep_reference_no;?></td>
<td ><?=$revision;?></td>
<td ><?=$file_from;?></td>
<td ><?=$file_to;?></td>
<td ><?=$file_no;?></td>
<td ><?=$file_category;?></td>
<td ><?=$drawing_series;?></td>
<td ><?=$doc_issue_date;?></td>
<td ><?=$received_date;?></td>
<td ><?=$doc_upload_date;?></td>
<td ><?=$remarks;?></td>


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
}
?>

</td> 

</body>
</html> 
  
