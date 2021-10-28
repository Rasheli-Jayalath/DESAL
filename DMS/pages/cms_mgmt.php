<div id="wrapperPRight">
		<div id="pageContentName"><?php echo "CMS Management";?></div>
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
		<table id="tblList" width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
        <tr>
		<th style="text-align:left"><?php echo "Title";?></th>
		<th style="text-align:left"><?php echo "Detail";?></th>
        <th style="text-align:left"><?php echo "Image";?></th>
		<th >Action</th>
		</tr>
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
				<a href="./?p=cms_form&cms_cd=<?php echo $rows['cms_cd'];?>" title="Edit"><img src="images/iconedit.png" border="0" /></a></td>		</tr>
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
	  </form>
	</div>