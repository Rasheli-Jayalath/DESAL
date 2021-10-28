<?php
if($_GET['mode'] == 'delete'){
	$objNews->setProperty('news_cd', $_GET['news_cd']);
	 $sql_ii="SELECT * FROM `rs_tbl_news` where news_cd='$_GET[news_cd]'"; 
		$sql_newi=mysql_query($sql_ii);
		$sql_resnew=mysql_fetch_array($sql_newi);
		if($sql_resnew['newsfile']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile']);
		}
		if($sql_resnew['newsfile1']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile1']);
		}
		if($sql_resnew['newsfile2']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile2']);
		}
		if($sql_resnew['newsfile3']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile3']);
		}
		if($sql_resnew['newsfile4']!="")
		{
		@unlink(NEWS_PATH . $sql_resnew['newsfile4']);
		}
	$objNews->actNews('D');
	
	$objCommon->setMessage('News deleted successfully!', 'Info');
	$activity="News deleted successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	mysql_query($sSQLlog_log);		
	redirect('./?p=news_mgmt');
}
if($_GET['mode'] == 'active')
{
$n_cd=$_GET['news_cd'];
$sqll="update rs_tbl_news set status='Y' where news_cd='$n_cd'";
mysql_query($sqll);
}
?>

<div id="wrapperPRight">
		<div id="pageContentName"><?php echo "News/Events Management";?></div>
		<?php if($_SESSION['user_type']==1)
				{
				?>
		<div id="pageContentRight">
			<div class="menu1">
				<ul>
				<li><a href="./?p=inactive_news_mgmt" class="lnkButton"><?php echo "Inactive News/Event";?>
					</a></li>
				<li><a href="./?p=news_form&amp;mode=add" class="lnkButton"><?php echo "Add News/Event";?>
					</a></li>
					</ul>
				<br style="clear:left"/>
			</div>
		</div>
		<?php
		}
		?>
		<div class="clear"></div>
			
		<?php echo $objCommon->displayMessage();?>
        
		<form name="prd_frm" id="prd_frm" method="post" action="">	
		<table  width="100%" border="0" cellspacing="1" cellpadding="5" style="padding:3px; margin:3px">
       		
 <?php
 	$objNews->setProperty("status", "Y");
	$objNews->setProperty("limit", PERPAGE);
	$objNews->setProperty("orderby", "newsdate desc");
	$objNews->lstNews();
	$Sql = $objNews->getSQL();
	if($objNews->totalRecords() >= 1){
		$sno = 1;
		while($rows = $objNews->dbFetchArray(1)){
			$bgcolor = ($bgcolor == "#FFFFFF") ? "#f1f0f0" : "#FFFFFF";
			?>
			<tr>
		<td style="padding-left:20px; padding-right:20px; padding-top:20px;">
    		<div style="width:100%">
			<div style=" background:#FEFEFE; bawidth:15%; min-height:120px; float:left"  > <?php if($rows['newsfile']!="") {?> <a href="<?php echo NEWS_URL.$rows['newsfile'] ;?>" target="_blank"><img src="<?php echo NEWS_URL.$rows['newsfile'] ;?>" border="0" width="80px" height="80px" /></a>
			
           <?php }
		   else
		   {
		   ?>
		   <img src="<?php echo "images/news.jpg" ;?>" border="0" width="80px" height="80px" />
		   <?php
		   }?></div>
			<div style="width:85%;min-height:120px; float:right" >
			<table width="100%" style=" border-spacing:10px">
			<tr>
               
                <td style=" text-align:left; color:#0033CC; font-size:14px; font-weight:bold"><?php echo $rows['title'];?></td>
				<td style="text-align:right; color:black;"> <?php echo date('d-m-Y', strtotime($rows['newsdate']));?></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" style="color:black"><?php print substr($rows['details'],0,300).'...'?></td>
                
    		</tr>
			<tr>
				<td  valign="top" style="color:black"><a href="?p=detail_news&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none">Read More</a></td>
				<?php if($_SESSION['user_type']==1)
				{
				?>
				<td style="text-align:right"><a href="./?p=news_form&mode=edit&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none"title="Edit">Edit</a> | <a onClick="return doConfirm('Are you sure to delete this news?');" href="./?p=news_mgmt&mode=delete&news_cd=<?php echo $rows['news_cd'];?>" style="text-decoration:none" title="Delete">Delete</a></td>
				<?php
				}
				else
				{
				?>
				<td>&nbsp;</td>
				<?php
				}
				?>
                
    		</tr>
			</table>
			</div>
			</div>
			</td>
			</tr>
			<tr>
			<td colspan="4" align="center">---------------------------------------------</td>
			
			</tr>
			
    		<?php
			$sno++;
		}
    }
	else{
	?>
    <tr>
    	<td colspan="6" align="center"><?php echo 'No news found.';?></td>
    </tr>
    <?php
	}
	?>
	<!--<tr>
	<td colspan="7" style="padding:0">		
	<div id="tblFooter">
	<?php
/*if($objNews->totalRecords() >= 1){
	$objPaginate = new Paginate($Sql, PERPAGE, OFFSET, "./?p=news_mgmt");
	?>
	
	<div style="float:left;width:170px;font-weight:bold"><?php $objPaginate->recordMessage();?></div>
	<div id="paging" style="float:right;text-align:right; padding-right:5px;  font-weight:bold">
	    <?php $objPaginate->showpages();?>
	</div>
<?php }*/?>
	
			
			</div>
	</td></tr>-->
		 </table>
	  </form>
	</div>

	