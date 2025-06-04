<div class="main">
<?php

if (isset($_GET['edit_id'])) {

	$edit_id = htmlspecialchars($_GET['edit_id']);

	$sql_edit = "select * from " . $tablename . " where ID = '" . $edit_id . "'";
	$res_edit = mysql_query($sql_edit, $conn) or die("データ抽出エラー");
	$row = mysql_fetch_array($res_edit, MYSQL_ASSOC);

	$writer = urlencode($row["writer"]);
	$date = urlencode($row["date"]);

	if (!isset($_GET['re'])) {
		$kind = $row["kind"];
		$who = $row["who"];
		$faculty = $row["faculty"];
		$grade = $row["grade"];
		$subject = $row["subject"];
		$name = mb_convert_kana($row["name"],"c","UTF-8");
		$comment = mb_convert_kana($row["comment"],"AKV","UTF-8");
		$comment = preg_replace("/(<br>|<br \/>)/","",$comment);
	}
} else {
	if (!isset($_GET['re'])) {
		$_SESSION = array();
		$kind = "";
		$who = "";
		$faculty = "";
		$grade = "";
		$subject = "";
		$name = "";
		$comment = "";
	}
}

if (isset($_GET['edit_id'])){
	echo "<form class=\"form\" name=\"form\" method=\"post\" action=\"edit_write.php?writer=" . $writer . "&date=" . $date . "&edit_id=" . $edit_id . "\">\n";
} else {
	echo "<form class=\"form\" name=\"form\" method=\"post\" action=\"../writer/write.php?mode=fromedit\">\n";
}

?>
      <div class="kind">
        <fieldset>
          <legend<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error1'])){ echo " class=\"error\""; }} ?>>種類</legend>
            <div class="kind-in">
              <input type="radio" name="kind" id="kind-q" value="question" <?php if (!isset($_GET['re'])) { if (preg_match("/^question$/",$kind)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error1']) and preg_match("/^question$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} ?> /><label for="kind-q">質問</label> <br />
              <input type="radio" name="kind" id="kind-a" value="answer" <?php if (!isset($_GET['re'])) { if ( preg_match("/^answer$/",$kind)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error1']) and preg_match("/^answer$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} ?> /><label for="kind-a">回答</label> <br />
              <input type="radio" name="kind" id="kind-o" value="opinion" <?php if (!isset($_GET['re'])) { if (preg_match("/^opinion$/",$kind)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error1']) and preg_match("/^opinion$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} ?> /><label for="kind-o">意見</label>
            </div>
        </fieldset>
      </div>
      <div class="who">
        <fieldset>
          <legend<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error2'])){ echo " class=\"error\""; }} ?>>発言者</legend>
            <div class="who-in">
              <input type="radio" name="who" id="who-p" value="presenter" <?php if (!isset($_GET['re'])) { if (preg_match("/^presenter$/",$who)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error2']) and preg_match("/^presenter$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} ?> /><label for="who-p">議案提出者</label>
              <input type="radio" name="who" id="who-c" value="chairman" <?php if (!isset($_GET['re'])) { if (preg_match("/^chairman$/",$who)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error2']) and preg_match("/^chairman$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} ?> /><label for="who-c">議長</label>
            </div>
            <div class="clear"><hr /></div>
            <div class="general">
              <fieldset>
                <legend class="general-bottom"><input type="radio" name="who" id="who-g" value="general" <?php if (!isset($_GET['re'])) { if (empty($who)) { echo "checked=\"checked\""; } else if (preg_match("/^general$/",$who)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error2']) and preg_match("/^general$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} ?> /><label for="who-g">一般</label></legend>
                  <div class="faculty">
                    <fieldset>
                      <legend<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error3'])){ echo " class=\"error\""; }} ?>>学部・学域</legend>
											<div class="faculty-in">
<!--                          <input type="radio" name="faculty" id="faculty-e" value="E" <?php if (!isset($_GET['re'])) { if (preg_match("/^E$/",$faculty)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error3']) and preg_match("/^E$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-e">電気通信学部・学域</label> -->
													<input type="radio" name="faculty" id="faculty-i" value="I" checked <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-i">情報理工学部</label>
													<input type="radio" name="faculty" id="faculty-k" value="Ⅱ" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-k">情報理工学域</label>
											</div>
                    </fieldset>
                  </div>
									<div class="subject">
                    <fieldset>
                      <legend<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error5'])){ echo " class=\"error\""; }} ?>>学科・学類</legend>
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
                      <legend<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error4'])){ echo " class=\"error\""; }} ?>>学年</legend>
											<div class="grade-in" id='grade-in'>
                                                                                                <input type="radio" name="grade" id="grade-1" value="1" <?php if (!isset($_GET['re'])) { if (preg_match("/^1$/",$grade)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error4']) and preg_match("/^1$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-1">1</label>
                                                                                                <input type="radio" name="grade" id="grade-2" value="2" <?php if (!isset($_GET['re'])) { if (preg_match("/^2$/",$grade)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error4']) and preg_match("/^2$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-2">2</label>
												<input type="radio" name="grade" id="grade-3" value="3" <?php if (!isset($_GET['re'])) { if (preg_match("/^3$/",$grade)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error4']) and preg_match("/^3$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-3">3</label>
												<input type="radio" name="grade" id="grade-4" value="4" <?php if (!isset($_GET['re'])) { if (preg_match("/^4$/",$grade)){ echo "checked=\"checked\""; }} else { if (empty($_SESSION['error4']) and preg_match("/^4$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-4">4</label>
											</div>
                    </fieldset>
                  </div>
                  <div class="name">
                    <fieldset>
                      <legend>名前</legend>
                        <input class="name-in<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error6'])){ echo " error2"; }} ?>" type="text" name="name" <?php if (!isset($_GET['re'])) { echo "value=\"" . $name . "\" "; } else { if (empty($_SESSION['error6']) or $_SESSION['error6'] == 2){ echo "value=\"" . $_SESSION['name'] . "\" "; }} ?> onkeypress="return submitStop(event);" autocomplete="off" />
                        <span class="hiragana">(ひらがな入力。自動的にカタカナに変換されます。)</span>
                    </fieldset>
                  </div>
                  <div class="clear"><hr /></div>
              </fieldset>
            </div>
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="comment">
        <textarea class="comment-in<?php if (isset($_GET['re'])) { if (!empty($_SESSION['error7'])){ echo " error2"; }} ?>" name="comment" rows="3" cols="100"><?php if (!isset($_GET['re'])) { echo $comment; } else { if (empty($_SESSION['error7'])){ echo $_SESSION['comment']; }} ?></textarea>
      </div>
<?php

if (isset($_GET['edit_id'])) {
	echo "<div class=\"submit\">";
	echo "<input type=\"submit\" value=\"　編集完了　\" />";
	echo "</div>";
	echo "<div class=\"reset\">";
	echo "<input type=\"button\" value=\"入力画面へ\" onClick=\"location.href='?mode=edit'\" />";
	echo "</div>";
} else {
	echo "<div class=\"submit\">";
	echo "<input type=\"submit\" value=\"　投稿　\" />";
	echo "</div>";
	echo "<div class=\"reset\">";
	echo "<input type=\"reset\" value=\"リセット\" onclick=\"return confirm('本当に入力内容を削除してもよろしいですか？');\" />";
	echo "</div>";
}

?>
	<div class="clear"><hr /></div>
    </form>
    </div><!--main:end-->
    <div class="main">
      <div id="list">
      </div>
    </div><!--main:end-->
