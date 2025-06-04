<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

if (preg_match("/^http:\/\/.*\/useradd.php/",$_SERVER["HTTP_REFERER"])) {
	
	$errflg = 0;
	
	if (!empty($_POST['user'])) {
		$sql = "select * from " . $tablename_user . " where user = '" . $_POST['user'] . "'";
		$res = mysql_query($sql, $conn) or die("データ抽出エラー");
		$num = mysql_num_rows($res);
		if ($num != 0) {
			echo "このユーザー名はすでに使われています。";
		}
	}
	
} else {
	$url = "./useradd.php?add=ng";
	header("Location: $url");
	exit;
}

?>