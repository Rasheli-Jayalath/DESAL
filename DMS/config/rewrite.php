<?php
	if(MOD_REWRITE != 'false'){
		// content remove leading slash
		if(isset($_GET['content']))
			$_GET['content'] = str_replace('/', '', $_GET['content']);
		
		$site_title = '';
		
		if(isset($_GET['category']) && !empty($_GET['category'])):
			$_GET['category'] = str_replace('/', '', $_GET['category']);
			$objProductURL = new Product;
			$objProductURL->setProperty('url_key', $_GET['category']);
			$objProductURL->lstSubCategories();
			$rows_cat_url = $objProductURL->dbFetchArray(1);
			$_GET['category_cd'] = $rows_cat_url['sub_cat_id'];
			$site_title .= $rows_cat_url['category_name'];
		endif;


		if(isset($_GET['category_cd']) && !empty($_GET['category_cd'])):
			$objProductURL1 = new Product;
			$objProductURL1->setProperty('category_cd', $_GET['category_cd']);
			$objProductURL1->lstSubCategories();
			$rowscat_url = $objProductURL1->dbFetchArray(1);
			$site_title .= $rowscat_url['sub_cat_name'];
		endif;


		if(isset($_GET['subcat_id']) && !empty($_GET['subcat_id'])):
			$_GET['subcat_id'] = str_replace('/', '', $_GET['subcat_id']);
			$objProductURL = new Product;
			$objProductURL->setProperty('category_cd', $_GET['subcat_id']);
			$objProductURL->lstCategories();
			$rows_cat_url = $objProductURL->dbFetchArray(1);
            
			$_GET['subcat_id'] = $rows_cat_url['category_cd'];
			$site_title .= $rows_cat_url['category_name'];
		endif;
		
if(isset($_GET['product']) && !empty($_GET['product']))
		{
		$objProductURL = new Product;
		$objProductURL->setProperty('url_key',$_GET['product']);
		$objProductURL->lstProduct_test();
		$rows_prd_url = $objProductURL->dbFetchArray(1);
		
		if(!empty($site_title)){
			$site_title .= ' >> ';
		}
		$site_title .= $rows_prd_url['product_name'];
		}	
	
	}
	if($_GET['show'] == 'zoeken'):
		$_GET['show'] = 'products';
	endif;
	
	
	if(empty($site_title))
	{
	$objCommonN = new Common;
	$objCommonN->setProperty('config_key', 'meta_title');
	$objCommonN->lstConfig();
	$rows = $objCommonN->dbFetchArray(1);
	$site_title = $rows['config_value'];
	//$site_title = _META_TITLE;
	}
?>