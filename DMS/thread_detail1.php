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
?><?php 
$user_cd	= $objAdminUser->user_cd;
if($objAdminUser->is_login== false){
	header("location: index.php");
}?>
<?php
//loadLang("product");

$objProductM= new Product;
$objProductMM= new Product;
if(isset($_GET['mode']) && $_GET['mode'] == "Delete"){
	$category_cd = $_GET['category_cd'];
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
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$category_cd 	= trim($_POST['category_cd']);
	$category_name 	= trim($_POST['category_name']);
	$category_status= trim($_POST['category_status']);
	
	$parent_cd 		= trim($_POST['parent_cd']);
	$cid 		= trim($_POST['cid']);
	$created_by	= $objAdminUser->fullname_name;
	 $userid_owner	= $objAdminUser->user_cd;
	
	$datt=date('Y-m-d H:i:s');
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
		$parent_group=$category_cd;
		}
		else
		{
		$parent_group1=$parent_cd."_".$category_cd;
		$sql="select parent_group from rs_tbl_category where category_cd='$parent_cd'";
		$sqlrw=mysql_query($sql);
		$sqlrw1=mysql_fetch_array($sqlrw);
		$parent_group=$sqlrw1['parent_group']."_".$category_cd;
		}
		
		
		 $users_rest = $_POST['users'];
		 $select_rest = $_POST['selected_user'];
		$owner_user = $_POST['owner_user'];
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
		 
		 if(($objAdminUser->user_type)==1)
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
					 $usersright1=$select_rest."_1,".$usersright;
					$user_rs=substr($usersright1, 0, -1);
					$user_ids1=$select_rest.",".$alluser;
					$user_ids=substr($user_ids1, 0, -1);
				}
				else
				{
				 $usersright1=$owner_user."_1,".$select_rest."_1,".$usersright;
					$user_rs=substr($usersright1, 0, -1);
					$user_ids1=$owner_user.",".$select_rest.",".$alluser;
					$user_ids=substr($user_ids1, 0, -1);
				}
			}
			else
			{
			$usersright1=$select_rest."_1,".$usersright;
		$user_rs=substr($usersright1, 0, -1);
		$user_ids1=$select_rest.",".$alluser;
		$user_ids=substr($user_ids1, 0, -1);
			}
		}
		else
		{
			if($owner_user==$select_rest)
			{
			$user_rs=$select_rest."_1";		
			$user_ids=$select_rest;
			}
			else
			{
			$user_rs=$owner_user."_1,".$select_rest."_1";		
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
	   mysql_query($sdelete);
				
			$cat_title_text1=	$_POST['cat_title_text'];
			
			$cat_field_name1=	$_POST['cat_field_name'];
			//$orderr=$_POST['order'];
			
		
		echo $counttt= count($cat_field_name1);
		
		for($h=0;$h<$counttt; $h++)
		{
		$orderr=$_POST['order'][$h];
		
		echo $cat_id=$category_cd;
		echo $cat_field_name=$cat_field_name1[$h];
		echo $cat_title_text= $cat_title_text1[$h];
		if($cat_title_text!="")
		{
		
		$sqlIn="INSERT INTO rs_tbl_category_template SET
			cat_id = '$cat_id',	
			cat_temp_order = '$orderr',
			cat_field_name = '".addslashes($cat_field_name)."',
			cat_title_text = '".addslashes($cat_title_text)."'";
		/*echo $sqlIn="Insert into rs_tbl_category_template (cat_id, cat_temp_order,cat_field_name,cat_title_text)
VALUES ($cat_id,,$cat_field_name,$cat_title_text)";*/
mysql_query($sqlIn);
		}
		else
		{
		}
		}
		
			
				if($_POST['mode'] == "U"){
					$objCommon->setMessage(PRD_FLD_UP_MSG_SUCCESS,'Info');
					$log_desc 	= $category_name . " updated successfully.";
				}
				else{
					$objCommon->setMessage(PRD_FLD_MSG_SUCCESS,'Info');
					$log_desc 	= $category_name . " added successfully.";
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



	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["download_all"])){

	 	$files_ids=$_POST['file_ids'];
		$message_id=$_GET['mess_id'];
		 if(isset($files_ids)){ 
		$files_count=count($files_ids);
		}
$getquery="SELECT thread_title FROM rs_tbl_attachments INNER JOIN rs_tbl_threads ON (rs_tbl_attachments.message_id = rs_tbl_threads.message_id) where rs_tbl_attachments.message_id=$message_id";
 $result=mysql_query($getquery);
 $res_rows = mysql_fetch_array($result);
$cat_name=preg_replace('/\s+/','_',$res_rows['thread_title']);
 $td = date('Y-m-d-h-m-s',time());
 $filename1 = $cat_name."-".$td.".zip";
 // $f = fopen ("data/".$filename,'w+');
 // fputs($f, $out);
  //fclose($f);
  
  
  $zip = new ZipArchive();
$filename = SITE_PATH."Zip/".$filename1;

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("cannot open <$filename>\n");
}

foreach ($files_ids as $selected_id) {
$getquery1="SELECT file_name FROM rs_tbl_attachments where message_id=$message_id and attachment_id=$selected_id";
 $result1=mysql_query($getquery1);
 $result23=mysql_fetch_array($result1);
 $file_name=$message_id."-".$result23['file_name'];
$zip->addFile("Task_attachments/".$file_name,"/".$file_name);
}
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
	
	
	<script type='text/javascript'>
			function refreshpage()
			{	
				window.opener.location.reload();
				<?php if(isset($_SESSION['ptest'])){?>
				self.close();
				<?php
				unset($_SESSION['ptest']);
				}
				
				?>
				
			}
	</script>
</head>
<body onLoad="refreshpage()">
    <?php echo $objCommon->displayMessage();?>
<div id="wrapperPRight" style="width:530">
<?php include ('includes/saveurl.php');?>
<!--<div id="wrapperPRight">-->

<?php     if(isset($_GET['mess_id']))
{
$mess_id= $_GET['mess_id'];

 $messl="Select * from rs_tbl_threads where message_id=". $mess_id;
$res_messl=mysql_query($messl);
$res_mess=mysql_fetch_array($res_messl);
$thread_title= $res_mess['thread_title'];
$thread_comments= $res_mess['thread_comments'];
$task_id=$res_mess['thread_no'];

$temp_t="Select status, thread_heading from rs_tbl_threads_titles where tt_id=".$res_mess['thread_no'];
$temp_t1=mysql_query($temp_t);
$status_res=mysql_fetch_array($temp_t1);
$status=$status_res['status'];

				
			?>
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo $status_res['thread_heading']?></strong></div></div>
         
		
		<div class="clear"></div>
				<form name="frmCategory" id="frmCategory" action="" method="post" onSubmit="return frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="category_cd" id="category_cd" value="<?php echo $category_cd;?>" />
        <input type="hidden" name="parent_cd" id="parent_cd" value="<?php echo $parent_cd;?>" />
         <input type="hidden" name="cid" id="cid" value="<?php echo $_REQUEST["cid"];?>" />
         <div id="tableContainer" class="table" style="border-left:1px;width:470">
        
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		<?php if($status=='1')
		{ ?>
		<tr>
		<td colspan="2" align="right" >
		
		<a href="javascript:void(null);" onClick="window.open('tasks_messages.php?p_mess_id=<?php echo $mess_id;?>&category_cd=<?php echo $_GET['category_cd']; ?>&cid=<?php echo $_GET['cid']; ?>&task_id=<?php echo $task_id; ?>','INV1','resizable=yes,left=550,top=60,width=550,height=400,scrollbars=yes');" >
Reply</a>
		
		</td>
        </tr>
		<?php
		}
		else
		{
		?>
		<tr>
		<td colspan="2" align="right" >
		
		<a href="javascript:function() { return false; }" >Locked</a>
		
		</td>
        </tr>
		<?php
		}
		?>   
	 <tr><td >
	    From <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><?php echo $res_mess['meassage_sent_by']. " (".$res_mess['meassage_sent_email'].")"?></div>
		</td>
        </tr>
		<tr><td >
	    To <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><?php echo $res_mess['meassage_sent_by']. " (".$res_mess['meassage_sent_email'].")"?></div>
		</td>
        </tr>		
   <tr><td >
	    Subject <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><?php echo $thread_title;?></div>
		</td>
        </tr>
		<tr><td >
	    Status <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><?php
			 		if($res_mess['thread_status']=='1')
					{
					echo "Initiated <img width='15' height='15'  src='./images/initiated.png'  alt='Initiated' />";
					} 
					else if($res_mess['thread_status']=='2')
					{
					echo "Approved <img width='15' height='15'  src='./images/approved.png'  alt='Approved' />";
					}
					else if($res_mess['thread_status']=='3')
					{
					echo  "Not Approved <img width='15' height='15'  src='./images/not_approved.png'  alt='Not Approved' />";
					}
					else if($res_mess['thread_status']=='4')
					{
					echo "Under Review <img width='15' height='15'  src='./images/under_review.png'  alt='Under Review' />";
					}
					else if($res_mess['thread_status']=='5')
					{
					echo "Response Awaited <img width='15' height='15'  src='./images/awaiting_decision.png'  alt='Awaiting Decision' />";
					}?></div>
		</td>
        </tr>
		 <tr>
        
        <td colspan="2">
		<?php echo $thread_comments;?>
		</td>
        </tr>
		<tr>
		<td >
	    Attachments <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><table>
		<?php $pdSQL1="SELECT attachment_id, message_id, thread_no, file_name FROM rs_tbl_attachments  where message_id = ".$mess_id." and  thread_no = ".$task_id;

$pdSQLResult1 = mysql_query($pdSQL1) or die(mysql_error());
$k=0;
while($pdData1 = mysql_fetch_array($pdSQLResult1))
{
$att_ids=$pdData1['attachment_id'];


/*$file_name_array=explode(".",$pdData1['file_name']);
$count_t=count($file_name_array);
$extension=$file_name_array[$count_t-1];*/

 ?>
 <input type="hidden" name="file_ids[]" id="file_ids[]" value="<?php echo $att_ids; ?>" />
		<tr>
		<td><?php echo $k=$k+1; ?></td>
		<td><a href="<?php echo "Task_attachments/".$pdData1['message_id']."-".$pdData1['file_name'];?>" target="_blank"><?php echo $pdData1['file_name'];?></a></td>
		</tr>
<?php
}
?>		
		</table></div>
		<?php if(count($att_ids)>=1)
		{?>
		<div>
		
		<input type="submit" name="download_all" id="download_all" value="Download All" /></div>
		<?php
		}
		?>
		</td>
        </tr>
	
		
		
        <?php if($status=='1')
		{ ?>
		<tr>
		<td colspan="2" align="right" >
		
		<a href="javascript:void(null);" onClick="window.open('tasks_messages.php?p_mess_id=<?php echo $mess_id;?>&category_cd=<?php echo $_GET['category_cd']; ?>&cid=<?php echo $_GET['cid']; ?>&task_id=<?php echo $task_id; ?>','INV1','resizable=yes,left=550,top=60,width=550,height=400,scrollbars=yes');" >Reply</a>
		
		</td>
        </tr>
		<?php
		}
		else
		{
		?>
		<tr>
		<td colspan="2" align="right" >
		
		<a href="javascript:function() { return false; }" >Locked</a>
		
		</td>
        </tr>
		<?php
		}
		?>   
        </table>
      
      </div>
	  
	</form>
	
	
 			
		
		
        
		
	</div> 
<?php
}
?>	
	<!--</div>
-->
</div>

</body>
</html>
        