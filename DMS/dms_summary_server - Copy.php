<?php
error_reporting(E_ALL & ~E_NOTICE);
$user_name_text=$_REQUEST['u'];
$password_text=$_REQUEST['p'];
$db = mysqli_connect('localhost', 'root', '@sj_SMEC@egc_2017', 'kfw_dms');
//require_once("config/config.php");
$authSQL = "select count(username) as username from mis_tbl_users where username = '$user_name_text' and passwd = '$password_text'";
$authResult = mysqli_query($db,$authSQL);
$authData = mysqli_fetch_array($authResult);
$authStatus = $authData['username'];
if ($authStatus > 0 ) {

$userSQL = "select user_type, user_cd from mis_tbl_users where username = '$user_name_text' and passwd = '$password_text' limit 0,1";
$userResult = mysqli_query($db,$userSQL);
$userData = mysqli_fetch_array($userResult);

$user_type=$userData['user_type'];
$user_cd	= $userData['user_cd'];  
$last_date = date("Y-m-d");
$first_date = date('Y-m-d', strtotime("-7 days"));
 
 ///project
 $totala=0;
$totalpdfa=0;
$totaldoca=0;
$totalimga=0;
$totaldwga=0;
$totalothera=0;

$total_sizea=0;
$totalpdf_sizea=0;
$totaldoc_sizea=0;
$totalimg_sizea=0;
$totaldwg_sizea=0;
$totalother_sizea=0;
 ///weekly
$total=0;
$totalpdf=0;
$totaldoc=0;
$totalimg=0;
$totaldwg=0;
$totalother=0;

$total_size=0;
$totalpdf_size=0;
$totaldoc_size=0;
$totalimg_size=0;
$totaldwg_size=0;
$totalother_size=0;
if($user_type==1)
{

	////// For All Files
	$sql2d_pa="Select count(*) as total_file_p, sum(file_size) as file_size_p from rs_tbl_documents";
$res2d_pa=mysqli_query($db,$sql2d_pa);
$row2d_pa=mysqli_fetch_array($res2d_pa);
$totala=$row2d_pa['total_file_p'];
$total_sizea=$row2d_pa['file_size_p'];	
/////pdf
$extension="'pdf' or extension='PDF'";
   
   $sql2d_pdfa="Select count(*) as total_file_pdf, sum(file_size) as file_size_pdf from rs_tbl_documents where (extension=$extension)"; 
   	$res2d_pdfa=mysqli_query($db,$sql2d_pdfa);
	$row2d_pdfa=mysqli_fetch_array($res2d_pdfa);
	$totalpdfa=$row2d_pdfa['total_file_pdf'];
	$totalpdf_sizea=$row2d_pdfa['file_size_pdf'];
/////DOC	
	 $extension="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
   $sql2d_doca="Select count(*) as total_file_doc, sum(file_size) as file_size_doc from rs_tbl_documents where (extension=$extension)"; 
   	$res2d_doca=mysqli_query($db,$sql2d_doca);
	$row2d_doca=mysqli_fetch_array($res2d_doca);
	$totaldoca=$row2d_doca['total_file_doc'];
	$totaldoc_sizea=$row2d_doca['file_size_doc'];
	
	 //////All Images Files
  $extension="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
   $sql2d_imga="Select count(*) as total_file_img, sum(file_size) as file_size_img from rs_tbl_documents where (extension=$extension)"; 
   	$res2d_imga=mysqli_query($db,$sql2d_imga);
	$row2d_imga=mysqli_fetch_array($res2d_imga);
	$totalimga=$row2d_imga['total_file_img'];
	$totalimg_sizea=$row2d_imga['file_size_img'];
	
	//////All Drawing Files
  $extension="'dwg' or extension='DWG'";
   $sql2d_dwga="Select count(*) as total_file_dwg, sum(file_size) as file_size_dwg from rs_tbl_documents where (extension=$extension)"; 
   	$res2d_dwga=mysqli_query($db,$sql2d_dwga);
	$row2d_dwga=mysqli_fetch_array($res2d_dwga);
	$totaldwga=$row2d_dwga['total_file_dwg'];
	$totaldwg_sizea=$row2d_dwga['file_size_dwg'];
	
	////Others
	$totalothera=$totala-($totalpdfa+$totaldoca+$totalimga+$totaldwga);
	$totalother_sizea=$total_sizea-($totalpdf_sizea+$totaldoc_sizea+$totalimg_sizea+$totaldwg_sizea);
	/////// For Weekly Files			
 $sql2d_p="Select count(*) as total_file_p, sum(file_size) as file_size_p from rs_tbl_documents where uploading_file_date between '$first_date' and '$last_date'";
$res2d_p=mysqli_query($db,$sql2d_p);
$row2d_p=mysqli_fetch_array($res2d_p);
$total=$row2d_p['total_file_p'];
$total_size=$row2d_p['file_size_p'];	
/////pdf
$extension="'pdf' or extension='PDF'";
   
   $sql2d_pdf="Select count(*) as total_file_pdf, sum(file_size) as file_size_pdf from rs_tbl_documents where (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_pdf=mysqli_query($db,$sql2d_pdf);
	$row2d_pdf=mysqli_fetch_array($res2d_pdf);
	$totalpdf=$row2d_pdf['total_file_pdf'];
	$totalpdf_size=$row2d_pdf['file_size_pdf'];
/////DOC	
	 $extension="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
   $sql2d_doc="Select count(*) as total_file_doc, sum(file_size) as file_size_doc from rs_tbl_documents where (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_doc=mysqli_query($db,$sql2d_doc);
	$row2d_doc=mysqli_fetch_array($res2d_doc);
	$totaldoc=$row2d_doc['total_file_doc'];
	$totaldoc_size=$row2d_doc['file_size_doc'];
	
	 //////All Images Files
  $extension="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
   $sql2d_img="Select count(*) as total_file_img, sum(file_size) as file_size_img from rs_tbl_documents where (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_img=mysqli_query($db,$sql2d_img);
	$row2d_img=mysqli_fetch_array($res2d_img);
	$totalimg=$row2d_img['total_file_img'];
	$totalimg_size=$row2d_img['file_size_img'];
	
	//////All Drawing Files
  $extension="'dwg' or extension='DWG'";
   $sql2d_dwg="Select count(*) as total_file_dwg, sum(file_size) as file_size_dwg from rs_tbl_documents where (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_dwg=mysqli_query($db,$sql2d_dwg);
	$row2d_dwg=mysqli_fetch_array($res2d_dwg);
	$totaldwg=$row2d_dwg['total_file_dwg'];
	$totaldwg_size=$row2d_dwg['file_size_dwg'];
	
	////Others
	$totalother=$total-($totalpdf+$totaldoc+$totalimg+$totaldwg);
	$totalother_size=$total_size-($totalpdf_size+$totaldoc_size+$totalimg_size+$totaldwg_size);
	
}
else
{

$sSQL_1 = "SELECT * FROM rs_tbl_category";
$my_query=mysqli_query($db,$sSQL_1);
while($my_query_r=mysqli_fetch_array($my_query))
{

$total_pa=0;
$total_pdfa=0;
$total_doca=0;
$total_imga=0;
$total_dwga=0;

$total_psizea=0;
$total_pdfsizea=0;
$total_docsizea=0;
$total_imgsizea=0;
$total_dwgsizea=0;
$total_othersizea=0;



$total_p=0;
$total_pdf=0;
$total_doc=0;
$total_img=0;
$total_dwg=0;

$total_psize=0;
$total_pdfsize=0;
$total_docsize=0;
$total_imgsize=0;
$total_dwgsize=0;
$total_othersize=0;

 $category_cd=$my_query_r['category_cd'];
	if($my_query_r['parent_cd']==0)
	{
	//// For All files
	$sql2d_pa="Select count(*) as total_file_p, sum(file_size) as file_size_p from rs_tbl_documents where report_category=$category_cd";
	$res2d_pa=mysqli_query($db,$sql2d_pa);
	$row2d_pa=mysqli_fetch_array($res2d_pa);
	$total_pa=$row2d_pa['total_file_p'];
	$total_psizea=$row2d_pa['file_size_p'];
	
	 //////All PDF files
	  $extension="'pdf' or extension='PDF'";
      $sql2d_pdfa="Select count(*) as total_file_pdf, sum(file_size) as file_size_pdf from rs_tbl_documents where report_category=$category_cd and (extension=$extension)"; 
   	$res2d_pdfa=mysqli_query($db,$sql2d_pdfa);
	$row2d_pdfa=mysqli_fetch_array($res2d_pdfa);
	 $total_pdfa=$row2d_pdfa['total_file_pdf'];
	  $total_pdfsizea=$row2d_pdfa['file_size_pdf'];
	 
	  //////All Doc Files
  $extension="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
   $sql2d_doca="Select count(*) as total_file_doc, sum(file_size) as file_size_doc from rs_tbl_documents where report_category=$category_cd and (extension=$extension)"; 
   	$res2d_doca=mysqli_query($db,$sql2d_doca);
	$row2d_doca=mysqli_fetch_array($res2d_doca);
	$total_doca=$row2d_doca['total_file_doc'];
	 $total_docsizea=$row2d_doca['file_size_doc'];
	 
	   //////All Images
	  $extension="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
   $sql2d_imga="Select count(*) as total_file_img, sum(file_size) as file_size_img from rs_tbl_documents where report_category=$category_cd and (extension=$extension)"; 
   	$res2d_imga=mysqli_query($db,$sql2d_imga);
	$row2d_imga=mysqli_fetch_array($res2d_imga);
	$total_imga=$row2d_imga['total_file_img'];
	$total_imgsizea=$row2d_imga['file_size_img'];
	
	 //////All Drawing Files
  $extension="'dwg' or extension='DWG'";
   $sql2d_dwga="Select count(*) as total_file_dwg, sum(file_size) as file_size_dwg from rs_tbl_documents where report_category=$category_cd and (extension=$extension)"; 
   	$res2d_dwga=mysqli_query($db,$sql2d_dwga);
	$row2d_dwga=mysqli_fetch_array($res2d_dwga);
	$total_dwga=$row2d_dwga['total_file_dwg'];
	$total_dwgsizea=$row2d_dwga['file_size_dwg'];
	
	
	
	////For Weekly
	$sql2d_p="Select count(*) as total_file_p, sum(file_size) as file_size_p from rs_tbl_documents where report_category=$category_cd and uploading_file_date between '$first_date' and '$last_date'";
	$res2d_p=mysqli_query($db,$sql2d_p);
	$row2d_p=mysqli_fetch_array($res2d_p);
	$total_p=$row2d_p['total_file_p'];
	$total_psize=$row2d_p['file_size_p'];
	
	 //////All PDF files
	  $extension="'pdf' or extension='PDF'";
      $sql2d_pdf="Select count(*) as total_file_pdf, sum(file_size) as file_size_pdf from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_pdf=mysqli_query($db,$sql2d_pdf);
	$row2d_pdf=mysqli_fetch_array($res2d_pdf);
	 $total_pdf=$row2d_pdf['total_file_pdf'];
	  $total_pdfsize=$row2d_pdf['file_size_pdf'];
	 
	  //////All Doc Files
  $extension="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
   $sql2d_doc="Select count(*) as total_file_doc, sum(file_size) as file_size_doc from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_doc=mysqli_query($db,$sql2d_doc);
	$row2d_doc=mysqli_fetch_array($res2d_doc);
	$total_doc=$row2d_doc['total_file_doc'];
	 $total_docsize=$row2d_doc['file_size_doc'];
	 
	   //////All Images
	  $extension="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
   $sql2d_img="Select count(*) as total_file_img, sum(file_size) as file_size_img from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_img=mysqli_query($db,$sql2d_img);
	$row2d_img=mysqli_fetch_array($res2d_img);
	$total_img=$row2d_img['total_file_img'];
	$total_imgsize=$row2d_img['file_size_img'];
	
	 //////All Drawing Files
  $extension="'dwg' or extension='DWG'";
   $sql2d_dwg="Select count(*) as total_file_dwg, sum(file_size) as file_size_dwg from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_dwg=mysqli_query($db,$sql2d_dwg);
	$row2d_dwg=mysqli_fetch_array($res2d_dwg);
	$total_dwg=$row2d_dwg['total_file_dwg'];
	$total_dwgsize=$row2d_dwg['file_size_dwg'];
	}
	else
	{
	$exp_arr=explode(",", $my_query_r['user_ids']);
	$count_exp_arr= count($exp_arr);
	$flag="";
		for($j=0; $j<$count_exp_arr; $j++)
		{
		
			if($exp_arr[$j]==$user_cd)
			{
			$flag=1;
			}
		}
		if($flag==1)
		{
		////// For All files
		$sql2d_pa="Select count(*) as total_file_p, sum(file_size) as file_size_p from rs_tbl_documents where report_category=$category_cd";
	$res2d_pa=mysqli_query($db,$sql2d_pa);
	$row2d_pa=mysqli_fetch_array($res2d_pa);
	 $total_pa=$row2d_pa['total_file_p'];
	 $total_psizea=$row2d_pa['file_size_p'];
	 
	 //////All PDF files
	  $extension="'pdf' or extension='PDF'";
      $sql2d_pdfa="Select count(*) as total_file_pdf, sum(file_size) as file_size_pdf from rs_tbl_documents where report_category=$category_cd and (extension=$extension)"; 
   	$res2d_pdfa=mysqli_query($db,$sql2d_pdfa);
	$row2d_pdfa=mysqli_fetch_array($res2d_pdfa);
	 $total_pdfa=$row2d_pdfa['total_file_pdf'];
	 $total_pdfsizea=$row2d_pdfa['file_size_pdf'];
	 
	  //////All Doc Files
  $extension="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
   $sql2d_doca="Select count(*) as total_file_doc, sum(file_size) as file_size_doc from rs_tbl_documents where report_category=$category_cd and (extension=$extension) "; 
   	$res2d_doca=mysqli_query($db,$sql2d_doca);
	$row2d_doca=mysqli_fetch_array($res2d_doca);
	$total_doca=$row2d_doca['total_file_doc'];
	 $total_docsizea=$row2d_doca['file_size_doc'];
	 
	   //////All Images
	  $extension="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
   $sql2d_imga="Select count(*) as total_file_img, sum(file_size) as file_size_img from rs_tbl_documents where report_category=$category_cd and (extension=$extension) "; 
   	$res2d_imga=mysqli_query($db,$sql2d_imga);
	$row2d_imga=mysqli_fetch_array($res2d_imga);
	$total_imga=$row2d_imga['total_file_img'];
	$total_imgsizea=$row2d_imga['file_size_img'];
	
	 //////All Drawing Files
  $extension="'dwg' or extension='DWG'";
   $sql2d_dwga="Select count(*) as total_file_dwg, sum(file_size) as file_size_dwg from rs_tbl_documents where report_category=$category_cd and (extension=$extension) "; 
   	$res2d_dwga=mysqli_query($db,$sql2d_dwga);
	$row2d_dwga=mysqli_fetch_array($res2d_dwga);
	$total_dwga=$row2d_dwga['total_file_dwg'];
	$total_dwgsizea=$row2d_dwga['file_size_dwg'];
		////For weekly Files
	$sql2d_p="Select count(*) as total_file_p, sum(file_size) as file_size_p from rs_tbl_documents where report_category=$category_cd and uploading_file_date between '$first_date' and '$last_date'";
	$res2d_p=mysqli_query($db,$sql2d_p);
	$row2d_p=mysqli_fetch_array($res2d_p);
	 $total_p=$row2d_p['total_file_p'];
	 $total_psize=$row2d_p['file_size_p'];
	 
	 //////All PDF files
	  $extension="'pdf' or extension='PDF'";
      $sql2d_pdf="Select count(*) as total_file_pdf, sum(file_size) as file_size_pdf from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_pdf=mysqli_query($db,$sql2d_pdf);
	$row2d_pdf=mysqli_fetch_array($res2d_pdf);
	 $total_pdf=$row2d_pdf['total_file_pdf'];
	 $total_pdfsize=$row2d_pdf['file_size_pdf'];
	 
	  //////All Doc Files
  $extension="'doc' or extension='DOC' or extension='DOCX' or extension='docx' or extension='txt' or extension='TXT' or extension='xls' or extension='xlsx' or extension='XLS' or extension='XLSX'";
   $sql2d_doc="Select count(*) as total_file_doc, sum(file_size) as file_size_doc from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_doc=mysqli_query($db,$sql2d_doc);
	$row2d_doc=mysqli_fetch_array($res2d_doc);
	$total_doc=$row2d_doc['total_file_doc'];
	 $total_docsize=$row2d_doc['file_size_doc'];
	 
	   //////All Images
	  $extension="'jpg' or extension='jpeg' or extension='JPG' or extension='JPEG' or extension='GIF' or extension='gif' or extension='png' or extension='PNG'";
   $sql2d_img="Select count(*) as total_file_img, sum(file_size) as file_size_img from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_img=mysqli_query($db,$sql2d_img);
	$row2d_img=mysqli_fetch_array($res2d_img);
	$total_img=$row2d_img['total_file_img'];
	$total_imgsize=$row2d_img['file_size_img'];
	
	 //////All Drawing Files
  $extension="'dwg' or extension='DWG'";
   $sql2d_dwg="Select count(*) as total_file_dwg, sum(file_size) as file_size_dwg from rs_tbl_documents where report_category=$category_cd and (extension=$extension) and (uploading_file_date between '$first_date' and '$last_date') "; 
   	$res2d_dwg=mysqli_query($db,$sql2d_dwg);
	$row2d_dwg=mysqli_fetch_array($res2d_dwg);
	$total_dwg=$row2d_dwg['total_file_dwg'];
	$total_dwgsize=$row2d_dwg['file_size_dwg'];
	
		}
	}
	
///total No of files	
$totala=$totala+$total_pa;
$totalpdfa=$totalpdfa+$total_pdfa;
$totaldoca=$totaldoca+$total_doca;
$totalimga=$totalimga+$total_imga;
$totaldwga=$totaldwga+$total_dwga;
///total files size	

$total_sizea=$total_sizea+$total_psizea;
$totalpdf_sizea=$totalpdf_sizea+$total_pdfsizea;
$totaldoc_sizea=$totaldoc_sizea+$total_docsizea;
$totalimg_sizea=$totalimg_sizea+$total_imgsizea;
$totaldwg_sizea=$totaldwg_sizea+$total_dwgsizea;
////All Others
$totalothera=$totala-($totalpdfa+$totaldoca+$totalimga+$totaldwga);
$totalother_sizea=$total_sizea-($totalpdf_sizea+$totaldoc_sizea+$totalimg_sizea+$totaldwg_sizea);	
	
	
	
	
///weekly No of files	
$total=$total+$total_p;
$totalpdf=$totalpdf+$total_pdf;
$totaldoc=$totaldoc+$total_doc;
$totalimg=$totalimg+$total_img;
$totaldwg=$totaldwg+$total_dwg;
///weekly files size	

$total_size=$total_size+$total_psize;
$totalpdf_size=$totalpdf_size+$total_pdfsize;
$totaldoc_size=$totaldoc_size+$total_docsize;
$totalimg_size=$totalimg_size+$total_imgsize;
$totaldwg_size=$totaldwg_size+$total_dwgsize;
////weekly Others
$totalother=$total-($totalpdf+$totaldoc+$totalimg+$totaldwg);
$totalother_size=$total_size-($totalpdf_size+$totaldoc_size+$totalimg_size+$totaldwg_size);
	
}
}

$week_all_nos = $total; 
$week_all_size = round($total_size/(1024*1024),0);
$week_pdf_nos = $totalpdf;
$week_pdf_size = round($totalpdf_size/(1024*1024),0);
$week_docs_nos = $totaldoc;
$week_docs_size = round($totaldoc_size/(1024*1024),0);
$week_img_nos = $totalimg;
$week_img_size = round($totalimg_size/(1024*1024),0);
$week_dwg_nos = $totaldwg;
$week_dwg_size = round($totaldwg_size/(1024*1024),0);
$week_other_nos = $totalother;
$week_other_size = round($totalother_size/(1024*1024),0);

$all_all_nos = $totala;
$all_all_size = round($total_sizea/(1024*1024),0);
$all_pdf_nos = $totalpdfa;
$all_pdf_size = round($totalpdf_sizea/(1024*1024),0);
$all_docs_nos = $totaldoca;
$all_docs_size = round($totaldoc_sizea/(1024*1024),0);
$all_img_nos = $totalimga;
$all_img_size = round($totalimg_sizea/(1024*1024),0);
$all_dwg_nos = $totaldwga;
$all_dwg_size = round($totaldwg_sizea/(1024*1024),0);
$all_other_nos = $totalothera;
$all_other_size = round($totalother_sizea/(1024*1024),0);



echo "<td style='border:1px solid #d4d4d4;text-align:right;'><a href='http://14.141.114.205/KFW/DMS/?p=weekly_search&fd=$first_date&td=$last_date' target='_blank' style='text-decoration:none'>".$week_all_nos."</a></td><td style='border:1px solid #d4d4d4;text-align:right;'>".$week_all_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'><a href='http://14.141.114.205/KFW/DMS/?p=weekly_search&fd=$first_date&td=$last_date&ext=pdf' target='_blank'  style='text-decoration:none'>".$week_pdf_nos."</a></td><td style='border:1px solid #d4d4d4;text-align:right;'>".$week_pdf_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'><a href='http://14.141.114.205/KFW/DMS/?p=weekly_search&fd=$first_date&td=$last_date&ext=doc' target='_blank' style='text-decoration:none' >".$week_docs_nos."</a></td><td style='border:1px solid #d4d4d4;text-align:right;'>".$week_docs_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'><a href='http://14.141.114.205/KFW/DMS/?p=weekly_search&fd=$first_date&td=$last_date&ext=img' target='_blank' style='text-decoration:none' >".$week_img_nos."</a></td><td style='border:1px solid #d4d4d4;text-align=left;'>".$week_img_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'><a href='http://14.141.114.205/KFW/DMS/?p=weekly_search&fd=$first_date&td=$last_date&ext=dwg' target='_blank' style='text-decoration:none' >".$week_dwg_nos."</a></td><td style='border:1px solid #d4d4d4;text-align:right;'>".$week_dwg_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'><a href='http://14.141.114.205/KFW/DMS/?p=weekly_search&fd=$first_date&td=$last_date&ext=other' target='_blank' style='text-decoration:none'>".$week_other_nos."</a></td><td style='border:1px solid #d4d4d4;text-align:right;'>".$week_other_size."</td><td style='border:1px solid #d4d4d4;text-align=left;'>".$all_all_nos."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_all_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_pdf_nos."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_pdf_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_docs_nos."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_docs_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_img_nos."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_img_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_dwg_nos."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_dwg_size."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_other_nos."</td><td style='border:1px solid #d4d4d4;text-align:right;'>".$all_other_size."</td>";
}
else{
	echo "Invalid Username or Password!!!";
}
?>