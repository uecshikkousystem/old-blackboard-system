<?php

$sql_now = "select * from " . $tablename_tables . " where id = '" . $usingnow_id . "'";
$res_now = mysql_query($sql_now, $conn);

$row_now = mysql_fetch_array($res_now,MYSQL_ASSOC);

$question[0] = f_parts_change($row_now['question']);
$fin = 0;
$i = 0;

echo "<div class=\"title-box\">";

while ($fin == 0) {
	if (preg_match("/^.{18,}$/u",$question[$i])) {
		$putque[$i] = parts_change(preg_replace("/^(.{18})(.*)$/u","$1",$question[$i]));
		$question[$i+1] = preg_replace("/^(.{18})(.*)$/u","$2",$question[$i]);
	} else {
		$putque[$i] = parts_change($question[$i]);
		$fin = 1;
	}

	if (!empty($putque[$i])) {
		echo "<div class=\"title\">" . $putque[$i] . "</div>";
	}

	$i++;
}

if (!empty($row_now['faculty']) && !empty($row_now['grade']) && !empty($row_now['subject']) && !empty($row_now['fname']) && !empty($row_now['lname'])) {
	echo "<div class=\"title-name\">";
	$name = f_parts_change($row_now['fname'] . $row_now['lname']);
	$str_num = 15 - mb_strlen($name);
	for ($i = 0; $i < $str_num; $i++) {
		echo "<div class=\"str-space\"><hr /></div>";
	}
        if ($row_now['faculty']=='Ⅱ') {
                                if ($row['subject']=='その他'){
                                   echo "<div class=\"title-name-1\">議案提出者</div><div class=\"title-name-2\">" . $row_now['grade'] ."年<br>". $row_now['subject'] . "</div><div class=\"title-name-3\">" . parts_change(f_parts_change($row_now['fname'])) . "<div class=\"name-space\"><hr /></div>" . parts_change(f_parts_change($row_now['lname'])) . "</div></div>\n";
                                } else {
                         echo "<div class=\"title-name-1\">議案提出者</div><div class=\"title-name-2\">" . $row_now['grade'] ."年<br>". $row_now['subject'] ."類". "</div><div class=\"title-name-3\">" . parts_change(f_parts_change($row_now['fname'])) . "<div class=\"name-space\"><hr /></div>" . parts_change(f_parts_change($row_now['lname'])) . "</div></div>\n";
                    }
                  } else {
                     echo "<div class=\"title-name-1\">議案提出者</div><div class=\"title-name-2\">" . $row_now['grade'] ."年<br>". $row_now['subject'] ."科". "</div><div class=\"title-name-3\">" . parts_change(f_parts_change($row_now['fname'])) . "<div class=\"name-space\"><hr /></div>" . parts_change(f_parts_change($row_now['lname'])) . "</div></div>\n";
                  }

	//echo "<div class=\"title-name-1\">議案提出者</div><div class=\"title-name-2\">" . $row_now['faculty'] . $row_now['grade'] . $row_now['subject'] . "</div><div class=\"title-name-3\">" . parts_change(f_parts_change($row_now['fname'])) . "<div class=\"name-space\"><hr /></div>" . parts_change(f_parts_change($row_now['lname'])) . "</div></div>\n";
}

echo "<div class=\"time\">&#65077;<br />" . date("H時i分", strtotime($row_now["date"])) . "開始<br />&#65078;<br /></div>\n";
echo "</div>";

$sql = "select * from " . $tablename . " where output = 'yes' ORDER BY id DESC limit 0,15";
$res = mysql_query($sql, $conn);

$newflg = 0;

