<?php
$report_path = REPORT_PATH;

$report_id = $_REQUEST['report_id'];
$cquery11 = "select * from rs_tbl_documents WHERE report_id = '$report_id'";
$cresult11 = mysql_query($cquery11);
$cdata11 = mysql_fetch_array($cresult11);
$cat_idm = $cdata11['report_category'];
$subcatid = $cdata11['report_subcategory'];
$uaccess1 = $cdata11['user_access'];
$user_ids1 = $cdata11['user_ids'];
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
//redirect('./?p=project_mgmt&pid='.$pid);
}
$mode	= "I";
$size=500;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["report_add"])){
	

			$report_id = trim($_REQUEST['report_id']);
			$mode = trim($_POST['mode']);
			$cat_id = trim($_POST['cat_id']);
			$subcatidm = trim($_POST['subcatidm']);
			//$subcatid = trim($_POST['subcatid']);
			$cat_title = trim($_POST['report_title']);
			$comment = trim($_POST['report_status']);
			$period = trim($_POST['period']);
			$revision = trim($_POST['revision']);
			$document_no = trim($_POST['document_no']);
			if($mode=="U")
			{
			$subcatide= trim($_POST['subcatide']);
			$subcatid=$subcatide;
			}
			else
			{
			
			if($subcatidm=="")
			{
			$subcatid="";
			}
			else
			{
				$subcat_array=explode("_",$subcatidm);
				$lengg=count($subcat_array);
				$category_cdp="";
				for($i=0;$i<$lengg; $i++)
				{
				 $parent_cdd=$subcat_array[$i];
				$cqueryp = "select * from  rs_tbl_category where parent_cd='$parent_cdd'";
				$cresultp = mysql_query($cqueryp);
				$cresultp1 =mysql_fetch_array($cresultp);
				$category_cdpt=$cresultp1['category_cd'];
				$add_u="_";
				if($i==$lengg-1)
				{
				$category_cdp=$category_cdp.$category_cdpt;
				}
				else
				{
				$category_cdp=$category_cdp.$category_cdpt.$add_u;
				}
				
				}
			$subcatid=$category_cdp;
			}
			}
			if($_POST['doc_issue_date']!="")
			{
		$doc_issue_date = date('Y-m-d',strtotime($_POST['doc_issue_date']));
			}
			else
			{
			$doc_issue_date="";
			}
			if($_POST['doc_closing_date']!="")
			{
		$doc_closing_date = date('Y-m-d',strtotime($_POST['doc_closing_date']));
			}
			else
			{
			$doc_closing_date="";
			}
			$doc_upload_date=date('Y-m-d');
			$report_file=$_FILES['report_file'];
			$old_report_file=trim($_POST['old_report_file']);
			 $uaccess = $_POST['user_access'];
			 $users_rest = $_POST['users'];
			 
			 
   
 if(isset($uaccess)){  
 $access_count=count($uaccess); 
 for($i=0;$i<$access_count;$i++)
 {
$count_users=$uaccess[$i];
if($count_users==5)
{
$flag=5;
}
 $accuser.=$count_users.",";
 

 }
 $serializedoptions1=$accuser;
 $serializedoptions=substr($serializedoptions1, 0, -1);
 if($flag==5)
 {
		 if(isset($users_rest)){ 
		/* $alluser=0;
		 $all_users=0;
		 $user_ids=0;*/
		  $user_count=count($users_rest); 
		 for($i=0;$i<$user_count;$i++)
		 {
		 $all_users=$users_rest[$i];
		 $alluser.=$all_users.",";
		 
		
		 }
		$user_ids1=$alluser;
		$user_ids=substr($user_ids1, 0, -1);
		
		}
 }
 else
 {
 $user_ids="";
 } 

}
 

			$max_size=($size * 1024 * 1024);
	
	$objValidate->setArray($_POST);
	/*$objValidate->setCheckField("report_category", PRD_FLD_MSG_CATNAME, "S");*/
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
		$report_id = ($_POST['mode'] == "U") ? $_POST['report_id'] : $objAdminUser->genCode("rs_tbl_documents", "report_id");
		$objProdctC1 = new Product;
		$objProdctC1->setProperty("report_id", $report_id);
		$objProdctC1->setProperty("report_category", $cat_id);
		$objProdctC1->setProperty("report_subcategory", $subcatid);
		$objProdctC1->setProperty("report_title", $cat_title);
		$objProdctC1->setProperty("report_status", $comment);
		$objProdctC1->setProperty("period", $period);
		$objProdctC1->setProperty("revision", $revision);
		$objProdctC1->setProperty("document_no", $document_no);
		$objProdctC1->setProperty("doc_issue_date", $doc_issue_date);
		$objProdctC1->setProperty("doc_closing_date", $doc_closing_date);
		$objProdctC1->setProperty("doc_upload_date", $doc_upload_date);	
		$objProdctC1->setProperty("user_access", $serializedoptions);
		$objProdctC1->setProperty("user_ids", $user_ids);
		
			if(isset($_FILES["report_file"]["name"])&&$_FILES["report_file"]["name"]!="")
		{
		/* Upload the pdf File */
		import("Image");
		$objImage = new Image($report_path);
		$objImage->setImage($report_file);
		if(($_FILES["report_file"]["type"] == "application/pdf")|| ($_FILES["report_file"]["type"] == "application/msword") || 
		($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
		($_FILES["report_file"]["type"] == "text/plain") || 
		($_FILES["report_file"]["type"] == "image/jpg")|| 
		($_FILES["report_file"]["type"] == "image/jpeg")|| 
		($_FILES["report_file"]["type"] == "image/gif") || 
		($_FILES["report_file"]["type"] == "image/png")&&($_FILES["report_file"]["size"] < $max_size))
		{ 
			
			if($old_report_file){
					@unlink(REPORT_PATH . $old_report_file);
						
					}
			if($objImage->uploadImage($report_id)){
				
			$report_file = $objImage->filename;
				$objProdctC1->setProperty("report_file",$report_file);
			}
			}
			else
		  {
		 $objCommon->setMessage("Invalid file ", 'Error');
		//redirect('./?p=upload_report&report_id='.$report_id);
		  }
		 
	}

			
			if($objProdctC1->actReport($_POST['mode'])){
				if($_POST['mode'] == "U"){
					$objCommon->setMessage("Document uploaded susccessfully",'Info');
					$log_desc 	= $category_name . " updated successfully.";
				}
				else{
					$objCommon->setMessage("Document uploaded susccessfully",'Info');
					$log_desc 	= $category_name . " added successfully.";
				}
				
				$log_module = "Setting";
				$log_title 	= "Report";
				//doLog($log_module, $log_title, $log_desc, $objAdminUser->user_cd);
				
				redirect('./?p=upload_report');
			}
		
	}
	
}
else{
	if(isset($_GET['report_id']) && !empty($_GET['report_id']))
		$report_id = $_GET['report_id'];
	else if(isset($_POST['report_id']) && !empty($_POST['report_id']))
		$report_id = $_POST['report_id'];
	if(isset($report_id) && !empty($report_id)){
		$objProduct->setProperty("report_id", $report_id);
		$objProduct->lstReport();
		$data = $objProduct->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}



?>
<?php
if(isset($cat_idm))
{
?>
<script>
/*alert("dsjfd");
window.onload = getsubcat1();
alert("dsjfd");
function getsubcat1() {
	alert("catid");
	}*/
</script>
<?php
}
?>
<script language="javascript" type="text/javascript">

function getXMLHTTP() { //fuction to return the xml http object
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
	

	
function getsubcat(catid) {

		//alert(catid);
		/*if (catid!=0) {
			alert(catid);*/	
			if(catid==""||catid==0)
			{
			
			<?php
		
			$cquery = "select * from  rs_tbl_category";
			
			$cresult = mysql_query($cquery);
			while ($cdata = mysql_fetch_array($cresult)) {	
			$cat_id=$cdata['category_cd'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdata['category_cd']?>).style.display="none";
		   document.getElementById("fields_"+<?php echo $cdata['category_cd']?>).style.display="none";
		  
	
            <?php }?>
			}
			else
			{
			<?php
		
			$cqueryg = "select * from  rs_tbl_category";
			
			$cresultg = mysql_query($cqueryg);
			while ($cdatag = mysql_fetch_array($cresultg)) {	
			$cat_idg=$cdatag['category_cd'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdatag['category_cd']?>).style.display="none";
		   document.getElementById("fields_"+<?php echo $cdatag['category_cd']?>).style.display="none";
	
            <?php }?>

			
			 
           document.getElementById("subcatdiv_"+catid).style.display="block";
		   
		   
		   document.getElementById("fields_"+catid).style.display="block"; 
	
           }
			
			
			
			var strURL="findsubcat_dpmTest.php?cat_id="+catid;
			var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("subcatdiv_"+catid).innerHTML=req.responseText;	
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			
			var strURLf="findfields_Test.php?cat_idf="+catid+"&parent_cdf=0";
			
			var reqf= getXMLHTTP();
			
			if (reqf) {
				//alert("if");
				
				reqf.onreadystatechange = function() {
					if (reqf.readyState == 4) {
						// only if "OK"
						if (reqf.status == 200) {						
							document.getElementById("fields_"+catid).innerHTML=reqf.responseText;	
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + reqf.statusText);
						}
					}				
				}			
				reqf.open("GET", strURLf, true);
				reqf.send(null);
			}
			 
		
	}
</script>
<script>
$(document).ready(function () {

    $('#cat_id').change(function(){
	   $.ajax({
            url: "selected_category.php",
            type: "post",
            data: {option: $(this).find("option:selected").val()},
			
            success: function(data){
			/*alert("category");*/
			
                //adds the echoed response to our container
				$("#tableContainer1").css('display','none');
                $("#tableContainer2").html(data);
				
            }
        });
    });
});
</script>
<?php
		//echo $cat_id;
		$cquery3 = "select * from  rs_tbl_category";
		
		$cresult3 = mysql_query($cquery3);
		while ($cdata3 = mysql_fetch_array($cresult3)) {	
		$cat_id4=$cdata3['category_cd'];	


		?>
<script language="javascript" type="text/javascript">
function getXMLHTTP1() { //fuction to return the xml http object
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
	
function subcatlisting_<?php echo $cat_id4?>(subcatid,catid,parent_cd) {

		 if(catid!="" && subcatid==0)
		  {

		  var myArray = catid.split('_');		  
		  var len=myArray.length;
		  var subcat=myArray[len-1];
		document.getElementById('tableContainer1').style.display="none";	
		    <?php
		 $cquery2 = "select * from  rs_tbl_category";
			
			$cresult2 = mysql_query($cquery2);
			while ($cdata2 = mysql_fetch_array($cresult2)) {	
			$cat_id2=$cdata2['category_cd'];	

			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['category_cd']?>).style.display="none";
			document.getElementById("fields_"+<?php echo $cdata2['category_cd']?>).style.display="none";
		  <?php
		  }
		   ?>
		   for(var i=0; i<len; i++)
		   {
		    document.getElementById("subcatdiv_"+myArray[i]).style.display="block";
			
			
		   }
		 	document.getElementById("fields_"+subcat).style.display="block";
		
		  
		   document.getElementById('tableContainer1').disabled = true;
		 
		  <?php
	
		  ?>
		  }else
		  {	
		 
		  
			 <?php
		 $cqueryt = "select * from  rs_tbl_category";
			
			$cresultt = mysql_query($cqueryt);
			while ($cdatat = mysql_fetch_array($cresultt)) {	
			$cat_idt=$cdatat['category_cd'];	

			?>
		   
			document.getElementById("fields_"+<?php echo $cdatat['category_cd']?>).style.display="none";
			
		  <?php
		  }
		  $cqueryt1 = "select * from  rs_tbl_category";
			
			$cresultt1 = mysql_query($cqueryt1);
			while ($cdatat1 = mysql_fetch_array($cresultt1)) {	
			$cat_idt1=$cdatat1['category_cd'];
			$par_idt1=$cdatat1['parent_cd'];
		

		   ?>
		   if(parent_cd==<?php echo $par_idt1?>)
		   {
		   document.getElementById("subcatdiv_"+<?php echo $cdatat1['category_cd']?>).style.display="none";
		   }
		   <?php
		  }
		  ?>
	
		  document.getElementById("subcatdiv_"+subcatid).style.display="block";
		   var myArray1 = catid.split('_');		  
		  var len1=myArray1.length;
		  var subcat1=myArray1[len1-1];
			 for(var j=0; j<len1; j++)
		   {
		    document.getElementById("fields_"+myArray1[j]).style.display="none";
		   }
		   document.getElementById("fields_"+subcatid).style.display="block";
		  }
		
		
			var strURL="selected_subcategory.php?subcat_idsub="+subcatid+"&catidsub="+catid;
			var strURL1="findcolumnsTest.php?subcat_id="+subcatid+"&catid="+catid;
			var strURLf1="findfields_Test.php?cat_idf="+subcatid+"&parent_cdf="+catid;
			
			
			//alert(strURL1);
			var req = getXMLHTTP1();
			var req1 = getXMLHTTP1();
			var reqf1= getXMLHTTP1();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {	
						   document.getElementById('tableContainer1').disabled = true;					
							document.getElementById('tableContainer2').innerHTML=req.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}
			if (req1) {
			
				
				
				req1.onreadystatechange = function() {
					if (req1.readyState == 4) {
						// only if "OK"
						if (req1.status == 200) 
						{
						
						document.getElementById("subcatidm").value=catid;
						document.getElementById("subcatdiv_"+subcatid).innerHTML=req1.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req1.statusText);
						}
					}				
				}			
				req1.open("GET", strURL1, true);
				req1.send(null);
			}
			
		 
			
			if (reqf1) {
				//alert("if");
				
				reqf1.onreadystatechange = function() {
					if (reqf1.readyState == 4) {
						// only if "OK"
						if (reqf1.status == 200) {
						if(subcatid==0)
							{
							subcatid=subcat;
							}
						
							document.getElementById("fields_"+subcatid).innerHTML=reqf1.responseText;	
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + reqf1.statusText);
						}
					}				
				}			
				reqf1.open("GET", strURLf1, true);
				reqf1.send(null);
			}
			
		
	}
