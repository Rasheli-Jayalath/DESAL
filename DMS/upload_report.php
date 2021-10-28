<?php 
require_once("config/config.php");
$objDb		= new Database;
$objCommon 		= new Common;
$objMenu 		= new Menu;
//$objNews 		= new News;
$objContent 	= new Content;
$objTemplate 	= new Template;
$objMail 		= new Mail;
$objCustomer 	= new Customer;
//$objCart 	= new Cart;
$objAdminUser 	= new AdminUser;
$objProduct 	= new Product;
$objValidate 	= new Validate;
//$objOrder 		= new Order;
$objLog 		= new Log;
require_once('rs_lang.admin.php');
require_once('rs_lang.website.php');
require_once('rs_lang.eng.php');
?><?php 

if($objAdminUser->is_login== false){
	header("location: index.php");
}?>
<?php include ('includes/saveurl.php');?>
<?php
 $user_cd	= $objAdminUser->user_cd;
 
 $objAdminUser->setProperty("user_cd", $user_cd);
$objAdminUser->lstAdminUser();
$data = $objAdminUser->dbFetchArray(1);
 $user_type= $data['user_type'];
 
$report_path = REPORT_PATH;
$report_id = $_REQUEST['report_id'];
$category_cd = $_REQUEST['category_cd'];
$cquery11 = "select * from rs_tbl_documents WHERE report_id = '$report_id'";
$cresult11=$objDb->dbCon->query($cquery11);
$cdata11=$cresult11->fetch();
if($report_id!="")
{
$cat_idm = $cdata11['report_category'];
}
else
{
$cat_idm = $_REQUEST['category_cd'];
}
$subcatid = $cdata11['report_subcategory'];
$uaccess1 = $cdata11['user_access'];
$user_ids1 = $cdata11['user_ids'];
$user_rs1 = $cdata11['user_right'];

/*echo $unserializedoptions = unserialize($uaccess1);*/

