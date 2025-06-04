  <div class="main">
    <form class="form" method="post" action="que_ele_write.php">
      <div class="faculty">
        <fieldset>
          <legend<?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error2'])){ echo " class=\"error\""; }} ?>>学部・学域</legend>
          <div class="faculty-in">
<!--                          <input type="radio" name="faculty" id="faculty-e" value="E" <?php if (!isset($_GET['re'])) { if (preg_match("/^E$/",$faculty)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error3']) and preg_match("/^E$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-e">電気通信学部・学域</label> -->
                          <input type="radio" name="faculty" id="faculty-i" value="I" checked <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-i">情報理工学部</label>
                          <input type="radio" name="faculty" id="faculty-k" value="Ⅱ" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-k">情報理工学域</label>
                      </div>
        </fieldset>
      </div>
      <div class="subject">
        <fieldset>
          <legend<?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error4'])){ echo " class=\"error\""; }} ?>>学科</legend>
          <div id="subject-in">
                        <input id="J" name="subject" type="radio" value="J" title="総合情報学科" />
                        <label for="J" title="総合情報学科">J</label>
                        <input id="I" name="subject" type="radio" value="I" title="情報・通信工学科" />
                        <label for="I" title="情報・通信工学科">I</label>
                        <input id="M" name="subject" type="radio" value="M" title="知能機械工学科" />
                        <label for="M" title="知能機械工学科">M</label>
                        <input id="S" name="subject" type="radio" value="S" title="先進理工学科" />
                        <label for="S" title="先進理工学科">S</label>
                        <input id="K" name="subject" type="radio" value="K" title="先端工学基礎課程" />
                        <label for="K" title="先端工学基礎課程">K</label>
                      </div>
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="grade">
        <fieldset>
          <legend<?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error3'])){ echo " class=\"error\""; }} ?>>学年</legend>
          <div class="grade-in" id='grade-in'>
                        <input type="radio" name="grade" id="grade-3" value="3" <?php if (!isset($_GET['re'])) { if (preg_match("/^3$/",$grade)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error4']) and preg_match("/^3$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-3">3</label>
                        <input type="radio" name="grade" id="grade-4" value="4" <?php if (!isset($_GET['re'])) { if (preg_match("/^4$/",$grade)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error4']) and preg_match("/^4$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-4">4</label>
                      </div>
        </fieldset>
      </div>
      <div class="name">
        <fieldset>
            <legend>名前</legend>
              姓<input class="name-in<?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error5'])){ echo " error2"; }} ?>" type="text" name="fname" <?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['fname'])){ echo "value=\"" . $_SESSION['fname'] . "\" "; }} ?> onkeypress="return submitStop(event);" />
              名<input class="name-in<?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error6'])){ echo " error2"; }} ?>" type="text" name="lname" <?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['lname'])){ echo "value=\"" . $_SESSION['lname'] . "\" "; }} ?> onkeypress="return submitStop(event);" />
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="which">
        <fieldset>
          <legend<?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (!empty($_SESSION['error1'])){ echo " class=\"error\""; }} ?>>種類</legend>
            <div class="which-in">
              <input type="radio" name="kind" id="kind-e-m" value="main" <?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (preg_match("/^main$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} ?> /><label for="kind-e-m">委員長</label>
              <input type="radio" name="kind" id="kind-e-s" value="sub" <?php if (preg_match("/^ele_re$/",$_SESSION['status'])) { if (preg_match("/^sub$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} ?> /><label for="kind-e-s">副委員長</label>
            </div>
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="submit">
        <input type="submit" name="add-e" value="　立候補者追加　" />
      </div>
      <div class="reset">
        <input type="reset" value="リセット" onclick="return confirm('本当に入力内容を削除してもよろしいですか？');" />
      </div>
      <div class="clear"><hr /></div>
    </form>
<?php

$sql = "select * from " . $tablename_ele . " where (kind = 'main' or kind = 'sub')";
$res = mysql_query($sql, $conn);

while ($row = mysql_fetch_array($res,MYSQL_ASSOC)) {

	if (preg_match("/^main$/",$row['kind'])) {
		$kind = "執行委員長";
	} else if (preg_match("/^sub$/",$row['kind'])) {
		$kind = "副執行委員長";
	}

	echo "<p class=\"question-box\">" . $kind . " " . $row['faculty'] . $row['grade'] . $row['subject'] . " " . $row['fname'] . $row['lname'] . "</p>";
	echo "<div class=\"button\"><a href=\"que_ele_write.php?del_ele_id=" . $row['id'] . "\" onclick=\"return DeleteConfirm();\">削除</a></div>";
	echo "<div class=\"clear\"><hr /></div>\n";
	echo "<hr />\n";
}

?>
  </div><!--main:end-->
