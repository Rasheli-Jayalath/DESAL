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
<?php include ('includes/saveurl.php');?>
<?php
//loadLang("product");
$objProductM= new Product;
$objProductMM= new Product;
if(isset($_REQUEST['task_id']))
{
$task_id=$_REQUEST['task_id'];
}
if(isset($_REQUEST['p_mess_id']))
{
$p_mess_id=$_REQUEST['p_mess_id'];
}

 $user_cd	= $objAdminUser->user_cd;
 
 $objAdminUser->setProperty("user_cd", $user_cd);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
 $user_type= $data['user_type'];
 
 $temp_w="Select * from rs_tbl_threads_titles where tt_id=".$_GET['task_id'];
$temp_w1=mysql_query($temp_w);
$res_w=mysql_fetch_array($temp_w1);

 
/*$report_path = REPORT_PATH;
$report_id = $_REQUEST['report_id'];
$category_cd = $_REQUEST['category_cd'];
$cquery11 = "select * from rs_tbl_documents WHERE report_id = '$report_id'";
$cresult11 = mysql_query($cquery11);
$cdata11 = mysql_fetch_array($cresult11);
if($report_id!="")
{
$cat_idm = $cdata11['report_category'];
}
else
{
$cat_idm = $_REQUEST['category_cd'];
}
$subcatid = $cdata11['report_subcategory'];
$uaccess1 = $cdata11['user_access'];
$user_ids1 = $cdata11['user_ids'];
$user_rs1 = $cdata11['user_right'];*/

/*echo $unserializedoptions = unserialize($uaccess1);*/