</script>

<?php
}
?>
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
  
<div id="wrapperPRight">

<div id="containerContent" style="min-height:80px;padding:0px">


<h2 align="center">Upload File</h2>
<?php echo $objCommon->displayMessage();?>
         
		<div class="clear"></div>
				<form name="frmReport" id="frmReport"  action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="report_id" id="report_id" value="<?php echo $cdata11['report_id'];?>" />
        
         <div id="tableContainer" class="table" style="border-left:1px;">
        
          <table width="70%" border="1" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
    
    <tr>
      
        <td >
	    <?php echo PRD_CAT_NAME;?><span style="color:#FF0000;">*</span>:
        </td>
        <td>
        <div id="componentdiv">
        
        <select name="cat_id" id="cat_id" onchange="getsubcat(this.value)">
              <option value="0">Select Category..</option>
              <?php
$cquery = "select category_cd,category_name,parent_cd from  rs_tbl_category WHERE parent_cd = 0";

$cresult = mysql_query($cquery);
while ($cdata = mysql_fetch_array($cresult)) {

?>
              <option value="<?php echo $cdata['category_cd']; ?>" <?php if ($cat_idm == $cdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $cdata['category_name']; ?></option>
              <?php
}
?>
            </select>
			<!--<input type="hidden" name="cat_id" id="cat_id" value="<?php //echo $cat_id ?>"/>-->
			</div>
		</td>
        </tr>

		<tr>
		<td colspan="2" style="padding:0px;">
			<?php
		


		?>
		
		<?php
		$arr_subcat=explode("_",$subcatid);
		$lenng=count($arr_subcat);
		$ist_sub=$arr_subcat[0];
		$lst_sub=$arr_subcat[$lenng-1];
		$cquery = "select category_cd from  rs_tbl_category";
		
		$cresult = mysql_query($cquery);
		while ($cdata = mysql_fetch_array($cresult)) {	
		$cat_id2=$cdata['category_cd'];	
		
		
		//$parent_cd=$cdata['parent_cd'];
		if(($cat_id2==$cat_idm))
		
		{
?>
<div id="<?php echo "subcatdiv_".$cat_idm?>" style="display:block" >
<table width="100%" border="0" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
<?php

 $tquery = "select * from  rs_tbl_category where parent_cd = ".$cat_idm . " order by category_cd ASC";
$tresult = mysql_query($tquery);
if(mysql_num_rows($tresult)>0)
{


?>


<tr>
<td width="180px"><?php echo "Sub Category";?> 
       <span style="color:#FF0000;">*</span>:</td>
<td>
<select name="subcatid_<?php echo $cat_idm; ?>" id="subcatid_<?php echo $cat_idm; ?>"  onchange="subcatlisting_<?php echo $cat_idm; ?>(this.value,'<?php echo $cat_idm?>')">
<option value="0">Select Sub Category..</option>
<?php

while ($tdata = mysql_fetch_array($tresult)) {
?>
	<option value="<?php echo $tdata['category_cd']; ?>" <?php if ($ist_sub == $tdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $tdata['category_name']; ?></option>
<?php
}
?>
</select>
</td>
</tr>
<?php
}
?>
</table>

		</div>
<?php
}
 if(($cat_id2==$cat_idm) && ($lenng>1))
		
		{
		for($i=0; $i<$lenng; $i++)
		{
		?>
		<div id="<?php echo "subcatdiv_".$arr_subcat[$i]?>" style="display:block" >
		<table width="100%" border="0" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
		<?php
 $subcat_id= $arr_subcat[$i];
$catid= $cat_idm;
if($subcat_id!="" && $subcat_id!=0)
{
?>
<?php 

$tquery = "select * from  rs_tbl_category where parent_cd = ".$subcat_id . " order by category_cd ASC";
$tresult = mysql_query($tquery);
if(mysql_num_rows($tresult)>0)
{
if($i==0)
{
 $con_catid=$catid."_".$subcat_id;
 }
 else
 {

 $subcats="";
 $subcats1="";
 for($j=0;$j<$i;$j++)
 {
 $subcats1=$arr_subcat[$j];
 $subcats=$subcats."_".$subcats1;
 }

 $con_catid=$catid.$subcats."_".$subcat_id;
 $subcats="";
 }

?>
<tr>
<td width="180px"><?php echo "Sub Category";?> 
       <span style="color:#FF0000;">*</span>:</td>
<td>
<select name="subcatid_<?php echo $subcat_id; ?>" id="subcatid_<?php echo $subcat_id; ?>" onchange="subcatlisting_<?php echo $subcat_id; ?>(this.value,'<?php echo $con_catid; ?>')" >
<option value="0">Select Sub Category..</option>
<?php

while ($tdata = mysql_fetch_array($tresult)) {
?>
	<option value="<?php echo $tdata['category_cd']; ?>" <?php if ($arr_subcat[$i+1] == $tdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $tdata['category_name']; ?></option>
<?php
}
?>
</select>
</td>
</tr>
<?php
}
}
?>
</table>
		</div>
		<?php
		}
		}
else
{
?>
<div id="<?php echo "subcatdiv_".$cdata['category_cd']?>" style="display:block" >
		</div>
<?php
}
if($subcatid=="")
{
$lst_sub=$cat_idm;
}

if($cat_id2==$lst_sub)
{



?>
<div id="<?php echo "fields_".$lst_sub?>" style="display:block" >
<table width="100%" border="0" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
<?php
$sql36="Select * from rs_tbl_category_template where cat_id=".$lst_sub;
$res36=mysql_query($sql36);
while($row36=mysql_fetch_array($res36))
			{
?>
<tr>
        
        <td><?php echo $row36['cat_title_text'] ?>:
        </td>
        <td>
		<?php 
		$field_name=$row36["cat_field_name"];
		?>
            <input type="text" name="<?php echo $row36['cat_field_name'] ?>" id="<?php echo $row36['cat_field_name']?>" size="25px" value="<?php echo $cdata11[$field_name]?>">&nbsp;&nbsp;<?php if(($field_name=="doc_issue_date")||($field_name=="doc_closing_date"))
			{
			echo "yyyy-mm-dd";
			} ?>
			<?php
		
			?>
        </td>
        </tr>
		
<?php
}
?>
</table>
		</div>
<?php
}
else
{
?>

		
		<div id="<?php echo "fields_".$cdata['category_cd']?>" style="display:block" >
		</div>
<?php
		}
		}
		
	
?>
			
			
			<input type="hidden" name="subcatide" id="subcatide" value="<?php echo $subcatid; ?>"/>
           <input type="hidden" name="subcatidm" id="subcatidm" value=""/>
		
       
		</td>
        </tr>
		<tr>
        <td>Upload File:        </td>
        <td>
            <input type="file" name="report_file" id="report_file" />
            <input type="hidden" name="old_report_file" value="<?php echo $file_report;?>" /></td>
		</tr>
            <tr>
					  <td class="label" valign="top" >&nbsp;</td>
<td  valign="top" align="left">
<?php if(($cdata11['report_file']!="")||($cdata11['report_file']!=NULL)) {
?> <a href="<?php echo REPORT_URL.$cdata11['report_file']?>" ><img src="images/tag_small.png" border="0" /></a>
			<a onClick="return doConfirm('Are you sure you want to delete the Document?');" href="?p=upload_report&report_id=<?php echo $cdata11['report_id'];?>&mode=DoDelete&file_report=<?php echo urlencode($cdata11['report_file']);?>">Remove Document?</a>
           <?php }?>                        </td>					  
	    </tr>
		<tr>
        <td>Status:</td>
        
        <td>
		<input type="radio" id="report_status" name="report_status" value="1" checked="checked"/>
			 Active 
			 <input type="radio" 
			 id="report_status" name="report_status" value="2" <?php echo ($cdata11['report_status']==2) ? 'checked="checked"' : "";?>/>
			Inactive        </td>
        </tr>
		<tr>
        <td>User Access:		</td>
       
        <td>
		<select multiple="multiple" name="user_access[]"  id="user_access[]" ONCHANGE="swapContent(this)" >
		<?php
		$arraccess= explode(",",$uaccess1);
		$acc_total_users=count($arraccess);
		

  foreach($arraccess as $key => $val) {
     $arraccess[$key] = trim($val);
	if($arraccess[$key]==1)
	{
	$arraccess1="1";
	}
	if($arraccess[$key]==2)
	{
	$arraccess2="2";
	}
	if($arraccess[$key]==3)
	{
	$arraccess3="3";
	}
	if($arraccess[$key]==4)
	{
	$arraccess4="4";
	}
	if($arraccess[$key]==5)
	{
	$arraccess5="5";
	}
  }
 
  
 
		?>
    <option value="1" <?php if($arraccess1=="1"){ ?> selected="selected"<?php }?>  >SupperAdmin</option>
    <option value="2" <?php if($arraccess2=="2"){ ?> selected="selected"<?php }?>>SubAdmin</option>
    <option value="3" <?php if($arraccess3=="3"){ ?> selected="selected"<?php }?>>Users</option>
    <option value="4" <?php if($arraccess4=="4"){ ?> selected="selected"<?php }?>>All</option>
    <option value="5" <?php if($arraccess5=="5"){ ?> selected="selected"<?php }?>>Restricted</option>
</select>        </td>
        </tr>
		
		<tr>
        <td>		</td>
       
        <td>
		<div id="users"	<?php if(isset($_GET['report_id']) && $user_ids1!=""){?> style="display:block" <?php } else	 { ?> style="display:none"	 
		 <?php
		 }
		 ?>>
		<select multiple="multiple" name="users[]"  id="users" >
		<?php 
		
	 
		

		$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "user_cd");
	$objAdminUser->lstAdminUser();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
	
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
		if($user_ids1)
		{
		$arrusers= explode(",",$user_ids1);
		$arr_total_users=count($arrusers);
		
		 foreach($arrusers as $key => $val) {
   $arrusers[$key] = trim($val);
   if($arrusers[$key]==$rows['user_cd']){ 
    $selected="selected";
	break;
	}
	else
	{
	$selected="";
	}
	}
	}	
		
		?>
    <option value="<?php echo $rows['user_cd'];?>"<?php echo $selected;?>  ><?php echo $rows['fullname'];?></option>
	
	<?php
	$sno += $sno;
	}
	//}
	}?>
</select>
</div>
        </td>
        </tr>

        <tr >
        <td colspan="2" align="center">
          
        <div id="div_button">
            <input type="submit" id="report_add" name="report_add" class="rr_button" value="<?php echo ($mode == "U") ? _BTN_UPDATE : _BTN_SAVE;?>" />
           
        </div>
        </td>
        </tr>
        </table>
            </div>
	</form>
	<div id="tableContainer2" class="table" style="border-left:1px;">
	</div>
	<div id="tableContainer1" class="table" style="border-left:1px;">
	
		
		</div>
 	</div> 
	</div>

      