if(isset($_GET['mode']) && $_GET['mode'] == "Delete"){
	$report_id = $_GET['report_id'];

		$objProduct->resetProperty();
		$objProduct->setProperty("report_id", $report_id);
		$objProduct->actReport("D");
		$objCommon->setMessage("Document deleted Successfully", 'Info');
		redirect('./?p=upload_report');
	
	
}
if(isset($_GET['report_id']) && !empty($_GET['report_id'])&&$_GET['mode']=="DoDelete"&&$_REQUEST['file_report']!="")
{
$objProdctD1 = new Product;
$report_id = $_GET['report_id'];
$file_report=$_REQUEST['file_report'];
if($file_report!=""){
					@unlink(REPORT_PATH . $file_report);
						
					}
					$file_report="";
$objProdctD1->setProperty("report_id",$report_id);
$objProdctD1->setProperty("report_file",$file_report);
$objProdctD1->actReport("U");
 $objProdctD1->getSQL();
 $objCommon->setMessage('File Removed Successfully.', 'Info');
		$activity="File has been removed";
		$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
		$objDb->dbCon->query($sSQLlog_log);
redirect('upload_report.php?report_id='.$report_id);
}
$mode	= "I";
//$size=500;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST["report_add"])){
	
			
			
			$created_by	= $objAdminUser->fullname_name;
			 $userid_owner	= $objAdminUser->user_cd;
			 date_default_timezone_set("Asia/Calcutta");
			 $timee= date("H:i:s");
			 $cdate=date('Y-m-d');
			 $datt=$cdate." ".$timee;
			 $doc_creat_by=$created_by." ".$datt;
			$file_uploading_date_for_size=date('Y-m-d');
			$report_id = trim($_REQUEST['report_id']);
			$mode = trim($_POST['mode']);
			$cat_id = $cat_idm;
			$subcatidm = trim($_POST['subcatidm']);
			//$subcatid = trim($_POST['subcatid']);
			$cat_title = mysql_real_escape_string(trim($_POST['report_title']));
			$comment = trim($_POST['report_status']);
			$period = trim($_POST['period']);
			$revision = trim($_POST['revision']);
			$document_no = trim($_POST['document_no']);
			$reference_no = trim($_POST['reference_no']);
			$rep_reference_no = trim($_POST['rep_reference_no']);
			$received_date = trim($_POST['received_date']);
			$file_from = trim($_POST['file_from']);
			$file_to = trim($_POST['file_to']);
			$file_no = trim($_POST['file_no']);
			$remarks = trim($_POST['remarks']);
			$file_category = trim($_POST['file_category']);
			$drawing_series = trim($_POST['drawing_series']);
			//echo $_POST['doc_upload_date'];
			
			if($mode=="U")
			{
			$subcatide= trim($_POST['subcatide']);
			$subcatid=$subcatide;
			}
			else
			{
			
			if($subcatidm=="")
			{
			$subcatid="";
			}
			else
			{
				$subcat_array=explode("_",$subcatidm);
				$lengg=count($subcat_array);
				$category_cdp="";
				for($i=0;$i<$lengg; $i++)
				{
				 $parent_cdd=$subcat_array[$i];
				$cqueryp = "select * from  rs_tbl_category where parent_cd='$parent_cdd'";
				$cresultp=$objDb->dbCon->query($cqueryp);
				$cresultp1=$cresultp->fetch();	
				$category_cdpt=$cresultp1['category_cd'];
				$add_u="_";
				if($i==$lengg-1)
				{
				$category_cdp=$category_cdp.$category_cdpt;
				}
				else
				{
				$category_cdp=$category_cdp.$category_cdpt.$add_u;
				}
				
				}
			$subcatid=$category_cdp;
			}
			}
			if($_POST['doc_issue_date']=="" ||  $_POST['doc_issue_date']==NULL ||  $_POST['doc_issue_date']=="0000-00-00" ||  $_POST['doc_issue_date']=="1970-01-01")
			{
			$doc_issue_date="";
		
			}
			else
			{
			$doc_issue_date = date('Y-m-d',strtotime($_POST['doc_issue_date']));
		
			}
			if($_POST['doc_closing_date']=="" ||  $_POST['doc_closing_date']==NULL ||  $_POST['doc_closing_date']=="0000-00-00" ||  $_POST['doc_closing_date']=="1970-01-01")
			{
			$doc_closing_date="";
			}
			else
			{
			$doc_closing_date = date('Y-m-d',strtotime($_POST['doc_closing_date']));
			
			}
			if($_POST['doc_upload_date']=="" ||  $_POST['doc_upload_date']==NULL ||  $_POST['doc_upload_date']=="0000-00-00" ||  $_POST['doc_upload_date']=="1970-01-01")
			{
			$doc_upload_date="";
			}
			else
			{
			$doc_upload_date = date('Y-m-d',strtotime($_POST['doc_upload_date']));
			
			}
			if($_POST['received_date']=="" ||  $_POST['received_date']==NULL ||  $_POST['received_date']=="0000-00-00" ||  $_POST['received_date']=="1970-01-01")
			{
			$received_date="";
			}
			else
			{
			$received_date = date('Y-m-d',strtotime($_POST['received_date']));
			
			}
		
		//	$doc_upload_date=date('Y-m-d');
			$report_file=$_FILES['report_file'];
			$old_report_file=trim($_POST['old_report_file']);

 

			//$max_size=($size * 1024 * 1024);
	
	$objValidate->setArray($_POST);
	/*$objValidate->setCheckField("report_category", PRD_FLD_MSG_CATNAME, "S");*/
	$vResult = $objValidate->doValidate();
	
	if(!$vResult){
	 
	if(isset($_GET['report_id'])){
	
		$report_id = ($_POST['mode'] == "U") ? $_POST['report_id'] : $objAdminUser->genCode("rs_tbl_documents", "report_id");
		$objProdctC1 = new Product;
		$objProdctC1->setProperty("report_id", $report_id);
		$objProdctC1->setProperty("report_category", $cat_id);
		$objProdctC1->setProperty("report_subcategory", $subcatid);
		if($_POST['mode']=="U")
			{
		$objProdctC1->setProperty("report_title", stripslashes($cat_title));
		}
		else
		{
		$objProdctC1->setProperty("report_title", $cat_title);
		}
		$objProdctC1->setProperty("report_status", $comment);
		$objProdctC1->setProperty("period", $period);
		$objProdctC1->setProperty("revision", $revision);
		$objProdctC1->setProperty("document_no", $document_no);
		
		$objProdctC1->setProperty("reference_no", $reference_no);
		$objProdctC1->setProperty("rep_reference_no", $rep_reference_no);
		$objProdctC1->setProperty("received_date", $received_date);
		$objProdctC1->setProperty("file_from", $file_from);
		$objProdctC1->setProperty("file_to", $file_to);
		$objProdctC1->setProperty("file_no", $file_no);
		$objProdctC1->setProperty("remarks", $remarks);
		$objProdctC1->setProperty("file_category", $file_category);
		$objProdctC1->setProperty("drawing_series", $drawing_series);
		
		$objProdctC1->setProperty("doc_issue_date", $doc_issue_date);
		$objProdctC1->setProperty("doc_closing_date", $doc_closing_date);
		$objProdctC1->setProperty("doc_upload_date", $doc_upload_date);	
		if($_POST['mode']=="U")
			{
			$objProdctC1->setProperty("doc_last_modified_by", $created_by." ".$datt);
			}
			else
			{
			$last_modified_by="";
			$objProdctC1->setProperty("doc_last_modified_by", $last_modified_by);
			$objProdctC1->setProperty("doc_creater", $created_by." ".$datt);
			$objProdctC1->setProperty("doc_creater_id", $userid_owner);
			}
		
		
		
			if(isset($_FILES["report_file"]["name"]) && ($_FILES["report_file"]["name"]!=""))
		{
		
		 $name_file=$_FILES["report_file"]["name"];
		$name_file_type=$_FILES["report_file"]["type"];
		$ext = pathinfo($name_file, PATHINFO_EXTENSION);
		$name_arr=explode(".",$name_file);
		$name_file1= preg_replace("/[^a-zA-Z0-9.]/", "", $name_arr[0]);
		import("Image");
		$objImage = new Image($report_path);
		$objImage->setImage($report_file);
		if(($_FILES["report_file"]["type"] == "application/pdf")|| ($_FILES["report_file"]["type"] == "application/msword") || 
		($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")||
		($_FILES["report_file"]["type"] == "application/vnd.ms-excel") ||	
		($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")||	
		($_FILES["report_file"]["type"] == "text/plain") || 
		($_FILES["report_file"]["type"] == "image/jpg")|| 
		($_FILES["report_file"]["type"] == "image/jpeg")|| 
		($_FILES["report_file"]["type"] == "image/gif") || 
		($_FILES["report_file"]["type"] == "image/png")||
		($_FILES["report_file"]["type"] == "application/dwg")|| 
		($_FILES["report_file"]["type"] == "image/vnd.dwg")||		
		($_FILES["report_file"]["type"] == "application/acad") ||
		($_FILES["report_file"]["type"] == "application/dxf") ||
		($_FILES["report_file"]["type"] == "application/rar") ||
		($_FILES["report_file"]["type"] == "application/x-dwf") ||
		($_FILES["report_file"]["type"] == "application/vnd.zzazz.deck+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.handheld-entertainment+xml")
|| ($_FILES["report_file"]["type"] == "application/zip")
|| ($_FILES["report_file"]["type"] == "application/vnd.zul")
|| ($_FILES["report_file"]["type"] == "application/yin+xml")
|| ($_FILES["report_file"]["type"] == "application/yang")
|| ($_FILES["report_file"]["type"] == "text/yaml")
|| ($_FILES["report_file"]["type"] == "chemical/x-xyz")
|| ($_FILES["report_file"]["type"] == "application/vnd.mozilla.xul+xml")
|| ($_FILES["report_file"]["type"] == "application/xspf+xml")
|| ($_FILES["report_file"]["type"] == "application/x-xpinstall")
|| ($_FILES["report_file"]["type"] == "application/xop+xml")
|| ($_FILES["report_file"]["type"] == "application/xslt+xml")
|| ($_FILES["report_file"]["type"] == "application/resource-lists-diff+xml")
|| ($_FILES["report_file"]["type"] == "application/resource-lists+xml")
|| ($_FILES["report_file"]["type"] == "application/rls-services+xml")
|| ($_FILES["report_file"]["type"] == "application/patch-ops-error+xml")
|| ($_FILES["report_file"]["type"] == "application/xenc+xml")
|| ($_FILES["report_file"]["type"] == "application/xcap-diff+xml")
|| ($_FILES["report_file"]["type"] == "application/xml")
|| ($_FILES["report_file"]["type"] == "application/xhtml+xml")
|| ($_FILES["report_file"]["type"] == "application/x-xfig")
|| ($_FILES["report_file"]["type"] == "application/x-x509-ca-cert")
|| ($_FILES["report_file"]["type"] == "image/x-xwindowdump")
|| ($_FILES["report_file"]["type"] == "image/x-xpixmap")
|| ($_FILES["report_file"]["type"] == "image/x-xbitmap")
|| ($_FILES["report_file"]["type"] == "application/wsdl+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.wt.stf")
|| ($_FILES["report_file"]["type"] == "application/vnd.wordperfect")
|| ($_FILES["report_file"]["type"] == "application/vnd.wap.wmlscriptc")
|| ($_FILES["report_file"]["type"] == "text/vnd.wap.wmlscript")
|| ($_FILES["report_file"]["type"] == "text/vnd.wap.wml")
|| ($_FILES["report_file"]["type"] == "application/winhlp")
|| ($_FILES["report_file"]["type"] == "application/widget")
|| ($_FILES["report_file"]["type"] == "application/vnd.webturbo")
|| ($_FILES["report_file"]["type"] == "image/webp")
|| ($_FILES["report_file"]["type"] == "application/wspolicy+xml")
|| ($_FILES["report_file"]["type"] == "application/x-font-woff")
|| ($_FILES["report_file"]["type"] == "application/davmount+xml")
|| ($_FILES["report_file"]["type"] == "audio/x-wav")
|| ($_FILES["report_file"]["type"] == "image/vnd.wap.wbmp")
|| ($_FILES["report_file"]["type"] == "application/vnd.wap.wbxml")
|| ($_FILES["report_file"]["type"] == "application/x-wais-source")
|| ($_FILES["report_file"]["type"] == "application/voicexml+xml")
|| ($_FILES["report_file"]["type"] == "application/ccxml+xml,")
|| ($_FILES["report_file"]["type"] == "video/vnd.vivo")
|| ($_FILES["report_file"]["type"] == "application/vnd.visionary")
|| ($_FILES["report_file"]["type"] == "model/vnd.vtu")
|| ($_FILES["report_file"]["type"] == "model/vnd.mts")
|| ($_FILES["report_file"]["type"] == "application/vnd.vcx")
|| ($_FILES["report_file"]["type"] == "model/vrml")
|| ($_FILES["report_file"]["type"] == "application/vnd.vsf")
|| ($_FILES["report_file"]["type"] == "application/x-cdlink")
|| ($_FILES["report_file"]["type"] == "text/x-vcard")
|| ($_FILES["report_file"]["type"] == "text/x-vcalendar")
|| ($_FILES["report_file"]["type"] == "text/x-uuencode")
|| ($_FILES["report_file"]["type"] == "application/x-ustar")
|| ($_FILES["report_file"]["type"] == "application/vnd.uiq.theme")
|| ($_FILES["report_file"]["type"] == "text/uri-list")
|| ($_FILES["report_file"]["type"] == "application/vnd.ufdl")
|| ($_FILES["report_file"]["type"] == "application/vnd.unity")
|| ($_FILES["report_file"]["type"] == "application/vnd.uoml+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.umajin")
|| ($_FILES["report_file"]["type"] == "text/turtle")
|| ($_FILES["report_file"]["type"] == "application/x-font-ttf")
|| ($_FILES["report_file"]["type"] == "application/vnd.trueapp")
|| ($_FILES["report_file"]["type"] == "text/troff")
|| ($_FILES["report_file"]["type"] == "application/vnd.triscape.mxs")
|| ($_FILES["report_file"]["type"] == "application/vnd.trid.tpt")
|| ($_FILES["report_file"]["type"] == "application/timestamped-data")
|| ($_FILES["report_file"]["type"] == "application/vnd.spotfire.dxp")
|| ($_FILES["report_file"]["type"] == "application/vnd.spotfire.sfs")
|| ($_FILES["report_file"]["type"] == "application/tei+xml")
|| ($_FILES["report_file"]["type"] == "application/x-tex-tfm")
|| ($_FILES["report_file"]["type"] == "application/x-tex")
|| ($_FILES["report_file"]["type"] == "application/x-tcl")
|| ($_FILES["report_file"]["type"] == "application/x-tar")
|| ($_FILES["report_file"]["type"] == "application/vnd.tao.intent-module-archive")
|| ($_FILES["report_file"]["type"] == "image/tiff")
|| ($_FILES["report_file"]["type"] == "text/tab-separated-values")
|| ($_FILES["report_file"]["type"] == "application/sbml+xml")
|| ($_FILES["report_file"]["type"] == "application/x-sv4crc")
|| ($_FILES["report_file"]["type"] == "application/x-sv4cpio")
|| ($_FILES["report_file"]["type"] == "application/vnd.syncml.dm+wbxml")
|| ($_FILES["report_file"]["type"] == "application/vnd.syncml.dm+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.syncml+xml")
|| ($_FILES["report_file"]["type"] == "application/smil+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.symbian.install")
|| ($_FILES["report_file"]["type"] == "application/vnd.wqd")
|| ($_FILES["report_file"]["type"] == "audio/basic")
|| ($_FILES["report_file"]["type"] == "application/vnd.olpc-sugar")
|| ($_FILES["report_file"]["type"] == "application/vnd.solent.sdkm+xml")
|| ($_FILES["report_file"]["type"] == "application/x-stuffit")
|| ($_FILES["report_file"]["type"] == "application/x-stuffitx")
|| ($_FILES["report_file"]["type"] == "application/vnd.stepmania.stepchart")
|| ($_FILES["report_file"]["type"] == "application/vnd.stardivision.writer-global")
|| ($_FILES["report_file"]["type"] == "application/vnd.stardivision.writer")
|| ($_FILES["report_file"]["type"] == "application/vnd.stardivision.math")
|| ($_FILES["report_file"]["type"] == "application/vnd.stardivision.impress")
|| ($_FILES["report_file"]["type"] == "application/vnd.stardivision.draw")
|| ($_FILES["report_file"]["type"] == "application/vnd.stardivision.calc")
|| ($_FILES["report_file"]["type"] == "text/sgml")
|| ($_FILES["report_file"]["type"] == "application/vnd.koan")
|| ($_FILES["report_file"]["type"] == "application/ssml+xml")
|| ($_FILES["report_file"]["type"] == "application/srgs+xml")
|| ($_FILES["report_file"]["type"] == "application/srgs")
|| ($_FILES["report_file"]["type"] == "application/sparql-results+xml")
|| ($_FILES["report_file"]["type"] == "application/sparql-query")
|| ($_FILES["report_file"]["type"] == "application/vnd.svd")
|| ($_FILES["report_file"]["type"] == "application/vnd.smart.teacher")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.smaf-phrase")
|| ($_FILES["report_file"]["type"] == "application/vnd.smaf")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.smaf-audio")
|| ($_FILES["report_file"]["type"] == "application/vnd.commonspace")
|| ($_FILES["report_file"]["type"] == "application/vnd.simtech-mindmapper")
|| ($_FILES["report_file"]["type"] == "application/vnd.accpac.simply.imp")
|| ($_FILES["report_file"]["type"] == "application/vnd.accpac.simply.aso")
|| ($_FILES["report_file"]["type"] == "application/vnd.epson.salt")
|| ($_FILES["report_file"]["type"] == "image/x-rgb")
|| ($_FILES["report_file"]["type"] == "application/x-shar")
|| ($_FILES["report_file"]["type"] == "application/thraud+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.shana.informed.formdata")
|| ($_FILES["report_file"]["type"] == "application/vnd.shana.informed.formtemplate")
|| ($_FILES["report_file"]["type"] == "application/vnd.shana.informed.interchange")
|| ($_FILES["report_file"]["type"] == "application/vnd.shana.informed.package")
|| ($_FILES["report_file"]["type"] == "video/x-sgi-movie")
|| ($_FILES["report_file"]["type"] == "text/x-setext")
|| ($_FILES["report_file"]["type"] == "application/sdp")
|| ($_FILES["report_file"]["type"] == "application/scvp-cv-response")
|| ($_FILES["report_file"]["type"] == "application/scvp-cv-request")
|| ($_FILES["report_file"]["type"] == "application/scvp-vp-response")
|| ($_FILES["report_file"]["type"] == "application/scvp-vp-request")
|| ($_FILES["report_file"]["type"] == "application/x-font-snf")
|| ($_FILES["report_file"]["type"] == "application/vnd.seemail")
|| ($_FILES["report_file"]["type"] == "application/vnd.sema")
|| ($_FILES["report_file"]["type"] == "application/vnd.semd")
|| ($_FILES["report_file"]["type"] == "application/vnd.semf")
|| ($_FILES["report_file"]["type"] == "application/set-registration-initiation")
|| ($_FILES["report_file"]["type"] == "application/set-payment-initiation")
|| ($_FILES["report_file"]["type"] == "application/sru+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.sus-calendar")
|| ($_FILES["report_file"]["type"] == "image/svg+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.sailingtracker.track")
|| ($_FILES["report_file"]["type"] == "application/shf+xml")
|| ($_FILES["report_file"]["type"] == "application/rss+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.route66.link66+xml")
|| ($_FILES["report_file"]["type"] == "text/richtext")
|| ($_FILES["report_file"]["type"] == "application/rtf")
|| ($_FILES["report_file"]["type"] == "application/vnd.jisp")
|| ($_FILES["report_file"]["type"] == "application/vnd.cloanto.rp9")
|| ($_FILES["report_file"]["type"] == "application/rdf+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.data-vision.rdz")
|| ($_FILES["report_file"]["type"] == "application/relax-ng-compact-syntax")
|| ($_FILES["report_file"]["type"] == "application/vnd.recordare.musicxml")
|| ($_FILES["report_file"]["type"] == "application/vnd.recordare.musicxml+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.realvnc.bed")
|| ($_FILES["report_file"]["type"] == "application/vnd.rn-realmedia")
|| ($_FILES["report_file"]["type"] == "application/rsd+xml")
|| ($_FILES["report_file"]["type"] == "audio/x-pn-realaudio")
|| ($_FILES["report_file"]["type"] == "audio/x-pn-realaudio-plugin")
|| ($_FILES["report_file"]["type"] == "application/x-rar-compressed")
|| ($_FILES["report_file"]["type"] == "video/quicktime")
|| ($_FILES["report_file"]["type"] == "application/vnd.intu.qfx")
|| ($_FILES["report_file"]["type"] == "application/vnd.epson.quickanime")
|| ($_FILES["report_file"]["type"] == "application/vnd.epson.esf")
|| ($_FILES["report_file"]["type"] == "application/vnd.epson.msf")
|| ($_FILES["report_file"]["type"] == "application/vnd.epson.ssf")
|| ($_FILES["report_file"]["type"] == "application/vnd.quark.quarkxpress")
|| ($_FILES["report_file"]["type"] == "application/vnd.pmi.widget")
|| ($_FILES["report_file"]["type"] == "application/vnd.publishare-delta-tree")
|| ($_FILES["report_file"]["type"] == "application/x-font-linux-psf")
|| ($_FILES["report_file"]["type"] == "text/prs.lines.tag")
|| ($_FILES["report_file"]["type"] == "application/vnd.pg.format")
|| ($_FILES["report_file"]["type"] == "application/vnd.pg.osasli")
|| ($_FILES["report_file"]["type"] == "application/pls+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.pvi.ptid1")
|| ($_FILES["report_file"]["type"] == "application/vnd.previewsystems.box")
|| ($_FILES["report_file"]["type"] == "application/pgp-signature")
|| ($_FILES["report_file"]["type"] == "application/pgp-encrypted")
|| ($_FILES["report_file"]["type"] == "application/vnd.powerbuilder6")
|| ($_FILES["report_file"]["type"] == "application/x-font-type1")
|| ($_FILES["report_file"]["type"] == "application/postscript")
|| ($_FILES["report_file"]["type"] == "application/vnd.ctc-posml")
|| ($_FILES["report_file"]["type"] == "application/pskc+xml")
|| ($_FILES["report_file"]["type"] == "image/x-portable-pixmap")
||  ($_FILES["report_file"]["type"] == "image/x-portable-graymap")
|| ($_FILES["report_file"]["type"] == "application/x-chess-pgn")
|| ($_FILES["report_file"]["type"] == "application/font-tdpfr")
|| ($_FILES["report_file"]["type"] == "application/x-font-pcf")
|| ($_FILES["report_file"]["type"] == "image/x-portable-bitmap")
|| ($_FILES["report_file"]["type"] == "image/x-portable-anymap")
|| ($_FILES["report_file"]["type"] == "application/vnd.pocketlearn")
|| ($_FILES["report_file"]["type"] == "application/pkcs8")
|| ($_FILES["report_file"]["type"] == "application/x-pkcs7-certificates")
|| ($_FILES["report_file"]["type"] == "application/x-pkcs7-certreqresp")
|| ($_FILES["report_file"]["type"] == "application/pkcs7-mime")
|| ($_FILES["report_file"]["type"] == "application/pkcs7-signature")
|| ($_FILES["report_file"]["type"] == "application/x-pkcs12")
|| ($_FILES["report_file"]["type"] == "application/pkcs10")
|| ($_FILES["report_file"]["type"] == "application/x-chat")
|| ($_FILES["report_file"]["type"] == "image/x-pict")
|| ($_FILES["report_file"]["type"] == "application/pics-rules")
|| ($_FILES["report_file"]["type"] == "image/vnd.adobe.photoshop")
|| ($_FILES["report_file"]["type"] == "image/x-pcx")
|| ($_FILES["report_file"]["type"] == "application/vnd.picsel")
|| ($_FILES["report_file"]["type"] == "application/vnd.hp-pclxl")
|| ($_FILES["report_file"]["type"] == "application/vnd.pawaafile")
|| ($_FILES["report_file"]["type"] == "text/x-pascal")
|| ($_FILES["report_file"]["type"] == "application/vnd.palm")
|| ($_FILES["report_file"]["type"] == "application/vnd.osgi.dp")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.openscoreformat.osfpvg+xml")
|| ($_FILES["report_file"]["type"] == "application/x-font-otf")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.writer.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.writer")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.writer.global")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.math")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.impress.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.impress")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.draw.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.draw")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.calc.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.sun.xml.calc")
|| ($_FILES["report_file"]["type"] == "image/ktx")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.text-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.text-master")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.text")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.spreadsheet-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.spreadsheet")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.presentation-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.presentation")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.image-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.image")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.graphics-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.graphics")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.formula-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.formula")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.database")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.chart-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.chart")
|| ($_FILES["report_file"]["type"] == "video/webm")
|| ($_FILES["report_file"]["type"] == "audio/webm")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.openscoreformat")
|| ($_FILES["report_file"]["type"] == "application/vnd.openofficeorg.extension")
|| ($_FILES["report_file"]["type"] == "application/vnd.intu.qbo")
|| ($_FILES["report_file"]["type"] == "application/oebps-package+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.oasis.opendocument.text-web")
|| ($_FILES["report_file"]["type"] == "application/vnd.oma.dd2+xml")
|| ($_FILES["report_file"]["type"] == "video/ogg")
|| ($_FILES["report_file"]["type"] == "audio/ogg")
|| ($_FILES["report_file"]["type"] == "application/ogg")
|| ($_FILES["report_file"]["type"] == "application/oda")
|| ($_FILES["report_file"]["type"] == "audio/vnd.nuera.ecelp9600")
|| ($_FILES["report_file"]["type"] == "audio/vnd.nuera.ecelp7470")
|| ($_FILES["report_file"]["type"] == "audio/vnd.nuera.ecelp4800")
|| ($_FILES["report_file"]["type"] == "application/vnd.flographit")
|| ($_FILES["report_file"]["type"] == "application/vnd.novadigm.edm")
|| ($_FILES["report_file"]["type"] == "application/vnd.novadigm.edx")
|| ($_FILES["report_file"]["type"] == "application/vnd.novadigm.ext")
|| ($_FILES["report_file"]["type"] == "text/n3")
|| ($_FILES["report_file"]["type"] == "application/vnd.nokia.radio-preset")
|| ($_FILES["report_file"]["type"] == "application/vnd.nokia.radio-presets")
|| ($_FILES["report_file"]["type"] == "application/vnd.noblenet-web")
|| ($_FILES["report_file"]["type"] == "application/vnd.noblenet-sealer")
|| ($_FILES["report_file"]["type"] == "application/vnd.noblenet-directory")
|| ($_FILES["report_file"]["type"] == "application/vnd.dna")
|| ($_FILES["report_file"]["type"] == "application/vnd.neurolanguage.nlu")
|| ($_FILES["report_file"]["type"] == "application/x-netcdf")
|| ($_FILES["report_file"]["type"] == "application/x-dtbncx+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.nokia.n-gage.symbian.install")
|| ($_FILES["report_file"]["type"] == "application/vnd.nokia.n-gage.data")
|| ($_FILES["report_file"]["type"] == "application/xv+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.muvee.style")
|| ($_FILES["report_file"]["type"] == "application/vnd.musician")
|| ($_FILES["report_file"]["type"] == "application/vnd.apple.mpegurl")
|| ($_FILES["report_file"]["type"] == "application/mp4")
|| ($_FILES["report_file"]["type"] == "video/mp4")
|| ($_FILES["report_file"]["type"] == "audio/mp4")
|| ($_FILES["report_file"]["type"] == "application/mp21")
|| ($_FILES["report_file"]["type"] == "video/mpeg")
|| ($_FILES["report_file"]["type"] == "video/vnd.mpegurl")
|| ($_FILES["report_file"]["type"] == "audio/mpeg")
|| ($_FILES["report_file"]["type"] == "video/mj2")
|| ($_FILES["report_file"]["type"] == "application/vnd.mophun.application")
|| ($_FILES["report_file"]["type"] == "application/vnd.mophun.certificate")
|| ($_FILES["report_file"]["type"] == "text/vnd.fly")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.daf")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.txf")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.msl")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.mqy")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.plc")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.dis")
|| ($_FILES["report_file"]["type"] == "application/vnd.mobius.mbk")
|| ($_FILES["report_file"]["type"] == "application/x-mobipocket-ebook")
|| ($_FILES["report_file"]["type"] == "application/vnd.tmobile-livetv")
|| ($_FILES["report_file"]["type"] == "application/vnd.jcp.javame.midlet-rms")
|| ($_FILES["report_file"]["type"] == "application/vnd.ibm.modcap")
|| ($_FILES["report_file"]["type"] == "application/vnd.ibm.minipay")
|| ($_FILES["report_file"]["type"] == "audio/midi")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-xpsdocument")
|| ($_FILES["report_file"]["type"] == "application/x-ms-xbap")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-works")
|| ($_FILES["report_file"]["type"] == "application/x-mswrite")
|| ($_FILES["report_file"]["type"] == "application/x-msterminal")
|| ($_FILES["report_file"]["type"] == "application/x-msmetafile")
|| ($_FILES["report_file"]["type"] == "video/x-ms-wvx")
|| ($_FILES["report_file"]["type"] == "video/x-ms-wmv")
|| ($_FILES["report_file"]["type"] == "application/x-ms-wmz")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-wpl")
|| ($_FILES["report_file"]["type"] == "application/x-ms-wmd")
|| ($_FILES["report_file"]["type"] == "video/x-ms-wmx")
|| ($_FILES["report_file"]["type"] == "audio/x-ms-wax")
|| ($_FILES["report_file"]["type"] == "audio/x-ms-wma")
|| ($_FILES["report_file"]["type"] == "video/x-ms-wm")
|| ($_FILES["report_file"]["type"] == "application/vnd.visio")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-pki.seccat")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-pki.stl")
|| ($_FILES["report_file"]["type"] == "application/x-silverlight-app")
|| ($_FILES["report_file"]["type"] == "application/x-msschedule")
|| ($_FILES["report_file"]["type"] == "application/x-mspublisher")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-project")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-powerpoint.slideshow.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-powerpoint.presentation.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-powerpoint.slide.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-powerpoint.addin.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-powerpoint")
|| ($_FILES["report_file"]["type"] == "video/vnd.ms-playready.media.pyv")
|| ($_FILES["report_file"]["type"] == "audio/vnd.ms-playready.media.pya")
|| ($_FILES["report_file"]["type"] == "application/onenote")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-officetheme")
|| ($_FILES["report_file"]["type"] == "application/x-msbinder")
|| ($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.slideshow")
|| ($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.slide")
|| ($_FILES["report_file"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
|| ($_FILES["report_file"]["type"] == "application/x-msmoney")
|| ($_FILES["report_file"]["type"] == "application/x-msmediaview")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-lrm")
|| ($_FILES["report_file"]["type"] == "application/x-mscardfile")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-htmlhelp")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-excel.sheet.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-excel.template.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-excel.sheet.binary.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-excel.addin.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-fontobject")
|| ($_FILES["report_file"]["type"] == "image/vnd.ms-modi")
|| ($_FILES["report_file"]["type"] == "application/x-msclip")
|| ($_FILES["report_file"]["type"] == "application/x-ms-application")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-ims")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-cab-compressed")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-artgalry")
|| ($_FILES["report_file"]["type"] == "application/x-msdownload")
|| ($_FILES["report_file"]["type"] == "video/x-ms-asf")
|| ($_FILES["report_file"]["type"] == "application/x-msaccess")
|| ($_FILES["report_file"]["type"] == "application/vnd.eszigno3+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.micrografx.igx")
|| ($_FILES["report_file"]["type"] == "application/vnd.micrografx.flo")
|| ($_FILES["report_file"]["type"] == "application/vnd.mcd")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-word.template.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-word.document.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/vnd.ms-powerpoint.template.macroenabled.12")
|| ($_FILES["report_file"]["type"] == "application/metalink4+xml")
|| ($_FILES["report_file"]["type"] == "application/mods+xml")
|| ($_FILES["report_file"]["type"] == "application/mets+xml")
|| ($_FILES["report_file"]["type"] == "application/mads+xml")
|| ($_FILES["report_file"]["type"] == "model/mesh")
|| ($_FILES["report_file"]["type"] == "application/vnd.mfmp")
|| ($_FILES["report_file"]["type"] == "application/vnd.mfer")
|| ($_FILES["report_file"]["type"] == "application/vnd.mediastation.cdkey")
|| ($_FILES["report_file"]["type"] == "application/mediaservercontrol+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.medcalcdata")
|| ($_FILES["report_file"]["type"] == "application/mbox")
|| ($_FILES["report_file"]["type"] == "application/mathml+xml")
|| ($_FILES["report_file"]["type"] == "application/mathematica")
|| ($_FILES["report_file"]["type"] == "application/vnd.wolfram.player")
|| ($_FILES["report_file"]["type"] == "application/mxf")
|| ($_FILES["report_file"]["type"] == "application/marcxml+xml")
|| ($_FILES["report_file"]["type"] == "application/marc")
|| ($_FILES["report_file"]["type"] == "application/vnd.osgeo.mapguide.package")
|| ($_FILES["report_file"]["type"] == "application/vnd.macports.portpkg")
|| ($_FILES["report_file"]["type"] == "application/mac-binhex40")
|| ($_FILES["report_file"]["type"] == "video/x-m4v")
|| ($_FILES["report_file"]["type"] == "audio/x-mpegurl")
|| ($_FILES["report_file"]["type"] == "audio/vnd.lucent.voice")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-wordpro")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-screencam")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-organizer")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-notes")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-freelance")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-approach")
|| ($_FILES["report_file"]["type"] == "application/vnd.lotus-1-2-3")
|| ($_FILES["report_file"]["type"] == "application/vnd.jam")
|| ($_FILES["report_file"]["type"] == "application/vnd.llamagraphics.life-balance.exchange+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.llamagraphics.life-balance.desktop")
|| ($_FILES["report_file"]["type"] == "application/x-latex")
|| ($_FILES["report_file"]["type"] == "application/vnd.las.las+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.kodak-descriptor")
|| ($_FILES["report_file"]["type"] == "application/vnd.kinar")
|| ($_FILES["report_file"]["type"] == "application/vnd.kidspiration")
|| ($_FILES["report_file"]["type"] == "application/vnd.kenameaapp")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kword")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kspread")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kpresenter")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kontour")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kivio")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kformula")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.kchart")
|| ($_FILES["report_file"]["type"] == "application/vnd.kde.karbon")
|| ($_FILES["report_file"]["type"] == "application/vnd.chipnuts.karaoke-mmd")
|| ($_FILES["report_file"]["type"] == "application/vnd.kahootz")
|| ($_FILES["report_file"]["type"] == "video/jpeg")
|| ($_FILES["report_file"]["type"] == "video/jpm")
|| ($_FILES["report_file"]["type"] == "application/vnd.joost.joda-archive")
|| ($_FILES["report_file"]["type"] == "application/json")
|| ($_FILES["report_file"]["type"] == "application/javascript")
|| ($_FILES["report_file"]["type"] == "text/x-java-source,java")
|| ($_FILES["report_file"]["type"] == "application/java-serialized-object")
|| ($_FILES["report_file"]["type"] == "application/x-java-jnlp-file")
|| ($_FILES["report_file"]["type"] == "application/java-vm")
|| ($_FILES["report_file"]["type"] == "application/java-archive")
|| ($_FILES["report_file"]["type"] == "text/vnd.sun.j2me.app-descriptor")
|| ($_FILES["report_file"]["type"] == "application/vnd.irepository.package+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.ipunplugged.rcprofile")
|| ($_FILES["report_file"]["type"] == "application/vnd.insors.igm")
|| ($_FILES["report_file"]["type"] == "application/pkix-pkipath")
|| ($_FILES["report_file"]["type"] == "application/pkix-crl")
|| ($_FILES["report_file"]["type"] == "application/pkixcmp")
|| ($_FILES["report_file"]["type"] == "application/pkix-cert")
|| ($_FILES["report_file"]["type"] == "application/ipfix")
|| ($_FILES["report_file"]["type"] == "application/vnd.isac.fcs")
|| ($_FILES["report_file"]["type"] == "application/vnd.intercon.formnet")
|| ($_FILES["report_file"]["type"] == "application/vnd.cinderella")
|| ($_FILES["report_file"]["type"] == "application/vnd.intergeo")
|| ($_FILES["report_file"]["type"] == "model/iges")
|| ($_FILES["report_file"]["type"] == "text/vnd.in3d.3dml")
|| ($_FILES["report_file"]["type"] == "text/vnd.in3d.spot")
|| ($_FILES["report_file"]["type"] == "application/reginfo+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.immervision-ivp")
|| ($_FILES["report_file"]["type"] == "application/vnd.immervision-ivu")
|| ($_FILES["report_file"]["type"] == "image/ief")
|| ($_FILES["report_file"]["type"] == "application/vnd.igloader")
|| ($_FILES["report_file"]["type"] == "image/x-icon")
|| ($_FILES["report_file"]["type"] == "application/vnd.iccprofile")
|| ($_FILES["report_file"]["type"] == "text/calendar")
|| ($_FILES["report_file"]["type"] == "application/vnd.ibm.secure-container")
|| ($_FILES["report_file"]["type"] == "application/vnd.ibm.rights-management")
|| ($_FILES["report_file"]["type"] == "text/html")
|| ($_FILES["report_file"]["type"] == "application/vnd.hal+xml")
|| ($_FILES["report_file"]["type"] == "application/hyperstudio")
|| ($_FILES["report_file"]["type"] == "application/vnd.hydrostatix.sof-data")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.hv-voice")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.hv-dic")
|| ($_FILES["report_file"]["type"] == "application/vnd.yamaha.hv-script")
|| ($_FILES["report_file"]["type"] == "application/vnd.hp-hpgl")
|| ($_FILES["report_file"]["type"] == "application/vnd.hp-pcl")
|| ($_FILES["report_file"]["type"] == "application/vnd.hp-jlyt")
|| ($_FILES["report_file"]["type"] == "application/vnd.hbci")
|| ($_FILES["report_file"]["type"] == "audio/vnd.rip")
|| ($_FILES["report_file"]["type"] == "application/x-hdf")
|| ($_FILES["report_file"]["type"] == "application/vnd.hp-hps")
|| ($_FILES["report_file"]["type"] == "application/vnd.hp-hpid")
|| ($_FILES["report_file"]["type"] == "video/h264")
|| ($_FILES["report_file"]["type"] == "video/h263")
|| ($_FILES["report_file"]["type"] == "video/h261")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-vcard")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-tool-template")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-tool-message")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-injector")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-identity-message")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-help")
|| ($_FILES["report_file"]["type"] == "application/vnd.groove-account")
|| ($_FILES["report_file"]["type"] == "text/vnd.graphviz")
|| ($_FILES["report_file"]["type"] == "application/vnd.grafeq")
|| ($_FILES["report_file"]["type"] == "application/vnd.google-earth.kmz")
|| ($_FILES["report_file"]["type"] == "application/vnd.google-earth.kml+xml")
|| ($_FILES["report_file"]["type"] == "application/x-gnumeric")
|| ($_FILES["report_file"]["type"] == "application/x-texinfo")
|| ($_FILES["report_file"]["type"] == "application/x-gtar")
|| ($_FILES["report_file"]["type"] == "application/x-font-bdf")
|| ($_FILES["report_file"]["type"] == "application/x-font-ghostscript")
|| ($_FILES["report_file"]["type"] == "application/vnd.geospace")
|| ($_FILES["report_file"]["type"] == "application/vnd.geoplan")
|| ($_FILES["report_file"]["type"] == "application/vnd.geonext")
|| ($_FILES["report_file"]["type"] == "application/vnd.geometry-explorer")
|| ($_FILES["report_file"]["type"] == "model/vnd.gdl")
|| ($_FILES["report_file"]["type"] == "application/vnd.geogebra.file")
|| ($_FILES["report_file"]["type"] == "application/vnd.geogebra.tool")
|| ($_FILES["report_file"]["type"] == "application/vnd.genomatix.tuxedo")
|| ($_FILES["report_file"]["type"] == "model/vnd.gtw")
|| ($_FILES["report_file"]["type"] == "application/vnd.gmx")
|| ($_FILES["report_file"]["type"] == "image/g3fax")
|| ($_FILES["report_file"]["type"] == "application/vnd.fuzzysheet")
|| ($_FILES["report_file"]["type"] == "application/x-futuresplash")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujitsu.oasys")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujitsu.oasys2")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujitsu.oasys3")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujitsu.oasysgp")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujitsu.oasysprs")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujixerox.docuworks.binder")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujixerox.docuworks")
|| ($_FILES["report_file"]["type"] == "application/vnd.fujixerox.ddd")
|| ($_FILES["report_file"]["type"] == "application/vnd.frogans.fnc")
|| ($_FILES["report_file"]["type"] == "application/vnd.frogans.ltf")
|| ($_FILES["report_file"]["type"] == "application/vnd.fsc.weblaunch")
|| ($_FILES["report_file"]["type"] == "image/x-freehand")
|| ($_FILES["report_file"]["type"] == "application/vnd.framemaker")
|| ($_FILES["report_file"]["type"] == "application/vnd.mif")
|| ($_FILES["report_file"]["type"] == "text/x-fortran")
|| ($_FILES["report_file"]["type"] == "application/vnd.fdf")
|| ($_FILES["report_file"]["type"] == "application/vnd.fluxtime.clip")
|| ($_FILES["report_file"]["type"] == "video/x-fli")
|| ($_FILES["report_file"]["type"] == "text/vnd.fmi.flexstor")
|| ($_FILES["report_file"]["type"] == "image/vnd.fpx")
|| ($_FILES["report_file"]["type"] == "image/vnd.net-fpx")
|| ($_FILES["report_file"]["type"] == "video/x-f4v")
|| ($_FILES["report_file"]["type"] == "video/x-flv")
|| ($_FILES["report_file"]["type"] == "application/vnd.denovo.fcselayout-link")
|| ($_FILES["report_file"]["type"] == "image/vnd.fastbidsheet")
|| ($_FILES["report_file"]["type"] == "image/vnd.fst")
|| ($_FILES["report_file"]["type"] == "video/vnd.fvt")
|| ($_FILES["report_file"]["type"] == "application/vnd.ezpix-album")
|| ($_FILES["report_file"]["type"] == "application/vnd.ezpix-package")
|| ($_FILES["report_file"]["type"] == "application/emma+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.xfdl")
|| ($_FILES["report_file"]["type"] == "image/vnd.xiff")
|| ($_FILES["report_file"]["type"] == "application/vnd.is-xpr")
|| ($_FILES["report_file"]["type"] == "application/vnd.enliven")
|| ($_FILES["report_file"]["type"] == "message/rfc822")
|| ($_FILES["report_file"]["type"] == "application/epub+zip")
|| ($_FILES["report_file"]["type"] == "application/vnd.proteus.magazine")
|| ($_FILES["report_file"]["type"] == "application/exi")
|| ($_FILES["report_file"]["type"] == "image/vnd.fujixerox.edmics-mmr")
|| ($_FILES["report_file"]["type"] == "image/vnd.fujixerox.edmics-rlc")
|| ($_FILES["report_file"]["type"] == "application/vnd.ecowin.chart")
|| ($_FILES["report_file"]["type"] == "application/ecmascript")
|| ($_FILES["report_file"]["type"] == "application/vnd.dynageo")
|| ($_FILES["report_file"]["type"] == "image/vnd.dwg")
|| ($_FILES["report_file"]["type"] == "audio/vnd.dts.hd")
|| ($_FILES["report_file"]["type"] == "audio/vnd.dts")
|| ($_FILES["report_file"]["type"] == "application/vnd.dreamfactory")
|| ($_FILES["report_file"]["type"] == "audio/vnd.dra")
|| ($_FILES["report_file"]["type"] == "application/vnd.dpgraph")
|| ($_FILES["report_file"]["type"] == "application/x-doom")
|| ($_FILES["report_file"]["type"] == "application/vnd.dolby.mlp")
|| ($_FILES["report_file"]["type"] == "application/xml-dtd")
|| ($_FILES["report_file"]["type"] == "image/vnd.djvu")
|| ($_FILES["report_file"]["type"] == "audio/vnd.digital-winds")
|| ($_FILES["report_file"]["type"] == "application/vnd.dvb.ait")
|| ($_FILES["report_file"]["type"] == "application/vnd.dvb.service")
|| ($_FILES["report_file"]["type"] == "application/x-dtbresource+xml")
|| ($_FILES["report_file"]["type"] == "application/x-dtbook+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.fdsn.seed")
|| ($_FILES["report_file"]["type"] == "application/x-dvi")
|| ($_FILES["report_file"]["type"] == "video/vnd.dece.video")
|| ($_FILES["report_file"]["type"] == "video/vnd.dece.sd")
|| ($_FILES["report_file"]["type"] == "video/vnd.dece.pd")
|| ($_FILES["report_file"]["type"] == "video/vnd.uvvu.mp4")
|| ($_FILES["report_file"]["type"] == "video/vnd.dece.mobile")
|| ($_FILES["report_file"]["type"] == "video/vnd.dece.hd")
|| ($_FILES["report_file"]["type"] == "image/vnd.dece.graphic")
|| ($_FILES["report_file"]["type"] == "audio/vnd.dece.audio")
|| ($_FILES["report_file"]["type"] == "application/x-debian-package")
|| ($_FILES["report_file"]["type"] == "application/dssc+der")
|| ($_FILES["report_file"]["type"] == "application/dssc+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.yellowriver-custom-menu")
|| ($_FILES["report_file"]["type"] == "application/vnd.curl.car")
|| ($_FILES["report_file"]["type"] == "application/vnd.curl.pcurl")
|| ($_FILES["report_file"]["type"] == "text/vnd.curl.scurl")
|| ($_FILES["report_file"]["type"] == "text/vnd.curl.mcurl")
|| ($_FILES["report_file"]["type"] == "text/vnd.curl.dcurl")
|| ($_FILES["report_file"]["type"] == "text/vnd.curl")
|| ($_FILES["report_file"]["type"] == "application/prs.cww")
|| ($_FILES["report_file"]["type"] == "application/cu-seeme")
|| ($_FILES["report_file"]["type"] == "chemical/x-cmdf")
|| ($_FILES["report_file"]["type"] == "chemical/x-cif")
|| ($_FILES["report_file"]["type"] == "application/vnd.rig.cryptonote")
|| ($_FILES["report_file"]["type"] == "application/vnd.criticaltools.wbs+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.crick.clicker.wordbank")
|| ($_FILES["report_file"]["type"] == "application/vnd.crick.clicker.template")
|| ($_FILES["report_file"]["type"] == "application/vnd.crick.clicker.palette")
|| ($_FILES["report_file"]["type"] == "application/vnd.crick.clicker.keyboard")
|| ($_FILES["report_file"]["type"] == "application/vnd.crick.clicker")
|| ($_FILES["report_file"]["type"] == "application/x-cpio")
|| ($_FILES["report_file"]["type"] == "application/vnd.cosmocaller")
|| ($_FILES["report_file"]["type"] == "application/vnd.xara")
|| ($_FILES["report_file"]["type"] == "image/x-cmx")
|| ($_FILES["report_file"]["type"] == "x-conference/x-cooltalk")
|| ($_FILES["report_file"]["type"] == "image/cgm")
|| ($_FILES["report_file"]["type"] == "application/vnd.wap.wmlc")
|| ($_FILES["report_file"]["type"] == "application/mac-compactpro")
|| ($_FILES["report_file"]["type"] == "text/csv")
|| ($_FILES["report_file"]["type"] == "model/vnd.collada+xml")
|| ($_FILES["report_file"]["type"] == "image/x-cmu-raster")
|| ($_FILES["report_file"]["type"] == "application/vnd.cluetrust.cartomobile-config-pkg")
|| ($_FILES["report_file"]["type"] == "application/vnd.cluetrust.cartomobile-config")
|| ($_FILES["report_file"]["type"] == "application/cdmi-queue")
|| ($_FILES["report_file"]["type"] == "application/cdmi-object")
|| ($_FILES["report_file"]["type"] == "application/cdmi-domain")
|| ($_FILES["report_file"]["type"] == "application/cdmi-container")
|| ($_FILES["report_file"]["type"] == "application/cdmi-capability")
|| ($_FILES["report_file"]["type"] == "image/vnd.dvb.subtitle")
|| ($_FILES["report_file"]["type"] == "application/vnd.clonk.c4group")
|| ($_FILES["report_file"]["type"] == "application/vnd.claymore")
|| ($_FILES["report_file"]["type"] == "application/vnd.contact.cmsg")
|| ($_FILES["report_file"]["type"] == "chemical/x-csml")
|| ($_FILES["report_file"]["type"] == "chemical/x-cml")
|| ($_FILES["report_file"]["type"] == "chemical/x-cdx")
|| ($_FILES["report_file"]["type"] == "text/css")
|| ($_FILES["report_file"]["type"] == "application/vnd.chemdraw+xml")
|| ($_FILES["report_file"]["type"] == "text/x-c")
|| ($_FILES["report_file"]["type"] == "application/x-csh")
|| ($_FILES["report_file"]["type"] == "application/x-bzip2")
|| ($_FILES["report_file"]["type"] == "application/x-bzip")
|| ($_FILES["report_file"]["type"] == "application/vnd.businessobjects")
|| ($_FILES["report_file"]["type"] == "image/prs.btif")
|| ($_FILES["report_file"]["type"] == "application/x-sh")
|| ($_FILES["report_file"]["type"] == "application/vnd.bmi")
|| ($_FILES["report_file"]["type"] == "application/vnd.blueice.multipass")
|| ($_FILES["report_file"]["type"] == "application/vnd.rim.cod")
|| ($_FILES["report_file"]["type"] == "application/x-bittorrent")
|| ($_FILES["report_file"]["type"] == "image/bmp")
|| ($_FILES["report_file"]["type"] == "application/octet-stream")
|| ($_FILES["report_file"]["type"] == "application/x-bcpio")
|| ($_FILES["report_file"]["type"] == "text/plain-bas")
|| ($_FILES["report_file"]["type"] == "model/vnd.dwf")
|| ($_FILES["report_file"]["type"] == "image/vnd.dxf")
|| ($_FILES["report_file"]["type"] == "application/vnd.audiograph")
|| ($_FILES["report_file"]["type"] == "video/x-msvideo")
|| ($_FILES["report_file"]["type"] == "audio/x-aiff")
|| ($_FILES["report_file"]["type"] == "application/pkix-attr-cert")
|| ($_FILES["report_file"]["type"] == "application/atom+xml")
|| ($_FILES["report_file"]["type"] == "application/atomsvc+xml")
|| ($_FILES["report_file"]["type"] == "application/atomcat+xml")
|| ($_FILES["report_file"]["type"] == "text/x-asm")
|| ($_FILES["report_file"]["type"] == "application/vnd.aristanetworks.swi")
|| ($_FILES["report_file"]["type"] == "application/vnd.hhe.lesson-player")
|| ($_FILES["report_file"]["type"] == "application/applixware")
|| ($_FILES["report_file"]["type"] == "application/vnd.apple.installer+xml")
|| ($_FILES["report_file"]["type"] == "application/vnd.antix.game-component")
|| ($_FILES["report_file"]["type"] == "application/vnd.anser-web-funds-transfer-initiation")
|| ($_FILES["report_file"]["type"] == "application/vnd.anser-web-certificate-issue-initiation")
|| ($_FILES["report_file"]["type"] == "application/vnd.android.package-archive")
|| ($_FILES["report_file"]["type"] == "application/andrew-inset")
|| ($_FILES["report_file"]["type"] == "application/vnd.amiga.ami")
|| ($_FILES["report_file"]["type"] == "application/vnd.amazon.ebook")
|| ($_FILES["report_file"]["type"] == "application/vnd.airzip.filesecure.azf")
|| ($_FILES["report_file"]["type"] == "application/vnd.airzip.filesecure.azs")
|| ($_FILES["report_file"]["type"] == "application/vnd.ahead.space")
|| ($_FILES["report_file"]["type"] == "audio/x-aac")
|| ($_FILES["report_file"]["type"] == "application/vnd.adobe.xfdf")
|| ($_FILES["report_file"]["type"] == "application/vnd.adobe.xdp+xml")
|| ($_FILES["report_file"]["type"] == "application/x-director")
|| ($_FILES["report_file"]["type"] == "application/vnd.cups-ppd")
|| ($_FILES["report_file"]["type"] == "application/vnd.adobe.fxp")
|| ($_FILES["report_file"]["type"] == "application/x-shockwave-flash")
|| ($_FILES["report_file"]["type"] == "application/vnd.adobe.air-application-installer-package+zip")
|| ($_FILES["report_file"]["type"] == "application/x-authorware-seg")
|| ($_FILES["report_file"]["type"] == "application/x-authorware-map")
|| ($_FILES["report_file"]["type"] == "application/x-authorware-bin")
|| ($_FILES["report_file"]["type"] == "audio/adpcm")
|| ($_FILES["report_file"]["type"] == "application/vnd.acucobol")
|| ($_FILES["report_file"]["type"] == "application/vnd.acucorp")
|| ($_FILES["report_file"]["type"] == "application/vnd.americandynamics.acc")
|| ($_FILES["report_file"]["type"] == "application/x-ace-compressed")
|| ($_FILES["report_file"]["type"] == "application/x-abiword")
|| ($_FILES["report_file"]["type"] == "application/x-7z-compressed")
|| ($_FILES["report_file"]["type"] == "application/vnd.3gpp2.tcap")
|| ($_FILES["report_file"]["type"] == "application/vnd.3gpp.pic-bw-var")
|| ($_FILES["report_file"]["type"] == "application/vnd.3gpp.pic-bw-small")
|| ($_FILES["report_file"]["type"] == "application/vnd.3gpp.pic-bw-large")
|| ($_FILES["report_file"]["type"] == "application/vnd.3m.post-it-notes")
|| ($_FILES["report_file"]["type"] == "application/vnd.mseq")
|| ($_FILES["report_file"]["type"] == "video/3gpp2")
|| ($_FILES["report_file"]["type"] == "video/3gpp")
|| ($_FILES["report_file"]["type"] == "application/vnd.hzn-3d-crossword")
|| ($_FILES["report_file"]["type"] == "image/x-dwg")
||  ($_FILES["report_file"]["type"] == "application/x-dosexec"))		 
{ 
			
			if($old_report_file){
					@unlink(REPORT_PATH . $old_report_file);
						
					}
			if($objImage->uploadImage($report_id,$name_file1)){
				
				$report_file = $objImage->filename;
				$objProdctC1->setProperty("report_file",$report_file);
			}
			}
			else
		  {
		 $objCommon->setMessage("Invalid file ", 'Error');
		//redirect('./?p=upload_report&report_id='.$report_id);
		  }
		 
	}

			
			if($objProdctC1->actReport($_POST['mode'])){
			//echo substr($report_file,0,(strlen($report_file)-4));
			if(substr($report_file,-4)==".bin")
			{
			rename($report_path.$report_file,$report_path.substr($report_file,0,(strlen($report_file)-4)).".".$ext);
			if($_POST['mode'] == "U"){
			$r_id=$report_id;
			}
			else
			{
			$r_id= mysql_insert_id();
			}
			$sql_u="update rs_tbl_documents set report_file='".substr($report_file,0,(strlen($report_file)-4)).".".$ext."' where report_id=".$r_id;
			$objDb->dbCon->query($sql_u);
			}
			
			if($_POST['mode'] == "U" && (isset($_FILES["report_file"]["name"]) && ($_FILES["report_file"]["name"]!=""))){
			$r_id=$report_id;
			$fulpath = $report_path.$report_file;
			  $file_size=round((filesize($fulpath)),3);
			  $sSQL_size = "update rs_tbl_documents set file_size='$file_size',extension='$ext',uploading_file_date='$file_uploading_date_for_size' where report_id=".$r_id;
				
			}
			/*else
			{
			$r_id= mysql_insert_id();
			$fulpath = $report_path.$report_file;
			 echo $file_size=round((filesize($fulpath)),3);
			 echo $sSQL_size = "update rs_tbl_documents set file_size='$file_size',extension='$ext',uploading_file_date='$file_uploading_date_for_size' where report_id=".$r_id;
			
			}*/
		$objDb->dbCon->query($sSQL_size);
		
			   
				if($_POST['mode'] == "U"){
					$objCommon->setMessage("Document uploaded susccessfully",'Info');
					$activity="Report has been updated";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				$objDb->dbCon->query($sSQLlog_log);
				}
				else{
					$objCommon->setMessage("Document uploaded susccessfully",'Info');
				$activity="Report has been added";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				$objDb->dbCon->query($sSQLlog_log);		
				}
				
			
				print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
				//redirect('./?p=upload_report');
			}
		
	}
	else
	{
		
		
	    //Loop through each file
        for($i=0; $i<count($_FILES['report_file']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['report_file']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname1 = $_FILES['report_file']['name'][$i];
				$ext = pathinfo($shortname1, PATHINFO_EXTENSION);
				$array_sname=explode(".",$shortname1);
				if(count($_FILES['report_file']['name'])==1 && $cat_title!='')
				{
				$report_title=$cat_title;
				}
				else
				{
				$report_title= mysql_real_escape_string(trim($array_sname[0]));
				}
				$report_title_1=preg_replace("/[^a-zA-Z0-9.]/", "", $array_sname[0]);
				$shortname=$shortname1.$ext;
				if($comment=="")
				{
				$comment1=NULL;
				}
				else
				{
				$comment1=$comment;
				}
				
				$sql_pro_ins="INSERT INTO rs_tbl_documents (report_category, report_title,doc_issue_date,report_status,period,
						doc_upload_date,revision,doc_closing_date,document_no,reference_no,rep_reference_no,received_date,file_from,file_to,file_no,drawing_series,file_category,remarks,doc_creater,doc_creater_id) Values(".$cat_id.",'".$report_title."','".$doc_issue_date."','".$comment1."','".$period."','".$doc_upload_date."','".$revision."','".$doc_closing_date."','".$document_no."','".$reference_no."','".$rep_reference_no."','".$received_date."','".$file_from."','".$file_to."','".$file_no."','".$drawing_series."','".$file_category."','".$remarks."', '".$doc_creat_by."',".$userid_owner.")";
				 
				 $query_res=$objDb->dbCon->query($sql_pro_ins);
					$report_idd=$query_res->lastInsertId();		
		
		
				$filename=$report_title_1."-".$report_idd.".".$ext;
                //save the url and the file
                $filePath = $report_path."/".$filename;

                
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                $file_size=round((filesize($filePath)),3);
				
                $sql_upd="update rs_tbl_documents set report_file='".$filename."' ,file_size='$file_size',extension='$ext',uploading_file_date='$file_uploading_date_for_size' where report_id=".$report_idd;
				$objDb->dbCon->query($sql_upd);
				$activity="Report has been added";
				$sSQLlog_log = "INSERT INTO rs_tbl_user_log(user_id, epname, logintime, user_ip, user_pcname, url_capture) VALUES ('$uid', '$nameuser', '$nowdt', '$ipadd', '$hostname','$activity')";
				$objDb->dbCon->query($sSQLlog_log);
				
						


                }
				
              }
			
        }
				
				print "<script type='text/javascript'>";
				print "window.opener.location.reload();";
				print "self.close();";
				print "</script>";  
    
	}

	}
	
	
	
}
else{
	if(isset($_GET['report_id']) && !empty($_GET['report_id']))
		$report_id = $_GET['report_id'];
	else if(isset($_POST['report_id']) && !empty($_POST['report_id']))
		$report_id = $_POST['report_id'];
	if(isset($report_id) && !empty($report_id)){
		$objProduct->setProperty("report_id", $report_id);
		$objProduct->lstReport();
		$data = $objProduct->dbFetchArray(1);
		$mode	= "U";
		extract($data);
	}
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo HOME_MAIN_TITLE?></title>
<head>

<link href="css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="menu/chromestyle.css"/>
<?php 
# JS file
importJs("Menu");
importJs("Common");
importJs("Ajax");
importJs("Calendar");
importJs("Lang-EN");
importJs("ShowCalendar");?>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<?php importCss("Login");?>
<?php importCss("Messages");
if($objAdminUser->is_login == true){
	importCss("PjStyles");
}?>
<link rel="stylesheet" type="text/css" media="all" href="datepickercode/jquery-ui.css" />
  <script type="text/javascript" src="datepickercode/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="datepickercode/jquery-ui.js"></script>
	<!---// load jQuery from the GoogleAPIs CDN //--->
	<?php /*?><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script><?php */?>
</head>
<body>
    <?php echo $objCommon->displayMessage();?>
<?php
if(isset($cat_idm))
{
?>
<script>
/*alert("dsjfd");
window.onload = getsubcat1();
alert("dsjfd");
function getsubcat1() {
	alert("catid");
	}*/
</script>
<?php
}
?>
<script language="javascript" type="text/javascript">
function frmValidatetitle(frm){
	var msg = "<?php echo _JS_FORM_ERROR;?>\r\n-----------------------------------------";
	var flag = true;

	if(frm.old_report_file.value=='')
	{
		if(frm.report_file.files.length < 1){
			msg = msg + "\r\n<?php echo "Please upload file";?>";
			flag = false;
		}
	}else
	{
	}
	if(flag == false){
		alert(msg);
		return false;
	}
}
</script>
 <script>
  $(function() {
    $( "#doc_issue_date" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
	
  });
   $(function() {
    $( "#doc_closing_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
   $(function() {
    $( "#doc_upload_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
   $(function() {
    $( "#received_date" ).datepicker({ dateFormat:'yy-mm-dd'}).val();
	
  });
  </script>
   
<div id="wrapperPRight" style="width:700px">

<h2 align="center">Upload File</h2>
<?php echo $objCommon->displayMessage();?>
         
		<div class="clear"></div>
				<form name="frmReport" id="frmReport"  action="" method="post" enctype="multipart/form-data" onSubmit="return frmValidatetitle(this);">
        <input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>" />
        <input type="hidden" name="report_id" id="report_id" value="<?php echo $cdata11['report_id'];?>" />
        
         <div id="tableContainer" class="table" style="border-left:1px;">
        
          <table width="70%" border="1" style="margin-right:90px" cellspacing="0" cellpadding="0" align="left">
    
    <tr>
      
        <td >
	    <?php echo PRD_CAT_NAME;?><span style="color:#FF0000;">*</span>:
        </td>
        <td>
        <div id="componentdiv">
        
        <select name="cat_id" id="cat_id" onChange="getsubcat(this.value)" disabled="disabled">
              <option value="0">Select Category..</option>
              <?php
$cquery = "select category_cd,category_name,parent_cd from  rs_tbl_category WHERE category_cd = ".$cat_idm;
$cresult=$objDb->dbCon->query($cquery);
while ($cdata = $cresult->fetch()) {

?>
              <option value="<?php echo $cdata['category_cd']; ?>" <?php if ($cat_idm == $cdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $cdata['category_name']; ?></option>
              <?php
}
?>
            </select>
			<!--<input type="hidden" name="cat_id" id="cat_id" value="<?php //echo $cat_id ?>"/>-->
			</div>
		</td>
        </tr>

		<tr>
		<td colspan="2" style="padding:0px;">
			<?php
		


		?>
		
		<?php
		$arr_subcat=explode("_",$subcatid);
		$lenng=count($arr_subcat);
		$ist_sub=$arr_subcat[0];
		$lst_sub=$arr_subcat[$lenng-1];
		$cquery = "select category_cd from  rs_tbl_category";
		
		$cresult = $objDb->dbCon->query($cquery);
		
		while ($cdata = $cresult->fetch()) {	
		$cat_id2=$cdata['category_cd'];	
		
		
		//$parent_cd=$cdata['parent_cd'];
		if(($cat_id2==$cat_idm))
		
		{
?>
<div id="<?php echo "subcatdiv_".$cat_idm?>" style="display:block" >
<table width="100%" border="0" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
<?php

 $tquery = "select * from  rs_tbl_category where parent_cd = ".$cat_idm . " order by category_cd ASC";
$tresult=$objDb->dbCon->query($tquery);
if($tresult->rowCount()>0)
{


?>

<?php
}
?>
</table>

		</div>
<?php
}
 if(($cat_id2==$cat_idm) && ($lenng>1))
		
		{
		for($i=0; $i<$lenng; $i++)
		{
		?>
		<div id="<?php echo "subcatdiv_".$arr_subcat[$i]?>" style="display:block" >
		<table width="100%" border="0" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
		<?php
 $subcat_id= $arr_subcat[$i];
$catid= $cat_idm;
if($subcat_id!="" && $subcat_id!=0)
{
?>
<?php 

$tquery = "select * from  rs_tbl_category where parent_cd = ".$subcat_id . " order by category_cd ASC";
$tresult=$objDb->dbCon->query($tquery);
if($tresult->rowCount()>0)
{
if($i==0)
{
 $con_catid=$catid."_".$subcat_id;
 }
 else
 {

 $subcats="";
 $subcats1="";
 for($j=0;$j<$i;$j++)
 {
 $subcats1=$arr_subcat[$j];
 $subcats=$subcats."_".$subcats1;
 }

 $con_catid=$catid.$subcats."_".$subcat_id;
 $subcats="";
 }

?>
<tr>
<td width="180px"><?php echo "Sub Category";?> 
       <span style="color:#FF0000;">*</span>:</td>
<td>
<select name="subcatid_<?php echo $subcat_id; ?>" id="subcatid_<?php echo $subcat_id; ?>" onChange="subcatlisting_<?php echo $subcat_id; ?>(this.value,'<?php echo $con_catid; ?>')" >
<option value="0">Select Sub Category..</option>
<?php

while ($tdata = $tresult->fetch()) {
?>
	<option value="<?php echo $tdata['category_cd']; ?>" <?php if ($arr_subcat[$i+1] == $tdata['category_cd']) {echo ' selected="selected"';} ?>><?php echo $tdata['category_name']; ?></option>
<?php
}
?>
</select>
</td>
</tr>
<?php
}
}
?>
</table>
		</div>
		<?php
		}
		}
else
{
?>
<div id="<?php echo "subcatdiv_".$cdata['category_cd']?>" style="display:block" >
		</div>
<?php
}
if($subcatid=="")
{
$lst_sub=$cat_idm;
}

if($cat_id2==$lst_sub)
{



?>
<div id="<?php echo "fields_".$lst_sub?>" style="display:block" >
<table width="100%" border="0" style="margin-right:90px" cellspacing="0" cellpadding="0" align="center">
<?php
$sql36="Select * from rs_tbl_category_template where cat_id=".$lst_sub." order by cat_temp_order asc";
$tresult=$objDb->dbCon->query($sql36);
while($row36=$tresult->fetch())
			{
?>
<tr>
        
        <td><?php echo $row36['cat_title_text'] ?>:
        </td>
        <td>
		<?php 
		 $field_name=$row36["cat_field_name"];
		
           if($field_name=="remarks")
		   {
		   ?>
		   <textarea name="<?php echo $row36['cat_field_name'] ?>" id="<?php echo $row36['cat_field_name']?>"><?php echo $cdata11[$field_name];?></textarea>
		   <?php 
		   }
		   else
		   {
		   ?>
		   
		    <input type="text" name="<?php echo $row36['cat_field_name'] ?>" id="<?php echo $row36['cat_field_name']?>" size="25px" 
			value="<?php 
			if($field_name=="doc_upload_date" && $cdata11[$field_name]=="")
			{
			echo date("Y-m-d");
			}
			else
			{
			echo $cdata11[$field_name];
			}?>">&nbsp;&nbsp;<?php if(($field_name=="doc_issue_date")||($field_name=="doc_closing_date")||($field_name=="doc_upload_date")||($field_name=="received_date"))
			{
			echo "yyyy-mm-dd";
			}
			if($field_name=="report_title")
			{
			echo "Please avoid special characters";
			}
			} ?>
			
        </td>
        </tr>
		
<?php
}
?>
</table>
		</div>
<?php
}
else
{
?>

		
		<div id="<?php echo "fields_".$cdata['category_cd']?>" style="display:block" >
		</div>
<?php
		}
		}
		
	
?>
			
			
			<input type="hidden" name="subcatide" id="subcatide" value="<?php echo $subcatid; ?>"/>
           <input type="hidden" name="subcatidm" id="subcatidm" value=""/>
		
       
		</td>
        </tr>
		<tr>
        <td>	<?php if(isset($_GET['report_id']))
		{
		echo "Upload File";
		}
		else
		{
		echo "Upload File(s):";
		}
		?>       </td>
		
        <td>
		<?php if(isset($_GET['report_id']))
		{
		?>
		<input type="file" name="report_file" id="report_file" />
            <input type="hidden" name="old_report_file" value="<?php echo $cdata11['report_file'];?>" />
		<?php
		}
		else
		{?>
        <input type="file" name="report_file[]" id="report_file" multiple="multiple" /><div id="selectedFiles"></div>
		 <input type="hidden" name="old_report_file" value="" />
		<?php }	?>
        </td>
		</tr>
		
            <tr>
					  <td class="label" valign="top" ></td>
<td  valign="top" align="left">

<?php if(($cdata11['report_file']!="")||($cdata11['report_file']!=NULL)) {
?> <a href="<?php echo REPORT_URL.$cdata11['report_file']?>" ><img src="images/tag_small.png" border="0" /></a>
			<?php /*?><a onClick="return doConfirm('Are you sure you want to delete the Document?');" href="?p=upload_report&report_id=<?php echo $cdata11['report_id'];?>&mode=DoDelete&file_report=<?php echo urlencode($cdata11['report_file']);?>">Remove Document?</a><?php */?>
           <?php }?>                        </td>					  
	    </tr>
		<?php
		if(isset($cat_idm))
		{
		//$category_cd_n=$_GET['category_cd'];
	 $sqlssr="select category_status from rs_tbl_category where category_cd='$cat_idm'";
	$sqlrwssr=$objDb->dbCon->query($sqlssr);
	$sqlrw1ssr=$sqlrwssr->fetch();
	if($sqlrw1ssr['category_status']==1)
	{
		
		  /*if($user_type==1)
			 {*/
			 ?>
		<tr>
        <td>Status:</td>
        
        <td>
		<?php
		
		if($cdata11['report_status']=='')
		{
		$cdata11['report_status']='1';
		}
		?>
		 <select name="report_status">
		 <option value="1" <?php if($cdata11['report_status']=='1')echo "selected";?>>Initiated</option>
  		<option value="2" <?php if($cdata11['report_status']=='2')echo "selected";?>>Approved</option>
  		<option value="3" <?php if($cdata11['report_status']=='3')echo "selected";?>>Not Approved</option>
  		<option value="4" <?php if($cdata11['report_status']=='4')echo "selected";?>>Under Review</option>
 		 <option value="5" <?php if($cdata11['report_status']=='5')echo "selected";?>>Response Awaited</option>
		  <option value="7" <?php if($cdata11['report_status']=='7')echo "selected";?>>Responded</option>
          <option value="8" <?php if($cdata11['report_status']=='8')echo "selected";?>>For Information Only</option>
		</select>  </td>
        </tr>
		<?php
		/*}
		else
		{
		?>
		<input type="hidden" name="report_status" id="report_status"  Value="<?php echo $cdata11['report_status'];?>"/>
		<?php
		}*/
		}
		}
		?>
		
        <tr >
        <td colspan="2" align="center">
          
        <div id="div_button">
            <input type="submit" id="report_add" name="report_add" class="rr_button" value="<?php echo ($mode == "U") ? _BTN_UPDATE : _BTN_SAVE;?>" />
           
        </div>
        </td>
        </tr>
        </table>
            </div>
	</form>
	 <script>
    var selDiv = "";
        
    document.addEventListener("DOMContentLoaded", init, false);
    
    function init() {
        document.querySelector('#report_file').addEventListener('change', handleFileSelect, false);
        selDiv = document.querySelector("#selectedFiles");
    }
        
    function handleFileSelect(e) {
        
        if(!e.target.files) return;
        
        selDiv.innerHTML = "";
        
        var files = e.target.files;
		if(files.length>1)
		{
			for(var i=0; i<files.length; i++) {
				var f = files[i];
				
				selDiv.innerHTML += f.name + "<br/>";
	
			}
		}
        
    }
    </script>
	<div id="tableContainer2" class="table" style="border-left:1px;">
	</div>
	<div id="tableContainer1" class="table" style="border-left:1px;">
	
		
		</div>
 	 
	</div>

</body>
</html>
        