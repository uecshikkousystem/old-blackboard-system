<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");

if (preg_match("/^https:\/\/.*\/projecter\/editer\/(index\.php|)/",$_SERVER["HTTP_REFERER"])) {
	
	if ($row_usingnow['kind'] == 2) {
		$sql = "UPDATE " . $tablename_ele . " SET ";
	} else {
		$sql = "UPDATE " . $tablename . " SET ";
	}
	
	if (!empty($_GET['submit_id'])) {
		$sql .= "output = 'yes'";
		$sql .= " WHERE id = '" . $_GET['submit_id'] . "'";
	} else if (!empty($_GET['delete_id'])) {
		$sql .= "output = 'no'";
		$sql .= " WHERE id = '" . $_GET['delete_id'] . "'";
	}
				
	$res = mysql_query($sql,$conn) or die("ユーザー編集エラー");

	if ($res) {
		$_SESSION['status'] = "";
		header("Location: ./index.php");
		exit;
	}
} else {
	$_SESSION['status'] = "output_ng";
	header("Location: ../parts/error_fin.php");
	exit;
}

?>
