<?php 

  class check_active_status{
	  
	  function _checkActive($checking_value, $default_value){
		  if($checking_value == $default_value) {
			return "color: #ffc107";
		  }else{
			return "";
		  }
	
		
     }
}

?>