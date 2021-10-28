<?php 
require_once("config/config.php");
$objDb		= new Database;
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
?><?php 
$user_cd	= $objAdminUser->user_cd;
if($objAdminUser->is_login== false){
	header("location: index.php");
}?>
<?php include ('includes/saveurl.php');?>
<?php
//loadLang("product");
$objProductM= new Product;
$objProductMM= new Product;
if(isset($_GET['mode']) && $_GET['mode'] == "Delete"){
	$category_cd = $_GET['category_cd'];
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
		/**/
			 $sql2d="Select * from rs_tbl_documents";
			 
			 $res2d=$objDb->dbCon->query($sql2d);
			    
				
				while($row2d=$res2d->fetch())
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
				$res2d= $objDb->dbCon->query($sql2d);
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
				/* $sdeletet= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
	   mysql_query($sdeletet);*/
				}
		
		
		$objCommon->setMessage(PRD_DELETE_SUCCESS, 'Info');
				$activity="Category has been deleted";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				  $objDb->dbCon->query($sSQLlog_log);	
		redirect('./?p=category');
	
	
}
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$category_cd 	= trim($_POST['category_cd']);
	$category_name 	= trim($_POST['category_name']);
 	$category_status1= trim($_POST['category_status']);
	if($category_status1=="")
	{
	 $category_status=0;
	}
	else
	{
	 $category_status=$category_status1;
	}
	
	$parent_cd 		= trim($_POST['parent_cd']);
	$cid 		= trim($_POST['cid']);
	$created_by	= $objAdminUser->fullname_name;
	 $userid_owner	= $objAdminUser->user_cd;
	
	 date_default_timezone_set("Asia/Calcutta");
	$timee= date("H:i:s");
	$cdate=date('Y-m-d');
	$datt=$cdate." ".$timee;
	
	//$datt=date('Y-m-d H:i:s');
	
	//$parent_group1		= trim($_POST['parent_group']);
	
	

	
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("category_name", PRD_FLD_MSG_CATNAME, "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$category_cd = ($_POST['mode'] == "U") ? $_POST['category_cd'] : $objAdminUser->genCode("rs_tbl_category", "category_cd");
		
		$objProdctC = new Product;
		$objProdctC->setProperty("category_name", $category_name);
		$objProdctC->setProperty("parent_cd", $parent_cd);
		$objProdctC->setProperty("cid", $cid);
		if($category_cd){
			$objProdctC->setProperty("category_cd", $category_cd);
		}
		if($objProdctC->checkCategory()){
			$objCommon->setMessage('Category name already exits. Please enter another category.', 'Error');
		}
		else{
			if($parent_cd==0)
		{
		//$parent_group=$category_cd;
			if(strlen($category_cd)==1)
			{
			$parent_group="00".$category_cd;
			}
			else if(strlen($category_cd)==2)
			{
			$parent_group="0".$category_cd;
			}
			else
			{
			$parent_group=$category_cd;
			}
		}
		else
		{
		$parent_group1=$parent_cd."_".$category_cd;
		$sql="select parent_group from rs_tbl_category where category_cd='$parent_cd'";
		$sqlrw= $objDb->dbCon->query($sql);
		$sqlrw1=$sqlrw->fetch();
		
		if(strlen($category_cd)==1)
			{
			$category_cd_pg="00".$category_cd;
			}
			else if(strlen($category_cd)==2)
			{
			$category_cd_pg="0".$category_cd;
			}
			else
			{
			$category_cd_pg=$category_cd;
			}
		
		$parent_group=$sqlrw1['parent_group']."_".$category_cd_pg;
		}
		
		
		 $users_rest = $_POST['users'];
		 $select_rest = $_POST['selected_user'];
		
		$owner_user = $_POST['owner_user'];
		 $selec_users_right1 = $_POST['rights'.$select_rest];
		  if(isset($users_rest)){ 
		/* $alluser=0;
		 $all_users=0;
		 $user_ids=0;*/
		  $user_count=count($users_rest); 
		 for($i=0;$i<$user_count;$i++)
		 {
		 $all_users=$users_rest[$i];
		 $users_right = $_POST['rights'.$all_users];
		 if($users_right=="")
		 {
		 $users_right=2;
		 }
		 $usersright.=$all_users."_".$users_right.",";
		 $alluser.=$all_users.",";
		 
		
		 }
		
		 
		 if(($objAdminUser->user_type)==1 || ($objAdminUser->user_type)==2)
		 {
		  $usersright1=$usersright;
		$user_rs=substr($usersright1, 0, -1);
		$user_ids1=$alluser;
		$user_ids=substr($user_ids1, 0, -1);
		 }
		 else if(isset($owner_user))
		 {
				if($owner_user==$select_rest)
				{
					$usersright1=$select_rest."_".$selec_users_right1.",".$usersright;
					
					$user_rs=substr($usersright1, 0, -1);
					$user_ids1=$select_rest.",".$alluser;
					$user_ids=substr($user_ids1, 0, -1);
				}
				else
				{
					$usersright1=$owner_user."_1,".$select_rest."_".$selec_users_right1.",".$usersright;
					$user_rs=substr($usersright1, 0, -1);
					$user_ids1=$owner_user.",".$select_rest.",".$alluser;
					$user_ids=substr($user_ids1, 0, -1);
				}
			}
			else
			{
		$usersright1=$select_rest."_".$selec_users_right1.",".$usersright;
			
		$user_rs=substr($usersright1, 0, -1);
		$user_ids1=$select_rest.",".$alluser;
		$user_ids=substr($user_ids1, 0, -1);
			}
		}
		else
		{
			if($owner_user=='' && $select_rest=='')
			{
			
			$user_rs="";		
			$user_ids="";
			}
			else if($owner_user==$select_rest && $owner_user!='' && $select_rest!='')
			{
			$user_rs=$select_rest."_".$selec_users_right1;		
			$user_ids=$select_rest;
			}
			else if($owner_user=='' && $select_rest!='')
			{
			$user_rs=$select_rest."_".$selec_users_right1;		
			$user_ids=$select_rest;
			}
			else
			{
			$user_rs=$owner_user."_1,".$select_rest."_".$selec_users_right1;		
			$user_ids=$owner_user.",".$select_rest;
			}	
		}
			$objProduct->setProperty("category_cd", $category_cd);
			$objProduct->setProperty("parent_cd", $parent_cd);
			$objProduct->setProperty("category_name", $category_name);
			$objProduct->setProperty("parent_group", $parent_group);
			$objProduct->setProperty("category_status",$category_status);
			$objProduct->setProperty("user_ids", $user_ids);
			$objProduct->setProperty("user_right", $user_rs);
			if($_POST['mode']=="U")
			{
			$objProduct->setProperty("last_modified_by", $created_by." ".$datt);
			}
			else
			{
			$last_modified_by="";
			$objProduct->setProperty("last_modified_by", $last_modified_by);
			$objProduct->setProperty("creater", $created_by." ".$datt);
			$objProduct->setProperty("creater_id", $userid_owner);
			}
			$objProduct->setProperty("cid", $cid);
			
			if($objProduct->actCategory($_POST['mode'])){
			
			
			$sdelete= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
			$objDb->dbCon->query($sdelete);
				
			$cat_title_text1=	$_POST['cat_title_text'];
			
			$cat_field_name1=	$_POST['cat_field_name'];
			//$orderr=$_POST['order'];
			
		
		$counttt= count($cat_field_name1);
		
		for($h=0;$h<$counttt; $h++)
		{
		$orderr=$_POST['order'][$h];
		
		 $cat_id=$category_cd;
		 $cat_field_name=$cat_field_name1[$h];
		 $cat_title_text= $cat_title_text1[$h];
		if($cat_title_text!="")
		{
		
		$sqlIn="INSERT INTO rs_tbl_category_template SET
			cat_id = '$cat_id',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."'";
		/*echo $sqlIn="Insert into rs_tbl_category_template (cat_id, cat_temp_order,cat_field_name,cat_title_text)
VALUES ($cat_id,,$cat_field_name,$cat_title_text)";*/
$objDb->dbCon->query($sqlIn);
		}
		else
		{
		}
		}
		
			
				if($_POST['mode'] == "U"){
					$objCommon->setMessage(PRD_FLD_UP_MSG_SUCCESS,'Info');
				$activity="Category has been updated";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				$objDb->dbCon->query($sSQLlog_log);		
				}
				else{
					$objCommon->setMessage(PRD_FLD_MSG_SUCCESS,'Info');
					$activity="Category has been added";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				$objDb->dbCon->query($sSQLlog_log);
				}
				/***** Log Entry *****/
				$log_module = "Setting";
				$log_title 	= "Category";
				//doLog($log_module, $log_title, $log_desc, $objAdminUser->user_cd);
				/***** End *****/
				print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
				//redirect('./?p=reports&category_cd='.$category_cd.'&cat_cd='.$_REQUEST['cat_cd'].'&cid='.$cid);
			}
		}
	}
	extract($_POST);
}
else{
	if(isset($_GET['category_cd']) && !empty($_GET['category_cd']))
		$category_cd = $_GET['category_cd'];
	else if(isset($_POST['category_cd']) && !empty($_POST['category_cd']))
		$category_cd = $_POST['category_cd'];
	if(isset($category_cd) && !empty($category_cd)){
		$objProduct->resetProperty();
		$objProduct->setProperty("category_cd", $category_cd);
		$objProduct->lstCategory();
		$data = $objProduct->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}
?>
<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.category_name.value == ""){
		msg = msg + "\r\n<?php echo PRD_FLD_MSG_CATNAME;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<script>
  function readWrite(option) {
var elements = document.getElementsByName("users[]");
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
		var rights=elements[i].value;
		
		document.getElementById('rights_'+rights).style.display = "block";
			
		}
		else
		{
		var rights=elements[i].value;
		
		document.getElementById('rights_'+rights).style.display = "none";
		}
	}

	
	
	
}
  </script>


 <script>
  $(function() {
    $( "#doc_issue_date" ).datepicker();
	
  });
   $(function() {
    $( "#doc_closing_date" ).datepicker();
	
  });
  </script>
  <script>
  function swapContent(that) {
    var restrict=that.value;
	
	if(restrict==1)
	{
	document.getElementById('users').style.display = "none";
	}
	if(restrict==2)
	{
	document.getElementById('users').style.display = "none";
	}
	if(restrict==3)
	{
	document.getElementById('users').style.display = "none";
	}
	if(restrict==4)
	{
	document.getElementById('users').style.display = "none";
	}
	if(restrict==5)
	{
	
	document.getElementById('users').style.display = "block";
	}
	
	
}
  </script>
  <style>
  .inactive {
    opacity: 0.5;
    pointer-events: none;
}
  </style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo HOME_MAIN_TITLE?></title>
