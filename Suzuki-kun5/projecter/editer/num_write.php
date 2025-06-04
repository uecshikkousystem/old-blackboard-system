<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/function.php");

if (preg_match("/^http:\/\/.*\/projecter\/editer\/.*\?mode=num.*$/",$_SERVER["HTTP_REFERER"])) {
	
	$errflg = 0;
	
	if (!preg_match("/^\d{1,4}$/",$_POST['num_jyonai']) || preg_match("/^0.+$/",$_POST['num_jyonai'])) {
		$_SESSION['error1'] = 2;
		$errflg = 1;
	} else {
		$_SESSION['error1'] = "";
	}
	
	if (!preg_match("/^\d{1,4}$/",$_POST['num_inin']) || preg_match("/^0.+$/",$_POST['num_inin'])) {
		$_SESSION['error2'] = 2;
		$errflg = 1;
	} else {
		$_SESSION['error2'] = "";
	}
	
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		if ($errflg == 0) {
			$num_jyonai = cnv_dbstr(mb_convert_kana($_POST['num_jyonai'],"n","UTF-8"));
			$num_inin = cnv_dbstr(mb_convert_kana($_POST['num_inin'],"n","UTF-8"));
			
			$sql = "INSERT INTO " . $tablename_num . "(num_jyonai, num_inin, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $num_jyonai . "',";
			$sql .= "'" . $num_inin . "',";
			$sql .= "'" . date("Y/m/d H:i:s") . "'";
			$sql .= ")";
				
			$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
			if ($res) {
				$_SESSION['status'] = "num_ok";
				header("Location: ../../parts/fin.php");
				exit;
			}
		} else {
			$_SESSION['num_jyonai'] = cnv_dbstr($_POST['num_jyonai']);
			$_SESSION['num_inin'] = cnv_dbstr($_POST['num_inin']);
			
			$_SESSION['status'] = "num_re";
			header("Location: ./index.php?mode=num");
			exit;
		}
	} else {
		$_SESSION['status'] = "num_ng";
		header("Location: ../../parts/error_fin.php");
		exit;
	}
} else {
	$_SESSION['status'] = "num_ng";
	header("Location: ../../parts/error_fin.php");
	exit;
}

?>
