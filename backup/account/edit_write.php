<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(infoadmin|admin)$/",$row_login['position'])) {
	header("Location: ../../");
	exit;
} else {
	$user_name = $_COOKIE['user_name'];
}

if (preg_match("/^http:\/\/.*\/account\/editer\.php.+$/",$_SERVER["HTTP_REFERER"])) {
	
	if (!isset($_GET['student_id']) || empty($_GET['student_id'])){
		die("学籍番号取得エラー");
	} else {
		$student_id = $_GET['student_id'];
	}
	
	$errflg = 0;
	
	if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['lname'])) {
		$_SESSION['error1'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error1'] = "";
	}
	
	if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['fname'])) {
		$_SESSION['error2'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error2'] = "";
	}
	
	if (empty($_POST['member'])) {
		$_SESSION['error3'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error3'] = "";
	}
	
	if (empty($_POST['status'])) {
		$_SESSION['error4'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error4'] = "";
	}
	
	if (!empty($_POST['status']) && preg_match("/^kojin$/",$_POST['status'])) {
		if (!preg_match("/^\d{7}$/",$_POST['parent_id'])) {
			$_SESSION['error5'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error5'] = "";
		}
	}
	
	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		
		if ($errflg == 0) {
			$sql = "select student_id from " . $tablename_account . " where student_id = " . $student_id;
			$res = mysql_query($sql, $conn);
			$num = mysql_num_rows($res);
			
			$lname = cnv_dbstr($_POST['lname']);
			$fname = cnv_dbstr($_POST['fname']);
			$member = cnv_dbstr($_POST['member']);
			if (preg_match("/^kojin$/",$_POST['status'])) {
				$status = cnv_dbstr($_POST['status']);
				$parent_id = cnv_dbstr($_POST['parent_id']);
			} else if (!preg_match("/^none$/",$_POST['status'])) {
				$status = cnv_dbstr($_POST['status']);
				$parent_id = NULL;
			} else {
				$status = NULL;
				$parent_id = NULL;
			}
		
			if ($num == 0) {
				$sql = "INSERT INTO " . $tablename_account . "(student_id, lname, fname, member, status, parent_id, editer, date)";
				$sql .= "VALUES(";
				$sql .= "'" . $student_id . "',";
				$sql .= "'" . $lname . "',";
				$sql .= "'" . $fname . "',";
				$sql .= "'" . $member . "',";
				$sql .= "'" . $status . "',";
				$sql .= "'" . $parent_id . "',";
				$sql .= "'" . $user_name . "',";
				$sql .= "'" . date("Y/m/d H:i:s") . "'";
				$sql .= ")";
				
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
			
			} else {
				$sql = "UPDATE " . $tablename_account . " SET ";
				$sql .= "lname = '" . $lname . "',";
				$sql .= "fname = '" . $fname . "',";
				$sql .= "member = '" . $member . "',";
				$sql .= "status = '" . $status . "',";
				$sql .= "parent_id = '" . $parent_id . "',";
				$sql .= "editer = '" . $user_name . "',";
				$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
				$sql .= " WHERE student_id = '" . $student_id . "'";
			
				$res = mysql_query($sql,$conn) or die("データ編集エラー");
			}
				
			if ($res) {
				header("Location: ./editer.php?student_id=" . $student_id . "&res=ok");
				exit;
			}
		} else {
			header("Location: ./editer.php?student_id=" . $student_id . "&res=re");
			exit;
		}
	} else {
		header("Location: ./editer.php?student_id=" . $student_id . "&res=ng");
		exit;
	}
}

?>