<head>

<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="menu/chromestyle.css"/>
<?php 
# JS file
importJs("Menu");
importJs("Common");
importJs("Ajax");
importJs("Calendar");
importJs("Lang-EN");
importJs("ShowCalendar");?>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<?php importCss("Login");?>
<?php importCss("Messages");
if($objAdminUser->is_login == true){
	importCss("PjStyles");
}?>

	<!---// load jQuery from the GoogleAPIs CDN //--->
	<?php /*?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script><?php */?>
</head>
<body>
    <?php echo $objCommon->displayMessage();?>
<div id="wrapperPRight">

<!--<div id="wrapperPRight">-->

<?php      if(isset($_REQUEST["cat_cd"])&&$_REQUEST["cat_cd"]!="")
			{
			$sql="Select * from rs_tbl_category where category_cd=".$_REQUEST["cat_cd"];
			$res=$objDb->dbCon->query($sql);
			$row3=$res->fetch();
			
				$report_category=$row3['category_name'];
				$parent_cd=$_REQUEST["cat_cd"];
			}
				
			?>
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo ($mode == "U")? "Update Category" : "Add New Category"."&raquo;".$report_category;?></strong></div></div>
         
		<!--<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=product_mgmt" class="lnkButton" title="back"><?php echo _BTN_BACK;?></a></li>	
					</ul>
				<br style="clear:left"/>
			</div>
		</div>-->
		<div class="clear"></div>
				<form name="frmCategory" id="frmCategory" action="" method="post" onSubmit="return frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="category_cd" id="category_cd" value="<?php echo $category_cd;?>" />
        <input type="hidden" name="parent_cd" id="parent_cd" value="<?php echo $parent_cd;?>" />
         <input type="hidden" name="cid" id="cid" value="<?php echo $_REQUEST["cid"];?>" />
         <div id="tableContainer" class="table" style="border-left:1px;">
        
          <table width="70%" border="0" cellspacing="0" cellpadding="0" >
		   <?php /*?><tr>
      
        <td>
	    <?php echo "Add Category In";?> <span style="color:#FF0000;">*</span>:
        </td>
        <td>
        <div class="frmElement"><select name="cid" id="cid" class="rr_select">
			<option value="0" selected>--select---</option>
			<option value="1" <?php if($cid==1) echo 'selected="selected"';?>> Project Data</option>
			<option value="2" <?php if($cid==2) echo 'selected="selected"';?>>DMS</option>
		</select></div>
		</td>
        </tr><?php */?>
		
		
		
		
		
   <tr>
      
        <td >
	    Category Name <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="category_name" id="category_name" value="<?php echo $category_name;?>" style="width:200px;" /></div>
		</td>
        </tr>
		 <tr>
      
        <td >
	    Template <span style="color:#FF0000;"></span>:
        </td>
        <td>
		<table>
		
		<?php
		
		
			
			
		//echo $sqll="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbCfg[db_name]' AND TABLE_NAME = 'rs_tbl_documents' ORDER BY CASE COLUMN_NAME ASC";
		 $sqll="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'rs_tbl_documents' AND COLUMN_NAME in ('report_title','doc_issue_date','period','revision','doc_closing_date', 'document_no', 'reference_no','rep_reference_no','received_date','file_from','file_to','file_no', 'drawing_series', 'remarks', 'file_category') ORDER BY CASE COLUMN_NAME
		WHEN 'document_no' THEN 6 WHEN 'reference_no' THEN 7 WHEN 'rep_reference_no' THEN 8 WHEN 'received_date' THEN 9 WHEN 'file_from' THEN 10 
		WHEN 'file_to' THEN 11 WHEN 'file_no' THEN 12 WHEN 'drawing_series' THEN 13 WHEN 'remarks' THEN 14 WHEN 'file_category' THEN 15
		WHEN 'report_title' THEN 1 WHEN 'doc_issue_date' THEN 2 WHEN 'period' THEN 3 WHEN 'revision' THEN 4 WHEN 'doc_closing_date' THEN 5 END";
