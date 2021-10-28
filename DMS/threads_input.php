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

$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$category_cd 	= trim($_POST['category_cd']);
	$thread_code 	= trim($_POST['thread_code']);
	$thread_heading 	= trim($_POST['thread_heading']);
	$status= '1';
	
	//$parent_cd 		= trim($_POST['parent_cd']);
	$cid 		= trim($_POST['cid']);
	$thread_created_by	= $objAdminUser->fullname_name;
	 $userid_owner	= $objAdminUser->user_cd;
	
//	$datt=date('Y-m-d H:i:s');
	//$parent_group1		= trim($_POST['parent_group']);
	
	

	
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("thread_heading", PRD_FLD_MSG_CATNAME, "S");
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$tt_id = ($_POST['mode'] == "U") ? $_POST['tt_id'] : $objAdminUser->genCode("rs_tbl_threads_titles", "tt_id");
		
		$objProdctC = new Product;
		$objProdctC->setProperty("thread_code", $thread_code);
		$objProdctC->setProperty("thread_heading", $thread_heading);
		//$objProdctC->setProperty("parent_cd", $parent_cd);
		$objProdctC->setProperty("cid", $cid);
		if($tt_id){
			$objProdctC->setProperty("tt_id", $tt_id);
		}
		/*if($objProdctC->checkCategory()){
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
		}*/
		
		
		 $users_rest = $_POST['users'];
		 $select_rest = $_POST['selected_user'];
		$owner_user = $_POST['owner_user'];
		  if(isset($users_rest)){ 
		
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
		
			$objProduct->setProperty("tt_id", $tt_id);
			$objProduct->setProperty("category_cd", $category_cd);
			//$objProduct->setProperty("parent_cd", $parent_cd);
			$objProduct->setProperty("thread_code", $thread_code);
			$objProduct->setProperty("thread_heading", $thread_heading);
			//$objProduct->setProperty("parent_group", $parent_group);
			$objProduct->setProperty("status",$status);
			$objProduct->setProperty("user_ids", $user_ids);
			$objProduct->setProperty("user_right", $user_rs);
			/*if($_POST['mode']=="U")
			{
			$objProduct->setProperty("last_modified_by", $created_by." ".$datt);
			}
			else
			{*/
			/*$last_modified_by="";
			$objProduct->setProperty("last_modified_by", $last_modified_by);*/
			$objProduct->setProperty("thread_created_by", $thread_created_by);
			$objProduct->setProperty("thread_creator_id", $userid_owner);
			//}
			$objProduct->setProperty("cid", $cid);
			
			if($objProduct->actTask($_POST['mode'])){
			
			
			
		
			
				if($_POST['mode'] == "U"){
					$objCommon->setMessage(PRD_FLD_UP_MSG_SUCCESS,'Info');
					$log_desc 	= $thread_heading . " updated successfully.";
				}
				else{
					$objCommon->setMessage(PRD_FLD_MSG_SUCCESS,'Info');
					$log_desc 	= $thread_heading . " added successfully.";
				}
				/***** Log Entry *****/
				$log_module = "Setting";
				$log_title 	= "Threads";
				//doLog($log_module, $log_title, $log_desc, $objAdminUser->user_cd);
				/***** End *****/
				print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
				//redirect('./?p=reports&category_cd='.$category_cd.'&cat_cd='.$_REQUEST['cat_cd'].'&cid='.$cid);
			}
		//}
	}
	extract($_POST);
}
else{
	if(isset($_GET['task_id']) && !empty($_GET['task_id']))
		$tt_id = $_GET['task_id'];
	else if(isset($_POST['tt_id']) && !empty($_POST['tt_id']))
		$tt_id = $_POST['tt_id'];
	if(isset($tt_id) && !empty($tt_id)){
		$objProduct->resetProperty();
		$objProduct->setProperty("tt_id", $tt_id);
		$objProduct->lstTask();
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
<?php include ('includes/saveurl.php');?>
<!--<div id="wrapperPRight">-->

<?php      if(isset($_REQUEST["cat_cd"])&&$_REQUEST["cat_cd"]!="")
			{
			$category_cd=$_REQUEST["cat_cd"];
			$sql="Select * from rs_tbl_category where category_cd=".$_REQUEST["cat_cd"];
			$res=mysql_query($sql);
			$row3=mysql_fetch_array($res);
			
				$report_category=$row3['category_name'];
				$parent_cd=$_REQUEST["cat_cd"];
			}
				
			?>
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo ($mode == "U")? "Edit Task" : "Add New Task" ?></strong></div></div>
         
		
		<div class="clear"></div>
				<form name="frmCategory" id="frmCategory" action="" method="post" onSubmit="return frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
		<input type="hidden" name="tt_id" id="tt_id" value="<?php echo $tt_id;?>" />
        <input type="hidden" name="category_cd" id="category_cd" value="<?php echo $category_cd;?>" />
       
         <input type="hidden" name="cid" id="cid" value="<?php echo $_REQUEST["cid"];?>" />
         <div id="tableContainer" class="table" style="border-left:1px;">
        
          <table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <tr>
        		
        <td >
	    Task Code <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="thread_code" id="thread_code" value="<?php echo $thread_code;?>" style="width:200px;" /></div>
		</td>
        </tr>	
   <tr>
        		
        <td >
	    Task Name <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement">
		<input class="rr_input" type="text" name="thread_heading" id="thread_heading" value="<?php echo $thread_heading;?>" style="width:200px;" /></div>
		</td>
        </tr>
   
		<tr>
        <td>		</td>
       
        <td>
		
				<div id="users"	>
		 
	
		<?php 
		if($_REQUEST['cat_cd'])
		{
		//echo "cat_cd";
		 $categoryy_cd=$_REQUEST['cat_cd'];
		 $cquery = "select * from  rs_tbl_category  where category_cd='$categoryy_cd'";
		//$cquery = "select * from   rs_tbl_threads_titles  where tt_id='$categoryy_cd'";
			$cresult = mysql_query($cquery);
			$cdata = mysql_fetch_array($cresult);
			$u_ids=$cdata['user_ids'];	
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
			//echo "category_cd";
			$categoryy_cd1=$_REQUEST['category_cd'];
		    $cquery1 = "select * from  rs_tbl_category  where category_cd='$categoryy_cd1'";
			$cresult1 = mysql_query($cquery1);
			$cdata1 = mysql_fetch_array($cresult1);
			$parent_group1=$cdata1['parent_group'];
			$parent_group12=explode("_",$parent_group1);
			$len_pg=count($parent_group12);
			$pgg=$parent_group12[$len_pg-2];
			$cquery2 = "select * from  rs_tbl_category  where category_cd='$pgg'";
			$cresult2 = mysql_query($cquery2);
			$cdata2 = mysql_fetch_array($cresult2);
				
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
 
//echo $u_ids1;


		$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "user_cd");
	$objAdminUser->setProperty("user_cd", "$u_ids1");
	$objAdminUser->lstAdminUser();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
	
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
		if($rows['user_type']=='1')
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
	$flag=1;
	
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
		
		<div  id="rights_<?php echo $rows['user_cd'];?>" <?php if($flag!=""){?>style=" text-align:right;margin-top:-20px;display:block;"<?php }else{ ?>style="display:none;text-align:right;margin-top:-20px;"<?php }?> ><input type="radio" name="rights<?php echo $rows['user_cd'];?>" value="1" <?php if($flag==1){ echo $selected;}?> /> R/W <input type="radio" name="rights<?php echo $rows['user_cd'];?>" value="2" <?php if($flag==2){ echo $selected;}?>/> R</div>
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
        