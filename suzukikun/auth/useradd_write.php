<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

$_SESSION['status'] = '';

if (preg_match("/^http:\/\/.*\/auth\/useradd.php/",$_SERVER["HTTP_REFERER"])) {
	
	$errflg = 0;
	
	if (!preg_match("/^[0-9a-zA-Z_\-]+$/",$_POST['user'])) {
		$errflg = 1;
		$err[1] = 1;
	} else {
		$sql = "select * from " . $tablename_user . " where user = '" . $_POST['user'] . "'";
		$res = mysql_query($sql, $conn) or die("データ抽出エラー");
		$num = mysql_num_rows($res);
		if ($num != 0) {
			$errflg = 1;
			$err[2] = 1;
		}
	}
	
	if (!preg_match("/^[0-9a-zA-Z]{6,}$/",$_POST['passwd'])) {
		$errflg = 1;
		$err[3] = 1;
	}
	
	if (empty($_POST['passwd2'])) {
		$errflg = 1;
		$err[4] = 1;
	}
	
	if ($_POST['passwd'] != $_POST['passwd2']) {
		$errflg = 1;
		$err[5] = 1;
	}
	
	if (empty($_POST['lname'])) {
		$errflg = 1;
		$err[6] = 1;
	}
	
	if (empty($_POST['fname'])) {
		$errflg = 1;
		$err[7] = 1;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ($errflg == 0) {
			$user = cnv_dbstr(strtolower($_POST['user']));
			$passwd = cnv_dbstr(md5($_POST['passwd']));
			$lname = cnv_dbstr($_POST['lname']);
			$fname = cnv_dbstr($_POST['fname']);
			if ($_SERVER['HTTP_USER_AGENT']) {
				$useragent = cnv_dbstr($_SERVER["REMOTE_ADDR"] . ";" . $_SERVER['HTTP_USER_AGENT']);
			} else {
				$useragent = "";
			}
			
			if (isset($_GET['newadmin'])) {
				$sql = "select * from " . $tablename_user . " where position = 'admin'";
				$res = mysql_query($sql, $conn) or die("データ抽出エラー");
				$num = mysql_num_rows($res);
				
				if ($num == 0) {
					$sql = "INSERT INTO " . $tablename_user . "(user, passwd, lname, fname, position, makedate, useragent)";
					$sql .= "VALUES(";
					$sql .= "'" . $user . "',";
					$sql .= "'" . $passwd . "',";
					$sql .= "'" . $lname . "',";
					$sql .= "'" . $fname . "',";
					$sql .= "'admin',";
					$sql .= "'" . date("Y/m/d H:i:s") . "',";
					$sql .= "'" . $useragent . "'";
					$sql .= ")";	
				}
			} else {
				$sql = "INSERT INTO " . $tablename_user . "(user, passwd, lname, fname, position, makedate, useragent)";
				$sql .= "VALUES(";
				$sql .= "'" . $user . "',";
				$sql .= "'" . $passwd . "',";
				$sql .= "'" . $lname . "',";
				$sql .= "'" . $fname . "',";
				$sql .= "'gene',";
				$sql .= "'" . date("Y/m/d H:i:s") . "',";
				$sql .= "'" . $useragent . "'";
				$sql .= ")";
			}
				
			$res = mysql_query($sql,$conn) or die("ユーザー追加エラー");
			
			$_SESSION['status'] = 'add_ok';
			header("Location: ../");
			exit;
			
		} else {
			$url = "./useradd.php?add=re";
			
			for ($i=1; $i<=7; $i++) {
				if (isset($err[$i])) {
					$url .= "&err" . $i;
				}
			}
			
			header("Location: $url");
			exit;
		}	
	} else {
		$url = "./useradd.php?add=ng";
		header("Location: $url");
		exit;
	}
} else {
	$url = "./useradd.php?add=ng";
	header("Location: $url");
	exit;
}

?>
