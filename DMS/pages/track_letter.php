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
    <link href="css/style.css" rel="stylesheet">


    <title>DMS</title>
</head>

<body>
  
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
  
  


 

<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 20px;">Reference Tracking</h4>
<div id="wrapperPRight" class="container" style=" margin-top: 20px; margin-bottom: 50px;  ">




<?php echo $objCommon->displayMessage();?>
         
		<div class="clear"></div>
		
<div id="advance_search" style=" margin-top: 20px; margin-bottom: 50px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">
<form name="searchfrm" id="searchfrm" action="reports_search.php"  method="post"  style=" border:1px solid #FFFFFF" >
            <div class="row">

                 
                    <div class="col-md-4 regular" style="font-size: small; text-align: right;; margin: auto;">
                      <label  class="sr-only">Reference No</label>
                      </div>

                    <div class=" col-md-4 regular" style="font-size: small; text-align: center; margin: auto; margin-top: 10px;">
                      <input type="text" class="form-control" value="" name="reference_no"  id="reference_no"  style="font-size: small;" placeholder="Reference No">
                    </div>

                    <div class=" col-md-4 regular" style="font-size: small; text-align: center; margin: auto; margin-top: 10px;">
                        <button type="button" class="btn btn-primary mb-2" onclick="ref_Search(reference_no.value)" value="Go" >Go</button>
                      </div>

        </div>
  
   </form>
</div>
</div>
<div  class="container-fluid" style=" border: none; ">

<div id="livesearch" ></div>
<div id="advsearch"></div>
</div>

	

</body>
</html>

      