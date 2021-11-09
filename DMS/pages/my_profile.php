<?php
 $user_cd	= $objAdminUser->user_cd;
$objAdminUser->setProperty("user_cd", $user_cd);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
$mode	= "U";
extract($data);
?>
<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 20px;"><?php echo USER_VIEW_BRD;?></h4>
<div id="wrapperPRight" class="container" style="margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">


		<div class="clear"></div>
		
		<div id="tableContainer">
			<!--<div class="formheading shadowWhite">--><?php echo $objCommon->displayMessage();?><!--</>-->
			<div class="clear"></div>			
	  	    <form id="form1" name="form1" method="post" action="">
			
	
		  <?php echo $objCommon->displayMessage();?>

		              <div class="row" >

                <div class="col-md-3">
                </div>

                    <div class="col-md-3 mobileclass" style="font-size: small;">
                      <label  class="sr-only semibold"><?php echo USER_FLD_FULLNAME;?>:</label>
                      </div>

                    <div class=" col-md-3 regular mobileclass2" style="font-size: small;">
                        <label  class="sr-only"><?php echo $first_name." ".$middle_name." ".$last_name;?></label>
                       </div>   

                       <div class="col-md-3">
                        </div>

            </div>

            <div class="row" style="margin-top: 20px;">

                <div class="col-md-3">
                </div>

                <div class="col-md-3 mobileclass" style="font-size: small;">
                  <label  class="sr-only semibold"><?php echo USER_FLD_EMAIL;?>:</label>
                  </div>

                <div class=" col-md-3 regular mobileclass2" style="font-size: small;">
                    <label  class="sr-only"><?php echo $email;?></label>
                   </div>  
                   
                   <div class="col-md-3">
                </div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-3">
            </div>

            <div class="col-md-3 mobileclass" style="font-size: small;">
              <label  class="sr-only semibold"><?php echo USER_FLD_PHONE;?>:</label>
              </div>

            <div class=" col-md-3 regular mobileclass2" style="font-size: small; ">
                <label  class="sr-only"><?php echo $phone;?></label>
               </div> 

               <div class="col-md-3">
            </div>  

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-3">
            </div>

            <div class="col-md-3 mobileclass" style="font-size: small;">
              <label  class="sr-only semibold"><?php echo USER_FLD_DESIGNATION;?>:</label>
              </div>

            <div class=" col-md-3 regular mobileclass2" style="font-size: small; ">
                <label  class="sr-only"><?php echo $designation;?></label>
               </div>   

               <div class="col-md-3">
            </div>

        </div>

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-3">
            </div>

            <div class="col-md-3 mobileclass" style="font-size: small;">
              <label  class="sr-only semibold"><?php echo "Role";?>:</label>
              </div>

            <div class=" col-md-3 regular mobileclass2" style="font-size: small; ">
                <label  class="sr-only"><?php 
			if($user_type==1) 
			echo "Super Admin";
			else
			echo "User";?></label>
               </div>   

               <div class="col-md-3">
            </div>

        </div>

       <!-- Update Button -->
        <div class="row" style="margin-top: 20px;">

            <div class="col-md-3">
            </div>

            <div class="col-md-3">
            </div>

            <div class="col-md-3 regular" style="font-size: small;text-align: left;">
                <a  class="btn btn-warning mb-2" style="font-size: 13px;" href="./?p=update_profile&user_cd=<?php echo $objAdminUser->user_cd;?>"> <?php echo USER_BTN_UPDATE;?> </a>
        
               </div>   

               <div class="col-md-3">
            </div>

        </div>
		</form>
			<div class="clear"></div>

  	    </div>

	</div>