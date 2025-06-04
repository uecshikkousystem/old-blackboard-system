<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/function.php");

if (preg_match("/^http:\/\/.*\/projecter\/editer\/.*\?mode=question.*$/",$_SERVER["HTTP_REFERER"])) {
	
	if (isset($_GET['start_id'])) {
		
		$start_id = htmlspecialchars($_GET['start_id']);
		
		if (!empty($row_usingnow["id"])) {
			$sql = "UPDATE " . $tablename_tables . " SET ";
			$sql .= "usenow = 'no',";
			$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
			$sql .= " WHERE id = '" . $row_usingnow["id"] . "'";
				
			$res = mysql_query($sql,$conn) or die("データ編集エラー");
		}
		
		$sql = "UPDATE " . $tablename_tables . " SET ";
		$sql .= "usenow = 'yes',";
		$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
		$sql .= " WHERE id = '" . $start_id . "'";
				
		$res = mysql_query($sql,$conn) or die("データ編集エラー");
				
		if ($res) {
			$_SESSION['status'] = "";
			header("Location: ./?mode=question");
			exit;
		}
		
	} else if ($_SERVER["REQUEST_METHOD"]  == "POST") {
		
		$errflg = 0;
		
		if (isset($_POST['hour'])) {
			if (!preg_match("/^\d{1,2}$/",$_POST['hour']) || $_POST['hour'] >= 24) {
				$_SESSION['error1'] = "2";
				$errflg = 1;
			} else {
				$_SESSION['error1'] = "";
			}
		} else {
			$_SESSION['error1'] = "1";
			$errflg = 1;
		}
		
		if (isset($_POST['min'])) {
			if (!preg_match("/^\d{1,2}$/",$_POST['min']) || $_POST['min'] >= 60) {
				$_SESSION['error2'] = "2";
				$errflg = 1;
			} else {
				$_SESSION['error2'] = "";
			}
		} else {
			$_SESSION['error2'] = "1";
			$errflg = 1;
		}
		
		if ($errflg == 0) {
			$hour = cnv_dbstr($_POST['hour']);
			$min = cnv_dbstr($_POST['min']);
			$question = "break(" . $hour . ":" . $min . ")";
			
			$sql = "UPDATE " . $tablename_tables . " SET ";
			$sql .= "question = '" . $question . "',";
			$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
			$sql .= " WHERE id = '3'";
			
			$res = mysql_query($sql,$conn) or die("データ編集エラー");
			
			if ($res) {
				$_SESSION['status'] = "";
				header("Location: ./?mode=question");
				exit;
			}
		} else {
			if (!empty($_POST['hour'])){
				$_SESSION['hour'] = cnv_dbstr($_POST['hour']);
			} else {
				$_SESSION['hour'] = "";
			}
			if (!empty($_POST['min'])){
				$_SESSION['min'] = cnv_dbstr($_POST['min']);
			} else {
				$_SESSION['min'] = "";
			}
			
			$_SESSION['status'] = "que_re";
			header("Location: ./?mode=question");
			exit;
		}
		
	} else {
		$_SESSION['status'] = "que_ng";
		header("Location: ../../parts/error_fin.php");
		exit;
	}
} else {
	$_SESSION['status'] = "que_ng";
	header("Location: ../../parts/error_fin.php");
	exit;
}

?>