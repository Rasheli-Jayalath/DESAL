<?php
/**
*
* This is a class AdminUser
* @version 0.01
* @author
* @Date 10 Aug, 2007
* @modified 10 Aug, 2007 by 
*
**/
class ManageLang extends Database{
	public $is_login;
	public $lang_id;
	public $lang_name;
	public $lang_flag;
	public $status;
	public $default_active;
	

 

	/*
	* This function is used to list the admin users
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function lstManageLang(){
		$Sql = "SELECT 
					lang_id,
					lang_name,
					lang_flag,
					status,
					default_active
					
				FROM
					tbl_lang
				WHERE 
					1=1";
		if($this->isPropertySet("lang_id", "V"))
			$Sql .= " AND lang_id=" . $this->getProperty("lang_id");
		if($this->isPropertySet("lang_name", "V"))
			$Sql .= " AND lang_name='" . $this->getProperty("lang_name") . "'";
		if($this->isPropertySet("status", "V"))
			$Sql .= " AND status='" . $this->getProperty("status") . "'";
						
			/*if($this->isPropertySet("user_type", "V"))
			$Sql .= " AND user_type='" . $this->getProperty("user_type") . "'";*/
			
		if($this->isPropertySet("limit", "V"))
		$Sql .= $this->appendLimit($this->getProperty("limit"));
		$this->dbQuery($Sql);
		
	}
	
	function updateLangActive($id,$active_yn)
{
	
	$sql = "UPDATE tbl_lang SET 
				status = '$active_yn'
				where lang_id = '$id'";
		$this->dbQuery($sql);
		return $sql;	
}
	
	/*
	* This function is used to perform DML (Delete/Update/Add)
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function actAdminUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_users(
						user_cd,
						username,
						passwd,
						first_name,
						last_name,
						email,
						phone,
						designation,
						user_type,
						last_login_date,
						is_active) 
						VALUES(";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("username", "V") ? "'" . $this->getProperty("username") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("passwd", "V") ? "'" . $this->getProperty("passwd") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("first_name", "V") ? "'" . $this->getProperty("first_name") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("last_name", "V") ? "'" . $this->getProperty("last_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("email", "V") ? "'" . $this->getProperty("email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("phone", "V") ? "'" . $this->getProperty("phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("designation", "V") ? "'" . $this->getProperty("designation") . "'" : "NULL";
				$Sql .= ",";
				
				$Sql .= $this->isPropertySet("user_type", "V") ? "'" . $this->getProperty("user_type") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("last_login_date", "V") ? "'" . $this->getProperty("last_login_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_active", "V") ? "'" . $this->getProperty("is_active") . "'" : "1";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_users SET ";
				if($this->isPropertySet("username", "K")){
					$Sql .= "username='" . $this->getProperty("username") . "'";
					$con = ",";
				}
				if($this->isPropertySet("email", "K")){
					$Sql .= "$con email='" . $this->getProperty("email") . "'";
					$con = ",";
				}
				if($this->isPropertySet("first_name", "K")){
					$Sql .= "$con first_name='" . $this->getProperty("first_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("middle_name", "K")){
					$Sql .= "$con middle_name='" . $this->getProperty("middle_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("last_name", "K")){
					$Sql .= "$con last_name='" . $this->getProperty("last_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("phone", "K")){
					$Sql .= "$con phone='" . $this->getProperty("phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("designation", "K")){
					$Sql .= "$con designation='" . $this->getProperty("designation") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_type", "K")){
					$Sql .= "$con user_type='" . $this->getProperty("user_type") . "'";
					$con = ",";
				}
				if($this->isPropertySet("is_active", "K")){
					$Sql .= "$con is_active='" . $this->getProperty("is_active") . "'";
					
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				break;
			case "D":
				$Sql = "Delete from mis_tbl_users 
						WHERE
							1=1";
				$Sql .= " AND user_cd=" . $this->getProperty("user_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}

	/*
	* This function is used to check the username already exists or not.
	* @author 
	* @Date Dec 05, 2007
	* @modified Dec 05, 2007 by 
	*/
	public function checkAdminUsername(){
		$Sql = "SELECT 
					username
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("username", "V"))
			$Sql .= " AND username='" . $this->getProperty("username") . "'";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd!=" . $this->getProperty("user_cd");
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the email address already exists or not.
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function checkAdminEmailAddress(){
		$Sql = "SELECT 
					user_cd,
					username,
					email,
					CONCAT(first_name,' ', middle_name , ' ',last_name) AS fullname
				FROM
					mis_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("email", "V"))
			$Sql .= " AND email='" . $this->getProperty("email") . "'";
		if($this->isPropertySet("user_cd", "V"))
			$Sql .= " AND user_cd!=" . $this->getProperty("user_cd");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to change the password
	* @author 
	* @Date 20 Dec, 2007
	* @modified 20 Dec, 2007 by 
	*/
	public function changePassword(){
		$Sql = "UPDATE mis_tbl_users SET
					passwd='" . $this->getProperty("passwd") . "' 
				WHERE 
					1=1 
					AND user_cd=" . $this->getProperty("user_cd") . " 
					AND username='" . $this->getProperty("username") . "'";
		return $this->dbQuery($Sql);
	}
	
	public function actMenuUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO mis_tbl_user_rights(
				        right_id,
						user_cd,
						menu_cd
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("right_id", "V") ? $this->getProperty("right_id") : 
					"";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("menu_cd", "V") ?  $this->getProperty("menu_cd") : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE mis_tbl_user_rights SET ";
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= "user_cd='" . $this->getProperty("user_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("menu_cd", "K")){
					$Sql .= "$con menu_cd='" . $this->getProperty("menu_cd") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND right_id=" . $this->getProperty("right_id");
				break;
			case "D":
				$Sql = "Delete from mis_tbl_user_rights
						WHERE
							1=1";
				$Sql .= " AND menu_cd=" . $this->getProperty("menu_cd");
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
	
	public function actCMSUser($mode){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_cms_rights(
				        cms_right_id,
						user_cd,
						cms_id
						) 
						VALUES(";
				$Sql .= $this->isPropertySet("cms_right_id", "V") ? $this->getProperty("cms_right_id") : 
					"";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cd", "V") ? $this->getProperty("user_cd") : 
				"NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cms_id", "V") ?  $this->getProperty("cms_id") : 
				"NULL";
				
				echo $Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_cms_rights SET ";
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= "user_cd='" . $this->getProperty("user_cd") . "'";
					$con = ",";
				}
				if($this->isPropertySet("cms_id", "K")){
					$Sql .= "$con cms_id='" . $this->getProperty("cms_id") . "'";
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				$Sql .= " AND cms_right_id=" . $this->getProperty("cms_right_id");
				break;
			case "D":
				$Sql = "Delete from rs_tbl_cms_rights
						WHERE
							1=1";
				$Sql .= " AND cms_id=" . $this->getProperty("cms_id");
				if($this->isPropertySet("user_cd", "K")){
					$Sql .= " AND user_cd=" . $this->getProperty("user_cd") ;
					
				}
				//echo $Sql;
				break;
			default:
				break;
		}
		return $this->dbQuery($Sql);
	}
}
?>