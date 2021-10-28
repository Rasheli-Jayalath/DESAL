<?php
$report_path = REPORT_PATH;
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
function atleast_onecheckbox(e) {
  if ($("input[type=checkbox]:checked").length === 0) {
      e.preventDefault();
      alert('Please check atleast on record');
      return false;
  }
}
</script>
 <script>
function showResult(strd,strr,strt) {
 // if (str.length==0) { 
 //  document.getElementById("livesearch").innerHTML="";
 //   document.getElementById("livesearch").style.border="0px";
 //   return;
 // }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","livesearch.php?d="+strd+"&r="+strr+"&t="+strt,true);
  xmlhttp.send();
}

function advSearch(catid,last_subcat,titlee,document_no,reference_no,revision,file_from,file_to,file_no,file_category,drawing_series,doc_issue_date,received_date,doc_upload_datef,doc_upload_datet,remarks) {
 // if (str.length==0) { 
 //  document.getElementById("livesearch").innerHTML="";
 //   document.getElementById("livesearch").style.border="0px";
 //   return;
 // }

if(last_subcat=="" || last_subcat==0)
{
alert("Please select Category first");
document.getElementById("advsearch").style.display="none"; 
}
else
{
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	document.getElementById("livesearch").style.display="none"; 
	document.getElementById("advsearch").style.display="block"; 
      document.getElementById("advsearch").innerHTML=xmlhttp.responseText;
      document.getElementById("advsearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","reports_search.php?catid="+catid+"&last_subcat="+last_subcat+"&titlee="+titlee+"&document_no="+document_no+"&reference_no="+reference_no+"&revision="+revision+"&file_from="+file_from+"&file_to="+file_to+"&file_no="+file_no+"&file_category="+file_category+"&drawing_series="+drawing_series+"&doc_issue_date="+doc_issue_date+"&received_date="+received_date+"&doc_upload_datef="+doc_upload_datef+"&doc_upload_datet="+doc_upload_datet+"&remarks="+remarks,true);
  xmlhttp.send();
 }
}

function advanceSearch(valuet,valued, valuer) {

document.getElementById("livesearch").style.display="none"; 
document.getElementById("intractive_search").style.display="none"; 
document.getElementById("advance_search").style.display="block"; 
document.getElementById("titlee").value=valuet;
document.getElementById("document_no").value=valued; 
document.getElementById("revision").value=valuer; 
}
</script>

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
  <script>
function selectAllUnSelectAll_1(chkAll, strSelecting, frm){

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
function selectUnSelect_top(value,frm)
{
var checkboxes = document.getElementsByClassName("checkbox");
if(value.checked == false){
chkAll.checked =false;
}
if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length)
{
chkAll.checked =true;
}
}
</script>
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

			if(catid==""||catid==0)
			{
			
			<?php
		
			$cquery = "select * from  rs_tbl_category";
			
			$cresult = mysql_query($cquery);
			while ($cdata = mysql_fetch_array($cresult)) {	
			$cat_id=$cdata['category_cd'];	

			?>
           document.getElementById("subcatdiv_"+<?php echo $cdata['category_cd']?>).style.display="none";
		   document.getElementById("subcatidm").value=catid;
		   
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
		   	
            <?php }?>

			
			 
           document.getElementById("subcatdiv_"+catid).style.display="block";
		   document.getElementById("subcatidm").value=catid;
		   
		   
	
           }
			
						
			var strURL="sel_nextcat.php?cat_id="+catid;
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
	}
</script>
<?php
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
		   <?php
		 $cquery2 = "select * from  rs_tbl_category";			
			$cresult2 = mysql_query($cquery2);
			while ($cdata2 = mysql_fetch_array($cresult2)) {	
			$cat_id2=$cdata2['category_cd'];
			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['category_cd']?>).style.display="none";
			 <?php
		  }
		   ?>		   
		   for(var i=0; i<len; i++)
		   {
		    document.getElementById("subcatdiv_"+myArray[i]).style.display="block";
			 document.getElementById("subcatidm").value=myArray[i]; 		
		   }
		 	
		  }
		  else 
		  {
		 
		  var myArray1 = catid.split('_');		  
		  var len1=myArray1.length;
		  var subcat=myArray1[len1-1];
		   <?php
		 $cquery2 = "select * from  rs_tbl_category";			
			$cresult2 = mysql_query($cquery2);
			while ($cdata2 = mysql_fetch_array($cresult2)) {	
			$cat_id2=$cdata2['category_cd'];
			?>
		    document.getElementById("subcatdiv_"+<?php echo $cdata2['category_cd']?>).style.display="none";
			 <?php
		  }
		   ?>		   
		   for(var j=0; j<len1; j++)
		   {
		    document.getElementById("subcatdiv_"+myArray1[j]).style.display="block";
			
		   }
		   document.getElementById("subcatdiv_"+subcatid).style.display="block"; 
		  	 document.getElementById("subcatidm").value=subcatid;
			
		  }
		
			var strURL1="sel_subcat.php?subcat_id="+subcatid+"&catid="+catid;
			var req1 = getXMLHTTP1();			
			if (req1) {
			
				req1.onreadystatechange = function() {
					if (req1.readyState == 4) {
						// only if "OK"
						if (req1.status == 200) 
						{
					
						document.getElementById("subcatdiv_"+subcatid).innerHTML=req1.responseText;						
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req1.statusText);
						}
					}				
				}			
				req1.open("GET", strURL1, true);
				req1.send(null);
			}
		
	}

</script>

<?php
}
?>

 
<div id="wrapperPRight">

<div id="containerContent" style="min-height:80px;padding:0px">
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
<h2 align="center">Quick Search </h2>

