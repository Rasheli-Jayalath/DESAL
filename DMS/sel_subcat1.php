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
?>
<?php
$user_cd	= $objAdminUser->user_cd;
$user_type	= $objAdminUser->user_type;
?>
<table width="90%" cellspacing="1" cellpadding="1" align="center">
<?php
$subcat_id= $_REQUEST['subcat_id'];
$catid= $_REQUEST['catid'];
if($subcat_id!="" && $subcat_id!=0)
{
?>
<?php 
if($user_type==1)
{

$tquery = "select * from  rs_tbl_category where parent_cd = ".$subcat_id . " order by category_cd ASC";
$tresult = mysql_query($tquery);
$mysql_rows=mysql_num_rows($tresult);
}
else
{


$tquery1 = "select * from  rs_tbl_category where parent_cd = ".$subcat_id . " order by category_cd ASC";
$tresult1 = mysql_query($tquery1);
$c_id1="";
$g=0;
while($cddata2=mysql_fetch_array($tresult1))
{
$catt_cdd=$cddata2['category_cd'];
$arr_rst1=explode(",",$cddata2['user_ids']);
$len_rst21=count($arr_rst1);

for($ri1=0; $ri1<$len_rst21; $ri1++)
{ 

if($arr_rst1[$ri1]==$user_cd)
{
$g=$g+1;
	if($g==1)
	{ 
	$c_id1="category_cd=".$catt_cdd ;
	}
	else
	{
	$c_id1.=" OR category_cd=".$catt_cdd ;
	}

}

}
//$g=$g+1;

}	

	if($c_id1!="")
	{
	$tquery = "select * from  rs_tbl_category where ".$c_id1." order by category_cd ASC";
	$tresult = mysql_query($tquery);
	$mysql_rows=mysql_num_rows($tresult);
	}
	else
	{
	$mysql_rows=0;
	?>
	
	<?php 
	}

}
if($mysql_rows>0)
{
 $con_catid=$catid."_".$subcat_id;

?>
<tr>
<td width="12%" class="label"><?php echo "Sub Category";?> 
       <span style="color:#FF0000;">*</span>:</td>
<td width="38%">
<select name="subcatid_<?php echo $subcat_id; ?>" id="subcatid_<?php echo $subcat_id; ?>" onchange="subcatlisting_<?php echo $subcat_id; ?>(this.value,'<?php echo $con_catid; ?>',<?php echo $subcat_id; ?>)" >
<option value="0">Select Sub Category..</option>
<?php

while ($tdata = mysql_fetch_array($tresult)) {
?>
	<option value="<?php echo $tdata['category_cd']; ?>" <?php if ($subcat_id == $tdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $tdata['category_name']; ?></option>
<?php
}
?>
</select>
</td>
</tr>
<?php
}
}
else
{
echo "empty";
}

?>

</table>

