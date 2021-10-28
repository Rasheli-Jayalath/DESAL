 <script>

function ref_Search(reference_no) {

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	document.getElementById("livesearch").style.display="none"; 
	document.getElementById("advsearch").style.display="block"; 
      document.getElementById("advsearch").innerHTML=xmlhttp.responseText;
      document.getElementById("advsearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","ref_search.php?reference_no="+reference_no,true);
  xmlhttp.send();

}

</script>

   <script>
  $(function() {
    $( "#doc_issue_date" ).datepicker();
	
  });
  $(function() {
    $( "#doc_upload_datef" ).datepicker();
	
  });
   $(function() {
    $( "#doc_upload_datet" ).datepicker();
	
  });
   $(function() {
    $( "#received_date" ).datepicker();
	
  });
 
  </script>
  
  


 
<div id="wrapperPRight">

<div id="containerContent" style="min-height:80px;padding:0px">

<h2 align="center">Reference Tracking</h2>

<?php echo $objCommon->displayMessage();?>
         
		<div class="clear"></div>
		
<div id="advance_search" style="margin-bottom:20px" >
<form name="searchfrm" id="searchfrm" action="reports_search.php"  method="post"  style=" border:1px solid #FFFFFF" >
     <table width="90%"  align="center" cellpadding="1" cellspacing="1" >      
      	  
	   <tr>
         <td width="30%" class="label">Reference No.: &nbsp;</td>
         <td width="15%" ><input type="text" value="" name="reference_no"  id="reference_no" /></td>
         <td width="45%" align="left" ><input type="button" onclick="ref_Search(reference_no.value)" value="Go" /></td>
       </tr>
     </table>
   </form>
</div>



<div id="livesearch"></div>
<div id="advsearch"></div>
	
 	</div> 
	</div>

      