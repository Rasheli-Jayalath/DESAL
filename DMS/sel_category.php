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

$type = $_REQUEST['type'];

$pdSQL = "SELECT * FROM rs_tbl_category  where parent_cd=0 and cid=".$type;
$pdSQLResult = mysql_query($pdSQL);



?>
<td><?php echo "Region"?></td><td>
   <select name="project_region" onchange="sel_nextcat(this.value)" >
   <option value=0  ><?php echo "Select Region"; ?> </option>
   		 <?php
							  
		if(mysql_num_rows($pdSQLResult)>=1)
		{
		while($pdData = mysql_fetch_array($pdSQLResult))
		{
		$category_cd=$pdData['category_cd'];
		 ?> 
        <option value="<?php echo $category_cd;?>" ><?php echo $pdData['category_name'] ?></option>
		<?php
		}
		}?>
		
	</select>
  
  </td>
  
  