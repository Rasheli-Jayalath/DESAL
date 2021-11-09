<div id="wrapperPRight">
   

<div class="container" style="margin-top: 20px; margin-bottom: 40px;">
        <div class="row">
            <div class="col-md">
				<?php $sql_cms="Select * from rs_tbl_cms where cms_cd=1";
				   $cms_data=$objDb->dbCon->query($sql_cms);
			       $sql_cms_r=$cms_data->fetch();
			    ?>
                <p class="medium" style="font-size: large;"> <?php echo $sql_cms_r['title'];?> </p>
            </div>

        </div>

        <div class="row">
            <div class="col-md">
                <p class="regular" style="font-size:small;"> <?php echo $sql_cms_r['details'];?> </p>
            </div>

        </div>

        <div class="row" style="margin-right: 1px; margin-left: 1px;">
            <div class="col-md-7" style="background-color: aliceblue; padding: 15px;">
                <p class="regular basicfontsize" style="text-align: justify;">
                    Dhaka Mass Rapid Transit Development Project (Line 5, Southern Route) is being exceuted by the Dhaka
                    Mass Transit Company Limited (DMTCL), under the Ministry of Road Transport and Bridges, and is
                    financed by the Asian Development Bank (ADB). The contract for “Consulting Services for Feasibility
                    Study, Engineering Design and Procurement Support” for the Project has been awarded to the Joint
                    Venture (JV) of Egis Rail S.A (as the Lead), Oriental Consultants Global Co., Ltd. Japan, SMEC
                    International Pty Ltd. Australia, and Egis India Consulting Engineers Pvt. Ltd.</p>

                <p class="regular basicfontsize" style=" text-align: justify;">
                    The Project has a total length of about 17.4 km between Gabtoli station and Dasherkandi station. It
                    consists of an underground section of about 12.8 km and an elevated section of about 4.6 km with 12
                    underground and 4 elevated stations. A depot accommodating rolling stocks and operational facilities
                    for Line 5 (South) is planned near the east end of the Project at Dasherkandi station area. </p>
    
            </div>

            <div class="col-md-5" style=" padding: 20px;">
                <img src="<?php echo CMS_URL; ?>/<?php echo $sql_cms_r['cmsfile'];?>" width="100%" alt="">
            </div>

        </div>


    </div>
	  
<div class="" style="margin-bottom:40px; text-decoration:none">

<span style="text-align:right;padding-right:20px;width:200px; float:right">
<?php
if($objAdminUser->user_type==1)  
{
echo "<b style=\"font-size:small;\">Number of users login:</b>";
}
else
{
echo  "<b style=\"font-size:small;\" >Number of times login:</b>";
}?>
 
<?php 
$usercd=$objAdminUser->user_cd;
if($objAdminUser->user_type==1)  
{
	$sSQL_d = "select distinct user_id as d_user_id from rs_tbl_user_log where url_capture=''";
	$user_count=$objDb->dbCon->query($sSQL_d);
			$total_num=$user_count->rowCount();
	
	?>
	<a href="users_log_detail.php" style="text-decoration:none" target="_blank"><?php echo $total_num; ?></a>
	<?php
}
else
{
	
	$sSQL_s = "select count(user_id) as no_user_ids from rs_tbl_user_log where user_id=".$usercd." and url_capture=''";
		$sSQL_q=$objDb->dbCon->query($sSQL_s);
			$sSQL_q1=$sSQL_q->fetch();
	echo $no_user_ids=$sSQL_q1['no_user_ids'];
} ?>
</span>
</div>


	</div>
