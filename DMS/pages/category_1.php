<?php
//loadLang("product");
$objProductM= new Product;
$objProductMM= new Product;
if(isset($_GET['mode']) && $_GET['mode'] == "category_delete"){
				$category_cd_ct = $_GET['category_cd'];
				
				 $sql2c="Select * from rs_tbl_category where parent_cd='$category_cd_ct'";
				$res2c=mysql_query($sql2c);
				if(mysql_num_rows($res2c)>=1)
				{
				
				$objCommon->setMessage("You should delete its sub category(s) first", 'Error');
				redirect('./?p=category');
				}
				else
				{
					   
						$objProduct->resetProperty();
						$objProduct->setProperty("category_cd", $category_cd_ct);
						$objProduct->actCategory("D");
						$objCommon->setMessage(PRD_DELETE_SUCCESS, 'Info');
						$activity="Category has been deleted";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
						redirect('./?p=category');
					}				
	
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
	$sqlrw=mysql_query($sql);
	$sqlrw1=mysql_fetch_array($sqlrw);
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
			$objProduct->setProperty("category_cd", $category_cd);
			$objProduct->setProperty("parent_cd", $parent_cd);
			$objProduct->setProperty("category_name", $category_name);
			$objProduct->setProperty("parent_group", $parent_group);
			$objProduct->setProperty("category_status", $category_status);
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
					$activity="Category has been updated";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
				}
				else{
					$objCommon->setMessage(PRD_FLD_MSG_SUCCESS,'Info');
					$activity="Category has been added";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				mysql_query($sSQLlog_log);		
				}
				/***** Log Entry *****/
				$log_module = "Setting";
				$log_title 	= "Category";
				//doLog($log_module, $log_title, $log_desc, $objAdminUser->user_cd);
				/***** End *****/
				redirect('./?p=category');
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
  
    var rights=option.value;
		
	document.getElementById('rights_'+rights).style.display = "block";
	
	
	
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
<link type="text/css" href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo SITE_URL;?>/jquery.mcdropdown/css/docs.css" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo SITE_URL;?>/jquery.mcdropdown/css/jquery.mcdropdown.min.css" rel="stylesheet" media="all" />

	<!---// load jQuery from the GoogleAPIs CDN //--->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

	<script type="text/javascript" src="<?php echo SITE_URL;?>/jquery.mcdropdown/lib/jquery.mcdropdown.min.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>/jquery.mcdropdown/lib/jquery.bgiframe.js"></script>

	<script type="text/javascript">
	<!--//
	// on DOM ready
	$(document).ready(function (){
		$("#current_rev").html("v"+$.mcDropdown.version);
		$("#parent_cd").mcDropdown("#categorymenu");
	});
	//-->
	</script>
<div id="wrapperPRight">
<!--<div id="wrapperPRight">-->
<div id="containerContent" class="box" style="min-height:80px;padding:0px">
		<div id="pageContentName" class="shadowWhite"><div align="left"><strong><?php echo ($mode == "U")? "Update Category" : "Add New Category";?></strong></div></div>
         
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
        
         <div id="tableContainer" class="table" style="border-left:1px;">
        
          <table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
		   <tr>
      
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
        </tr>
		  <tr>
      
        <td >
	    <?php echo PRD_CAT_NAME;?> <span style="color:#FF0000;">*</span>:
        </td>
        <td>
        <div class="frmElement"><input class="rr_input" type="text" name="category_name" id="category_name" value="<?php echo $category_name;?>" style="width:200px;" /></div>
		</td>
        </tr>
  
        </tr>
		 <tr>
      
        <td >
	    Template <span style="color:#FF0000;"></span>:
        </td>
        <td>
		<table>
		
		<?php
		
		
			
			
		$sqll="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbCfg[db_name]' AND TABLE_NAME = 'rs_tbl_documents' limit 3,20";
