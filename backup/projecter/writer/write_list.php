<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");

if ($row_usingnow['kind'] == 1) {
	
	$sql = "SELECT * FROM " . $tablename . " ORDER BY id DESC LIMIT 10";
	$res = mysql_query($sql, $conn) or die("データ抽出エラー");
	
	while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
		if (!preg_match("/^motion$/",$row["kind"]) && !preg_match("/^vote$/",$row["kind"]) && preg_match("/^question$/",$row["kind"])) {
			echo "<p class=\"kind-q\">質問</p>";
			
			if (!preg_match("/^general$/",$row["who"])) {
				if (preg_match("/^presenter$/",$row["who"])) {
					echo "<p class=\"name\">提出者</p>";
				} else if (preg_match("/^chairman$/",$row["who"])) {
					echo "<p class=\"name\">議長</p>";
				}
			} else {
				echo "<p  class=\"name\">" . $row["faculty"] . $row["grade"] . $row["subject"] . " " . $row["name"] . "</p>";
			}
		
			echo "<div class=\"clear\"><hr /></div>\n";
		
			echo "<p class=\"comment\">" . mb_convert_kana($row["comment"],"AKV","UTF-8") . "</p>";
			echo "<p class=\"date\">(" . date("m/d H:i:s", strtotime($row["date"])) . ")";
			if (preg_match("/^yes$/",$row["edit"])) {
				echo " 修正済";
			}
			echo "<div class=\"button-box\">";
			if (preg_match("/^no$/",$row["output"])) {
				echo "<div class=\"button\">表示</div>";
			} else if (preg_match("/^yes$/",$row["output"])) {
				echo "<div class=\"button-show\">表示中</div>";
			}
			echo "</div><div class=\"clear\"><hr /></div>\n";
			echo "<hr />\n";
		}
	}	
}

?>