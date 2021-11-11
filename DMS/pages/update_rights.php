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

<?php
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['cancel']=="Cancel"))
{
redirect('./?p=user_mgmt');
}
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['refresh']=="Refresh"))
{
 $u_id= $_GET["user_cd"];
redirect('./?p=update_rights&user_cd='.$u_id);
}

 $u_id= $_GET["user_cd"];
 $sql_name="Select first_name, last_name from mis_tbl_users where user_cd=".$u_id;
 $sql_name_q=$objDb->dbCon->query($sql_name);
 $sql_name_res= $sql_name_q->fetch() ; 
 $firstnam=$sql_name_res['first_name'];
 $lastnam=$sql_name_res['last_name'];
 $name_full=$firstnam." ".$lastnam;
$mode	= "I";
if(($_SERVER['REQUEST_METHOD'] == "POST") && ($_POST['save']=="Save"))
{
 $u_id= $_GET["user_cd"];

$sql = "SELECT * FROM rs_tbl_category order by parent_group, parent_cd";
$sqlresult = $objDb->dbCon->query($sql);
while ($data = $sqlresult->fetch() ) {

	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_cd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql = "select * from rs_tbl_category where category_cd = ".$cdlist[0];
	$cdsqlresult = $objDb->dbCon->query($cdsql);
	$cddata = $cdsqlresult->fetch() ; 
	$category_name = $cddata['category_name'];
	$cdsql3 = "select category_cd,user_ids,user_right from rs_tbl_category where category_cd = ".$cdlist[$items-1];
		$cdsqlresult3 = $objDb->dbCon->query($cdsql3);
		$cddata3 = $cdsqlresult3->fetch() ; 
		$catsid = $cddata3['category_cd'];
		
		 $status_r = trim($_POST['status'.$catsid]);
		
		if($status_r==0)
				{
				
				if (strpos($cddata3['user_ids'], $u_id) !== false) 
		   					{
								
							$arr_ids=explode(",",$cddata3['user_ids']);
						
							$len=count($arr_ids);
							
							
									if($len==1)
									{
										if($arr_ids[0]==$u_id)
										{
										$user_ii=$u_id;
										$concatids2= str_replace($user_ii,"",$cddata3['user_ids']);
										$f_flag=1;
										
										}
									
									}
									else
									{
								
										
										for($t=0; $t<$len; $t++)
											{
													if(($arr_ids[$t]==$u_id))
													{
													
													array_splice($arr_ids, $t, 1);
													$concatids2=implode(",",$arr_ids);
													$f_flag=1;
													
													}
											}
											
										}
									
									
								$arr_rite=explode(",",$cddata3['user_right']);
								
								$len_rite=count($arr_rite);
									if($len_rite==1)
									{
											if(($arr_rite[0]==$u_id."_1") || ($arr_rite[0]==$u_id."_2") || ($arr_rite[0]==$u_id."_3"))
											{
											$user_rt=$arr_rite[0];
											$concatrights2= str_replace($user_rt,"",$cddata3['user_right']);
											$ff_flag=2;
											}
									}
									else
									{
									
									for($j=0; $j<$len_rite; $j++)
											{
													if(($arr_rite[$j]==$u_id."_1") || ($arr_rite[$j]==$u_id."_2") || ($arr_rite[$j]==$u_id."_3"))
													{
													
													array_splice($arr_rite, $j, 1);
													$concatrights2=implode(",",$arr_rite);
													$ff_flag=2;
													
													}
											}
									
										
									}
							
							
							}
							if(isset($concatids2) && isset($concatrights2) && ($f_flag==1) && ($ff_flag==2))
							{
						
						$concatids=$concatids2;
						$concatrights=$concatrights2;
							}
							
							
							else
							{
							
							$concatids= $cddata3['user_ids'];
							$concatrights= $cddata3['user_right'];
							}
		
				}
				else
				{
				
					if(($cddata3['user_ids']=="") && ($cddata3['user_right']==""))
					{
					 $concatids=$u_id;
					 $concatrights=$u_id."_".$status_r;
					}
					else
					{
						 if (strpos($cddata3['user_ids'], $u_id) !== false) 
		   					{
								$arr_uid=explode(",",$cddata3['user_ids']);
									
									$len_arr_uid=count($arr_uid);
									
										for($n=0;$n<$len_arr_uid;$n++)
										{
											if($arr_uid[$n]==$u_id)
											{
											$concatids1=$cddata3['user_ids'];
											}
										}
								//$concatids=$cddata3['user_ids'];
								//$concatrights=$cddata3['user_right'];
									$arr_status1=explode(",",$cddata3['user_right']);
									
									$len_arr1=count($arr_status1);
									//$abcc="";
									for($m=0;$m<$len_arr1;$m++)
									{
									$arr_status2=explode("_",$arr_status1[$m]);
										if($arr_status2[0]==$u_id)
										{
										
											$status=$arr_status2[1];
											if($status==$status_r)
											{
											
											$concatrights1=$cddata3['user_right'];
											}
											else
											{
											
											$abcc=$arr_status2[0]."_".$status_r;
											 $concatrights1= str_replace($arr_status1[$m],$abcc,$cddata3['user_right']);
											}
											
										 }
										 else
										 {
										 }
										
									}
								}
							
							if($concatids1!="" && $concatrights1!="")
							{
							$concatids=$concatids1;
							$concatrights=$concatrights1;
							}
								
								
							else
							{
								
							$concatids=$cddata3['user_ids'].",".$u_id;
							$concatrights=$cddata3['user_right'].",".$u_id."_".$status_r;
							} 
					}
				}
				
				$sqlu="UPDATE rs_tbl_category set user_ids='$concatids',user_right='$concatrights' where category_cd=$catsid"; 
				$sql_run=$objDb->dbCon->query($sqlu);
				$concatids="";
				$concatrights="";
				$concatids1="";
				$concatrights1="";
				$concatids2="";
				$concatrights2="";
				$f_flag="";
				$ff_flag="";
				
				
	}
	$activity="User rights updated successfully";
	$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
	$objDb->dbCon->query($sSQLlog_log);		
	redirect('./?p=user_mgmt');

}