$res=mysql_query($sqll);
while($ress=mysql_fetch_array($res))
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
elseif($column_name1=="cid")
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
elseif($column_name1=="cid")
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
			$res3=mysql_query($sql3);
			while($row3=mysql_fetch_array($res3))
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
elseif($column_name1=="cid")
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
			$res3=mysql_query($sql3);
			while($row3=mysql_fetch_array($res3))
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
	
	
 			
		<?php echo $objCommon->displayMessage();?>
		
        <div id="tableContainer" class="table" style="border-left:1px;">
		<table  width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="width:60%; font-weight:bold; background:#ededed" class="clsleft"><?php echo PRD_CAT_NAME;?></td>
       <td style="width:20%; font-weight:bold; background:#ededed" class="clsleft"><?php echo "Component";?></td>
      <td colspan="2" style="width:20%; font-weight:bold; background:#ededed"><?php echo "Action";?></td>
      
    </tr>
    <?php
	$objProduct->resetProperty();
	$objProduct->setProperty("limit", PERPAGE);
	$objProduct->setProperty("parent_cd", 0);
	$objProduct->lstCategory();
	$Sql = $objProduct->getSQL();
	if($objProduct->totalRecords() >= 1){
		while($rows = $objProduct->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
                <td class="clsleft"><?php echo $rows['category_name'];?></td>
                 <td class="clsleft"><?php if($rows['cid']==1)
				 {
					 echo "Project Data";
				 }
				 else
				 {
					  echo "DMS";
				}
				 ?></td>
                <td><a href="./?p=category&category_cd=<?php echo $rows['category_cd'];?>" title="Edit"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" /></a></td>
                <td><a href="./?p=category&mode=category_delete&category_cd=<?php echo $rows['category_cd'];?>" onClick="return doConfirm('Are you sure you want to delete this category?');" title="Delete"><img src="<?php echo SITE_URL;?>images/delete.gif" border="0" alt="Delete" title="Delete" /></a></td>
    		</tr>
    		<?php
			//getSub($rows['category_cd']);
		}
    }
	else{
	?>
    <tr>
    	<td colspan="3" align="center"><?php echo PRD_CAT_NO_CAT;?></td>
    </tr>
    <?php
	}
	?>
  </table>
		</div>
		
	</div> 
	<!--</div>
-->
</div>

        <?php
function getSub($parent_cd, $spaces = ''){
	$spaces .= '&nbsp;&nbsp;&nbsp;';
	$objProductN = new Product;
	$objProductN->setProperty("parent_cd", $parent_cd);
	$objProductN->lstCategory();
	if($objProductN->totalRecords() >= 1){
		while($rows_sub = $objProductN->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
    		<tr bgcolor="<?php echo $bgcolor;?>">
                <td class="clsleft"><?php echo $spaces . $rows_sub['category_name'];?></td>
                  <td class="clsleft"><?php if($rows_sub['cid']==1)
				 {
					 echo "Project Data";
				 }
				 else
				 {
					  echo "DMS";
				}
				 ?></td>
                
                <td><a href="./?p=category&category_cd=<?php echo $rows_sub['category_cd'];?>" title="Edit"><img src="<?php echo SITE_URL;?>images/edit.gif" border="0" title="Edit" alt="Edit" /></a></td>
                <td><a href="./?p=category&mode=Delete&category_cd=<?php echo $rows_sub['category_cd'];?>" onClick="return doConfirm('Are you sure you want to delete this category?');" title="Delete" ><img src="<?php echo SITE_URL;?>images/delete.gif" border="0" alt="Delete" title="Delete" /></a></td>
    		</tr>
    		<?php
    		getSub($rows_sub['category_cd'], $spaces);
		}
    }
}
function getSubMM($parent_cd){
	
	$objProductNM = new Product;
	$objProductNM->setProperty("cid", 1);
	$objProductNM->setProperty("parent_cd", $parent_cd);
	$objProductNM->lstCategory();
	if($objProductNM->totalRecords() >= 1){
		while($rows_sub = $objProductNM->dbFetchArray(1)){
			
			?>
    		<li rel="<?php echo $rows_sub['category_cd'];?>">
           <?php echo $rows_sub['category_name'];?>
           <ul>
    		<?php
    		getSubMM($rows_sub['category_cd']);
			?>
            </ul>
           </li>
            <?php
		}
    }
}
?>
