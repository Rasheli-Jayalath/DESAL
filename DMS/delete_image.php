<?php
require_once("config/config.php");
/*require_once("requires/Database.php");
$obj= new Database();*/
$objCommon 		= new Common;
$objMenu 		= new Menu;
$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objManageLang 	= new ManageLang;
$objProduct 	= new Product;
$objValidate 	= new Validate;
$objOrder 		= new Order;
$objLog 		= new Log;
require_once('requires/rs_lang.admin.php');
require_once('requires/rs_lang.website.php');
require_once('requires/rs_lang.eng.php');
?>
<?php
$news_cd= $_GET['news_cd'];
$image= $_GET['image'];
$name= $_GET['name'];

if((isset($news_cd)) && (isset($image)))
{
 @unlink(NEWS_PATH . $image);
 $sql_lis1="update `rs_tbl_news` set $name='' WHERE news_cd='$news_cd'";
			$res_lis1=mysql_query($sql_lis1);

}

?>

