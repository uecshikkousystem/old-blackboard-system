<div class="title-box">
  <div class="title">正副執行委員長選挙</div>

<?php

echo "<div class=\"time\">&#65077;<br />" . date("H時i分", strtotime($row_usingnow["date"])) . "開始<br />&#65078;<br /></div>\n";
echo "</div>";
  
$sql_main = "select * from " . $tablename_ele . " where kind = 'main'";
$res_main = mysql_query($sql_main, $conn);

if (mysql_num_rows($res_main) > 0) {
	echo "<div class=\"ele-box\">";
	echo "<div class=\"comment-line\">執行委員長候補</div>";
	while ($row_main = mysql_fetch_array($res_main,MYSQL_ASSOC)) {
		echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_main['grade'] . $row_main['subject'] . "</div>";
		//echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_main['faculty'] . $row_main['grade'] . $row_main['subject'] . "</div>";
		echo "<div class=\"ele-name-1\">" . parts_change(f_parts_change($row_main['fname'])) . "<div class=\"space\"><hr /></div>" . parts_change(f_parts_change($row_main['lname'])) . "</div></div>";
	}
	echo "</div>";
}

$sql_sub = "select * from " . $tablename_ele . " where kind = 'sub'";
$res_sub = mysql_query($sql_sub, $conn);

if (mysql_num_rows($res_sub) > 0) {
	echo "<div class=\"ele-box\">";
	echo "<div class=\"comment-line\">副執行委員長候補</div>";
	while ($row_sub = mysql_fetch_array($res_sub,MYSQL_ASSOC)) {
		echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_sub['grade'] . $row_sub['subject'] . "</div>";
		//echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_sub['faculty'] . $row_sub['grade'] . $row_sub['subject'] . "</div>";
		echo "<div class=\"ele-name-1\">" . parts_change(f_parts_change($row_sub['fname'])) . "<div class=\"space\"><hr /></div>" . parts_change(f_parts_change($row_sub['lname'])) . "</div></div>";
	}
	echo "</div>";
}

$sql_vote = "select * from " . $tablename_ele . " where output = 'yes' ORDER BY id DESC limit 0,1";
$res_vote = mysql_query($sql_vote, $conn);

if ($res_vote) {
	
	echo "<div class=\"line2\"><hr /></div>";
	
	while ($row_vote = mysql_fetch_array($res_vote,MYSQL_ASSOC)) {
		
		if (preg_match("/^vote-main$/",$row_vote['kind'])) {
			echo "<div class=\"ele-box2\">";
			echo "<div class=\"comment-line\">執行委員長</div>";
			echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_vote['grade'] . $row_vote['subject'] . "</div>";
			//echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_vote['faculty'] . $row_vote['grade'] . $row_vote['subject'] . "</div>";
			echo "<div class=\"ele-name-1\">" . parts_change(f_parts_change($row_vote['fname'])) . "<div class=\"space\"><hr /></div>" . parts_change(f_parts_change($row_vote['lname'])) . "</div></div>";
			echo "</div>";
		} else if (preg_match("/^vote-sub$/",$row_vote['kind'])) {
			echo "<div class=\"ele-box2\">";
			echo "<div class=\"comment-line\">副執行委員長</div>";
			echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_vote['grade'] . $row_vote['subject'] . "</div>";
			//echo "<div class=\"ele-name\"><div class=\"title-name-2\">" . $row_vote['faculty'] . $row_vote['grade'] . $row_vote['subject'] . "</div>";
			echo "<div class=\"ele-name-1\">" . parts_change(f_parts_change($row_vote['fname'])) . "<div class=\"space\"><hr /></div>" . parts_change(f_parts_change($row_vote['lname'])) . "</div></div>";
			echo "</div>";
		}
		
		$ok = preg_replace("/(.+),(.+),(.+)/","$1",$row_vote["comment"]);
		$ng = preg_replace("/(.+),(.+),(.+)/","$2",$row_vote["comment"]);
		$fi = preg_replace("/(.+),(.+),(.+)/","$3",$row_vote["comment"]);
		
		if (preg_match("/^ok$/",$fi)){
			$result = "信任";
		} else if (preg_match("/^ng$/",$fi)) {
			$result = "不信任";
		}
	
		if (preg_match("/\(/",$ok)) {
			$ok_num = preg_replace("/^(.+)\((.+\+.+)\)$/","$1",$ok);
			$ok_in = preg_replace("/^(.+)\((.+\+.+)\)$/","$2",$ok);
			echo "<div class=\"num\">信任<br />＊" . parts_change(f_parts_change($ok_num)) . "票<div class=\"inin\">&#65077;<br />" . parts_change(f_parts_change($ok_in)) . "&#65078;</div></div>";
		} else {
			echo "<div class=\"num\">信任<br />＊" . parts_change(f_parts_change($ok)) . "票</div>";
		}
		
		if (preg_match("/\(/",$ng)) {
			$ng_num = preg_replace("/^(.+)\((.+\+.+)\)$/","$1",$ng);
			$ng_in = preg_replace("/^(.+)\((.+\+.+)\)$/","$2",$ng);
			echo "<div class=\"num\">不信任<br />＊" . parts_change(f_parts_change($ng_num))  . "票<div class=\"inin\">&#65077;<br />" . parts_change(f_parts_change($ng_in)) . "&#65078;</div></div>";
		} else {
			echo "<div class=\"num\">不信任<br />＊" . parts_change(f_parts_change($ng)) . "票</div>";
		}
		
		if (preg_match("/^ok$/",$fi)){
			echo "<div class=\"result-ele\"><div class=\"result-title-eleok\">" . $result . "</div></div>";
		} else if (preg_match("/^ng$/",$fi)) {
			echo "<div class=\"result-ele\"><div class=\"result-title-eleng\">" . $result . "</div></div>";
		}
	}
}

?>
