<?php
/**
*
* This is a class Image
* @version 0.01
* 
* @Date 28 Dec, 2007
* @modified 28 Dec, 2007 by 
*
**/
class Image extends Database{
	protected $image;
	protected $type;
	protected $size;
	protected $error;
	protected $path;
	protected $thumbs;
	
	public $filename;
	/*
	* This is the constructor of the class Image
	* 
	* @Date 28 Dec, 2007
	* @modified 28 Dec, 2007 by 
	*/
	public function __construct($path){
		parent::__construct();
		$this->path 	= $path;
		$this->thumbs 	= $path . "thumbs/";
		if(!is_dir($this->thumbs)){
			mkdir($this->thumbs);
			chmod($this->thumbs, 0777);
		}
	}

	/*
	* This method is used to set the image
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	public function setImage($image){
		$this->image 	= $image;
		$this->type 	= $this->image['type'];
		$this->size 	= $this->image['size'];
	}

	/*
	* This method is used to check whether the file is uploaded or not
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	public function isFileUploaded(){
		if(is_uploaded_file($this->image['tmp_name']))
			return true;
		else
			return false;
	}
	
	/*
	* This method is used to check the valid image type
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	public function isValidImage(){
		if(in_array($this->type, $this->validImage())){
			return true;
		}
		else{
			$this->error[] = 'Invalid image type.';
			return false;
		}
	}

	/*
	* This method is used to get filename
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	protected function genFilename($id,$name){
		$filen = $this->genRandom(5);
		$filen = $name . "-" . $id . "." . $this->getExtention();
		$this->filename = $filen;
		return $this->filename;
	}
	
	/*
	* This method is used to check the valid image type
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	public function uploadImage($id,$name){
		$this->filename = $this->genFilename($id,$name);
		if(move_uploaded_file($this->image['tmp_name'], $this->path . $this->filename)){
			return true;
		}
		else{
			$this->error[] = 'Ooops! Error in image uploading.';
			return false;
		}
	}

	/*
	* This method is used to check the valid image size
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	public function isValidSize($size = 1){
		$total = ($size * 1024 * 1024);
		if($this->size <= $total){
			return true;
		}
		else{
			$this->error[] = 'Invalid image size (max size is ' . $size . 'MB only).';
			return false;
		}
	}

	/*
	* This method is used to get the valid image types
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	private function validImage(){
		return array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png');
	}
	
	/*
	* This method is used to get image extension
	* @author 
	* @Date : 30 Dec, 2007
	* @modified : 30 Dec, 2007 by 
	* @return : bool
	*/
	function getExtention(){
		if($this->type == "image/jpeg" || $this->type == "image/jpg" || $this->type == "image/pjpeg")
			return "jpg";
		elseif($this->type == "image/png")
			return "png";
		elseif($this->type == "image/gif")
			return "gif";
		elseif($this->type == "application/pdf")
			return "pdf";
		elseif($this->type == "application/msword")
			return "doc";
		elseif($this->type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
			return "docx";
		elseif($this->type == "text/plain")
			return "txt";
		elseif($this->type == "application/vnd.ms-excel")
			return "xls";
		elseif($this->type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
			return "xlsx";
		elseif($this->type == "application/acad")
			return "dwg";
		elseif($this->type == "application/dxf")
			return "dxf";
    	elseif($this->type == "application/x-dwf")
			return "dwf";
	
elseif($this->type == "application/vnd.zzazz.deck+xml") return "zaz";
elseif($this->type == "application/vnd.handheld-entertainment+xml") return "zmm";
elseif($this->type == "application/zip") return "zip";
elseif($this->type == "application/vnd.zul") return "zir";
elseif($this->type == "application/yin+xml") return "yin";
elseif($this->type == "application/yang") return "yang";
elseif($this->type == "text/yaml") return "yaml";
elseif($this->type == "chemical/x-xyz") return "xyz";
elseif($this->type == "application/vnd.mozilla.xul+xml") return "xul";
elseif($this->type == "application/xspf+xml") return "xspf";
elseif($this->type == "application/x-xpinstall") return "xpi";
elseif($this->type == "application/xop+xml") return "xop";
elseif($this->type == "application/xslt+xml") return "xslt";
elseif($this->type == "application/resource-lists-diff+xml") return "rld";
elseif($this->type == "application/resource-lists+xml") return "rl";
elseif($this->type == "application/rls-services+xml") return "rs";
elseif($this->type == "application/patch-ops-error+xml") return "xer";
elseif($this->type == "application/xenc+xml") return "xenc";
elseif($this->type == "application/xcap-diff+xml") return "xdf";
elseif($this->type == "application/xml") return "xml";
elseif($this->type == "application/xhtml+xml") return "xhtml";
elseif($this->type == "application/x-xfig") return "fig";
elseif($this->type == "application/x-x509-ca-cert") return "der";
elseif($this->type == "image/x-xwindowdump") return "xwd";
elseif($this->type == "image/x-xpixmap") return "xpm";
elseif($this->type == "image/x-xbitmap") return "xbm";
elseif($this->type == "application/wsdl+xml") return "wsdl";
elseif($this->type == "application/vnd.wt.stf") return "stf";
elseif($this->type == "application/vnd.wordperfect") return "wpd";
elseif($this->type == "application/vnd.wap.wmlscriptc") return "wmlsc";
elseif($this->type == "text/vnd.wap.wmlscript") return "wmls";
elseif($this->type == "text/vnd.wap.wml") return "wml";
elseif($this->type == "application/winhlp") return "hlp";
elseif($this->type == "application/widget") return "wgt";
elseif($this->type == "application/vnd.webturbo") return "wtb";
elseif($this->type == "image/webp") return "webp";
elseif($this->type == "application/wspolicy+xml") return "wspolicy";
elseif($this->type == "application/x-font-woff") return "woff";
elseif($this->type == "application/davmount+xml") return "davmount";
elseif($this->type == "audio/x-wav") return "wav";
elseif($this->type == "image/vnd.wap.wbmp") return "wbmp";
elseif($this->type == "application/vnd.wap.wbxml") return "wbxml";
elseif($this->type == "application/x-wais-source") return "src";
elseif($this->type == "application/voicexml+xml") return "vxml";
elseif($this->type == "application/ccxml+xml,") return "ccxml";
elseif($this->type == "video/vnd.vivo") return "viv";
elseif($this->type == "application/vnd.visionary") return "vis";
elseif($this->type == "model/vnd.vtu") return "vtu";
elseif($this->type == "model/vnd.mts") return "mts";
elseif($this->type == "application/vnd.vcx") return "vcx";
elseif($this->type == "model/vrml") return "wrl";
elseif($this->type == "application/vnd.vsf") return "vsf";
elseif($this->type == "application/x-cdlink") return "vcd";
elseif($this->type == "text/x-vcard") return "vcf";
elseif($this->type == "text/x-vcalendar") return "vcs";
elseif($this->type == "text/x-uuencode") return "uu";
elseif($this->type == "application/x-ustar") return "ustar";
elseif($this->type == "application/vnd.uiq.theme") return "utz";
elseif($this->type == "text/uri-list") return "uri";
elseif($this->type == "application/vnd.ufdl") return "ufd";
elseif($this->type == "application/vnd.unity") return "unityweb";
elseif($this->type == "application/vnd.uoml+xml") return "uoml";
elseif($this->type == "application/vnd.umajin") return "umj";
elseif($this->type == "text/turtle") return "ttl";
elseif($this->type == "application/x-font-ttf") return "ttf";
elseif($this->type == "application/vnd.trueapp") return "tra";
elseif($this->type == "text/troff") return "t";
elseif($this->type == "application/vnd.triscape.mxs") return "mxs";
elseif($this->type == "application/vnd.trid.tpt") return "tpt";
elseif($this->type == "application/timestamped-data") return "tsd";
elseif($this->type == "application/vnd.spotfire.dxp") return "dxp";
elseif($this->type == "application/vnd.spotfire.sfs") return "sfs";
elseif($this->type == "application/tei+xml") return "tei";
elseif($this->type == "application/x-tex-tfm") return "tfm";
elseif($this->type == "application/x-tex") return "tex";
elseif($this->type == "application/x-tcl") return "tcl";
elseif($this->type == "application/x-tar") return "tar";
elseif($this->type == "application/vnd.tao.intent-module-archive") return "tao";
elseif($this->type == "image/tiff") return "tiff";
elseif($this->type == "text/tab-separated-values") return "tsv";
elseif($this->type == "application/sbml+xml") return "sbml";
elseif($this->type == "application/x-sv4crc") return "sv4crc";
elseif($this->type == "application/x-sv4cpio") return "sv4cpio";
elseif($this->type == "application/vnd.syncml.dm+wbxml") return "bdm";
elseif($this->type == "application/vnd.syncml.dm+xml") return "xdm";
elseif($this->type == "application/vnd.syncml+xml") return "xsm";
elseif($this->type == "application/smil+xml") return "smi";
elseif($this->type == "application/vnd.symbian.install") return "sis";
elseif($this->type == "application/vnd.wqd") return "wqd";
elseif($this->type == "audio/basic") return "au";
elseif($this->type == "application/vnd.olpc-sugar") return "xo";
elseif($this->type == "application/vnd.solent.sdkm+xml") return "sdkm";
elseif($this->type == "application/x-stuffit") return "sit";
elseif($this->type == "application/x-stuffitx") return "sitx";
elseif($this->type == "application/vnd.stepmania.stepchart") return "sm";
elseif($this->type == "application/vnd.stardivision.writer-global") return "sgl";
elseif($this->type == "application/vnd.stardivision.writer") return "sdw";
elseif($this->type == "application/vnd.stardivision.math") return "smf";
elseif($this->type == "application/vnd.stardivision.impress") return "sdd";
elseif($this->type == "application/vnd.stardivision.draw") return "sda";
elseif($this->type == "application/vnd.stardivision.calc") return "sdc";
elseif($this->type == "text/sgml") return "sgml";
elseif($this->type == "application/vnd.koan") return "skp";
elseif($this->type == "application/ssml+xml") return "ssml";
elseif($this->type == "application/srgs+xml") return "grxml";
elseif($this->type == "application/srgs") return "gram";
elseif($this->type == "application/sparql-results+xml") return "srx";
elseif($this->type == "application/sparql-query") return "rq";
elseif($this->type == "application/vnd.svd") return "svd";
elseif($this->type == "application/vnd.smart.teacher") return "teacher";
elseif($this->type == "application/vnd.yamaha.smaf-phrase") return "spf";
elseif($this->type == "application/vnd.smaf") return "mmf";
elseif($this->type == "application/vnd.yamaha.smaf-audio") return "saf";
elseif($this->type == "application/vnd.commonspace") return "csp";
elseif($this->type == "application/vnd.simtech-mindmapper") return "twd";
elseif($this->type == "application/vnd.accpac.simply.imp") return "imp";
elseif($this->type == "application/vnd.accpac.simply.aso") return "aso";
elseif($this->type == "application/vnd.epson.salt") return "slt";
elseif($this->type == "image/x-rgb") return "rgb";
elseif($this->type == "application/x-shar") return "shar";
elseif($this->type == "application/thraud+xml") return "tfi";
elseif($this->type == "application/vnd.shana.informed.formdata") return "ifm";
elseif($this->type == "application/vnd.shana.informed.formtemplate") return "itp";
elseif($this->type == "application/vnd.shana.informed.interchange") return "iif";
elseif($this->type == "application/vnd.shana.informed.package") return "ipk";
elseif($this->type == "video/x-sgi-movie") return "movie";
elseif($this->type == "text/x-setext") return "etx";
elseif($this->type == "application/sdp") return "sdp";
elseif($this->type == "application/scvp-cv-response") return "scs";
elseif($this->type == "application/scvp-cv-request") return "scq";
elseif($this->type == "application/scvp-vp-response") return "spp";
elseif($this->type == "application/scvp-vp-request") return "spq";
elseif($this->type == "application/x-font-snf") return "snf";
elseif($this->type == "application/vnd.seemail") return "see";
elseif($this->type == "application/vnd.sema") return "sema";
elseif($this->type == "application/vnd.semd") return "semd";
elseif($this->type == "application/vnd.semf") return "semf";
elseif($this->type == "application/set-registration-initiation") return "setreg";
elseif($this->type == "application/set-payment-initiation") return "setpay";
elseif($this->type == "application/sru+xml") return "sru";
elseif($this->type == "application/vnd.sus-calendar") return "sus";
elseif($this->type == "image/svg+xml") return "svg";
elseif($this->type == "application/vnd.sailingtracker.track") return "st";
elseif($this->type == "application/shf+xml") return "shf";
elseif($this->type == "application/rss+xml") return "rss, xml";
elseif($this->type == "application/vnd.route66.link66+xml") return "link66";
elseif($this->type == "text/richtext") return "rtx";
elseif($this->type == "application/rtf") return "rtf";
elseif($this->type == "application/vnd.jisp") return "jisp";
elseif($this->type == "application/vnd.cloanto.rp9") return "rp9";
elseif($this->type == "application/rdf+xml") return "rdf";
elseif($this->type == "application/vnd.data-vision.rdz") return "rdz";
elseif($this->type == "application/relax-ng-compact-syntax") return "rnc";
elseif($this->type == "application/vnd.recordare.musicxml") return "mxl";
elseif($this->type == "application/vnd.recordare.musicxml+xml") return "musicxml";
elseif($this->type == "application/vnd.realvnc.bed") return "bed";
elseif($this->type == "application/vnd.rn-realmedia") return "rm";
elseif($this->type == "application/rsd+xml") return "rsd";
elseif($this->type == "audio/x-pn-realaudio") return "ram";
elseif($this->type == "audio/x-pn-realaudio-plugin") return "rmp";
elseif($this->type == "application/x-rar-compressed") return "rar";
elseif($this->type == "video/quicktime") return "qt";
elseif($this->type == "application/vnd.intu.qfx") return "qfx";
elseif($this->type == "application/vnd.epson.quickanime") return "qam";
elseif($this->type == "application/vnd.epson.esf") return "esf";
elseif($this->type == "application/vnd.epson.msf") return "msf";
elseif($this->type == "application/vnd.epson.ssf") return "ssf";
elseif($this->type == "application/vnd.quark.quarkxpress") return "qxd";
elseif($this->type == "application/vnd.pmi.widget") return "wg";
elseif($this->type == "application/vnd.publishare-delta-tree") return "qps";
elseif($this->type == "application/x-font-linux-psf") return "psf";
elseif($this->type == "text/prs.lines.tag") return "dsc";
elseif($this->type == "application/vnd.pg.format") return "str";
elseif($this->type == "application/vnd.pg.osasli") return "ei6";
elseif($this->type == "application/pls+xml") return "pls";
elseif($this->type == "application/vnd.pvi.ptid1") return "ptid";
elseif($this->type == "application/vnd.previewsystems.box") return "box";
elseif($this->type == "application/pgp-signature") return "pgp";
elseif($this->type == "application/pgp-encrypted") return "";
elseif($this->type == "application/vnd.powerbuilder6") return "pbd";
elseif($this->type == "application/x-font-type1") return "pfa";
elseif($this->type == "application/postscript") return "ai";
elseif($this->type == "application/vnd.ctc-posml") return "pml";
elseif($this->type == "application/pskc+xml") return "pskcxml";
elseif($this->type == "image/x-portable-pixmap") return "ppm";
elseif($this->type == "image/x-portable-graymap") return "pgm";
elseif($this->type == "application/x-chess-pgn") return "pgn";
elseif($this->type == "application/font-tdpfr") return "pfr";
elseif($this->type == "application/x-font-pcf") return "pcf";
elseif($this->type == "image/x-portable-bitmap") return "pbm";
elseif($this->type == "image/x-portable-anymap") return "pnm";
elseif($this->type == "application/vnd.pocketlearn") return "plf";
elseif($this->type == "application/pkcs8") return "p8";
elseif($this->type == "application/x-pkcs7-certificates") return "p7b";
elseif($this->type == "application/x-pkcs7-certreqresp") return "p7r";
elseif($this->type == "application/pkcs7-mime") return "p7m";
elseif($this->type == "application/pkcs7-signature") return "p7s";
elseif($this->type == "application/x-pkcs12") return "p12";
elseif($this->type == "application/pkcs10") return "p10";
elseif($this->type == "application/x-chat") return "chat";
elseif($this->type == "image/x-pict") return "pic";
elseif($this->type == "application/pics-rules") return "prf";
elseif($this->type == "image/vnd.adobe.photoshop") return "psd";
elseif($this->type == "image/x-pcx") return "pcx";
elseif($this->type == "application/vnd.picsel") return "efif";
elseif($this->type == "application/vnd.hp-pclxl") return "pclxl";
elseif($this->type == "application/vnd.pawaafile") return "paw";
elseif($this->type == "text/x-pascal") return "p";
elseif($this->type == "application/vnd.palm") return "pdb";
elseif($this->type == "application/vnd.osgi.dp") return "dp";
elseif($this->type == "application/vnd.yamaha.openscoreformat.osfpvg+xml") return "osfpvg";
elseif($this->type == "application/x-font-otf") return "otf";
elseif($this->type == "application/vnd.sun.xml.writer.template") return "stw";
elseif($this->type == "application/vnd.sun.xml.writer") return "sxw";
elseif($this->type == "application/vnd.sun.xml.writer.global") return "sxg";
elseif($this->type == "application/vnd.sun.xml.math") return "sxm";
elseif($this->type == "application/vnd.sun.xml.impress.template") return "sti";
elseif($this->type == "application/vnd.sun.xml.impress") return "sxi";
elseif($this->type == "application/vnd.sun.xml.draw.template") return "std";
elseif($this->type == "application/vnd.sun.xml.draw") return "sxd";
elseif($this->type == "application/vnd.sun.xml.calc.template") return "stc";
elseif($this->type == "application/vnd.sun.xml.calc") return "sxc";
elseif($this->type == "image/ktx") return "ktx";
elseif($this->type == "application/vnd.oasis.opendocument.text-template") return "ott";
elseif($this->type == "application/vnd.oasis.opendocument.text-master") return "odm";
elseif($this->type == "application/vnd.oasis.opendocument.text") return "odt";
elseif($this->type == "application/vnd.oasis.opendocument.spreadsheet-template") return "ots";
elseif($this->type == "application/vnd.oasis.opendocument.spreadsheet") return "ods";
elseif($this->type == "application/vnd.oasis.opendocument.presentation-template") return "otp";
elseif($this->type == "application/vnd.oasis.opendocument.presentation") return "odp";
elseif($this->type == "application/vnd.oasis.opendocument.image-template") return "oti";
elseif($this->type == "application/vnd.oasis.opendocument.image") return "odi";
elseif($this->type == "application/vnd.oasis.opendocument.graphics-template") return "otg";
elseif($this->type == "application/vnd.oasis.opendocument.graphics") return "odg";
elseif($this->type == "application/vnd.oasis.opendocument.formula-template") return "odft";
elseif($this->type == "application/vnd.oasis.opendocument.formula") return "odf";
elseif($this->type == "application/vnd.oasis.opendocument.database") return "odb";
elseif($this->type == "application/vnd.oasis.opendocument.chart-template") return "otc";
elseif($this->type == "application/vnd.oasis.opendocument.chart") return "odc";
elseif($this->type == "video/webm") return "webm";
elseif($this->type == "audio/webm") return "weba";
elseif($this->type == "application/vnd.yamaha.openscoreformat") return "osf";
elseif($this->type == "application/vnd.openofficeorg.extension") return "oxt";
elseif($this->type == "application/vnd.intu.qbo") return "qbo";
elseif($this->type == "application/oebps-package+xml") return "opf";
elseif($this->type == "application/vnd.oasis.opendocument.text-web") return "oth";
elseif($this->type == "application/vnd.oma.dd2+xml") return "dd2";
elseif($this->type == "video/ogg") return "ogv";
elseif($this->type == "audio/ogg") return "oga";
elseif($this->type == "application/ogg") return "ogx";
elseif($this->type == "application/oda") return "oda";
elseif($this->type == "audio/vnd.nuera.ecelp9600") return "ecelp9600";
elseif($this->type == "audio/vnd.nuera.ecelp7470") return "ecelp7470";
elseif($this->type == "audio/vnd.nuera.ecelp4800") return "ecelp4800";
elseif($this->type == "application/vnd.flographit") return "gph";
elseif($this->type == "application/vnd.novadigm.edm") return "edm";
elseif($this->type == "application/vnd.novadigm.edx") return "edx";
elseif($this->type == "application/vnd.novadigm.ext") return "ext";
elseif($this->type == "text/n3") return "n3";
elseif($this->type == "application/vnd.nokia.radio-preset") return "rpst";
elseif($this->type == "application/vnd.nokia.radio-presets") return "rpss";
elseif($this->type == "application/vnd.noblenet-web") return "nnw";
elseif($this->type == "application/vnd.noblenet-sealer") return "nns";
elseif($this->type == "application/vnd.noblenet-directory") return "nnd";
elseif($this->type == "application/vnd.dna") return "dna";
elseif($this->type == "application/vnd.neurolanguage.nlu") return "nlu";
elseif($this->type == "application/x-netcdf") return "nc";
elseif($this->type == "application/x-dtbncx+xml") return "ncx";
elseif($this->type == "application/vnd.nokia.n-gage.symbian.install") return "n-gage";
elseif($this->type == "application/vnd.nokia.n-gage.data") return "ngdat";
elseif($this->type == "application/xv+xml") return "mxml";
elseif($this->type == "application/vnd.muvee.style") return "msty";
elseif($this->type == "application/vnd.musician") return "mus";
elseif($this->type == "application/vnd.apple.mpegurl") return "m3u8";
elseif($this->type == "application/mp4") return "mp4";
elseif($this->type == "video/mp4") return "mp4";
elseif($this->type == "audio/mp4") return "mp4a";
elseif($this->type == "application/mp21") return "m21";
elseif($this->type == "video/mpeg") return "mpeg";
elseif($this->type == "video/vnd.mpegurl") return "mxu";
elseif($this->type == "audio/mpeg") return "mpga";
elseif($this->type == "video/mj2") return "mj2";
elseif($this->type == "application/vnd.mophun.application") return "mpn";
elseif($this->type == "application/vnd.mophun.certificate") return "mpc";
elseif($this->type == "text/vnd.fly") return "fly";
elseif($this->type == "application/vnd.mobius.daf") return "daf";
elseif($this->type == "application/vnd.mobius.txf") return "txf";
elseif($this->type == "application/vnd.mobius.msl") return "msl";
elseif($this->type == "application/vnd.mobius.mqy") return "mqy";
elseif($this->type == "application/vnd.mobius.plc") return "plc";
elseif($this->type == "application/vnd.mobius.dis") return "dis";
elseif($this->type == "application/vnd.mobius.mbk") return "mbk";
elseif($this->type == "application/x-mobipocket-ebook") return "prc";
elseif($this->type == "application/vnd.tmobile-livetv") return "tmo";
elseif($this->type == "application/vnd.jcp.javame.midlet-rms") return "rms";
elseif($this->type == "application/vnd.ibm.modcap") return "afp";
elseif($this->type == "application/vnd.ibm.minipay") return "mpy";
elseif($this->type == "audio/midi") return "mid";
elseif($this->type == "application/vnd.ms-xpsdocument") return "xps";
elseif($this->type == "application/x-ms-xbap") return "xbap";
elseif($this->type == "application/vnd.ms-works") return "wps";
elseif($this->type == "application/x-mswrite") return "wri";
elseif($this->type == "application/x-msterminal") return "trm";
elseif($this->type == "application/x-msmetafile") return "wmf";
elseif($this->type == "video/x-ms-wvx") return "wvx";
elseif($this->type == "video/x-ms-wmv") return "wmv";
elseif($this->type == "application/x-ms-wmz") return "wmz";
elseif($this->type == "application/vnd.ms-wpl") return "wpl";
elseif($this->type == "application/x-ms-wmd") return "wmd";
elseif($this->type == "video/x-ms-wmx") return "wmx";
elseif($this->type == "audio/x-ms-wax") return "wax";
elseif($this->type == "audio/x-ms-wma") return "wma";
elseif($this->type == "video/x-ms-wm") return "wm";
elseif($this->type == "application/vnd.visio") return "vsd";
elseif($this->type == "application/vnd.ms-pki.seccat") return "cat";
elseif($this->type == "application/vnd.ms-pki.stl") return "stl";
elseif($this->type == "application/x-silverlight-app") return "xap";
elseif($this->type == "application/x-msschedule") return "scd";
elseif($this->type == "application/x-mspublisher") return "pub";
elseif($this->type == "application/vnd.ms-project") return "mpp";
elseif($this->type == "application/vnd.ms-powerpoint.slideshow.macroenabled.12") return "ppsm";
elseif($this->type == "application/vnd.ms-powerpoint.presentation.macroenabled.12") return "pptm";
elseif($this->type == "application/vnd.ms-powerpoint.slide.macroenabled.12") return "sldm";
elseif($this->type == "application/vnd.ms-powerpoint.addin.macroenabled.12") return "ppam";
elseif($this->type == "application/vnd.ms-powerpoint") return "ppt";
elseif($this->type == "video/vnd.ms-playready.media.pyv") return "pyv";
elseif($this->type == "audio/vnd.ms-playready.media.pya") return "pya";
elseif($this->type == "application/onenote") return "onetoc";
elseif($this->type == "application/vnd.ms-officetheme") return "thmx";
elseif($this->type == "application/x-msbinder") return "obd";
elseif($this->type == "application/vnd.openxmlformats-officedocument.wordprocessingml.template") return "dotx";
elseif($this->type == "application/vnd.openxmlformats-officedocument.spreadsheetml.template") return "xltx";
elseif($this->type == "application/vnd.openxmlformats-officedocument.presentationml.template") return "potx";
elseif($this->type == "application/vnd.openxmlformats-officedocument.presentationml.slideshow") return "ppsx";
elseif($this->type == "application/vnd.openxmlformats-officedocument.presentationml.slide") return "sldx";
elseif($this->type == "application/vnd.openxmlformats-officedocument.presentationml.presentation") return "pptx";
elseif($this->type == "application/x-msmoney") return "mny";
elseif($this->type == "application/x-msmediaview") return "mvb";
elseif($this->type == "application/vnd.ms-lrm") return "lrm";
elseif($this->type == "application/x-mscardfile") return "crd";
elseif($this->type == "application/vnd.ms-htmlhelp") return "chm";
elseif($this->type == "application/vnd.ms-excel.sheet.macroenabled.12") return "xlsm";
elseif($this->type == "application/vnd.ms-excel.template.macroenabled.12") return "xltm";
elseif($this->type == "application/vnd.ms-excel.sheet.binary.macroenabled.12") return "xlsb";
elseif($this->type == "application/vnd.ms-excel.addin.macroenabled.12") return "xlam";
elseif($this->type == "application/vnd.ms-fontobject") return "eot";
elseif($this->type == "image/vnd.ms-modi") return "mdi";
elseif($this->type == "application/x-msclip") return "clp";
elseif($this->type == "application/x-ms-application") return "application";
elseif($this->type == "application/vnd.ms-ims") return "ims";
elseif($this->type == "application/vnd.ms-cab-compressed") return "cab";
elseif($this->type == "application/vnd.ms-artgalry") return "cil";
elseif($this->type == "application/x-msdownload") return "exe";
elseif($this->type == "video/x-ms-asf") return "asf";
elseif($this->type == "application/x-msaccess") return "mdb";
elseif($this->type == "application/vnd.eszigno3+xml") return "es3";
elseif($this->type == "application/vnd.micrografx.igx") return "igx";
elseif($this->type == "application/vnd.micrografx.flo") return "flo";
elseif($this->type == "application/vnd.mcd") return "mcd";
elseif($this->type == "application/vnd.ms-word.template.macroenabled.12") return "dotm";
elseif($this->type == "application/vnd.ms-word.document.macroenabled.12") return "docm";
elseif($this->type == "application/vnd.ms-powerpoint.template.macroenabled.12") return "potm";
elseif($this->type == "application/metalink4+xml") return "meta4";
elseif($this->type == "application/mods+xml") return "mods";
elseif($this->type == "application/mets+xml") return "mets";
elseif($this->type == "application/mads+xml") return "mads";
elseif($this->type == "model/mesh") return "msh";
elseif($this->type == "application/vnd.mfmp") return "mfm";
elseif($this->type == "application/vnd.mfer") return "mwf";
elseif($this->type == "application/vnd.mediastation.cdkey") return "cdkey";
elseif($this->type == "application/mediaservercontrol+xml") return "mscml";
elseif($this->type == "application/vnd.medcalcdata") return "mc1";
elseif($this->type == "application/mbox") return "mbox";
elseif($this->type == "application/mathml+xml") return "mathml";
elseif($this->type == "application/mathematica") return "ma";
elseif($this->type == "application/vnd.wolfram.player") return "nbp";
elseif($this->type == "application/mxf") return "mxf";
elseif($this->type == "application/marcxml+xml") return "mrcx";
elseif($this->type == "application/marc") return "mrc";
elseif($this->type == "application/vnd.osgeo.mapguide.package") return "mgp";
elseif($this->type == "application/vnd.macports.portpkg") return "portpkg";
elseif($this->type == "application/mac-binhex40") return "hqx";
elseif($this->type == "video/x-m4v") return "m4v";
elseif($this->type == "audio/x-mpegurl") return "m3u";
elseif($this->type == "audio/vnd.lucent.voice") return "lvp";
elseif($this->type == "application/vnd.lotus-wordpro") return "lwp";
elseif($this->type == "application/vnd.lotus-screencam") return "scm";
elseif($this->type == "application/vnd.lotus-organizer") return "org";
elseif($this->type == "application/vnd.lotus-notes") return "nsf";
elseif($this->type == "application/vnd.lotus-freelance") return "pre";
elseif($this->type == "application/vnd.lotus-approach") return "apr";
elseif($this->type == "application/vnd.lotus-1-2-3") return "123";
elseif($this->type == "application/vnd.jam") return "jam";
elseif($this->type == "application/vnd.llamagraphics.life-balance.exchange+xml") return "lbe";
elseif($this->type == "application/vnd.llamagraphics.life-balance.desktop") return "lbd";
elseif($this->type == "application/x-latex") return "latex";
elseif($this->type == "application/vnd.las.las+xml") return "lasxml";
elseif($this->type == "application/vnd.kodak-descriptor") return "sse";
elseif($this->type == "application/vnd.kinar") return "kne";
elseif($this->type == "application/vnd.kidspiration") return "kia";
elseif($this->type == "application/vnd.kenameaapp") return "htke";
elseif($this->type == "application/vnd.kde.kword") return "kwd";
elseif($this->type == "application/vnd.kde.kspread") return "ksp";
elseif($this->type == "application/vnd.kde.kpresenter") return "kpr";
elseif($this->type == "application/vnd.kde.kontour") return "kon";
elseif($this->type == "application/vnd.kde.kivio") return "flw";
elseif($this->type == "application/vnd.kde.kformula") return "kfo";
elseif($this->type == "application/vnd.kde.kchart") return "chrt";
elseif($this->type == "application/vnd.kde.karbon") return "karbon";
elseif($this->type == "application/vnd.chipnuts.karaoke-mmd") return "mmd";
elseif($this->type == "application/vnd.kahootz") return "ktz";
elseif($this->type == "video/jpeg") return "jpgv";
elseif($this->type == "video/jpm") return "jpm";
elseif($this->type == "application/vnd.joost.joda-archive") return "joda";
elseif($this->type == "application/json") return "json";
elseif($this->type == "application/javascript") return "js";
elseif($this->type == "text/x-java-source,java") return "java";
elseif($this->type == "application/java-serialized-object") return "ser";
elseif($this->type == "application/x-java-jnlp-file") return "jnlp";
elseif($this->type == "application/java-vm") return "class";
elseif($this->type == "application/java-archive") return "jar";
elseif($this->type == "text/vnd.sun.j2me.app-descriptor") return "jad";
elseif($this->type == "application/vnd.irepository.package+xml") return "irp";
elseif($this->type == "application/vnd.ipunplugged.rcprofile") return "rcprofile";
elseif($this->type == "application/vnd.insors.igm") return "igm";
elseif($this->type == "application/pkix-pkipath") return "pkipath";
elseif($this->type == "application/pkix-crl") return "crl";
elseif($this->type == "application/pkixcmp") return "pki";
elseif($this->type == "application/pkix-cert") return "cer";
elseif($this->type == "application/ipfix") return "ipfix";
elseif($this->type == "application/vnd.isac.fcs") return "fcs";
elseif($this->type == "application/vnd.intercon.formnet") return "xpw";
elseif($this->type == "application/vnd.cinderella") return "cdy";
elseif($this->type == "application/vnd.intergeo") return "i2g";
elseif($this->type == "model/iges") return "igs";
elseif($this->type == "text/vnd.in3d.3dml") return "3dml";
elseif($this->type == "text/vnd.in3d.spot") return "spot";
elseif($this->type == "application/reginfo+xml") return "rif";
elseif($this->type == "application/vnd.immervision-ivp") return "ivp";
elseif($this->type == "application/vnd.immervision-ivu") return "ivu";
elseif($this->type == "image/ief") return "ief";
elseif($this->type == "application/vnd.igloader") return "igl";
elseif($this->type == "image/x-icon") return "ico";
elseif($this->type == "application/vnd.iccprofile") return "icc";
elseif($this->type == "text/calendar") return "ics";
elseif($this->type == "application/vnd.ibm.secure-container") return "sc";
elseif($this->type == "application/vnd.ibm.rights-management") return "irm";
elseif($this->type == "text/html") return "html";
elseif($this->type == "application/vnd.hal+xml") return "hal";
elseif($this->type == "application/hyperstudio") return "stk";
elseif($this->type == "application/vnd.hydrostatix.sof-data") return "sfd-hdstx";
elseif($this->type == "application/vnd.yamaha.hv-voice") return "hvp";
elseif($this->type == "application/vnd.yamaha.hv-dic") return "hvd";
elseif($this->type == "application/vnd.yamaha.hv-script") return "hvs";
elseif($this->type == "application/vnd.hp-hpgl") return "hpgl";
elseif($this->type == "application/vnd.hp-pcl") return "pcl";
elseif($this->type == "application/vnd.hp-jlyt") return "jlt";
elseif($this->type == "application/vnd.hbci") return "hbci";
elseif($this->type == "audio/vnd.rip") return "rip";
elseif($this->type == "application/x-hdf") return "hdf";
elseif($this->type == "application/vnd.hp-hps") return "hps";
elseif($this->type == "application/vnd.hp-hpid") return "hpid";
elseif($this->type == "video/h264") return "h264";
elseif($this->type == "video/h263") return "h263";
elseif($this->type == "video/h261") return "h261";
elseif($this->type == "application/vnd.groove-vcard") return "vcg";
elseif($this->type == "application/vnd.groove-tool-template") return "tpl";
elseif($this->type == "application/vnd.groove-tool-message") return "gtm";
elseif($this->type == "application/vnd.groove-injector") return "grv";
elseif($this->type == "application/vnd.groove-identity-message") return "gim";
elseif($this->type == "application/vnd.groove-help") return "ghf";
elseif($this->type == "application/vnd.groove-account") return "gac";
elseif($this->type == "text/vnd.graphviz") return "gv";
elseif($this->type == "application/vnd.grafeq") return "gqf";
elseif($this->type == "application/vnd.google-earth.kmz") return "kmz";
elseif($this->type == "application/vnd.google-earth.kml+xml") return "kml";
elseif($this->type == "application/x-gnumeric") return "gnumeric";
elseif($this->type == "application/x-texinfo") return "texinfo";
elseif($this->type == "application/x-gtar") return "gtar";
elseif($this->type == "application/x-font-bdf") return "bdf";
elseif($this->type == "application/x-font-ghostscript") return "gsf";
elseif($this->type == "application/vnd.geospace") return "g3w";
elseif($this->type == "application/vnd.geoplan") return "g2w";
elseif($this->type == "application/vnd.geonext") return "gxt";
elseif($this->type == "application/vnd.geometry-explorer") return "gex";
elseif($this->type == "model/vnd.gdl") return "gdl";
elseif($this->type == "application/vnd.geogebra.file") return "ggb";
elseif($this->type == "application/vnd.geogebra.tool") return "ggt";
elseif($this->type == "application/vnd.genomatix.tuxedo") return "txd";
elseif($this->type == "model/vnd.gtw") return "gtw";
elseif($this->type == "application/vnd.gmx") return "gmx";
elseif($this->type == "image/g3fax") return "g3";
elseif($this->type == "application/vnd.fuzzysheet") return "fzs";
elseif($this->type == "application/x-futuresplash") return "spl";
elseif($this->type == "application/vnd.fujitsu.oasys") return "oas";
elseif($this->type == "application/vnd.fujitsu.oasys2") return "oa2";
elseif($this->type == "application/vnd.fujitsu.oasys3") return "oa3";
elseif($this->type == "application/vnd.fujitsu.oasysgp") return "fg5";
elseif($this->type == "application/vnd.fujitsu.oasysprs") return "bh2";
elseif($this->type == "application/vnd.fujixerox.docuworks.binder") return "xbd";
elseif($this->type == "application/vnd.fujixerox.docuworks") return "xdw";
elseif($this->type == "application/vnd.fujixerox.ddd") return "ddd";
elseif($this->type == "application/vnd.frogans.fnc") return "fnc";
elseif($this->type == "application/vnd.frogans.ltf") return "ltf";
elseif($this->type == "application/vnd.fsc.weblaunch") return "fsc";
elseif($this->type == "image/x-freehand") return "fh";
elseif($this->type == "application/vnd.framemaker") return "fm";
elseif($this->type == "application/vnd.mif") return "mif";
elseif($this->type == "text/x-fortran") return "f";
elseif($this->type == "application/vnd.fdf") return "fdf";
elseif($this->type == "application/vnd.fluxtime.clip") return "ftc";
elseif($this->type == "video/x-fli") return "fli";
elseif($this->type == "text/vnd.fmi.flexstor") return "flx";
elseif($this->type == "image/vnd.fpx") return "fpx";
elseif($this->type == "image/vnd.net-fpx") return "npx";
elseif($this->type == "video/x-f4v") return "f4v";
elseif($this->type == "video/x-flv") return "flv";
elseif($this->type == "application/vnd.denovo.fcselayout-link") return "fe_launch";
elseif($this->type == "image/vnd.fastbidsheet") return "fbs";
elseif($this->type == "image/vnd.fst") return "fst";
elseif($this->type == "video/vnd.fvt") return "fvt";
elseif($this->type == "application/vnd.ezpix-album") return "ez2";
elseif($this->type == "application/vnd.ezpix-package") return "ez3";
elseif($this->type == "application/emma+xml") return "emma";
elseif($this->type == "application/vnd.xfdl") return "xfdl";
elseif($this->type == "image/vnd.xiff") return "xif";
elseif($this->type == "application/vnd.is-xpr") return "xpr";
elseif($this->type == "application/vnd.enliven") return "nml";
elseif($this->type == "message/rfc822") return "eml";
elseif($this->type == "application/epub+zip") return "epub";
elseif($this->type == "application/vnd.proteus.magazine") return "mgz";
elseif($this->type == "application/exi") return "exi";
elseif($this->type == "image/vnd.fujixerox.edmics-mmr") return "mmr";
elseif($this->type == "image/vnd.fujixerox.edmics-rlc") return "rlc";
elseif($this->type == "application/vnd.ecowin.chart") return "mag";
elseif($this->type == "application/ecmascript") return "es";
elseif($this->type == "application/vnd.dynageo") return "geo";
elseif($this->type == "image/vnd.dwg") return "dwg";
elseif($this->type == "audio/vnd.dts.hd") return "dtshd";
elseif($this->type == "audio/vnd.dts") return "dts";
elseif($this->type == "application/vnd.dreamfactory") return "dfac";
elseif($this->type == "audio/vnd.dra") return "dra";
elseif($this->type == "application/vnd.dpgraph") return "dpg";
elseif($this->type == "application/x-doom") return "wad";
elseif($this->type == "application/vnd.dolby.mlp") return "mlp";
elseif($this->type == "application/xml-dtd") return "dtd";
elseif($this->type == "image/vnd.djvu") return "djvu";
elseif($this->type == "audio/vnd.digital-winds") return "eol";
elseif($this->type == "application/vnd.dvb.ait") return "ait";
elseif($this->type == "application/vnd.dvb.service") return "svc";
elseif($this->type == "application/x-dtbresource+xml") return "res";
elseif($this->type == "application/x-dtbook+xml") return "dtb";
elseif($this->type == "application/vnd.fdsn.seed") return "seed";
elseif($this->type == "application/x-dvi") return "dvi";
elseif($this->type == "video/vnd.dece.video") return "uvv";
elseif($this->type == "video/vnd.dece.sd") return "uvs";
elseif($this->type == "video/vnd.dece.pd") return "uvp";
elseif($this->type == "video/vnd.uvvu.mp4") return "uvu";
elseif($this->type == "video/vnd.dece.mobile") return "uvm";
elseif($this->type == "video/vnd.dece.hd") return "uvh";
elseif($this->type == "image/vnd.dece.graphic") return "uvi";
elseif($this->type == "audio/vnd.dece.audio") return "uva";
elseif($this->type == "application/x-debian-package") return "deb";
elseif($this->type == "application/dssc+der") return "dssc";
elseif($this->type == "application/dssc+xml") return "xdssc";
elseif($this->type == "application/vnd.yellowriver-custom-menu") return "cmp";
elseif($this->type == "application/vnd.curl.car") return "car";
elseif($this->type == "application/vnd.curl.pcurl") return "pcurl";
elseif($this->type == "text/vnd.curl.scurl") return "scurl";
elseif($this->type == "text/vnd.curl.mcurl") return "mcurl";
elseif($this->type == "text/vnd.curl.dcurl") return "dcurl";
elseif($this->type == "text/vnd.curl") return "curl";
elseif($this->type == "application/prs.cww") return "cww";
elseif($this->type == "application/cu-seeme") return "cu";
elseif($this->type == "chemical/x-cmdf") return "cmdf";
elseif($this->type == "chemical/x-cif") return "cif";
elseif($this->type == "application/vnd.rig.cryptonote") return "cryptonote";
elseif($this->type == "application/vnd.criticaltools.wbs+xml") return "wbs";
elseif($this->type == "application/vnd.crick.clicker.wordbank") return "clkw";
elseif($this->type == "application/vnd.crick.clicker.template") return "clkt";
elseif($this->type == "application/vnd.crick.clicker.palette") return "clkp";
elseif($this->type == "application/vnd.crick.clicker.keyboard") return "clkk";
elseif($this->type == "application/vnd.crick.clicker") return "clkx";
elseif($this->type == "application/x-cpio") return "cpio";
elseif($this->type == "application/vnd.cosmocaller") return "cmc";
elseif($this->type == "application/vnd.xara") return "xar";
elseif($this->type == "image/x-cmx") return "cmx";
elseif($this->type == "x-conference/x-cooltalk") return "ice";
elseif($this->type == "image/cgm") return "cgm";
elseif($this->type == "application/vnd.wap.wmlc") return "wmlc";
elseif($this->type == "application/mac-compactpro") return "cpt";
elseif($this->type == "text/csv") return "csv";
elseif($this->type == "model/vnd.collada+xml") return "dae";
elseif($this->type == "image/x-cmu-raster") return "ras";
elseif($this->type == "application/vnd.cluetrust.cartomobile-config-pkg") return "c11amz";
elseif($this->type == "application/vnd.cluetrust.cartomobile-config") return "c11amc";
elseif($this->type == "application/cdmi-queue") return "cdmiq";
elseif($this->type == "application/cdmi-object") return "cdmio";
elseif($this->type == "application/cdmi-domain") return "cdmid";
elseif($this->type == "application/cdmi-container") return "cdmic";
elseif($this->type == "application/cdmi-capability") return "cdmia";
elseif($this->type == "image/vnd.dvb.subtitle") return "sub";
elseif($this->type == "application/vnd.clonk.c4group") return "c4g";
elseif($this->type == "application/vnd.claymore") return "cla";
elseif($this->type == "application/vnd.contact.cmsg") return "cdbcmsg";
elseif($this->type == "chemical/x-csml") return "csml";
elseif($this->type == "chemical/x-cml") return "cml";
elseif($this->type == "chemical/x-cdx") return "cdx";
elseif($this->type == "text/css") return "css";
elseif($this->type == "application/vnd.chemdraw+xml") return "cdxml";
elseif($this->type == "text/x-c") return "c";
elseif($this->type == "application/x-csh") return "csh";
elseif($this->type == "application/x-bzip2") return "bz2";
elseif($this->type == "application/x-bzip") return "bz";
elseif($this->type == "application/vnd.businessobjects") return "rep";
elseif($this->type == "image/prs.btif") return "btif";
elseif($this->type == "application/x-sh") return "sh";
elseif($this->type == "application/vnd.bmi") return "bmi";
elseif($this->type == "application/vnd.blueice.multipass") return "mpm";
elseif($this->type == "application/vnd.rim.cod") return "cod";
elseif($this->type == "application/x-bittorrent") return "torrent";
elseif($this->type == "image/bmp") return "bmp";
//elseif($this->type == "application/octet-stream") return "rar";
elseif($this->type == "application/octet-stream") return "bin";
elseif($this->type == "application/x-bcpio") return "bcpio";
elseif($this->type == "text/plain-bas") return "par";
elseif($this->type == "model/vnd.dwf") return "dwf";
elseif($this->type == "image/vnd.dxf") return "dxf";
elseif($this->type == "application/vnd.audiograph") return "aep";
elseif($this->type == "video/x-msvideo") return "avi";
elseif($this->type == "audio/x-aiff") return "aif";
elseif($this->type == "application/pkix-attr-cert") return "ac";
elseif($this->type == "application/atom+xml") return "atom, xml";
elseif($this->type == "application/atomsvc+xml") return "atomsvc";
elseif($this->type == "application/atomcat+xml") return "atomcat";
elseif($this->type == "text/x-asm") return "s";
elseif($this->type == "application/vnd.aristanetworks.swi") return "swi";
elseif($this->type == "application/vnd.hhe.lesson-player") return "les";
elseif($this->type == "application/applixware") return "aw";
elseif($this->type == "application/vnd.apple.installer+xml") return "mpkg";
elseif($this->type == "application/vnd.antix.game-component") return "atx";
elseif($this->type == "application/vnd.anser-web-funds-transfer-initiation") return "fti";
elseif($this->type == "application/vnd.anser-web-certificate-issue-initiation") return "cii";
elseif($this->type == "application/vnd.android.package-archive") return "apk";
elseif($this->type == "application/andrew-inset") return "N/A";
elseif($this->type == "application/vnd.amiga.ami") return "ami";
elseif($this->type == "application/vnd.amazon.ebook") return "azw";
elseif($this->type == "application/vnd.airzip.filesecure.azf") return "azf";
elseif($this->type == "application/vnd.airzip.filesecure.azs") return "azs";
elseif($this->type == "application/vnd.ahead.space") return "ahead";
elseif($this->type == "audio/x-aac") return "aac";
elseif($this->type == "application/vnd.adobe.xfdf") return "xfdf";
elseif($this->type == "application/vnd.adobe.xdp+xml") return "xdp";
elseif($this->type == "application/x-director") return "dir";
elseif($this->type == "application/vnd.cups-ppd") return "ppd";
elseif($this->type == "application/vnd.adobe.fxp") return "fxp";
elseif($this->type == "application/x-shockwave-flash") return "swf";
elseif($this->type == "application/vnd.adobe.air-application-installer-package+zip") return "air";
elseif($this->type == "application/x-authorware-seg") return "aas";
elseif($this->type == "application/x-authorware-map") return "aam";
elseif($this->type == "application/x-authorware-bin") return "aab";
elseif($this->type == "audio/adpcm") return "adp";
elseif($this->type == "application/vnd.acucobol") return "acu";
elseif($this->type == "application/vnd.acucorp") return "atc";
elseif($this->type == "application/vnd.americandynamics.acc") return "acc";
elseif($this->type == "application/x-ace-compressed") return "ace";
elseif($this->type == "application/x-abiword") return "abw";
elseif($this->type == "application/x-7z-compressed") return "7z";
elseif($this->type == "application/vnd.3gpp2.tcap") return "tcap";
elseif($this->type == "application/vnd.3gpp.pic-bw-var") return "pvb";
elseif($this->type == "application/vnd.3gpp.pic-bw-small") return "psb";
elseif($this->type == "application/vnd.3gpp.pic-bw-large") return "plb";
elseif($this->type == "application/vnd.3m.post-it-notes") return "pwn";
elseif($this->type == "application/vnd.mseq") return "mseq";
elseif($this->type == "video/3gpp2") return "3g2";
elseif($this->type == "video/3gpp") return "3gp";
elseif($this->type == "application/vnd.hzn-3d-crossword") return "x3d";
	
	}
	
	/*
	* This method is used to get some random characters
	* @author 
	* @Date 30 Dec, 2007
	* @modified 30 Dec, 2007 by 
	*/
	function genRandom($char = 5){
		$md5 = md5(time());
		return substr($md5, rand(5, 25), $char);
	}

	/*
	* This method is used to create thumbnail of an image.
	* @author 
	* @Date : 22 Dec, 2007
	* @modified :  22 Dec, 2007 by 
	* @return : bool
	*/
	public function createThumb($rW, $rH, $do = "thumbs"){
		if($do == "resize")
			$image_path = $this->path . $this->filename;
		else
			$image_path = $this->thumbs . $this->filename;
		if($this->type == "image/gif"){
			$im 			= imagecreatefromgif($this->path . $this->filename);
			$width 			= imagesx($im);
			$height 		= imagesy($im);
			
			#$n_width		= ($width > $rW) ? $rW : $width;
			#$n_height		= ($height > $rH) ? $rH : $height;
			
			if($width > $rW){
				$diff 			= $width - $rW;
				$n_width 		= $rW;
				$per 			= number_format(($diff * 100) / $width, 2);
				$n_height 		= $height - (int)(($height * $per) / 100);
			}
			else{
				$n_width		= $width;
				$n_height		= $height;
			}
			
			$canvas 		= imagecreatetruecolor($n_width, $n_height);
			imagecopyresized($canvas, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
			if(function_exists("imagegif")){
				imagegif($canvas, $image_path);
			}
			elseif(function_exists("imagejpeg")){
				imagejpeg($canvas, $image_path);
			}
			chmod($image_path, 0777);
		}
		if($this->type == "image/pjpeg" || $this->type == "image/jpeg" || $this->type == "image/jpg"){
			$im 			= imagecreatefromjpeg($this->path . $this->filename);
			$width 			= imagesx($im);
			$height 		= imagesy($im);
			if($width > $rW){
				$diff 			= $width - $rW;
				$n_width 		= $rW;
				$per 			= number_format(($diff * 100) / $width, 2);
				$n_height 		= $height - (int)(($height * $per) / 100);
			}
			else{
				$n_width		= $width;
				$n_height		= $height;
			}
			$canvas 		= imagecreatetruecolor($n_width, $n_height);                 
			imagecopyresized($canvas, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
			imagejpeg($canvas, $image_path);
			chmod($image_path, 0777);
		}
		if($this->type == "image/png"){
			$im 			= imagecreatefrompng($this->path . $this->filename); 
			$width 			= imagesx($im);
			$height 		= imagesy($im);
			if($width > $rW){
				$diff 			= $width - $rW;
				$n_width 		= $rW;
				$per 			= number_format(($diff * 100) / $width, 2);
				$n_height 		= $height - (int)(($height * $per) / 100);
			}
			else{
				$n_width		= $width;
				$n_height		= $height;
			}
			$canvas 		= imagecreatetruecolor($n_width, $n_height);                 
			imagecopyresized($canvas, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
			imagepng($canvas, $image_path);
			chmod($image_path, 0777);
		}
		@imagedestroy($im);
		@imagedestroy($canvas);
	}

	/*
	* This method is used to crop the image
	* @author 
	* @Date : 30 Dec, 2007
	* @modified :  30 Dec, 2007 by 
	* @return : bool
	*/
	public function cropImage($rW, $rH, $image_path){
		if(file_exists($image_path)){
			$size		= getimagesize($image_path);
			$this->type = $size['mime'];
		}
		else{
			$image_path = $this->path . $this->filename;
		}
		$canvas = imagecreatetruecolor($rW, $rH);
		
		if($this->type == "image/gif"){
			$im 			= imagecreatefromgif($image_path);
			$width 			= imagesx($im);
			$height 		= imagesy($im);

			$n_width 		= $width / 2;
			$n_height 		= $height / 2;
			
			$cropLeft 		= ($n_width / 2) - ($rW / 2);
			$cropTop 		= ($n_height / 2) - ($rH / 2);

			imagecopyresized($canvas, $im, 0, 0, $cropLeft, $cropTop, $rW, $rH, $n_width, $n_height);
			if(function_exists("imagegif")) {
				header("Content-type: image/gif");
				imagegif($canvas, $this->thumbs . $this->filename);
			}
			elseif(function_exists("imagejpeg")) {
				header("Content-type: image/jpeg");
				imagejpeg($canvas, $image_path, 90);
			}
			chmod($image_path, 0777);
		}
		if($this->type == "image/pjpeg" || $this->type == "image/jpeg" || $this->type == "image/jpg"){
			$im 			= imagecreatefromjpeg($image_path);
			$width 			= imagesx($im);
			$height 		= imagesy($im);

			$n_width 		= $width / 2;
			$n_height 		= $height / 2;
			
			$cropLeft 		= ($n_width / 2) - ($rW / 2);
			$cropTop 		= ($n_height / 2) - ($rH / 2);

			imagecopyresized($canvas, $im, 0, 0, $cropLeft, $cropTop, $rW, $rH, $n_width, $n_height);
			imagejpeg($canvas, $image_path, 90);
			chmod($image_path, 0777);
		}
		if($this->type == "image/png"){
			$im 			= imagecreatefrompng($image_path); 
			$width 			= imagesx($im);
			$height 		= imagesy($im);

			$n_width 		= $width / 2;
			$n_height 		= $height / 2;
			
			$cropLeft 		= ($n_width / 2) - ($rW / 2);
			$cropTop 		= ($n_height / 2) - ($rH / 2);

			imagecopyresized($canvas, $im, 0, 0, $cropLeft, $cropTop, $rW, $rH, $n_width, $n_height);
			imagepng($canvas, $image_path);
			chmod($image_path, 0777);
		}
		@imagedestroy($im);
		@imagedestroy($canvas);
	}
	
	/*
	* This method is used to return all the errors that occured during image upload.
	* @author 
	* @Date : 30 Dec, 2007
	* @modified :  30 Dec, 2007 by 
	* @return : bool
	*/
	public function getErrors(){
		return $this->error;
	}

	/*
	* This method is used to delete the image
	* @author 
	* @Date : 02 Jan, 2008
	* @modified :  02 Jan, 2008 by 
	* @return : bool
	*/
	public function deleteImage($image){
		@unlink($this->path . $image);
		@unlink($this->thumbs . $image);
	}
}
?>