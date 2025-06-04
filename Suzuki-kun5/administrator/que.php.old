  <div class="main">
    <form class="form" method="post" action="que_ele_write.php">
      <div class="faculty">
        <fieldset>
          <legend>学部・学域</legend>
            <div class="faculty-in">
              <input type="radio" name="faculty" id="faculty-e" value="E" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^E$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> /><label for="faculty-e">電気通信学部・学域</label> 
              <input type="radio" name="faculty" id="faculty-i" value="I" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> /><label for="faculty-i">情報理工学部</label>
            </div>
        </fieldset>
      </div>
      <div class="subject">
        <fieldset>
          <legend>学科</legend>
            <div class="subject-in">
              <input type="radio" name="subject" id="subject-j" value="J" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^J$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-j">J</label>
              <input type="radio" name="subject" id="subject-i" value="I" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^I$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-i">I</label>
              <input type="radio" name="subject" id="subject-m" value="M" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^M$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-m">M</label>
              <input type="radio" name="subject" id="subject-s" value="S" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^S$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-s">S</label>
              <input type="radio" name="subject" id="subject-k" value="K" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^K$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-k">K</label>
              <input type="radio" name="subject" id="subject-c" value="C" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^C$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-c">C</label>
              <input type="radio" name="subject" id="subject-e" value="E" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^E$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-e">E</label>
              <input type="radio" name="subject" id="subject-f" value="F" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^F$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-f">F</label>
              <input type="radio" name="subject" id="subject-t" value="T" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^T$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-t">T</label>
              <input type="radio" name="subject" id="subject-h" value="H" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^H$/",$_SESSION['subject'])){ echo "checked=\"checked\""; }} ?> /><label for="subject-h">H</label>
            </div>
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="grade">
        <fieldset>
          <legend>学年</legend>
            <div class="grade-in">
              <input type="radio" name="grade" id="grade-1" value="1" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^1$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-1">1</label>
              <input type="radio" name="grade" id="grade-2" value="2" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^2$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-2">2</label>
              <input type="radio" name="grade" id="grade-3" value="3" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^3$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-3">3</label>
              <input type="radio" name="grade" id="grade-4" value="4" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (preg_match("/^4$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-4">4</label>
            </div>
        </fieldset>
      </div>
      <div class="name">
        <fieldset>
            <legend>名前</legend>
              姓<input class="name-in" type="text" name="fname" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (!empty($_SESSION['fname'])){ echo "value=\"" . $_SESSION['fname'] . "\" "; }} ?> onkeypress="return submitStop(event);" />
              名<input class="name-in" type="text" name="lname" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (!empty($_SESSION['lname'])){ echo "value=\"" . $_SESSION['lname'] . "\" "; }} ?> onkeypress="return submitStop(event);" />
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="question">
        <fieldset>
          <legend<?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error1'])){ echo " class=\"error\""; }} ?>>議案名</legend>
          <input class="question-in" type="text" name="question" <?php if (preg_match("/^que_re$/",$_SESSION['status'])) { if (empty($_SESSION['error1'])){ echo "value=\"" . $_SESSION['name'] . "\" "; }} ?> onkeypress="return submitStop(event);" />
        </fieldset>     
      </div>
      <div class="submit">
        <input type="submit" name="add-g" value="　議案追加　" />
      </div>
      <div class="reset">
        <input type="reset" value="リセット" onclick="return confirm('本当に入力内容を削除してもよろしいですか？');" />
      </div>
      <div class="clear"><hr /></div>
    </form>
<?php

$sql = "select * from " . $tablename_tables . " where kind = '1' ORDER BY id DESC";
$res = mysql_query($sql, $conn);
	
while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {
	
	$sql_tables = "show tables";
	$res_tables = mysql_query($sql_tables,$conn) or die("データ抽出エラー");
	
	while ($row_tables = mysql_fetch_row($res_tables)) {
		$get_tables_id = preg_replace("/question([\d]+$)/","$1",$row_tables[0]);
		if ($row['id'] == $get_tables_id) {
			$tables_id = $get_tables_id;
		}
	}
	
	echo "<div class=\"question-box\">";
	echo "<span>" . $row['question'] . "</span>";
	if (!empty($row['faculty']) && !empty($row['grade']) && !empty($row['subject']) && !empty($row['fname']) && !empty($row['lname'])) {
		echo " <span class=\"question-name\">(" . $row['faculty'] . $row['grade'] . $row['subject'] . " " . $row['fname'] . $row['lname'] .  ")</span>";
	}
	echo "</div>";
	
	if (isset($tables_id) && $row['id'] == $tables_id){
		$sql_num = "select id from question" . $row['id'];
		$res_num = mysql_query($sql_num, $conn) or die;	
		$num_num = mysql_num_rows($res_num);
			
		echo "<div class=\"button\"><a href=\"que_ele_write.php?drop_id=" . $row["id"] . "\" onclick=\"return DropConfirm();\">テーブル削除</a></div>";
		echo "<span class=\"que-num\">(投稿数:" . $num_num . "件)</span>";
	} else {
		echo "<div class=\"button\"><a href=\"que_ele_write.php?table_id=" . $row["id"] . "\">テーブル作成</a></div>";
		echo "<div class=\"button\"><a href=\"que_ele_write.php?delete_id=" . $row["id"] . "\">議案削除</a></div>";
	}
	echo "<div class=\"clear\"><hr /></div>\n";
	echo "<hr />\n";
}

?>
  </div><!--main:end-->