?>
<style>
.inactive
{
pointer-events: none;
opacity: 0.5;
background: #CCC;
}
</style>

<script language="javascript" type="text/javascript">
function frmValidate(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;
	if(frm.first_name.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_FIRSTNAME;?>";
		flag = false;
	}

	if(frm.email.value == ""){
		msg = msg + "\r\n<?php echo USER_FLD_MSG_EMAIL;?>";
		flag = false;
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>

<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		return xmlhttp;
    }
	
function Showactive(cd,s_value,space,user_id) {
var category_cd=cd;
var status_value=s_value;

		<?php
		
		$sql = "SELECT * FROM rs_tbl_category";
$sqlresult = $objDb->dbCon->query($sql);
while ($data = $sqlresult->fetch()  ) {
	$category_cdd = $data['category_cd'];
		?>
	if(category_cd==<?php echo $category_cdd ?>)
	{
	
	<?php
	$sql2 = "SELECT * FROM rs_tbl_category where parent_cd=$category_cdd";
$sqlresult2 = $objDb->dbCon->query($sql2);
while ($data1 =  $sqlresult2->fetch()) {
	$category_cd_main = $data1['category_cd'];
	//$category_cd_main1=strlen($category_cd_main);
	if(strlen($category_cd_main)==1)
	{
	$category_cd_main1="00".$category_cd_main;
	}
	else if(strlen($category_cd_main)==2)
	{
	$category_cd_main1="0".$category_cd_main;
	}
	else
	{
	$category_cd_main1=$category_cd_main;
	}

	?>

		var strURL="active_cats.php?cat_cd="+<?php echo $category_cd_main; ?>+"&main_cat_s_value="+status_value+"&indent_space="+space+"&user_cd="+user_id;
		
		var req<?php echo $category_cd_main; ?> = getXMLHTTP();
						
						if (req<?php echo $category_cd_main; ?>) {
							//alert("if");
							
							req<?php echo $category_cd_main; ?>.onreadystatechange = function() {
								if (req<?php echo $category_cd_main; ?>.readyState == 4) {
									// only if "OK"
									if (req<?php echo $category_cd_main; ?>.status == 200) {
										
									   document.getElementById('abcd'+"<?php echo $category_cd_main1; ?>").innerHTML=req<?php echo $category_cd_main; ?>.responseText;
															
									} else {
										alert("There was a problem while using XMLHTTP:7\n" + req<?php echo $category_cd_main; ?>.statusText);
									}
								}				
							}			
							req<?php echo $category_cd_main; ?>.open("GET", strURL, true);
							req<?php echo $category_cd_main; ?>.send(null);
						}
						
						
						
						<?php
						$sql3 = "SELECT * FROM rs_tbl_category where parent_cd=$category_cd_main";
$sqlresult3 = $objDb->dbCon->query($sql3);
$t_rows= $sqlresult3->rowCount();
if($t_rows>=1)
{
$data6 =  $sqlresult3->fetch();
$path6 = $data6['parent_group'];
$cdlist6 = explode("_",$path6);
	$items6 = count($cdlist6)-1;
?>
Showactive(<?php echo $category_cd_main; ?>,0,<?php echo $items6; ?>,user_id);
<?php
}

						}
						?>
						}
		<?php
		}
		?>
		
		}
		
		
		
function Showactiveall(s_value,userid) {
var status_value=s_value;
var strURL="all_read.php?s_value="+status_value+"&user_cd="+userid;
var req= getXMLHTTP();
			
			if (req) {
				//alert("if");
				
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						// only if "OK"
						if (req.status == 200) {						
							document.getElementById("all").innerHTML=req.responseText;	
												
						} else {
							alert("There was a problem while using XMLHTTP:7\n" + req.statusText);
						}
					}				
				}			
				req.open("GET", strURL, true);
				req.send(null);
			}

}
	
		</script>

	<h4 class="semibold"  style="text-align: center; margin: auto; margin-bottom: 20px; margin-top: 25PX;">
			<?php echo ($mode == "U") ? "Manage Rights &raquo; ".$name_full : "Manage Rights &raquo; ".$name_full?>
	</h4>
