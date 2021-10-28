<?php
/**
*
* This is a class News
* @version 0.01
* @author Raju Gautam  <raju@devraju.com>
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by Raju Gautam
*
**/
class Content extends Database{
	/**
	* This is the constructor of the class News
	* @author Raju Gautam
	* @Date 10 Aug, 2007
	* @modified 10 Aug, 2007 by Raju Gautam
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This method is used to list the news
	* @author Raju Gautam
	* @Date 11 Aug, 2007
	* @modified 11 Aug, 2007 by Raju Gautam
	*/
	public function lstCMS($lang = false){
		$Sql = "SELECT
					cms_cd,
					title,
					details,
					cmsfile
				FROM
					rs_tbl_cms
				WHERE
					1=1 ";
		
		
		
		if($this->isPropertySet("cms_cd", "V")){
			$Sql .= " AND cms_cd=" . $this->getProperty("cms_cd");
		}
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		return $this->dbQuery($Sql);
	}

	/**
	* This function is used to perform DML (Delete/Update/Add)
	* on the table rr_tbl_news the basis of property set
	* @author Raju Gautam
	* @Date 25 Dec, 2007
	* @modified 25 Dec, 2007 by Raju Gautam
	*/
	public function actCMS($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_cms(
						cms_cd,						
						title,
						details,
						cmsfile)
						VALUES(";
				$Sql .= $this->isPropertySet("cms_cd", "V") ? $this->getProperty("cms_cd") : "NULL";
				$Sql .= ",";				
				$Sql .= $this->isPropertySet("title", "V") ? "'" . $this->getProperty("title") . "'" : "''";
				$Sql .= ",";			
				$Sql .= $this->isPropertySet("details", "V") ? "'" . $this->getProperty("details") . "'" : "''";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cmsfile", "V") ? "'" . $this->getProperty("cmsfile") . "'" : "''";
				$Sql .= ")";
				
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_cms SET ";
				if($this->isPropertySet("title", "K")){
					$Sql .= "$con title='" . $this->getProperty("title") . "'";
					$con = ",";
				}
			
				if($this->isPropertySet("details", "K")){
					$Sql .= "$con details='" . $this->getProperty("details") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cmsfile", "K")){
					$Sql .= "$con cmsfile='" . $this->getProperty("cmsfile") . "'";
					$con = ",";
				}
				
				
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cms_cd=" . $this->getProperty("cms_cd");
				break;
			case "D":
				$Sql = "DELETE FROM rs_tbl_cms WHERE cms_cd=" . $this->getProperty("cms_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
?>