<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(writer|editer|admin)$/",$row_login['position'])) {
	header("Location: ../../");
	exit;
}

if (!isset($_GET['status'])) {
	$_SESSION = array();
	$status = "";
} else {
	$status = $_GET['status'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

if (preg_match("/^re$/",$status)) {
	echo "<title>発言投稿システム [入力エラー]</title>";
} else {
	echo "<title>発言投稿システム</title>";
}

?>
<link href="../../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../parts/css/writer_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../../parts/js/stop_submit.js"></script>
<script type="text/javascript" src="../../parts/js/write_reload.js"></script>
<script type="text/javascript" src="../../parts/js/subject_ch.js"></script>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <p class="title">審議内容スクリーン表示システム</p>
    <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../../auth/auth.php?mode=logout">ログアウト</a></span></div>
    <div class="clear"><hr /></div>
    <p class="subtitle">発言投稿システム</p>
    <p class="top"><a href="../../">トップへ</a></p>
    <div class="clear"><hr /></div>
  </div>
  <div id="inner">
    <div id="space-title">
    </div>
  <div class="main">
    <form class="form" name="form" method="post" action="write.php" autocomplete="off">
      <div class="kind">
        <fieldset>
          <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error1'])){ echo " class=\"error\""; }} ?>>種類</legend>
            <div class="kind-in">
              <input type="radio" name="kind" id="kind-q" value="question" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error1']) && preg_match("/^question$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} else { if (isset($_COOKIE['kind']) && preg_match("/^question$/",$_COOKIE['kind'])) { echo "checked=\"checked\""; }} ?> onclick="buttonChangeMode();" /><label for="kind-q">質問</label>
              <input type="radio" name="kind" id="kind-a" value="answer" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error1']) && preg_match("/^answer$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} else { if (isset($_COOKIE['kind']) && preg_match("/^answer$/",$_COOKIE['kind'])) { echo "checked=\"checked\""; }} ?> onclick="buttonChangeMode('a');" /><label for="kind-a">回答</label>
              <input type="radio" name="kind" id="kind-o" value="opinion" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error1']) && preg_match("/^opinion$/",$_SESSION['kind'])){ echo "checked=\"checked\""; }} else { if (isset($_COOKIE['kind']) && preg_match("/^opinion$/",$_COOKIE['kind'])) { echo "checked=\"checked\""; }} ?> onclick="buttonChangeMode();" /><label for="kind-o">意見</label>
            </div>
        </fieldset>
      </div>
      <div class="clear"><hr /></div>
      <div class="who">
        <fieldset>
          <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error2'])){ echo " class=\"error\""; }} ?>>発言者</legend>
            <div class="who-in">
              <input type="radio" name="who" id="who-p" value="presenter" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error2']) && preg_match("/^presenter$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} ?> /><label for="who-p">議案提出者</label>
              <input type="radio" name="who" id="who-c" value="chairman" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error2']) && preg_match("/^chairman$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} ?> /><label for="who-c">議長</label>
            </div>
            <div class="general">
              <fieldset>
                <legend class="general-bottom"><input type="radio" name="who" id="who-g" value="general" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error2']) && preg_match("/^general$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} else { echo "checked=\"checked\""; } ?> /><label for="who-g">一般</label></legend>
                  <div class="faculty">
                    <fieldset>
                      <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error3'])){ echo " class=\"error\""; }} ?>>学部・学域</legend>
                      <div class="faculty-in">
                        <input type="radio" name="faculty" id="faculty-i" value="I" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-i">情報理工学部</label>
                        <input type="radio" name="faculty" id="faculty-k" value="Ⅱ" checked <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-k">情報理工学域</label>
                        <input type="radio" name="faculty" id="faculty-e" value="E" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^E$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-e">その他</label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="subject">
                    <fieldset>
                  <legend>学科・学類</legend>
                  <div id="subject-in">
										<input id="Ⅰ" name="subject" type="radio" value="Ⅰ" title="Ⅰ類" />
				            <label for="Ⅰ" title="Ⅰ類">Ⅰ類</label>
				            <input id="Ⅱ" name="subject" type="radio" value="Ⅱ" title="Ⅱ類" />
				            <label for="Ⅱ" title="Ⅱ類">Ⅱ類</label>
				            <input id="Ⅲ" name="subject" type="radio" value="Ⅲ" title="Ⅲ類" />
				            <label for="Ⅲ" title="Ⅲ類">Ⅲ類</label>
				            <input id="その他" name="subject" type="radio" value="その他" title="先進理工学科" />
				            <label for="その他" title="その他">その他</label>
                  </div>
<!--                      <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error5'])){ echo " class=\"error\""; }} ?>>学科</legend>
                        <div id="subject-in">
                          <?php

						  if (preg_match("/^re$/",$status) && empty($_SESSION['error3']) && ($_SESSION['faculty'] == 'E' || $_SESSION['faculty'] == 'I')) {
							  if (preg_match("/^E$/",$_SESSION['faculty'])) {
								  $arysubject = array('C' => '情報通信工学科', 'J' => '情報工学科', 'E' => '電子工学科', 'F' => '量子・物質工学科', 'M' => '知能機械工学科', 'T' => 'システム工学科', 'H' => '人間コミュニケーション学科');
							  } else if (preg_match("/^I$/",$_SESSION['faculty'])) {
								  $arysubject = array('J' => '総合情報学科', 'I' => '情報・通信工学科', 'M' => '知能機械工学科', 'S' => '先進理工学科', 'K' => '先端工学基礎課程');
							  }

							  foreach ($arysubject as $key => $value) {
								  echo "<input type=\"radio\" name=\"subject\" id=\"subject-" . $key . "\" value=\"" . $key . "\"";
								  if (empty($_SESSION['error5'])) {
									  if (preg_match("/^$key$/",$_SESSION['subject'])) {
										  echo " checked=\"checked\"";
									  }
								  }
								  echo " title=\"" . $value . "\" /><label for=\"subject-" . $key . "\" title=\"" . $value . "\">" . $key . "</label>";
							  }
						  } else {
							  echo "<p class=\"p-check\">(学部・学域を選択してください)</p>";
						  }

						  ?>
                        </div> -->
                        <div id="subject-name"></div>
                    </fieldset>
                  </div>
                  <div class="clear"><hr /></div>
                  <div class="grade">
                    <fieldset>
                      <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error4'])){ echo " class=\"error\""; }} ?>>学年</legend>
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
                        <input class="name-in<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error6'])){ echo " error2"; }} ?>" type="text" name="name" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error6']) or $_SESSION['error6'] == 2){ echo "value=\"" . $_SESSION['name'] . "\" "; }} ?> onkeypress="return submitStop(event);" />
                        <span class="hiragana">(ひらがな入力。自動的にカタカナに変換されます。)</span>
                    </fieldset>
                  </div>
                  <div class="clear"><hr /></div>
              </fieldset>
            </div>
        </fieldset>
      </div>
      <div class="comment">
        <fieldset>
          <legend>本文</legend>
            <textarea class="comment-in<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error7'])){ echo " error2"; }} ?>" name="comment" rows="3" cols="100"><?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error7'])){ echo $_SESSION['comment']; }} ?></textarea>
        </fieldset>
      </div>
      <div class="submit">
        <input type="submit" value="　投稿　" />
      </div>
      <div class="reset">
        <input type="reset" value="リセット" onclick="return confirm('本当に入力内容を削除してもよろしいですか？');" />
      </div>
      <div class="clear"><hr /></div>
    </form>
    </div><!--main:end-->
	<div class="main" id="list-wrapper"<?php if (!isset($_COOKIE['kind']) || !preg_match("/^answer$/",$_COOKIE['kind'])) { echo " style=\"display:none;\""; } ?>>
      <div id="list">
      </div>
    </div><!--main:end-->
  </div><!--innner:end-->
</div><!--wrapper:end-->
</body>
</html>
