<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");

$errflg = 0;
	
if (empty($_GET['k_id'])) {
	$errflg = 1;
	echo "<p class=\"error-txt-k\">未入力です。</p>";
	exit;
} else {
	if (!preg_match("/^\d{7}$/",$_GET['k_id'])) {
		$errflg = 1;
		echo "<p class=\"error-txt-k\">正しい学籍番号を入力してください。</p>";
		exit;
	}
}
	
if ($_SERVER['REQUEST_METHOD'] === "GET") {
	if ($errflg == 0) {
		if (!empty($_GET['k_id'])) {
			$k_id = $_GET['k_id'];
			
			$sql = "select * from " . $tablename_account . " where student_id = '" . $k_id . "'";
			$res = mysql_query($sql,$conn) or die("抽出エラー");
			$row = mysql_fetch_array($res,MYSQL_ASSOC);
			
			if (empty($row['student_id'])) {
				echo "<p class=\"error-txt-k\">該当者が存在しません。</p>";
				exit;
			}
		}
	}
}

echo "<div class=\"space-form\"><hr /></div>";
if (preg_match("/^yes$/",$row['member'])) {
	if (!empty($row['status'])) {
		if (preg_match("/^attend1$/",$row['status'])) {
			echo "<p class=\"re-txt\">１票で出席中です。</p>";
		} else if (preg_match("/^attend2$/",$row['status'])) {
			echo "<p class=\"re-txt\">２票で出席中です。</p>";
		} else if (preg_match("/^attend3$/",$row['status'])) {
			echo "<p class=\"re-txt\">３票で出席中です。</p>";
		} else if (preg_match("/^gicho$/",$row['status'])) {
			echo "<p class=\"re-txt\">議長委任中です。</p>";
		} else if (preg_match("/^kojin$/",$row['status'])) {
			echo "<p class=\"re-txt\">" . $row['parent_id'] . "に対して個人委任中です。</p>";
		}
		echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
		echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
	} else {
		echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
		echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
		echo "<div class=\"button-box\">";
		echo "<div class=\"button\"><a href=\"./write.php?k_id=" . $row['student_id'] . "&p_id=" . $_GET['p_id'] . "\" onclick=\"if (window.confirm('”" . $row['lname'] . $row['fname'] . "” さんで間違いないですか？')) { return ture; } else { return false; }\" >個人委任</a></div>";
		echo "<div class=\"clear\"><hr /></div>";
		echo "</div>";
	}
} else if (preg_match("/^(no|)$/",$row['member'])) {
	echo "<p class=\"re-txt\">学友会員ではありません。</p>";
	echo "<p class=\"res-id\">学籍番号：" . $row['student_id'] . "</p>";
	echo "<p class=\"res-name\">名前：" . $row['lname'] . $row['fname'] . "</p>";
}

?>