while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
	if ($newflg == 0) {
		echo "<div class=\"line\"><hr /></div>";
		echo "<div class=\"card\">";
		echo "<div class=\"newline\"><hr /></div>";
	} else {
		echo "<div class=\"card\">";
		echo "<div class=\"oldline\"><hr /></div>";
	}

	if (preg_match("/^motion$/",$row["kind"])) {
		if (preg_match("/^kyukai$/",$row["comment"])) {
			echo "<p class=\"kyukai-dogi\">休会動議</p>";
		} else if (preg_match("/^horyu$/",$row["comment"])) {
			echo "<p class=\"horyu-dogi\">保留動議</p>";
		} else if (preg_match("/^yokyu$/",$row["comment"])) {
			echo "<p class=\"yokyu-dogi\">採決要求動議</p>";
		} else if (preg_match("/^tekkai$/",$row["comment"])) {
			echo "<p class=\"tekkai-dogi\">撤回動議</p>";
		}
	} else if (preg_match("/^vote$/",$row["kind"])) {
		$ok = preg_replace("/(.+),(.+),(.+)/","$1",$row["comment"]);
		$ng = preg_replace("/(.+),(.+),(.+)/","$2",$row["comment"]);
		$fi = preg_replace("/(.+),(.+),(.+)/","$3",$row["comment"]);
		if (preg_match("/^ok$/",$fi)){
			$result = "可決";
		} else if (preg_match("/^ng$/",$fi)) {
			$result = "否決";
		}

		if (preg_match("/\(/",$ok)) {
			$ok_num = preg_replace("/^(.+)\((.+\+.+)\)$/","$1",$ok);
			$ok_in = preg_replace("/^(.+)\((.+\+.+)\)$/","$2",$ok);
			echo "<div class=\"num\">賛成<br />＊" . parts_change(f_parts_change($ok_num)) . "票<div class=\"inin\">&#65077;<br />" . parts_change(f_parts_change($ok_in)) . "&#65078;</div></div>";
		} else {
			echo "<div class=\"num\">賛成<br />＊" . parts_change(f_parts_change($ok)) . "票</div>";
		}

		if (preg_match("/\(/",$ng)) {
			$ng_num = preg_replace("/^(.+)\((.+\+.+)\)$/","$1",$ng);
			$ng_in = preg_replace("/^(.+)\((.+\+.+)\)$/","$2",$ng);
			echo "<div class=\"num\">反対<br />＊" . parts_change(f_parts_change($ng_num))  . "票<div class=\"inin\">&#65077;<br />" . parts_change(f_parts_change($ng_in)) . "&#65078;</div></div>";
		} else {
			echo "<div class=\"num\">反対<br />＊" . parts_change(f_parts_change($ng)) . "票</div>";
		}

		if (preg_match("/^saiketsu$/",$row["name"])) {
			echo "<div class=\"result\"><div class=\"result-title-q\">" . $result . "</div></div>";
		} else if (preg_match("/^kyukai$/",$row["name"])) {
			echo "<div class=\"result\"><div class=\"result-title\">休会動議</div>" . $result . "</div>";
		} else if (preg_match("/^horyu$/",$row["name"])) {
			echo "<div class=\"result\"><div class=\"result-title\">保留動議</div>" . $result . "</div>";
		} else if (preg_match("/^yokyu$/",$row["name"])) {
			echo "<div class=\"result\"><div class=\"result-title-y\">採決要求動議</div>" . $result . "</div>";
		}

	} else {
		if (preg_match("/^question$/",$row["kind"])) {
			echo "<p class=\"kind\">質問</p>\n";
		} else if (preg_match("/^answer$/",$row["kind"])) {
			echo "<p class=\"kind\">回答</p>\n";
		} else if (preg_match("/^opinion$/",$row["kind"])) {
			echo "<p class=\"kind\">意見</p>\n";
		}

		if (!preg_match("/^general$/",$row["who"])) {
			if (preg_match("/^presenter$/",$row["who"])) {
				echo "<p class=\"name-other\">提出者</p>";
			} else if (preg_match("/^chairman$/",$row["who"])) {
				echo "<p class=\"name-other\">議長</p>";
			}
		} else {
			if ($row['faculty']=='Ⅱ') {
				if ($row['subject']=='その他'){
					echo "<p class=\"grade\">" . $row["grade"] . '年' . $row["subject"] . "</p>\n";
					//echo "<p class=\"grade\">" . $row["faculty"] . $row["grade"] . $row["subject"] . "</p>\n";
					echo "<p class=\"name\">" . $row["name"] . "</p>\n";
				} else {
			    echo "<p class=\"grade\">" . $row["grade"] . '年' . $row["subject"] . "類</p>\n";
			    //echo "<p class=\"grade\">" . $row["faculty"] . $row["grade"] . $row["subject"] . "</p>\n";
			    echo "<p class=\"name\">" . $row["name"] . "</p>\n";
		    }
		  } else {
			echo "<p class=\"grade\">" . $row["grade"] . '年' . $row["subject"] . "科</p>\n";
			//echo "<p class=\"grade\">" . $row["faculty"] . $row["grade"] . $row["subject"] . "</p>\n";
			echo "<p class=\"name\">" . $row["name"] . "</p>\n";
		  }
		}

		$putcom = array();
		$comment = array();
		$fin = 0;
		$i = 0;

		$comment[0] = f_parts_change($row["comment"]);

		echo "<div class=\"comment\">";

		while ($fin == 0) {
			if (preg_match("/^.{15,}$/u",$comment[$i])) {
				if (preg_match("/^.{15}(。|、).*$/u",$comment[$i])) {
					$putcom[$i] = parts_change(preg_replace("/^(.{16})(.*)$/u","$1",$comment[$i]));
					$comment[$i+1] = preg_replace("/^(.{16})(.*)$/u","$2",$comment[$i]);
				} else {
					$putcom[$i] = parts_change(preg_replace("/^(.{15})(.*)$/u","$1",$comment[$i]));
					$comment[$i+1] = preg_replace("/^(.{15})(.*)$/u","$2",$comment[$i]);
				}
			} else {
				$putcom[$i] = parts_change($comment[$i]);
				$fin = 1;
			}

			if (!empty($putcom[$i])) {
				echo "<div class=\"comment-line\">" . $putcom[$i] . "</div>";
			}

			$i++;
		}

		echo "</div>\n";

	}

	echo "</div>";
	echo "<div class=\"line\"><hr /></div>";

	$newflg = 1;
}

?>
