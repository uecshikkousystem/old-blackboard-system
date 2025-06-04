<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/function.php");

if (preg_match("/^https:\/\/.*\/editer\/.*\?mode=motion.*$/",$_SERVER["HTTP_REFERER"])) {
	
	$errflg = 0;
	
	if (empty($_POST['motion'])) {
		$errflg = 1;
	}
	
	if ($_SERVER["REQUEST_METHOD"]  == "POST") {
		if ($errflg == 0) {
			$kind = "motion";
			$comment = cnv_dbstr($_POST['motion']);
			
			$sql = "INSERT INTO " . $tablename . "(kind, comment, edit, writer, output, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $kind . "',";
			$sql .= "'" . $comment . "',";
			$sql .= "'no',";
			$sql .= "'" . $_COOKIE['user_name'] . "',";
			$sql .= "'no',";
			$sql .= "'" . date("Y/m/d H:i:s") . "'";
			$sql .= ")";
				
			$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
			if ($res) {
				$_SESSION['status'] = "";
				header("Location: ./index.php?mode=edit");
				exit;
			}
		} else {
			$_SESSION['status'] = "motion_re";
			header("Location: ./index.php?mode=motion");
			exit;
		}
	} else {
		$_SESSION['status'] = "motion_ng";
		header("Location: ../../parts/error_fin.php");
		exit;
	}
} else {
	$_SESSION['status'] = "motion_ng";
	header("Location: ../../parts/error_fin.php");
	exit;
}

?>