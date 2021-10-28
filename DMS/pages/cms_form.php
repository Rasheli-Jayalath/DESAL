<?php
include("./fckeditor/fckeditor.php");
$cms_path=CMS_PATH;
$mode	= "I";
if($_SERVER['REQUEST_METHOD'] == "POST")
{

		 $title 		= trim($_POST['title1']);
		 $details 		= trim($_POST['details']);
		 $cmsfile      = $_FILES['cmsfile'];
		 $mode=$_POST['mode'];
		 $old_cms_file =trim($_POST['old_cms_file']);
		
		$cms_cd = ($_POST['mode'] == "U") ? $_POST['cms_cd'] : $objAdminUser->genCode("rs_tbl_cms", "cms_cd");		
		$objContent->setProperty("cms_cd", $cms_cd);
		$objContent->setProperty("title", $title);
		$objContent->setProperty("details", $details);
		if(isset($_FILES["cmsfile"]["name"])&&$_FILES["cmsfile"]["name"]!="")
		{
		/* Upload the image File */
		$name_file=$_FILES["cmsfile"]["name"];
		$name_file_type=$_FILES["cmsfile"]["type"];
		$ext = pathinfo($name_file, PATHINFO_EXTENSION);
		$name_arr=explode(".",$name_file);
		$name_file1= rand(100,1000)."-".preg_replace("/[^a-zA-Z0-9.]/", "", $name_arr[0]);
		import("Image");
		$objImage = new Image($cms_path);
		$objImage->setImage($cmsfile);
		if(($_FILES["cmsfile"]["type"] == "image/jpg")|| 
		($_FILES["cmsfile"]["type"] == "image/jpeg")|| 
		($_FILES["cmsfile"]["type"] == "image/gif") || 
		($_FILES["cmsfile"]["type"] == "image/png"))
		{ # max allowable image size in mb
			
			if($old_cms_file){
					@unlink(CMS_PATH . $old_cms_file);
						
					}
			if($objImage->uploadImage($cms_cd,$name_file1)){
				
					$cmsfile = $objImage->filename;
					$objContent->setProperty("cmsfile",$cmsfile);
			}
		 }
			else
		 {
		 $objCommon->setMessage("Invalid file ", 'Error');
		 }
		 
		}
		if($objContent->actCMS($_POST['mode'])){
			if($mode=="U")
			{
			$objCommon->setMessage("CMS page is updated successfully",'Update');
			$activity="CMS page is updated successfully";
			$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
			}
			else
			{
			$objCommon->setMessage("CMS page is saved successfully",'Info');
			$activity="CMS page is added successfully";
			$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);	
			}
			redirect('./?p=cms_mgmt');
		}
	
	extract($_POST);
}
else
{
	if(isset($_GET['cms_cd']) && !empty($_GET['cms_cd']))
		$cms_cd = $_GET['cms_cd'];
	else if(isset($_POST['cms_cd']) && !empty($_POST['cms_cd']))
		$cms_cd = $_POST['cms_cd'];
	if(isset($cms_cd) && !empty($cms_cd))
	{
		$objContent->setProperty("cms_cd", $cms_cd);
		$objContent->lstCMS();
		$data = $objContent->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}
?>
<script>
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	/*var invid=frm.invid.value;
	var id_inv='paymentdate_'+invid;
	alert(id_inv);
	alert(invid);*/
	if(frm.title1.value == ""){
		msg = msg + "\r\n<?php echo "Title is required field";?>";
		flag = false;
	}
		
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
<script language="javascript" type="text/javascript">
function getXMLHTTP2() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
function doDeleteNewsFile(cms_cd,image,name) {

		
			var strURL="<?php echo SITE_URL; ?>delete_image.php?news_cd="+news_cd+"&image="+image+"&name="+name;
		
			var req = getXMLHTTP2();
				
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
						    document.getElementById('delete_'+name).innerHTML=req.responseText;	
						   						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
		
	}
</script>
<div id="wrapperPRight">
		<div id="pageContentName" class="shadowWhite"><?php echo ($mode == "U") ? 'Edit CMS Page' : 'Add CMS Page';?></div>
		<div id="pageContentRight">
		</div>
		<div class="clear"></div>
		<?php echo $objCommon->displayMessage();?>
		<div class="clear"></div>
		
		<div id="tableContainer">
		<div class="clear"></div>			
	  	    <form name="frmCms" id="frmCms" action="" method="post" onSubmit="return frmValidate(this);" enctype="multipart/form-data">
			
			<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        	<input type="hidden" name="cms_cd" id="cms_cd" value="<?php echo $cms_cd;?>" />
       		<div class="formfield b shadowWhite"><?php echo 'Title';?>:</div>
			<div class="formvalue"><input class="rr_input" type="text" name="title1" id="title1" value="<?php echo $title;?>" style="width:485px" /></div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Details';?>:</div>
			<div class="formvalue"> 
			  <?php
			  $oFCKeditor = new FCKeditor('details') ;
			  $oFCKeditor->BasePath   = SITE_URL.'fckeditor/';
			  $oFCKeditor->Width      = "506px";
			  $oFCKeditor->Height     = "250";
			  $oFCKeditor->ToolbarSet = "Basic";
			  $oFCKeditor->Value     = stripslashes($details);      
			  $oFCKeditor->Create( );
			  ?>
			</div>
			<div class="clear"></div>
			<div class="formfield b shadowWhite"><?php echo 'Upload Image';?>:</div>
			<div class="formvalue" style="width:250px">
			<input type="file" name="cmsfile" id="cmsfile" />
            <input type="hidden" name="old_cms_file" value="<?php echo $cmsfile;?>" /><span style="color:green">Image width should be atleast 720px</span>
			</div>
			
			<div class="clear"></div>
			<div id="submit" style="margin-left:164px;"><input type="submit" class="SubmitButton" value="<?php echo ($mode == "U") ? " Update " : " Save ";?>" /></div>
			<div id="submit2">
			<input type="button" class="SubmitButton" value=" Cancel " onclick="javascript: history.back(-1);" />
			</div>
			<div class="clear"></div>
		    </form>
			<div class="clear"></div>
  	    </div>
	</div>