if(isset($_GET['mode']) && $_GET['mode'] == "Delete"){
	$report_id = $_GET['report_id'];

		$objProduct->resetProperty();
		$objProduct->setProperty("report_id", $report_id);
		$objProduct->actReport("D");
		$objCommon->setMessage("Document deleted Successfully", 'Info');
		redirect('./?p=upload_report');
	
	
}
if(isset($_GET['report_id']) && !empty($_GET['report_id'])&&$_GET['mode']=="DoDelete"&&$_REQUEST['file_report']!="")
{
$objProdctD1 = new Product;
$report_id = $_GET['report_id'];
$file_report=$_REQUEST['file_report'];
if($file_report!=""){
					@unlink(REPORT_PATH . $file_report);
						
					}
					$file_report="";
$objProdctD1->setProperty("report_id",$report_id);
$objProdctD1->setProperty("report_file",$file_report);
$objProdctD1->actReport("U");
 $objProdctD1->getSQL();
 $objCommon->setMessage('File Removed Successfully.', 'Info');
redirect('upload_report.php?report_id='.$report_id);
}
$mode	= "I";
//$size=500;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["save"])){
	
			$created_by	= $objAdminUser->fullname_name;
			 $userid_owner	= $objAdminUser->user_cd;
			$message_id = trim($_REQUEST['message_id']);
			$mode = trim($_POST['mode']);
			//$cat_id = $cat_idm;
			$parent_message_id = trim($_REQUEST['p_mess_id']);
			$thread_no = trim($_REQUEST['thread_no']);
			//$subcatid = trparent_message_idim($_POST['subcatid']);
			$thread_title = trim($_POST['thread_title']);
			$thread_comments = trim($_POST['thread_comments']);
			$thread_status = trim($_POST['thread_status']);
			$meassage_sent_by = trim($_POST['meassage_sent_by']);
			$meassage_sent_email = trim($_POST['meassage_sent_email']);
			/*$thread_file=$_FILES['thread_file'];
			$old_thread_file=trim($_POST['old_thread_file']);*/

 

			//$max_size=($size * 1024 * 1024);
	
	$objValidate->setArray($_POST);
	/*$objValidate->setCheckField("report_category", PRD_FLD_MSG_CATNAME, "S");*/
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$message_id = ($_POST['mode'] == "U") ? $_POST['message_id'] : $objAdminUser->genCode("rs_tbl_threads", "message_id");
		$objProdctC1 = new Product;
		$objProdctC1->setProperty("message_id", $message_id);
		$objProdctC1->setProperty("parent_message_id", $parent_message_id);
		$objProdctC1->setProperty("thread_no", $thread_no);
		$objProdctC1->setProperty("thread_title", $thread_title);
		$objProdctC1->setProperty("thread_comments", $thread_comments);
		$objProdctC1->setProperty("thread_status", $thread_status);
		$objProdctC1->setProperty("thread_created_by", $created_by);
		$objProdctC1->setProperty("creator_id", $userid_owner);
		$objProdctC1->setProperty("meassage_sent_by", $meassage_sent_by);
		$objProdctC1->setProperty("meassage_sent_email", $meassage_sent_email);
		/*$objProdctC1->setProperty("revision", $revision);
		$objProdctC1->setProperty("document_no", $document_no);
		$objProdctC1->setProperty("doc_issue_date", $doc_issue_date);
		$objProdctC1->setProperty("doc_closing_date", $doc_closing_date);
		$objProdctC1->setProperty("doc_upload_date", $doc_upload_date);	
		if($_POST['mode']=="U")
			{
			$objProdctC1->setProperty("doc_last_modified_by", $created_by." ".$datt);
			}
			else
			{
			$last_modified_by="";
			$objProdctC1->setProperty("doc_last_modified_by", $last_modified_by);
			$objProdctC1->setProperty("doc_creater", $created_by." ".$datt);
			$objProdctC1->setProperty("doc_creater_id", $userid_owner);
			}*/
		
		
		
			/*if(isset($_FILES["report_file"]["name"])&&$_FILES["report_file"]["name"]!="")
		{}
*/
			
			if($objProdctC1->actMessage($_POST['mode'])){
			$messg_id=mysql_insert_id();
			
			
			 if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES['upload']['name'][$i];
						

                //save the url and the file
                $filePath = "Task_attachments/".$messg_id."-".$_FILES['upload']['name'][$i];

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                    $files[] = $shortname;
                    //insert into db 
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file
					


                }
              }
        }
    }
	    
    if(is_array($files))
	{
       
        foreach($files as $file)
		{
         $sql_pro=mysql_query("INSERT INTO rs_tbl_attachments (message_id, thread_no, file_name) Values(".$messg_id.",".$thread_no.", '".$file."')");
	if ($sql_pro == TRUE) {
						$message=  "New record added successfully";
						}
				   else {
    					$message= mysql_error($db);
						}
        }
      
    }
			
			
			$sql_pro="UPDATE rs_tbl_threads SET thread_status='6' where message_id=".$_GET['p_mess_id'];
	
			$sql_proresult=mysql_query($sql_pro) or die(mysql_error());
	
			
				if($_POST['mode'] == "U"){
					$objCommon->setMessage("Message Add/Reply susccessfully",'Info');
					$activity="Task has been updated";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
				}
				else{
					$objCommon->setMessage("Message Add/Reply  susccessfully",'Info');
					$activity="Task has been updated";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
				}
				
				$log_module = "Setting";
				$log_title 	= "Report";
				//doLog($log_module, $log_title, $log_desc, $objAdminUser->user_cd);
				print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				if($_GET['p_mess_id']!=0)
				{
				$_SESSION['ptest']=1;
				}
				//print "setInterval(window.opener.close(),5000);";
				//print "window.opener.close();";
				print "self.close();";
				print "</script>";  
				//redirect('./?p=upload_report');
			}
		
	}
	
}
else{
	if(isset($_GET['message_id']) && !empty($_GET['message_id']))
		$message_id = $_GET['message_id'];
	else if(isset($_POST['message_id']) && !empty($_POST['message_id']))
		$message_id = $_POST['message_id'];
	if(isset($message_id) && !empty($message_id)){
		$objProduct->setProperty("message_id", $message_id);
		$objProduct->lstMessage();
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
<div id="wrapperPRight" style="width:530">
<!--<div id="wrapperPRight">-->

<?php 


    
/*if(isset($_GET['mess_id']))
{
$mess_id= $_GET['mess_id'];
$messl="Select * from rs_tbl_threads where cat_cd=".$_GET['category_cd']. "  and message_id=". $mess_id;
$res_messl=mysql_query($messl);
$res_mess=mysql_fetch_array($res_messl);
$thread_title= $res_mess['thread_title'];
$thread_comments= $res_mess['thread_comments'];


}*/
				
			?>
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo $res_w['thread_heading']?></strong></div></div>
         
		
		<div class="clear"></div>
				<form name="frmCategory" id="frmCategory" action="" method="post" enctype="multipart/form-data" onSubmit="return frmValidate(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="message_id" id="message_id" value="<?php echo $message_id;?>" />
        <input type="hidden" name="p_mess_id" id="p_mess_id" value="<?php echo $p_mess_id;?>" />
         <input type="hidden" name="thread_no" id="thread_no" value="<?php echo $_REQUEST["task_id"];?>" />
         <div id="tableContainer" class="table" style="border-left:1px;width:470 ">
        
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		<!--<tr>
		<td colspan="2" >
		<div id="div_button" style="text-align:right">
		
		<a href="javascript:void(null);" onClick="window.open('threads_input.php?mess_id=<?php echo $mess_id;?>&category_cd=<?php echo $_GET['category_cd']; ?>&cid=<?php echo $_GET['cid']; ?>', 'INV','width=650,height=500,scrollbars=yes');" >
Reply</a>
		
            
        </div>
		</td>
        </tr>   -->
	 <tr><td >
	    From<span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="meassage_sent_by" id="meassage_sent_by" value="<?php echo $meassage_sent_by;?>" style="width:200px;" /></div>
		</td>
        </tr>
		 <tr><td >
	    From Email<span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="meassage_sent_email" id="meassage_sent_email" value="<?php echo $meassage_sent_email;?>" style="width:200px;" /></div>
		</td>
        </tr>
		<!--<tr><td >
	    To <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="to_name" id="to_name" value="<?php //echo $to_name;?>" style="width:200px;" /></div>
		</td>
        </tr>	-->	
   <tr><td >
	    Subject <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="thread_title" id="thread_title" value="<?php echo $thread_title;?>" style="width:300px;" /></div>
		</td>
        </tr>
		<tr><td >
	    Status <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement"><select name="thread_status">
		 <option value="1" <?php if($thread_status=='1')echo "selected";?>>Initiated</option>
  		<option value="2" <?php if($thread_status=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($thread_status=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($thread_status=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($thread_status=='5')echo "selected";?>>Response Awaited</option>
		  <option value="6" <?php if($thread_status=='6')echo "selected";?>>Replied</option>
		</select></div>
		</td>
        </tr>
		 <tr>
        
        <td >
	   Message <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
		<textarea name="thread_comments" rows="7"   style="width:300px;"><?php echo $thread_comments;?></textarea>
		</td>
        </tr>
		<tr><td >
	    Attachments <span style="color:#FF0000;">*</span>:
		
        </td>
        <td>
        <div class="frmElement">
		 <input id='upload' name="upload[]" type="file" multiple="multiple" /></div>
		</td>
        </tr>
	
		
		
        <tr >
        <td colspan="2" align="center">
          
        <div id="div_button" style="text-align:right">
			
            <input type="submit" class="rr_button" value="Save" name="save" id="save" />
			
           
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
        