$res=$objDb->dbCon->query($sqll);
			   
while( $ress=$res->fetch())
{
?>
<tr>

<?php
 $column_name1=$ress['COLUMN_NAME'];
 if($column_name1=="report_file")
{
}
elseif($column_name1=="file_size")
{
}
elseif($column_name1=="extension")
{
}
elseif($column_name1=="doc_upload_date")
{
}
elseif($column_name1=="user_access")
{
}
elseif($column_name1=="user_ids")
{
}
elseif($column_name1=="user_right")
{
}
elseif($column_name1=="report_status")
{
}
else
{
 ?>
 <td>
 <?php
if($column_name1=="report_title")
{
echo $column_name="Title";
}

if($column_name1=="doc_issue_date")
{
echo $column_name="Issue Date";
}
/*if($column_name1=="report_status")
{
echo $column_name="Status";
}*/
if($column_name1=="period")
{
echo $column_name="Period";
}
/*if($column_name1=="doc_upload_date")
{
echo $column_name="Uploading Date";
}*/
if($column_name1=="revision")
{
echo $column_name="Revision";
}
if($column_name1=="doc_closing_date")
{
echo $column_name="Closing Date";
}
if($column_name1=="document_no")
{
echo $column_name="Document No";
}
if($column_name1=="reference_no")
{
echo $column_name="Reference No";
}
if($column_name1=="rep_reference_no")
{
echo $column_name="Reply Reference No";
}
if($column_name1=="received_date")
{
echo $column_name="Received Date";
}
if($column_name1=="file_from")
{
echo $column_name="From";
}
if($column_name1=="file_to")
{
echo $column_name="To";
}
if($column_name1=="file_no")
{
echo $column_name="File No";
}
if($column_name1=="drawing_series")
{
echo $column_name="Drawing Series";
}
if($column_name1=="remarks")
{
echo $column_name="Remarks";
}
if($column_name1=="file_category")
{
echo $column_name="File Category";
}

?>
	
</td>

<?php
}
if($column_name1=="report_file")
{
}
elseif($column_name1=="file_size")
{
}
elseif($column_name1=="extension")
{
}
elseif($column_name1=="doc_upload_date")
{
}
elseif($column_name1=="user_access")
{
}
elseif($column_name1=="user_ids")
{
}
elseif($column_name1=="user_right")
{
}
elseif($column_name1=="report_status")
{
}
else
{
?>

		<td>
        <input class="rr_input" type="hidden" name="cat_field_name[]" id="cat_field_name[]" value="<?php echo $column_name1;?>" style="width:200px;" />
		<input class="rr_input" type="text" name="cat_title_text[]" id="cat_title_text[]" value="<?php
		if(isset($_GET['category_cd']))
		{
		$sql3="Select * from rs_tbl_category_template where cat_id=".$category_cd;
			$res3=$objDb->dbCon->query($sql3);
			while($row3=$res3->fetch())
			{
			
			 $cat_fieldname=$row3['cat_field_name'];
			  $cat_titletext=$row3['cat_title_text'];
			if ($column_name1==$cat_fieldname)
		{
		echo $cat_titletext;
		} 
			
			
			}
			}
			else
			{
			}
		
		 ?>" style="width:200px;" />
		 
		</td>
		<?php
		}
if($column_name1=="report_file")
{
}
elseif($column_name1=="file_size")
{
}
elseif($column_name1=="extension")
{
}
elseif($column_name1=="doc_upload_date")
{
}
elseif($column_name1=="user_access")
{
}
elseif($column_name1=="user_ids")
{
}
elseif($column_name1=="user_right")
{
}
elseif($column_name1=="report_status")
{
}
else
{
		?>
		<td>
		<input name="order[]" type="text" class="rr_input" id="order[]" tabindex="<?php echo $i;?>" value="<?php
		if(isset($_GET['category_cd']))
		{
		$sql3="Select * from rs_tbl_category_template where cat_id=".$category_cd;
			$res3=$objDb->dbCon->query($sql3);
			while($row3=$res3->fetch())
			{
			
			 $cat_fieldname=$row3['cat_field_name'];
			  $cat_temporder=$row3['cat_temp_order'];
			if ($column_name1==$cat_fieldname)
		{
		echo $cat_temporder;
		} 
			
			
			}
			}
			else
			{
			}
		
		 ?>" style="width:40px" />
						
         <input name="field_name[]" type="hidden" id="field_name[]" value="<?php echo $column_name1;?>"  />
		</td>
		<?php
		}
		?>
		<!--<td>
		<input class="rr_input"  type="checkbox" name="check_id[]" id="check_id[]" value="<?php //$column_name1?>" style="width:10px;" />
		</td>-->
		</tr>
		
		
		<?php
		}
		?>
		<tr><td>
		Do you need Status of Documents? </td><td><input type="checkbox" name="category_status" id="category_status" value="1" <?php if($category_status==1){ echo 'checked="checked"';} ?> /></td></tr>
		</table>
		</td>
        </tr>
		
		<tr>
        <td>		</td>
       
        <td>
		
				<div id="users"	<?php /*if(isset($_GET['report_id']) && $user_ids1!=""){?> style="display:block" <?php } else	 { ?> style="display:none"<?php
		 }*/?>>
		 
	
		<?php 
		if($_REQUEST['cat_cd'])
		{
		 $categoryy_cd=$_REQUEST['cat_cd'];
	$cquery = "select * from  rs_tbl_category  where category_cd='$categoryy_cd'";
			$cresult = $objDb->dbCon->query($cquery);
			$cdata = $cresult->fetch();
			$u_ids=$cdata['user_ids'];	
			$u_rits=$cdata['user_right'];
			//print_r($u_rits);
			$u_idscat=explode(",",$u_ids);
			
		$len_u=count($u_idscat);
		 
		 for($j=0;$j<$len_u;$j++)
 {
	 
 $u_ids1.=$u_idscat[$j];
if($j<$len_u-1)
{
$u_ids1.=" OR user_cd=" ;
}
else if($j=$len_u-1)
{
}
 }
 }
 else if($_REQUEST['category_cd'])
		{
			 $categoryy_cd1=$_REQUEST['category_cd'];
		    $cquery1 = "select * from  rs_tbl_category  where category_cd='$categoryy_cd1'";
			$cresult1 =$objDb->dbCon->query($cquery1);
			$cdata1 = $cresult1->fetch();
			$parent_group1=$cdata1['parent_group'];
			$parent_group12=explode("_",$parent_group1);
			$len_pg=count($parent_group12);
			$pgg=$parent_group12[$len_pg-2];
			$cquery2 = "select * from  rs_tbl_category  where category_cd='$pgg'";
			$cresult2 = $objDb->dbCon->query($cquery2);
			$cdata2 = $cresult2->fetch();
				
			$u_idst=$cdata2['user_ids'];	
			$u_idscat1=explode(",",$u_idst);
			
		$len_u1=count($u_idscat1);
		
		 
		 for($t=0;$t<$len_u1;$t++)
 {
 $u_ids1.=$u_idscat1[$t];
if($t<$len_u1-1)
{
$u_ids1.=" OR user_cd=" ;
}
else if($t=$len_u1-1)
{
}
 }
 }
 



		$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "user_cd");
	$objAdminUser->setProperty("user_cd", "$u_ids1");
	$objAdminUser->lstAdminUser();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
	
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
		if($rows['user_type']=='1' || $rows['user_type']=='2')
		{
		continue;
		}
		
		
		if($user_ids)
		{
		
		$arrusers= explode(",",$user_ids);
		$arr_total_users=count($arrusers);
		
		
		 foreach($arrusers as $key => $val) {
   $arrusers[$key] = trim($val);
   if($arrusers[$key]==$rows['user_cd'])
   { 
   $selected="checked";
	   if(($arrusers[$key]==$rows['user_cd']) && ($rows['user_cd']==$user_cd))
	   {
	 	$disabled="disabled";
	   }
	   else if(($arrusers[$key]==$rows['user_cd']) && ($arrusers[$key]==$creater_id))
	   {
		$disabled="disabled";
	   }
	   else
	   {
	   $disabled="";
	   }
   
    
	break;
	}
	
	else
	{
	$disabled="";
	$selected="";
	}
	}
	}
	else
	{
	if($rows['user_cd']==$user_cd)
	{
	
	$selected="checked";
	$disabled="disabled";
	
	
	}
	else
	{
	$selected="";
	$disabled="";
	
	}
	}
	if($user_right)
	{
		
	$arruright= explode(",",$user_right);
		$arr_right_users=count($arruright);
		
		 foreach($arruright as $key => $val) {
   $arruright[$key] = trim($val);
   $aright= explode("_", $arruright[$key]);
   
   
   
   if($aright[0]==$rows['user_cd']){
   	if($aright[1]==1)
	{
	 $flag=1;
    $selected="checked";
	break;
	}
	else if($aright[1]==3)
	{
	 $flag=3;
    $selected="checked";
	break;
	}
	else if($aright[1]==2)
	{ 
	$flag=2;
    $selected="checked";
	break;
	}
	else
	{
	 $flag="";
	}
	
	}
	}
	}
	else
	{
	if($rows['user_cd']==$user_cd)
	{
		$arruright5= explode(",",$u_rits);
		$arr_right_users5=count($arruright5);
		
		 foreach($arruright5 as $key2 => $val2) {
   		$arruright5[$key2] = trim($val2);
   		$aright5= explode("_", $arruright5[$key2]);
   		if($aright5[0]==$rows['user_cd']){
   		if($aright5[1]==1)
		{
	 	$flag=1;
   		 }
		else if($aright5[1]==3)
		{
		 $flag=3;
	   
		}
		}
		 }
		
	
	
	}
	else
	{
	$flag="";
	}
	}	
	
		?>
		
		<input type="checkbox"    name="users[]"  value="<?php echo $rows['user_cd'];?>"  <?php echo $disabled;?>   <?php echo $selected;?>   onclick="readWrite(this)"/><?php echo $rows['fullname'];?>
		<?php if($rows['user_cd']==$user_cd)
		{
		?>
		<input type="hidden"    name="selected_user"  value="<?php echo $rows['user_cd'];?>"  />
		<?php
		}
		?>
		<?php if($rows['user_cd']==$creater_id)
		{
		?>
		<input type="hidden"    name="owner_user"  value="<?php echo $rows['user_cd'];?>"  />
		<?php
		}
		?>
        
		<div id="rights_<?php echo $rows['user_cd'];?>"<?php if($objAdminUser->user_cd==$rows['user_cd']){ ?> class="inactive"<?php } ?> 
		<?php if($flag!=""){?>style=" text-align:right;margin-top:-20px;display:block;"<?php }else{ ?>style="display:none;text-align:right;margin-top:-20px;"<?php }?> ><input type="radio" name="rights<?php echo $rows['user_cd'];?>" value="3" <?php if($flag==3){ echo $selected;}?> /> R/W/D <input type="radio" name="rights<?php echo $rows['user_cd'];?>" value="1" <?php if($flag==1){ echo $selected;}?> /> R/W <input type="radio" name="rights<?php echo $rows['user_cd'];?>" value="2" <?php if($flag==2){ echo $selected;}?>/> R</div>
		 <br />
  
	
	<?php
	echo $flag="";	
	$sno += $sno;
	}
	
	}?>
	
</div>

        </td>
        </tr>
		
        <tr >
        <td colspan="2" align="center">
          
        <div id="div_button">
            <input type="submit" class="rr_button" value="<?php echo ($mode == "U") ? _BTN_UPDATE : _BTN_SAVE;?>" />
            <!--<input type="button" class="rr_button" value="<?php //echo _BTN_CANCEL;?>" onClick="document.location='./?p=category';" />-->
        </div>
        </td>
        </tr>
        </table>
      
      </div>
	</form>
	
	
 			
		
		
        
		
	</div> 
	<!--</div>
-->
</div>
</body>
</html>
        