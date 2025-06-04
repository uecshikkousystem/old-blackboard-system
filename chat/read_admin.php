<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^admin$/",$row_login['position'])) {
	exit;
}

if (isset($_GET['mode'])) {
	if (preg_match("/^list(get|conti)$/",$_GET['mode'])) {
		$sql = "select * from " . $tablename_chat . " ORDER BY id DESC";	
		$res = mysql_query($sql, $conn);
		$num = mysql_num_rows($res);
		
		if (preg_match("/^listget$/",$_GET['mode'])) {
			$_SESSION['cnt'] = 1;
		} else if (preg_match("/^listconti$/",$_GET['mode'])) {
			$_SESSION['cnt']++;
		}
		$cnt = $_SESSION['cnt'];
		$cntsum = 12 * $_SESSION['cnt'];
		
		$newflg = 0;
		$user_name = $_COOKIE['user_name'];
		
		if ($num == 0) {
			setcookie('newid','0',time() + 24 * 3600);
		} else if ($num <= $cntsum) {
			while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
				
				if ($newflg == 0 && $cnt == 1) {
					setcookie('newid',$row['id'],time() + 24 * 3600);
				}
				
				if (preg_match("/^$user_name$/",$row['user'])) {
					echo "<div class=\"mycard\">\n";
				} else {
					echo "<div class=\"card\">\n";
				}
				
				$sql_writer = "select lname,fname from " . $tablename_user . " where user = '" . $row['user'] . "'";
				$res_writer = mysql_query($sql_writer, $conn) or die("データ抽出エラー");
				$row_writer = mysql_fetch_array($res_writer,MYSQL_ASSOC);
				
				echo "<p class=\"nameinfo\">" . $row_writer['lname'] . $row_writer['fname'] . "<span class=\"posi-name\">[" . name_change($row['position']) . "]</span> → " . name_change($row['addr']) . "</p>\n";
				echo "<p>" . $row['comment'] . "</p>\n";
				echo "<p class=\"time\">(" . date("m/d H:i", strtotime($row["date"])) . ")</p>\n";
				echo "<div class=\"button\"><a onclick=\"ListDelete('" . $row['id'] . "')\" href=\"javascript:void(0);\">取り消し</a></div>\n";
				echo "<div class=\"clear\"><hr /></div>\n";
				echo "</div>\n";
				
				$newflg = 1;
			}
		} else {
			for ($i = 0; $i < $cntsum; $i++) {
				$row = mysql_fetch_array($res,MYSQL_ASSOC);
				
				if ($newflg == 0 && $cnt == 1) {
					setcookie('newid',$row['id'],time() + 24 * 3600);
				}
	
				if (preg_match("/^$user_name$/",$row['user'])) {
					echo "<div class=\"mycard\">\n";
				} else {
					echo "<div class=\"card\">\n";
				}
				
				$sql_writer = "select lname,fname from " . $tablename_user . " where user = '" . $row['user'] . "'";
				$res_writer = mysql_query($sql_writer, $conn) or die("データ抽出エラー");
				$row_writer = mysql_fetch_array($res_writer,MYSQL_ASSOC);
				
				echo "<p class=\"nameinfo\">" . $row_writer['lname'] . $row_writer['fname'] . "<span class=\"posi-name\">[" . name_change($row['position']) . "]</span> → " . name_change($row['addr']) . "</p>\n";
				echo "<p>" . $row['comment'] . "</p>\n";
				echo "<p class=\"time\">(" . date("m/d H:i", strtotime($row["date"])) . ")</p>\n";
				echo "<div class=\"button\"><a onclick=\"ListDelete('" . $row['id'] . "')\" href=\"javascript:void(0);\">取り消し</a></div>\n";
				echo "<div class=\"clear\"><hr /></div>\n";
				echo "</div>\n";
				
				$newflg = 1;
			}
			echo "<div class=\"loadicon\"><img src=\"../parts/image/loading.gif\" width=\"24\" height=\"24\" alt=\"Loading\"></div>";
		}
	} else if (preg_match("/^listcheck$/",$_GET['mode'])) {
		$sql = "select id from " . $tablename_chat . " where id > '" . $_COOKIE['newid'] . "'";
		$res = mysql_query($sql, $conn);
		$num = mysql_num_rows($res);
		
		if ($num > 0) {
			echo "<div class=\"newalert\"><a onclick=\"Chatload()\" href=\"javascript:void(0)\">新しい鈴木ーとが" . $num . "件あります</a></div>";
		}
	}
}

?>