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



    <title>DMS</title>
</head>

<body>
	<?php
if($_GET['mode'] == 'Delete')
{
	$member_cd = $_GET['member_cd'];
	
	$objAdminUser->setProperty("member_cd", $member_cd);
	$objAdminUser->actStaffMember('D');
	$objCommon->setMessage('Member account deleted successfully.', 'Error');
	$activity="Staff member  deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
	redirect('./?p=staff_dir');
	
}


if(!empty($_GET['search_by'])){
	$search_by = urldecode($_GET['search_by']);
	$search_value = urldecode($_GET['search_value']);
	if($search_by=="firstname")
	{
	$objAdminUser->setProperty("first_name", strtolower($search_value));
	}
	if($search_by=="lastname")
	{
	$objAdminUser->setProperty("last_name", strtolower($search_value));
	}
	if($search_by=="position")
	{
	$objAdminUser->setProperty("position", strtolower($search_value));
	}
	if($search_by=="cellno")
	{
	$objAdminUser->setProperty("cell_no", strtolower($search_value));
	}if($search_by=="landline")
	{
	$objAdminUser->setProperty("landline", strtolower($search_value));
	}
	if($search_by=="email")
	{
	$objAdminUser->setProperty("email", strtolower($search_value));
	}
	if($search_by=="address")
	{
	$objAdminUser->setProperty("address", strtolower($search_value));
	}
}
if(!empty($_GET['search_value'])){
	$search_value = urldecode($_GET['search_value']);
	$objAdminUser->setProperty("search_value", strtolower($search_value));
}
?>
<script type="text/javascript">
function doFilter(frm){
	var qString = '';
	if(frm.search_value.value=='')
	{
	alert("Please enter search value");
	}
	else
	{
	if(frm.search_by.value == "firstname"){
		qString += '&search_by=firstname&search_value=' + escape(frm.search_value.value);
	}
	if(frm.search_by.value == "lastname"){
		qString += '&search_by=lastname&search_value=' + escape(frm.search_value.value);
	}
	if(frm.search_by.value == "position"){
		qString += '&search_by=position&search_value=' + escape(frm.search_value.value);
	}
	if(frm.search_by.value == "cellno"){
		qString += '&search_by=cellno&search_value=' + escape(frm.search_value.value);
	}
	if(frm.search_by.value == "landline"){
		qString += '&search_by=landline&search_value=' + escape(frm.search_value.value);
	}
	if(frm.search_by.value == "email"){
		qString += '&search_by=email&search_value=' + escape(frm.search_value.value);
	}
	if(frm.search_by.value == "address"){
		qString += '&search_by=address&search_value=' + escape(frm.search_value.value);
	}
	document.location = '?p=staff_dir' + qString;
	}
}
</script>

<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;">
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 25PX;">Staff Directory Management</h4>

		<div class="container" style="text-align: right;">
		<?php if($objAdminUser->user_type==1){?>			
				<a href="./?p=update_staff_detail" class="btn btn-warning commontextsize"> 
				<i class="bi bi-person-plus-fill" style="margin-right: 10px;"></i>Add New Staff Member</a>
			<?php
			}
			?>
		</div>

			<form name="frmCustomer" id="frmCustomer" class="form-inline">


<div class="container" style="margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">
        <div class="row">

            
                    <div class="col-md-3 regular" style="text-align: right; margin: auto; font-size: small;">
                      <label  class="sr-only">Search By</label>
                      </div>

                    <div class=" col-md-3 regular" style="text-align: center; margin: auto; margin-top: 10px;">
                        <select class="form-select" style="font-size: small;" name="search_by" >
							<option value="firstname" selected>  First Name  </option>
							<option value="lastname" >           Last Name   </option>
							<option value="position" >           Position    </option>
							<option value="cellno" >             Cell No.    </option>
							<option value="landline" >           Landline    </option>
			 				<option value="email">               Email       </option>
			 				<option value="address">             Address     </option>
                          </select>
                    </div>

                    <div class=" col-md-3 regular" style="text-align: center; margin: auto; margin-top: 10px;">
                        <input type="text" style="font-size: small;" class="form-control" id="search_value" placeholder="Enter" name="search_value" value="" >
                      </div>

                    <div class=" col-md-3 regular" style="text-align: left;  margin-top: 8px;">
                        <button type="button" onClick="doFilter(this.form);" class="btn btn-primary mb-2 commontextsize" name="Submit" id="Submit"><i class="bi bi-search" style="margin-right: 10px;"></i>Search</button>
                      </div>

        </div>

    </div>
