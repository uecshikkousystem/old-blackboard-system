<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

if (isset($_GET['mode']) && $_GET['mode'] === "conf") {
	
	if (isset($_POST['account'])) {
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=account_" . date("YmdHi") . ".csv");
		
		$sql = "SELECT * FROM " . $tablename_account . " ORDER BY student_id ASC";
		$res = mysql_query($sql, $conn);
		
		while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
			echo "\"" . $row['student_id'] . "\",\"" . $row['lname'] . "\",\"" . $row['fname'] . "\",\"" . $row['member'] . "\",\"" . $row['status'] . "\",\"" . $row['parent_id'] . "\",\"" . $row['editer'] . "\",\"" . $row['date'] . "\"\n";
		}
		exit;
		
	} else if (isset($_POST['user'])) {
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=user_" . date("YmdHi") . ".csv");
		
		$sql = "SELECT * FROM " . $tablename_user . " ORDER BY id ASC";
		$res = mysql_query($sql, $conn);
	
		while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
			echo "\"" . $row['id'] . "\",\"" . $row['user'] . "\",\"" . $row['passwd'] . "\",\"" . $row['lname'] . "\",\"" . $row['fname'] . "\",\"" . $row['position'] . "\",\"" . $row['login'] . "\",\"" . $row['logout'] . "\",\"" . $row['makedate'] . "\",\"" . $row['useragent'] . "\"\n";
		}
		exit;
	}

	
	$errflg = 0;
	
	if (empty($_POST['kind'])) {
		$errflg = 1;
	}
	
	if (!preg_match("/^\d{2}$/",$_POST['num']) || preg_match("/^0.*$/",$_POST['num'])) {
		$errflg = 1;
	}

	if (empty($_POST['cal'])) {
		$errflg = 1;
	}
	
	if (empty($_POST['add'])) {
		$errflg = 1;
	}
	
	if (!empty($_POST['tabledel'])) {
		
		foreach ($_POST['tabledel'] as $value) {
			if ($value == 'chattable') {
				$sql = "drop table " . $tablename_chat;
				$res = mysql_query($sql,$conn) or die("テーブル削除エラー");
				
			} else if ($value == 'numtable') {
				$sql = "drop table " . $tablename_num;
				$res = mysql_query($sql,$conn) or die("テーブル削除エラー");
					
			} else if ($value == 'eletable') {
				$sql = "delete from " . $tablename_ele . " where kind = 'vote-main' or kind = 'vote-sub'";
				$res = mysql_query($sql,$conn) or die("データ削除エラー");
				
			} else if ($value == 'accstatus') {
				$sql = "UPDATE " . $tablename_account . " SET ";
				$sql .= "status = NULL,";
				$sql .= "parent_id = NULL,";
				$sql .= "editer = NULL,";
				$sql .= "date = NULL";
			
				$res = mysql_query($sql,$conn) or die("データ削除エラー");
				
			} else if ($value == 'acctable') {
				$sql = "drop table " . $tablename_account;
				$res = mysql_query($sql,$conn) or die("テーブル削除エラー");
				
			}
		}
		
		$iniflg = 0;
		$aryname = array('sets', 'num', 'tables_list', 'tables_ele', 'account', 'chat', 'user');

		foreach ($aryname as $value) {
			$sql = "show tables like '". $value ."'";
			$res = mysql_query($sql,$conn);
			if (!mysql_num_rows($res)) {
				$iniflg = 1;
			}
		}
		
		if ($iniflg == 1) {
			include("./initialization.php");
		}
	}
	
	if (is_uploaded_file($_FILES['upfile']['tmp_name']) && preg_match("/csv/",$_FILES['upfile']['type'])) {
		$file = fopen($_FILES['upfile']['tmp_name'], "r");
		$i = 0;
		$sql = "REPLACE INTO " . $tablename_account . " (student_id, lname, fname, member, status, parent_id, editer, date) VALUES ";

		while (!feof($file)) {
	    	$csv = fgets($file);
			$str = explode(",", preg_replace('/"/', '', $csv));
			
			$errflg = 0;
			if (isset($str[0]) && preg_match("/^\d{7}$/", $str[0]))
				$str[0] = cnv_dbstr_acnt($str[0]);
			else
				$errflg = 1;

			$str[1] = (isset($str[1])) ? mysql_real_escape_string($str[1]) : '';
			$str[2] = (isset($str[2])) ? mysql_real_escape_string($str[2]) : '';
			$str[3] = (isset($str[3])) ? cnv_dbstr_acnt($str[3]) : '';
			$str[4] = (isset($str[4])) ? cnv_dbstr_acnt($str[4]) : '';
			$str[5] = (isset($str[5])) ? cnv_dbstr_acnt($str[5]) : '';
			$str[6] = (isset($str[6])) ? cnv_dbstr_acnt($str[6]) : '';
			$str[7] = (isset($str[7])) ? cnv_dbstr_acnt($str[7]) : '';


			if ($errflg == 0) {
				$sql .= ($i++==0) ? "(" : ",(";
				$sql .= "'" . $str[0] . "',";
				$sql .= "'" . $str[1] . "',";
				$sql .= "'" . $str[2] . "',";
				$sql .= "'" . $str[3] . "',";
				$sql .= "'" . $str[4] . "',";
				$sql .= "'" . $str[5] . "',";
				$sql .= "'" . $str[6] . "',";
				$sql .= "'" . date("Y/m/d H:i:s", strtotime($str[7])) . "'";
				$sql .= ")";
			}
		}
		//echo $sql;
		//exit;
		mysql_query($sql, $conn) or die("インサートエラー");
		fclose($file);
	}
	
	if (is_uploaded_file($_FILES['userfile']['tmp_name']) && preg_match("/csv/",$_FILES['userfile']['type'])) {
		$file = fopen($_FILES['userfile']['tmp_name'], "r");
		$i = 0;
		$sql = "REPLACE INTO " . $tablename_user . " (id, user, passwd, lname, fname, position, login, logout, makedate, useragent) VALUES ";

		while (!feof($file)) {
	    	$csv = fgets($file);
			$str = explode(",", preg_replace('/"/', '', $csv));
			
			$errflg = 0;
			if (isset($str[0]) && preg_match("/^\d+$/", $str[0]))
				$str[0] = cnv_dbstr_acnt($str[0]);
			else
				$errflg = 1;

			$str[0] = (isset($str[0])) ? cnv_dbstr_acnt($str[0]) : '';
			$str[1] = (isset($str[1])) ? cnv_dbstr_acnt($str[1]) : '';
			$str[2] = (isset($str[2])) ? cnv_dbstr_acnt($str[2]) : '';
			$str[3] = (isset($str[3])) ? mysql_real_escape_string($str[3]) : '';
			$str[4] = (isset($str[4])) ? mysql_real_escape_string($str[4]) : '';
			$str[5] = (isset($str[5])) ? cnv_dbstr_acnt($str[5]) : '';
			$str[6] = (isset($str[6])) ? cnv_dbstr_acnt($str[6]) : '';
			$str[7] = (isset($str[7])) ? cnv_dbstr_acnt($str[7]) : '';
			$str[8] = (isset($str[8])) ? cnv_dbstr_acnt($str[8]) : '';
			$str[9] = (isset($str[9])) ? mysql_real_escape_string($str[9]) : '';


			if (preg_match("/^\d+$/", $str[0])) {
				$sql .= ($i++==0) ? "(" : ",(";
				$sql .= "'" . $str[0] . "',";
				$sql .= "'" . $str[1] . "',";
				$sql .= "'" . $str[2] . "',";
				$sql .= "'" . $str[3] . "',";
				$sql .= "'" . $str[4] . "',";
				$sql .= "'" . $str[5] . "',";
				$sql .= "'" . date("Y/m/d H:i:s", strtotime($str[6])) . "',";
				$sql .= "'" . date("Y/m/d H:i:s", strtotime($str[7])) . "',";
				$sql .= "'" . date("Y/m/d H:i:s", strtotime($str[8])) . "',";
				$sql .= "'" . $str[9] . "'";
				$sql .= ")";
			}
		}
		//echo $sql;
		//exit;
		mysql_query($sql, $conn) or die("インサートエラー");
		fclose($file);

		//$sql = "drop table " . $tablename_user;
		//$res = mysql_query($sql,$conn) or die("テーブル削除エラー");
	
		//include("./initialization.php");
	
		//$csvname = $_FILES['userfile']['tmp_name'];
		//$sql = "LOAD DATA LOCAL INFILE '" . $csvname . "' INTO TABLE " . $tablename_user . " FIELDS TERMINATED BY ',' ENCLOSED BY '\"'";
		//$res = mysql_query($sql,$conn) or die("インサートエラー");
	}

	if ($_SERVER["REQUEST_METHOD"]  == "POST") {
	
		if ($errflg == 0) {
			$ary = array('kind' => cnv_dbstr($_POST['kind']), 'cal' => cnv_dbstr($_POST['cal']), 'add' => cnv_dbstr($_POST['add']), 'num' => cnv_dbstr($_POST['num']));
			
			foreach($ary as $key => $value) {
				$sql = "UPDATE " . $tablename_set . " SET ";
				$sql .= "body = '" . $value . "',";
				$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
				$sql .= " WHERE item = '" . $key . "'";
				
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
			}
		
			if ($res) {
				header("Location: ./?mode=conf");
				exit;
			}
		} else {
			header("Location: ./?mode=conf");
			exit;
		}
	}

}

?>
