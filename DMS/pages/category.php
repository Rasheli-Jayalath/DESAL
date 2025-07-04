<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table-styling.css" rel="stylesheet">


    <!---  due to navbar not visible // <link type="text/css" href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" media="all" /> --->
	<link type="text/css" href="<?php echo SITE_URL;?>/jquery.mcdropdown/css/docs.css" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo SITE_URL;?>/jquery.mcdropdown/css/jquery.mcdropdown.min.css" rel="stylesheet" media="all" />

    <title>DMS</title>
</head>

<body>
	<?php
//loadLang("product");
$objDb		= new Database;
$objProductM= new Product;
$objProductMM= new Product;
if(isset($_GET['mode']) && $_GET['mode'] == "category_delete"){
				$category_cd_ct = $_GET['category_cd'];
				
				$sql2c="Select * from rs_tbl_category where parent_cd='$category_cd_ct'";
				$res2c=$objDb->dbCon->query($sql2c);
			    $row2c=$res2c->fetch();	
				if($res2c->rowCount()>=1)
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
				$objDb->dbCon->query($sSQLlog_log);		
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
	$sqlrw=$objDb->dbCon->query($sql);
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
			$objProduct->setProperty("category_cd", $category_cd);
			$objProduct->setProperty("parent_cd", $parent_cd);
			$objProduct->setProperty("category_name", $category_name);
			$objProduct->setProperty("parent_group", $parent_group);
			$objProduct->setProperty("category_status", $category_status);
			$objProduct->setProperty("cid", $cid);
			
			if($objProduct->actCategory($_POST['mode'])){
			
			
			$sdelete= "Delete from rs_tbl_category_template where cat_id='$category_cd'";
			$objDb->dbCon->query($sdelete);
	
				
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



	
<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;"> 
<!--<div id="wrapperPRight">-->

		<div id="pageContentName" class="shadowWhite"><div align="left"><h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 25PX;"><?php echo ($mode == "U")? "Update Category" : "Add New Category";?></h4></div></div>
		
	<div id="containerContent" class="container" style="margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">         
		<!--<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=product_mgmt" class="lnkButton" title="back"><?php echo _BTN_BACK;?></a></li>	
					</ul>
				<br style="clear:left"/>
			</div>
		</div>-->
		<div class="clear"></div>
				<form name="frmCategory" id="frmCategory" action="" method="post" onSubmit="return frmValidate(this); " class="form-inline">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="category_cd" id="category_cd" value="<?php echo $category_cd;?>" />
        
         <div id="tableContainer" class="table" style="border-left:1px;">
        
          <table width="70%" border="0" cellspacing="0" cellpadding="0" align="center">
			 <div class="row" style="margin-top: 20px;">

                    <div class="col-md-4" style="text-align: right; margin: auto; font-size: small;">
                      <label  class="sr-only bold"><?php echo "Add Category In";?> <span style="color:#FF0000;">*</span></label>
                    </div>

                    <div class=" col-md-4 regular frmElement" style="text-align: left; margin: auto;">
                        <select class="form-select rr_select" style="font-size: small;" name="cid" id="cid">
						<option value="0" selected>--select---</option>
			   			<option value="1" <?php if($cid==1) echo 'selected="selected"';?>> Project Data</option>
						<option value="2" <?php if($cid==2) echo 'selected="selected"';?>>DMS</option>
                          </select>
                    </div>

                    <div class="col-md-4">
                    </div>

            </div>

			<div class="row" style="margin-top: 10px;">

				<div class="col-md-4" style="text-align: right; margin: auto; font-size: small;">
				<label  class="sr-only bold">   <?php echo PRD_CAT_NAME;?> <span style="color:#FF0000;">*</span> </label>
				</div>

				<div class=" col-md-4 regular frmElement" style="text-align: left; margin: auto;">
					<input class="form-control commontextsize rr_input" type="text" placeholder="Category Name" name="category_name" id="category_name" value="<?php echo $category_name;?>">
				</div>

				<div class="col-md-4">
				</div>

			</div>

  
  
		 
      
        <!-- Template -->
        <div class="row" style="margin-top: 30px; margin-bottom: 20px;">

            <div class=" col-md-4">
               
            </div>

            <div class="col-md-4 regular" style=" margin: auto; font-size: small;">
                <p class="bold"  style="text-align: left; margin: auto; font-size: 20px;">Template</p>
       
            </div>

            

            <div class="col-md-4">
            </div>

        </div>
		
        <th   style="  border: 1px solid white;"> 
		<table>
		
		<?php
		
		
			
			
		$sqll="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbCfg[db_name]' AND TABLE_NAME = 'rs_tbl_documents' limit 3,20";
$res=$objDb->dbCon->query($sqll);
while($ress=$res->fetch())
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
 echo " <div class=\"col-md-7 regular\" style=\"text-align: right;  width: 200px; margin: auto; font-size: small;\">
 <label  class=\"sr-only bold\">  ";
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
echo "</label> </div>";
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
		<div class=" " style="text-align: left; margin: auto; margin-right: 20px">
        <input class="rr_input" type="hidden" name="cat_field_name[]" id="cat_field_name[]" value="<?php echo $column_name1;?>" style="width:200px;" />
		<input class="rr_input form-control commontextsize " type="text" name="cat_title_text[]" id="cat_title_text[]" value="<?php
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
		
		 ?>"  style = "width: 300px; margin-left: 35px"/>
		 </div>
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
		<td style = "  padding : 5px;" >
		<input name="order[]" type="text" class="rr_input form-control commontextsize" id="order[]" tabindex="<?php echo $i;?>" value="<?php
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
		
		 ?>" style="width:75px" placeholder="Order #" />
						
         <input name="field_name[]" type="hidden" id="field_name[]" value="<?php echo $column_name1;?>"  />
		</td>
		<?php
		}
		?>
		<!--<td>
		<input class="rr_input"  type="checkbox" name="check_id[]" id="check_id[]" value="<?php //$column_name1?>" style="width:10px;" />
		</td>-->
		
		
		
		<?php
		}
		?>
		  </table>
	
		<div class="row" style="margin-top: 10px;">

            <div class="col-md-7 regular" style="text-align: right; margin: auto; font-size: small;">
              <label  class="sr-only bold">Do you need Status of Documents?</label>
            </div>

            <div class="col-md-5 form-check" style="text-align: right;">
				<input class="form-check-input"  type="checkbox" name="category_status" id="category_status" value="1" <?php if($category_status==1){ echo 'checked="checked"';} ?> />
              </div>

            <div class="col-md-2">
            </div>

        </div>
	
		
		<div class="row">

			<div class="regular" style=" text-align: center; margin: auto; margin-top: 40px; margin-top: 10px; ">
				<button type="submit" class="btn btn-success" value="<?php echo ($mode == "U") ? _BTN_UPDATE : _BTN_SAVE;?>"> <i class="bi bi-arrow-bar-up" style="margin-right: 10px;"></i>Save</button>

			</div>

         </div>
      
	</table>
      </div>
	</form>
	</div>
	
	
 			
		<?php echo $objCommon->displayMessage();?>
		
        <div id="tableContainer" class="table" style="border-left:1px;" class="container" style="margin-top: 20px; margin-bottom: 100px;">
		<div class="table-responsive commontextsize">
		<table  width="100%"  id="customers" class="table">
		<thead>
				<tr>
				<th style="width:60%;  " class="semibold"><?php echo PRD_CAT_NAME;?></th>
				<th style="width:20%;  " class="semibold"><?php echo "Component";?></th>
				<th colspan="2" style="width:20%;  text-align: center;" class="semibold"><?php echo "Action";?></th> 
				
				</tr>
	    </thead>
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
                <td style="text-align: center;"><a href="./?p=category&category_cd=<?php echo $rows['category_cd'];?>" title="Edit"><i class="bi bi-pencil-fill iconorange" style="margin-right: 20px;"></i></a>
                <a href="./?p=category&mode=category_delete&category_cd=<?php echo $rows['category_cd'];?>" onClick="return doConfirm('Are you sure you want to delete this category?');" title="Delete"> <i class="bi bi-trash-fill iconred"></i> </a></td>
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
                <td><a href="./?p=category&mode=Delete&category_cd=<?php echo $rows_sub['category_cd'];?>" onClick="return doConfirm('Are you sure you want to delete this category?');" title="Delete" > <i class="bi bi-trash-fill iconred"></i> </a></td>
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
</div>
</body>
</html>
