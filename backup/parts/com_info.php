<?php

if (isset($_COOKIE['user_name'])) {
	$user_name = $_COOKIE['user_name'];
	$sql_login = "select * from " . $tablename_user . " where user = '" . $user_name . "'";
	$res_login = mysql_query($sql_login, $conn) or die("データ抽出エラー");
	$row_login = mysql_fetch_array($res_login,MYSQL_ASSOC);
}

$ary = array('kind', 'cal', 'add', 'num');

foreach ($ary as $value) {
	$sql_setdata = "select body from " . $tablename_set . " where item = '" . $value . "'";
	$res_setdata = mysql_query($sql_setdata, $conn);
	$row_setdata = mysql_fetch_array($res_setdata, MYSQL_ASSOC);
	
	$set[$value] = $row_setdata['body'];
}

?>