</form>
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<?php if(isset($_REQUEST['search_by']) && isset($_REQUEST['search_value']))
		{
		?>
		<p style="margin-left:10px;"><b>Search Results of:</b> <?php echo $_REQUEST['search_value']; ?></p>
		<?php
		}?>
		<div class="table-responsive">
		<table id="customers" width="100%" class="table" style="font-size: small;">
        <tr>
		<th class="semibold" style="text-align:center"><?php echo "Name";?></th>
		<th class="semibold" style="text-align:center"><?php echo "Position";?></th>
        <th class="semibold" style="text-align:center"><?php echo "Cell No.";?></th>
		<th class="semibold" style="text-align:center"><?php echo "Landline";?></th>
        <th class="semibold" style="text-align:center"><?php echo "Email";?></th>
		<th class="semibold" style="text-align:center"><?php echo "Address";?></th>
		<th class="semibold" style="text-align:center" >Action</th>
		</tr>
		<?php
	//$objAdminUser->setProperty("ORDER BY", "a.first_name");
	$objAdminUser->setProperty("limit", PERPAGE);
	$objAdminUser->setProperty("GROUP BY", "b.member_cd");
	$objAdminUser->lstStaffMember();
	$Sql = $objAdminUser->getSQL();
	if($objAdminUser->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objAdminUser->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<!-- Start Your Php Code her For Display Record's -->
			<tr style="background-color:<?php echo $bgcolor;?>">
				<td><?php echo $rows['fullname'];?></td>
                <td><?php echo $rows['position'];?></td>
				<td><?php echo $rows['cell_no'];?></td>
				<td><?php echo $rows['landline'];?></td>
				<td><?php echo $rows['email'];?></td>
				<td><?php echo $rows['address'];?></td>
				
				<td style="text-align:center">
				<?php if($objAdminUser->user_type==1){?>
				<a href="./?p=update_staff_detail&member_cd=<?php echo $rows['member_cd'];?>" title="Edit"> <i class="bi bi-pencil-fill iconorange" style="margin-right: 20px;"></i> </a><?php	} ?>
				
				<?php if($objAdminUser->user_type==1){?>
				<a class="lnk" href="./?p=staff_dir&amp;mode=Delete&amp;member_cd=<?php echo $rows['member_cd'];?>" onclick="return doConfirm('Are you sure you want to Delete Permanently this member ?');" title="Delete Member"><i class="bi bi-trash-fill iconred"></i></a>
				<?php	} ?>
				</td>
				</tr>
			<?php
			
		}
    }
	else{
	?>
	<tr>
	<td colspan="9">
  <div align="center" style="padding:5px 5px 5px 5px"> <?php echo "No Staff Member Found";?></div>
   </td></tr>
    <?php
	}
	?>
	<tr>
	<td colspan="9" style="padding:0">		
	<div id="tblFooter">
			<?php
if($objAdminUser->totalRecords() >= 1){
	$objPaginate = new Paginate($Sql, PERPAGE, OFFSET, "./?p=user_mgmt");
	?>
	
	<div style="float:left;width:170px;font-weight:bold"><?php $objPaginate->recordMessage();?></div>
	<div id="paging" style="float:right;text-align:right; padding-right:5px;  font-weight:bold">
	    <?php $objPaginate->showpages();?>
	</div>
<?php }?>
			</div>
	</td></tr>
		 </table>
</div>
	  </form>
	</div>

</body>
</html>