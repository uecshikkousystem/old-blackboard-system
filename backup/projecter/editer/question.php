    <div class="main">
<?php

$sql_tables = "show tables";
$res_tables = mysql_query($sql_tables,$conn) or die("データ抽出エラー");
	
while ($row_tables = mysql_fetch_row($res_tables)) {
	
	if (preg_match("/^question\d+$/",$row_tables[0])) {
			
		$get_tables_id = preg_replace("/^question([\d]+$)/","$1",$row_tables[0]);
			
		$sql = "select * from " . $tablename_tables . " where id = '" . $get_tables_id . "'";
		$res = mysql_query($sql, $conn) or die;
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
		
		$sql_num = "select id from " . $row_tables[0];
		$res_num = mysql_query($sql_num, $conn) or die;	
		$num_num = mysql_num_rows($res_num);
		
		echo "<div class=\"question-box\">";
		echo "<span>" . $row['question'] . "</span>";
		
		if (!empty($row['faculty']) && !empty($row['grade']) && !empty($row['subject']) && !empty($row['fname']) && !empty($row['lname'])) {
			echo " <span class=\"question-name\">(" . $row['faculty'] . $row['grade'] . $row['subject'] . " " . $row['fname'] . $row['lname'] .  ")</span>";
		}
		
		echo "<span class=\"que-num\">(投稿数:" . $num_num . "件)</span></div>";
		
		if ($row['usenow'] == 'yes') {
			echo "<div class=\"now\">審議中</div>";
		} else {
			echo "<div class=\"button\"><a href=\"question_write.php?start_id=" . $row["id"] . "\">審議開始</a></div>";
		}
		
		echo "<div class=\"clear\"><hr /></div>";
		echo "<hr />\n";
	}
}

$sql = "select kind from " . $tablename_ele;
$res = mysql_query($sql, $conn) or die;

$num = array('main' => '0', 'sub' => '0', 'com' => '0');

while ($row = mysql_fetch_row($res,MYSQL_ASSOC)) {
	if ($row['kind'] == 'main') {
		$num['main']++;
	} else if ($row['kind'] == 'sub') {
		$num['sub']++;
	} else {
		$num['com']++;
	}
}

echo "<div class=\"question-box\">";
echo "<span>正副執行委員長選挙<span class=\"que-num\">(正:" . $num['main'] . "人, 副:" . $num['sub'] . "人, 投稿数:" . $num['com'] . "件)</span></span>";
echo "</div>";

if ($row_usingnow['kind'] == 2) {
	echo "<div class=\"now\">審議中</div>";
} else {
	echo "<div class=\"button\"><a href=\"question_write.php?start_id=1\">審議開始</a></div>";
}

echo "<div class=\"clear\"><hr /></div>";
echo "<hr />\n";

?>

</div>
<div class="main">
  <form class="time-set" method="post" action="question_write.php">
    <fieldset>
      <legend>休会時の再開時刻</legend>
        <input class="time<?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error1'])){ echo " error2"; }} ?>" type="text" name="hour" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (empty($_SESSION['error1']) or $_SESSION['error1'] == 2){ echo "value=\"" . $_SESSION['hour'] . "\" "; }} ?>onkeypress="return submitStop(event);" /><span>：</span><input class="time<?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error2'])){ echo " error2"; }} ?>" type="text" name="min" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (empty($_SESSION['error2']) or $_SESSION['error2'] == 2){ echo "value=\"" . $_SESSION['min'] . "\" "; }} ?>onkeypress="return submitStop(event);" />
        <input type="submit" value="設定" />
        <p>24時間表記で入力してください。</p>
    </fieldset>
  </form>

<?php

if ($row_usingnow['kind'] != 6) {
	echo "<div class=\"button2\"><a href=\"question_write.php?start_id=5\">無表示</a></div>";
} else {
	echo "<div class=\"now2\">無表示</div>";
}

if ($row_usingnow['kind'] != 3) {
	echo "<div class=\"button2\"><a href=\"question_write.php?start_id=2\">開会前</a></div>";
} else {
	echo "<div class=\"now2\">開会前</div>";
}

$sql_break = "select * from " . $tablename_tables . " where id = '3'";
$res_break = mysql_query($sql_break, $conn);
$row_break = mysql_fetch_array($res_break,MYSQL_ASSOC);
$time = preg_replace("/^.+\((.+:.+)\)$/","$1",$row_break['question']);

if ($row_usingnow['kind'] != 4) {
	if (preg_match("/^.+\(.+:.+\)$/",$row_break['question'])) {
		echo "<div class=\"button2\"><a href=\"question_write.php?start_id=3\">休会(" . $time . "再開)</a></div>";
	} else {
		echo "<div class=\"button2-no\">休会(開始時刻未設定)</div>";
	}
} else {
	echo "<div class=\"now2\">休会(" . $time . "再開)</div>";
}

if ($row_usingnow['kind'] != 5) {
	echo "<div class=\"button2\"><a href=\"question_write.php?start_id=4\">閉会</a></div>";
} else {
	echo "<div class=\"now2\">閉会</div>";
}



?>
      <div class="clear"><hr /></div>
    </div><!--main:end-->