<div id="wrapperPRight" class="container" style=" margin-bottom: 100px;  border-radius: 15px; border: 2px solid #dfdfdf;padding: 20px; ">

		
  <div class="row">
    <div class="col pt-2">
	<?php echo _NOTE;?>
    </div>
    <div class="col">
    <p style="text-align:right;  font-weight:bold"><a href="./?p=user_mgmt" class="btn btn-primary" style="text-decoration: none;"> 
			 <i class="bi bi-chevron-double-left"></i> Back </a>	</p>
    </div>
 
  </div>

	
	<?php echo $objCommon->displayMessage();?>
		
		<div id="tableContainer"  class="table-responsive commontextsize">
		 <form name="form1" method="post" action="">
		<table width="100%" id="customers" class="table">
		<thead>
		 <tr>
<th width="70%" align="right" style="font-weight:bold; font-size:12px">All rights will enable in one click</th>

		<div class="<?php echo $active; ?>"  >
		<th  width="6%" style="border-style: none; margin:0; padding:0; padding-left:10px; padding-bottom:5px"> 
  <input type="radio" class="form-check-input mt-1 px-2 py-2" style="margin-right: 5px; " name="status_all" value="2" onclick="Showactiveall(2,<?php echo $u_id; ?>)"  >
  <label class="form-check-label text-warning  semibold px-1 py-1 " style=" "> R  </label> 
</th>
<th  width="8%" style="border-style: none; margin:0; padding:0; padding-left:10px; padding-bottom:5px">
  <input type="radio" class="form-check-input mt-1 px-2 py-2" style="margin-right: 5px; " name="status_all" value="1" onclick="Showactiveall(1,<?php echo $u_id; ?>)">
  <label class="form-check-label text-warning  semibold px-1 py-1 " style=" "> R / W </label>
  </th>
<th  width="9%" style="border-style: none; margin:0; padding:0; padding-left:10px; padding-bottom:5px"> 
  <input type="radio" class="form-check-input mt-1 px-2 py-2" style="margin-right: 5px; " name="status_all" value="3" onclick="Showactiveall(3,<?php echo $u_id; ?>)">
  <label class="form-check-label text-warning  semibold px-1 py-1 " style=" "> R / W / D </label>
  </th>
<th  width="8%" style="border-style: none; margin:0; padding:0; padding-left:10px; padding-bottom:5px">
  <input type="radio" class="form-check-input mt-1 px-2 py-2" style="margin-right: 5px; " name="status_all" value="0" onclick="Showactiveall(0,<?php echo $u_id; ?>)"> 
  <label class="form-check-label text-warning  semibold px-1 py-1 " style=" "> No</label>
  </th>

  </div>

	
		</tr>
</thead>
		</table>
		<div id="all">
		<?php
		$sql = "SELECT * FROM rs_tbl_category order by parent_group, parent_cd";
