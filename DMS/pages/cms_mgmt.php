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
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 25PX;">CMS Management</h4>
<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;">

		<?php /*?><div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=cms_form" class="lnkButton"><?php echo "Add New Page";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div><?php */?>
		<div class="clear"></div>
		<br />
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<div class="table-responsive">
		<table id="customers" class="table" style="font-size: small;">
		<thead>
			<tr>
			<th class="semibold" style="text-align:left"><?php echo "Title";?></th>
			<th  class="semibold" style="text-align:left"><?php echo "Detail";?></th>
			<th  class="semibold" style="text-align:left"><?php echo "Image";?></th>
			<th  class="semibold" style="text-align:center">Action</th>
			</tr>
       </thead>
		<?php
	//$objAdminUser->setProperty("ORDER BY", "a.first_name");
	$objContent->setProperty("limit", PERPAGE);
	$objContent->setProperty("GROUP BY", "cms_cd");
	$objContent->lstCMS();
	$Sql = $objContent->getSQL();
	if($objContent->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objContent->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<!-- Start Your Php Code her For Display Record's -->
			<tr style="background-color:<?php echo $bgcolor;?>">
				<td><?php echo $rows['title'];?></td>
                <td><?php echo $rows['details'];?></td>
				<td><a href="<?php echo CMS_URL.$rows['cmsfile'] ;?>"  target="_blank"><img src="<?php echo CMS_URL.$rows['cmsfile'] ;?>" width="40px" height="40px" /></a></td>				
				<td align="center">
				<a href="./?p=cms_form&cms_cd=<?php echo $rows['cms_cd'];?>" title="Edit"><i class="bi bi-pencil-fill iconorange" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"></i></a></td>		</tr>
			<?php
			
		}
    }
	else{
	?>
	<tr>
	<td colspan="7">
  <div align="center" style="padding:5px 5px 5px 5px"> <?php echo "No CMS Page Found";?></div>
   </td></tr>
    <?php
	}
	?> </table>
	</div>
	  </form>
	</div>

</body>
</html>