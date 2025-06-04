<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");

if ($row_usingnow['kind'] == 1) {
	
	$sql = "select * from " . $tablename . " ORDER BY id DESC";
	$res = mysql_query($sql, $conn) or die("データ抽出エラー");
	
	while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
		
		$sql_writer = "select lname,fname from " . $tablename_user . " where user = '" . $row['writer'] . "'";
		$res_writer = mysql_query($sql_writer, $conn) or die("データ抽出エラー");
		$row_writer = mysql_fetch_array($res_writer,MYSQL_ASSOC);
		
		if (preg_match("/^motion$/",$row["kind"])) {
			if (preg_match("/^kyukai$/",$row["comment"])) {
				echo "<p class=\"dogi\">休会動議</p>";
			} else if (preg_match("/^horyu$/",$row["comment"])) {
				echo "<p class=\"dogi\">保留動議</p>";
			} else if (preg_match("/^yokyu$/",$row["comment"])) {
				echo "<p class=\"dogi\">採決要求動議</p>";
			} else if (preg_match("/^tekkai$/",$row["comment"])) {
				echo "<p class=\"dogi\">撤回動議</p>";
			}
		
			echo "<div class=\"clear\"><hr /></div>\n";
			
			echo "<p  class=\"date\">(" . date("m/d H:i:s", strtotime($row["date"])) . ")";
			echo " 入力者:" . $row_writer['lname'] . $row_writer['fname'] . "</p><div class=\"button-box\">";
			if (preg_match("/^no$/",$row["output"])) {
				echo "<div class=\"button\"><a onclick=\"ListChange('submit_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示</a></div>";
			} else if (preg_match("/^yes$/",$row["output"])) {
				echo "<div class=\"button-show\"><a onclick=\"ListChange('delete_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示中</a></div>";
			}
			echo "<span class=\"up\"><a onclick=\"ListChange('mode', 'up" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8679;</a></span>";
			echo "<span class=\"down\"><a onclick=\"ListChange('mode', 'down" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8681;</a></span></div>";
			echo "<div class=\"clear\"><hr /></div>\n";
		
		} else if (preg_match("/^vote$/",$row["kind"])) {
			$ok = preg_replace("/(.+),(.+),(.+)/","$1",$row["comment"]);
			$ng = preg_replace("/(.+),(.+),(.+)/","$2",$row["comment"]);
			$fi = preg_replace("/(.+),(.+),(.+)/","$3",$row["comment"]);
			if (preg_match("/^ok$/",$fi)) {
				$result = "可決";
			} else if (preg_match("/^ng$/",$fi)) {
				$result = "否決";
			}
			echo "<p class=\"vote\">採決（". $result . "）</p>";
			echo "<div class=\"clear\"><hr /></div>\n";
			echo "<p class=\"num\">賛成:" . $ok . " 反対:" . $ng . "</p>";
			if (preg_match("/^saiketsu$/",$row["name"])) {
				echo "<p class=\"result\">" . $result . "</p>";
			} else if (preg_match("/^kyukai$/",$row["name"])) {
				echo "<p class=\"result\">休会動議 " . $result . "</p>";
			} else if (preg_match("/^horyu$/",$row["name"])) {
				echo "<p class=\"result\">保留動議 " . $result . "</p>";
			} else if (preg_match("/^yokyu$/",$row["name"])) {
				echo "<p class=\"result\">採決要求動議 " . $result . "</p>";
			}
		
			echo "<p  class=\"date\">(" . date("m/d H:i:s", strtotime($row["date"])) . ")";
			echo " 入力者:" . $row_writer['lname'] . $row_writer['fname'] . "</p><div class=\"button-box\">";
			if (preg_match("/^no$/",$row["output"])) {
				echo "<div class=\"button\"><a onclick=\"ListChange('submit_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示</a></div>";
			} else if (preg_match("/^yes$/",$row["output"])) {
				echo "<div class=\"button-show\"><a onclick=\"ListChange('delete_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示中</a></div>";
			}
			echo "<span class=\"up\"><a onclick=\"ListChange('mode', 'up" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8679;</a></span>";
			echo "<span class=\"down\"><a onclick=\"ListChange('mode', 'down" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8681;</a></span></div>";
			echo "<div class=\"clear\"><hr /></div>\n";
		
		} else {
			if (preg_match("/^question$/",$row["kind"])) {
				echo "<p class=\"kind-q\">質問</p>";
			} else if (preg_match("/^answer$/",$row["kind"])) {
				echo "<p class=\"kind-a\">回答</p>";
			} else if (preg_match("/^opinion$/",$row["kind"])) {
				echo "<p class=\"kind-o\">意見</p>";
			}
		
			if (!preg_match("/^general$/",$row["who"])) {
				if (preg_match("/^presenter$/",$row["who"])) {
					echo "<p class=\"name\">提出者</p>";
				} else if (preg_match("/^chairman$/",$row["who"])) {
					echo "<p class=\"name\">議長</p>";
				}
			} else {
				echo "<p  class=\"name\">" . $row["grade"] . $row["subject"] . " " . $row["name"] . "</p>";
			//	echo "<p  class=\"name\">" . $row["faculty"] . $row["grade"] . $row["subject"] . " " . $row["name"] . "</p>";
			}
		
			echo "<div class=\"clear\"><hr /></div>\n";
		
			echo "<p class=\"comment\">" . mb_convert_kana($row["comment"],"AKV","UTF-8") . "</p>";
			echo "<p class=\"date\">(" . date("m/d H:i:s", strtotime($row["date"])) . ")";
			if (preg_match("/^yes$/",$row["edit"])) {
				echo " 修正済";
			}
			echo " 入力者:" . $row_writer['lname'] . $row_writer['fname'] . "</p>";
			echo "<div class=\"button-box\">";
			if (preg_match("/^no$/",$row["output"])) {
				echo "<div class=\"button\"><a onclick=\"ListChange('submit_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示</a></div>";
			} else if (preg_match("/^yes$/",$row["output"])) {
				echo "<div class=\"button-show\"><a onclick=\"ListChange('delete_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示中</a></div>";
			}
			echo "<div class=\"button\"><a href=\"index.php?mode=edit&edit_id=" . $row["id"] . "\">編集</a></div>";
			echo "<span class=\"up\"><a onclick=\"ListChange('mode', 'up" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8679;</a></span>";
			echo "<span class=\"down\"><a onclick=\"ListChange('mode', 'down" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8681;</a></span></div>";
			echo "<div class=\"clear\"><hr /></div>\n";
		}
		echo "<hr />\n";
	}
	
} else if ($row_usingnow['kind'] == 2) {
	
	$sql = "select * from " . $tablename_ele . " where (kind = 'vote-main' or kind = 'vote-sub') ORDER BY id DESC";
	$res = mysql_query($sql, $conn) or die("データ抽出エラー");
	
	while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
		if (preg_match("/^vote-(main|sub)$/",$row['kind'])) {
			$ok = preg_replace("/(.+),(.+),(.+)/","$1",$row['comment']);
			$ng = preg_replace("/(.+),(.+),(.+)/","$2",$row['comment']);
			$fi = preg_replace("/(.+),(.+),(.+)/","$3",$row['comment']);
			if (preg_match("/^ok$/",$fi)) {
				$result = "信任";
			} else if (preg_match("/^ng$/",$fi)) {
				$result = "不信任";
			}
			echo "<p class=\"vote\">選挙（". $result . "）</p>";
			echo "<div class=\"clear\"><hr /></div>\n";
			echo "<p class=\"num\">信任:" . $ok . " 不信任:" . $ng . "</p>";
			if (preg_match("/^vote-main$/",$row['kind'])) {
				echo "<p class=\"result\">委員長候補 " . $row['fname'] . $row['lname'] . " " . $result . "</p>";
			} else if (preg_match("/^vote-sub$/",$row['kind'])) {
				echo "<p class=\"result\">副委員長候補 " . $row['fname'] . $row['lname'] . " " . $result . "</p>";
			}
		
			echo "<p  class=\"date\">(" . date("Y/m/d H:i:s", strtotime($row["date"])) . ")</p><div class=\"button-box\">";
			if (preg_match("/^no$/",$row["output"])) {
				echo "<div class=\"button\"><a onclick=\"ListChange('submit_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示</a></div>";
			} else if (preg_match("/^yes$/",$row["output"])) {
				echo "<div class=\"button-show\"><a onclick=\"ListChange('delete_id', '" . $row["id"] . "')\" href=\"javascript:void(0);\">表示中</a></div>";
			}
			echo "<span class=\"up\"><a onclick=\"ListChange('mode', 'up" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8679;</a></span>";
			echo "<span class=\"down\"><a onclick=\"ListChange('mode', 'down" . $row["id"] . "')\" href=\"javascript:void(0)\">&#8681;</a></span></div>";
			echo "<div class=\"clear\"><hr /></div>\n";
			echo "<hr />\n";
		}
	}
}

?>
