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
?><?php 

if($objAdminUser->is_login== false){
	header("location: index.php");
}?>
<style>
.inactive
{
pointer-events: none;
opacity: 0.5;
background: #CCC;
}
.active
{
//font-weight:bold;
 
}
</style>
<?php

$s_value=$_GET['s_value'];


 ?>
 		<?php
		$sql = "SELECT * FROM rs_tbl_category order by parent_group, parent_cd";
$sqlresult = mysql_query($sql);
while ($data = mysql_fetch_array($sqlresult)) {
	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_cd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql = "select * from rs_tbl_category where category_cd = ".$cdlist[0];
	$cdsqlresult = mysql_query($cdsql);
	$cddata = mysql_fetch_array($cdsqlresult);
	$category_name = $cddata['category_name'];
	//	echo $cdlist[0];
	?>
<div id="abcd<?php echo $cdlist[$items-1];?>">
<table border="1px solid" width="100%" >





			<tr>
			
			<?php
		
	
		$cdsql = "select category_cd,category_name from rs_tbl_category where category_cd = ".$cdlist[$items-1];
		$cdsqlresult = mysql_query($cdsql);
		$cddata = mysql_fetch_array($cdsqlresult);
		$category_cd = $cddata['category_cd'];

			?>
			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parent_cd==0){	
			echo "<b>".$category_name."</b>";
			}
			else
			{
			echo $h.$cddata['category_name'];
		
			}
		  
		  
		   ?>



		
		</td>
		<?php
		$colorr="";
		
		 if($parent_cd==0){?>
		<td>&nbsp;</td>
		<?php
		}else
		{
		  $abc= $_GET["user_cd"];
		$cdsql2 = "select category_cd,parent_cd,user_ids,user_right from rs_tbl_category where category_cd = ".$cdlist[$items-1];
		$cdsqlresult2 = mysql_query($cdsql2);
		$cddata2 = mysql_fetch_array($cdsqlresult2);
		$category_cd2 = $cddata2['category_cd'];
		$parent_cdd = $cddata2['parent_cd'];
		
		$cdsqlt = "select category_cd,parent_cd,user_ids,user_right from rs_tbl_category where category_cd = ".$parent_cdd;
		$cdsqlresult = mysql_query($cdsqlt);
		$cddatat = mysql_fetch_array($cdsqlresult);
		$category_cdt = $cddatat['category_cd'];
	
		if($s_value==1  || $s_value==2 || $s_value==3)
		{
		$active="active";
		}
		else if($cddatat['parent_cd']==0)
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		 ?>
		<td width="30%">
		<div class="<?php echo $active; ?>"  >
  <input type="radio" name="status<?php echo $category_cd2;?>" value="2" <?php if($s_value=="2"){ echo "checked";} ?>  onclick="Showactive(<?php echo $category_cd2;?>,2,<?php echo $items; ?>,<?php echo $abc; ?>)"  >R
  <input type="radio" name="status<?php echo $category_cd2;?>" value="1" <?php if($s_value=="1"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,1,<?php echo $items; ?>,<?php echo $abc; ?>)">R/W
  <input type="radio" name="status<?php echo $category_cd2;?>" value="3" <?php if($s_value=="3"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,3,<?php echo $items; ?>,<?php echo $abc; ?>)">R/W/D
  <input type="radio" name="status<?php echo $category_cd2;?>" value="0"  <?php if($s_value=="0"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,0,<?php echo $items; ?>,<?php echo $abc; ?>)"> No
  </div>

		</td>
		<?php
		$flag="";
		$flag3="";
		
		}
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist);
}
			?>