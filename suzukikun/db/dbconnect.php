<?php

include(__DIR__ . "/dbuser/dbuser.php");

$tablename_tables = "tables_list";
$tablename_ele = "tables_ele";
$tablename_num = "num";
$tablename_account = "account";
$tablename_chat = "chat";
$tablename_user = "user";
$tablename_set = "sets";
$tablename_aud = "audience";
$conn = mysql_connect($sv, $user, $pass);

if (!$conn) {
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/db/dbregi.php");
	exit;
}

if (version_compare(PHP_VERSION,'5.2.0') >= 0) {
	mysql_set_charset("utf8",$conn);
} else {
	mysql_query("SET NAMES utf8",$conn);
}

$sql = "create database if not exists " . $dbname . " default character set utf8";
mysql_query($sql,$conn);

mysql_select_db($dbname) or die("接続エラー");

$sql = "select * from " . $tablename_tables . " where usenow = 'yes'";
$res = mysql_query($sql, $conn);

if ($res) {
	$row_usingnow = mysql_fetch_array($res, MYSQL_ASSOC);
}

if (isset($row_usingnow['id'])) {
	$usingnow_id = $row_usingnow['id'];
	$tablename = "question" . $usingnow_id;
} else {
	$usingnow_id = "";
	$tablename = "";
}	
  
?>
