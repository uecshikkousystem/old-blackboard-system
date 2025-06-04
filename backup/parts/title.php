<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");

if (empty($usingnow_id)) {
	echo "<p>初期化設定が行われていません。<br />管理画面から初期化設定を行ってください。</p>\n";
	exit;
}

echo "<p>《審議中議案名》</p><div class=\"question-title\">";
if (!empty($usingnow_id)) {
	if ($row_usingnow['kind'] == 2) {
		echo "<p>正副執行委員長選挙";
	} else if ($row_usingnow['kind'] == 3) {
		echo "<p>(開会前です)";
	} else if ($row_usingnow['kind'] == 4) {
		$sql_break = "select * from " . $tablename_tables . " where id = '3'";
		$res_break = mysql_query($sql_break, $conn);
		$row_break = mysql_fetch_array($res_break,MYSQL_ASSOC);
		$time = preg_replace("/^.+\((.+:.+)\)$/","$1",$row_break['question']);
		echo "<p>(休会中です。" . $time . "から再開します。)";
	} else if ($row_usingnow['kind'] == 5) {
		echo "<p>(閉会しました)";
	} else if ($row_usingnow['kind'] == 6) {
		echo "<p>(無表示)";
	} else {
		echo "<p>" . $row_usingnow['question'];
		if (!empty($row_usingnow['faculty']) && !empty($row_usingnow['grade']) && !empty($row_usingnow['subject']) && !empty($row_usingnow['fname']) && !empty($row_usingnow['lname'])) {
			echo " <span class=\"question-name\">(" . $row_usingnow['faculty'] . $row_usingnow['grade'] . $row_usingnow['subject'] . " " . $row_usingnow['fname'] . $row_usingnow['lname'] .  ")</span>";
		}
	}
} else {
	echo "<p>(議案が選択されていません)";
}
echo "</p></div>";
	

?>