$sqlresult = $objDb->dbCon->query($sql);
while ($data =  $sqlresult->fetch()) {
	$cdlist = array();
	$items = 0;
	$path = $data['parent_group'];
	$parent_cd = $data['parent_cd'];
	$cdlist = explode("_",$path);
	$items = count($cdlist);
	$cdsql = "select * from rs_tbl_category where category_cd = ".$cdlist[0];
	$cdsqlresult = $objDb->dbCon->query($cdsql);
	$cddata = $cdsqlresult->fetch();
	$category_name = $cddata['category_name'];
	//	echo $cdlist[0];
	?>
	
<div id="abcd<?php echo $cdlist[$items-1];?>"  class="table-responsive commontextsize" >
<table  width="100%" id="customers" class="table">





			<tr>
			
			<?php
		
	
		$cdsql = "select category_cd,category_name from rs_tbl_category where category_cd = ".$cdlist[$items-1];
		$cdsqlresult = $objDb->dbCon->query($cdsql);
		$cddata =  $cdsqlresult->fetch();
		$category_cd = $cddata['category_cd'];

			?>
			
			<?php
			$space=$items;
			$h="";
			for($j=1; $j<$space; $j++)
			{
			$k="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$h=$h.$k;
			
			if($j==$space-1)
				{
					if($j==1)
					{
					//red
					
					$colorr="#FFF9F9";
					}
					elseif($j==2)
					{
					
					//green
					$colorr="#E1FFE1";
					}
					elseif($j==3)
					{
					
					//blue
					$colorr="#E9E9F3";
					} 
					elseif($j==4)
					{
					
					//yellow
					$colorr="#FFFFC6";
					} 
					elseif($j==5)
					{
					
					//brown
					$colorr="#F0E1E1";
					}
					
				}  
			}
			
			
			?>
			<td width="70%" style=" color: #000000; background-color: <?php echo $colorr; ?>">
			<?php
			if($parent_cd==0){	
			echo "<b>".$category_name."</b>";
			}
			else
			{
			echo $h.$cddata['category_name'];
		
			}
		  
		  
		   ?>



		
		</td>
		<?php
		$colorr="";
		
		 if($parent_cd==0){?>
		<td>&nbsp;</td>
		<?php
		}else
		{
		  $abc= $_GET["user_cd"];
		$cdsql2 = "select category_cd,parent_cd,user_ids,user_right from rs_tbl_category where category_cd = ".$cdlist[$items-1];
		$cdsqlresult2 = $objDb->dbCon->query($cdsql2);
		$cddata2 = $cdsqlresult2->fetch();
		$category_cd2 = $cddata2['category_cd'];
		$parent_cdd = $cddata2['parent_cd'];
		
		$cdsqlt = "select category_cd,parent_cd,user_ids,user_right from rs_tbl_category where category_cd = ".$parent_cdd;
		$cdsqlresult = $objDb->dbCon->query($cdsqlt);
		$cddatat = $cdsqlresult->fetch();
		$category_cdt = $cddatat['category_cd'];
		
		
		
		if ((strpos($cddatat['user_right'], $abc."_1") !== false) || (strpos($cddatat['user_right'], $abc."_2") !== false) || (strpos($cddatat['user_right'], $abc."_3") !== false))
		{
				$arr_ritu=explode(",",$cddatat['user_right']);
				$len_ritu=count($arr_ritu);
				for($r=0; $r<$len_ritu; $r++)
					{
						if(($arr_ritu[$r]==$abc."_1")||($arr_ritu[$r]==$abc."_2")||($arr_ritu[$r]==$abc."_3"))
								{
									//$active="active";
									$flag3="active";
									
								}
					}
		}	
		
		if($flag3=="active")
		{
		$active="active";
		}
		else if($cddatat['parent_cd']==0)
		{
		$active="active";
		}
		else
		{
		$active="inactive";
		}
		
		
		if ((strpos($cddata2['user_right'], $abc."_1") !== false) || (strpos($cddata2['user_right'], ",". $abc."_1")!== false))
		  {
		  $arr_rst=explode(",",$cddata2['user_right']);
		 $len_rst2=count($arr_rst);
		 for($ri=0; $ri<$len_rst2; $ri++)
		{
			if($arr_rst[$ri]==$abc."_1")
					{
					$flag=1;
					//echo	$user_rit="1";
					}
		
		}
		 
		  
		  }
		  if ((strpos($cddata2['user_right'], $abc."_2") !== false) || (strpos($cddata2['user_right'], ",". $abc."_2")!== false))
		  {
		  
		 $arr_rst1=explode(",",$cddata2['user_right']);
		 $len_rst21=count($arr_rst1);
					 for($ri1=0; $ri1<$len_rst21; $ri1++)
					{ 
									if($arr_rst1[$ri1]==$abc."_2")
											{	
											$flag=2;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		   if ((strpos($cddata2['user_right'], $abc."_3") !== false) || (strpos($cddata2['user_right'], ",". $abc."_3")!== false))
		  {
		  
		 $arr_rst11=explode(",",$cddata2['user_right']);
		 $len_rst211=count($arr_rst11);
					 for($ri11=0; $ri11<$len_rst211; $ri11++)
					{ 
									if($arr_rst11[$ri11]==$abc."_3")
											{	
											$flag=3;				
												//echo $user_rit="2";
												
											}
			
					}
		 
		  }
		  if($flag==1)
		{
			$user_rit="1";
		}
		else if($flag==2)
		{
			$user_rit="2";
		}
		else if($flag==3)
		{
			$user_rit="3";
		}
		  else
		  {
		 
	       $user_rit="0";
		  }
		
		 ?>
		
		<div class="<?php echo $active; ?>"  >
		<td width="6%" style="border-style: none;  margin:0; padding:0; padding-left:10px" >
  <input type="radio" class="form-check-input" style="margin-right: 5px; " name="status<?php echo $category_cd2;?>" value="2" <?php if($user_rit=="2"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,2,<?php echo $items; ?>,<?php echo $abc; ?>)"  >
   <label class="form-check-label text-dark  semibold  px-2 " style="font-size:small; "> R  </label> &emsp; &emsp; 
		</td>
	   	<td width="8%"  style="border-style: none;  margin:0; padding:0; padding-left:10px">
   <input type="radio" class="form-check-input" style="margin-right: 5px; " name="status<?php echo $category_cd2;?>" value="1" <?php if($user_rit=="1"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,1,<?php echo $items; ?>,<?php echo $abc; ?>)" >
  <label class="form-check-label text-dark  semibold  px-2 " style="font-size:small; "> R / W </label> &emsp; &emsp; 
  </td>
	   	<td width="9%" style="border-style: none;  margin:0; padding:0; padding-left:10px">
  <input type="radio" class="form-check-input" style="margin-right: 5px; " name="status<?php echo $category_cd2;?>" value="3" <?php if($user_rit=="3"){ echo "checked";} ?>  onclick="Showactive(<?php echo $category_cd2;?>,3,<?php echo $items; ?>,<?php echo $abc; ?>)" >
  <label class="form-check-label text-dark  semibold px-2 " style="font-size:small; ">  R / W / D   </label> &emsp; &emsp; 
  </td>
	   	<td width="8%" style="border-style: none;  margin:0; padding:0; padding-left:10px">
  <input type="radio" class="form-check-input" style="margin-right: 5px; " name="status<?php echo $category_cd2;?>" value="0"  <?php if($user_rit=="0"){ echo "checked";} ?> onclick="Showactive(<?php echo $category_cd2;?>,0,<?php echo $items; ?>,<?php echo $abc; ?>)">
    <label class="form-check-label text-dark  semibold  px-2 " style="font-size:small; "> No  </label> &emsp; &emsp; 
	</td>


	   	
</div>

	
		<?php
		$flag="";
		$flag3="";
		
		}
		?>
</tr>
</table>
</div>
<?php
	unset($cdlist);
}
			?>
			</div>
			<div class="d-flex justify-content-center" style="margin:auto; ">
				<button type="submit" class="btn btn-success mx-2" name="save"    value="Save" >   <i class="bi bi-arrow-bar-up"    style="margin-right: 10px;"></i>Save     </button>
				<button type="submit" class="btn btn-danger mx-2"  name="cancel"  value="Cancel" > <i class="bi bi-x-circle"        style="margin-right: 10px;"></i>Cancel   </button>
				<button type="submit" class="btn btn-info mx-2"    name="refresh" value="Refresh" ><i class="bi bi-arrow-clockwise" style="margin-right: 10px;"></i>Refresh  </button>
			</div>
			</form>
  	    </div>
	</div>




</body>

</html>