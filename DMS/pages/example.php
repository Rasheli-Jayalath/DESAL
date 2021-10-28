<?php
/*
 * Example, ParentChild class to populate a tree/list of items based on the parent child relationships among them with unlimited level of hierarchy. 
 * The test database schema with some test data are also given at the bottom of this file as well as in another file with the package called "test_database.sql". Any one of them can be used to test the code.
 *
 * Author : Mrinal Nandi <nandi.mrinal2005@gmail.com> - mrinal.0fees.net 
*/

function sorted_data($tt_id,$t_status)
{

	require_once("ParentChild.php");
	
	$obj_parentchild = new ParentChild();	
	
	$obj_parentchild->db_host="localhost";
	$obj_parentchild->db_user="root";
	$obj_parentchild->db_pass="@sj_SMEC@egc_2017";
	$obj_parentchild->db_database="desal_dms"; 	
	
	if(!$obj_parentchild->db_connect()) {
		echo "<h1>Sorry! Could not connect to the database server.</h1>";	
		exit();	
	}
	 	 	 	 	 	 	 	 	 	
	 
	$obj_parentchild->db_table="rs_tbl_threads";	
	$obj_parentchild->item_identifier_field_name="message_id";
	$obj_parentchild->parent_identifier_field_name="parent_message_id";
	$obj_parentchild->item_list_field_name[0]="message_id"; 
	$obj_parentchild->item_list_field_name[1]="parent_message_id"; 
	$obj_parentchild->item_list_field_name[2]="cat_cd"; 
	$obj_parentchild->item_list_field_name[3]="thread_no"; 
	$obj_parentchild->item_list_field_name[4]="thread_title"; 
	$obj_parentchild->item_list_field_name[5]="thread_comments"; 
	$obj_parentchild->item_list_field_name[6]="created_date_time"; 
	$obj_parentchild->item_list_field_name[7]="thread_created_by"; 
	$obj_parentchild->item_list_field_name[8]="creator_id"; 
	$obj_parentchild->item_list_field_name[9]="thread_status"; 
	$obj_parentchild->item_list_field_name[10]="meassage_sent_by"; 
	$obj_parentchild->item_list_field_name[11]="meassage_sent_email"; 
	
	if(isset($t_status))
	{
	$obj_parentchild->extra_condition=" thread_no=".$tt_id." and thread_status=".$t_status; 
	}
	else
	{
	$obj_parentchild->extra_condition=" and thread_no=".$tt_id; 
	}//if required 
	$obj_parentchild->order_by_phrase=" ORDER BY `message_id` ";
	
	$obj_parentchild->level_identifier="  ";
	$obj_parentchild->item_pointer="|-";
	
		
	
	if(isset($t_status))
	{
	$all_childs=$obj_parentchild->getAllChilds1();
	}
	else
	{
	$root_item_id=0;
	$all_childs=$obj_parentchild->getAllChilds($root_item_id);
	}
	//print_r($all_childs); 
	//print_r($all_childs); 
	/*echo "<pre>";
	foreach($all_childs as $chld) {
	for($i=0; $i<12; $i++){
		echo $chld[$obj_parentchild->item_list_field_name[$i]]."->";
		}
		echo "</br>";
	}
	*/
	
	//Getting the path of an item from the root : added on 18 january, 2011 : start 
/*	echo "<p><b>Example : the full path for element q : </b></p>";
	$item_id=15; 
	$item_path_array=$obj_parentchild->getItemPath($item_id); 
	foreach ($item_path_array as $val) { echo $val['thread_title']."->"; }
	*/
	//$obj_parentchild->db_disconnect();
	//Getting the path of an item from the root : added on 18 january, 2011 : end 
return $all_childs;
}
?>

<?php 

// DATABASE FOR TESTING THIS CODE 

/*-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2010 at 08:43 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `parentchild`
--

CREATE TABLE IF NOT EXISTS `parentchild` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Parent_ID` bigint(20) NOT NULL,
  `Name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `parentchild`
--

INSERT INTO `parentchild` (`ID`, `Parent_ID`, `Name`) VALUES
(1, 0, 'a'),
(2, 0, 'b'),
(3, 1, 'c'),
(4, 1, 'd'),
(5, 3, 'e'),
(6, 3, 'f'),
(7, 5, 'i'),
(8, 5, 'j'),
(9, 6, 'k'),
(10, 6, 'l'),
(11, 7, 'm'),
(12, 7, 'n'),
(13, 8, 'o'),
(14, 8, 'p'),
(15, 11, 'q'),
(16, 11, 'r'),
(17, 12, 's'),
(18, 12, 't'),
(19, 4, 'g'),
(20, 4, 'h'),
(21, 19, 'u'),
(22, 19, 'v'),
(23, 22, 'w'),
(24, 22, 'x'),
(25, 2, 'y'),
(26, 2, 'z'),
(27, 25, 'y1'),
(28, 25, 'y2'),
(29, 26, 'z1'),
(30, 26, 'z2');*/


?>