<?php echo $objCommon->displayMessage();?>
         
		<div class="clear"></div>
		<div id="intractive_search">
		<table width="825" border="0px" align="center">
				<form action="searchadv.php" method="post">

<tr>
  <td><label><strong>Title: </strong></label></td>
  <td class="borbf"><input name="valuet" type="text" onKeyUp="showResult(valued.value,valuer.value,this.value)" size="10" maxlength="30"></td>
  <td class="borbf"></td>
</tr>
<tr>
<td><label><strong>Document No: </strong></label></td>
<td class="borbf"><input name="valued" type="text" onKeyUp="showResult(this.value,valuer.value,valuet.value)" size="10" maxlength="30"></td>
  <td class="borbf"></td>
</tr>
<tr>
<td><label><strong>Revision No: </strong></label></td>
<td class="borbf"><input name="valuer" type="text" onKeyUp="showResult(valued.value,this.value,valuet.value)" size="10" maxlength="30"></td>
  <td class="borbf"></td>
</tr>
<tr>
<td></td>
<td class="borbf"><input type="button" onclick="advanceSearch(valuet.value,valued.value,valuer.value)" value="Advance Search" /></td>
  <td class="borbf"></td>
</tr>

<!--<tr><td><label><strong>Period: </strong></label></td>
<td class="borbf"><input name="valuesp" id="valuesp" type="text" onKeyUp="showResult(valued.value,valuei.value,valuer.value,valuet.value,this.value,valueep.value)" size="10" maxlength="30">
<input name="valuesp" id="valueep" id="valueep" type="text" onKeyUp="showResult(valued.value,valuei.value,valuer.value,valuet.value,valuesp.value,this.value)" size="10" maxlength="30"></td>
  <td class="borbf"></td>
</tr>-->




</form>
</table>
</div>
<div id="advance_search" style="display:none">
<form name="searchfrm" id="searchfrm" action="reports_search.php"  method="post"  style=" border:1px solid #FFFFFF" >
     <table width="90%"  align="center" cellpadding="1" cellspacing="1" >      
      <tr >
	  
	  <td width="14%" class="label" >Select Category: &nbsp;</td>
	  <td width="38%" >
	  <select  name="cat_id" id="cat_id" onchange="getsubcat(this.value)" >
  		<option value=0  ><?php echo "Select Category.."; ?> </option>
		 <?php
		$cquery = "select * from  rs_tbl_category WHERE parent_cd = 0";
		$cresult = mysql_query($cquery);
		while ($cdata = mysql_fetch_array($cresult)) {

?>
		
       <option value="<?php echo $cdata['category_cd']; ?>" <?php if ($cat_idm == $cdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $cdata['category_name']; ?></option>
		<?php
		}
		?>
</select>
</td>
<td width="14%" class="label">&nbsp;</td>
 <td width="38%" >&nbsp;</td>
</tr>
<tr>
		<td colspan="2" style="padding:0px;">
			<?php
$cquery = "select category_cd from  rs_tbl_category";
		
		$cresult = mysql_query($cquery);
		while ($cdata = mysql_fetch_array($cresult)) {	
		$cat_id2=$cdata['category_cd'];	
		?>
<div id="<?php echo "subcatdiv_".$cdata['category_cd']?>" style="display:block" >
		</div>
<?php
}

?>
 <input type="hidden" name="subcatidm" id="subcatidm" value=""/>         
</td>
<td width="14%" class="label">&nbsp;</td>
 <td width="38%" >&nbsp;</td>
</tr>
	 
	   <tr>
	   
         <td width="14%" class="label">Title: &nbsp;</td>
         <td width="38%" > <input type="text" value="" name="titlee"  id="titlee" /></td>
		 <td width="14%" class="label">Document No.: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="document_no"  id="document_no" /></td>
       </tr>
	  
	   <tr>
         <td width="14%" class="label">Reference No.: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="reference_no"  id="reference_no" /></td>
		 <td width="14%" class="label">Revision: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="revision"  id="revision" /></td>
       </tr>
	   
	   <tr>
         <td width="14%" class="label">From: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="file_from"  id="file_from" /></td>
		 <td width="14%" class="label">To: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="file_to"  id="file_to" /></td>
       </tr>
	   
	   <tr>
         <td width="14%" class="label">File No: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="file_no"  id="file_no" /></td>
		 <td width="14%" class="label">File Category: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="file_category"  id="file_category" /></td>
       </tr>
	   
	    <tr>
         <td width="14%" class="label">Drawing Series: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="drawing_series"  id="drawing_series" /></td>
		 <td width="14%" class="label">Issue Date: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="doc_issue_date"  id="doc_issue_date" /></td>
       </tr>
	   
	   
	   <tr>
         <td width="14%" class="label">Received Date: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="received_date"  id="received_date" /></td>
       </tr>
	    <tr>
         <td width="14%" class="label">Uploading Date: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="doc_upload_datef"  id="doc_upload_datef" /><input type="text" value="" name="doc_upload_datet"  id="doc_upload_datet" /></td>
       </tr>
	    <tr>
         <td width="14%" class="label">Remarks: &nbsp;</td>
         <td width="38%" ><input type="text" value="" name="remarks"  id="remarks"  style="width:413px"/></td>
       </tr>
	    
   <tr>
         <td></td>
         <td colspan="3">
          <input type="button" onclick="advSearch(cat_id.value,subcatidm.value,titlee.value,document_no.value,reference_no.value,revision.value,file_from.value,file_to.value,file_no.value,file_category.value,drawing_series.value,doc_issue_date.value,received_date.value,doc_upload_datef.value,doc_upload_datet.value,remarks.value)" value="Go" /></td>
       </tr>
     </table>
   </form>
</div>



<div id="livesearch"></div>
<div id="advsearch"></div>
	
 	</div> 
	</div>

      