<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(writer|editer|admin)$/",$row_login['position'])) {
header("Location: ../");
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
    echo "<title>傍聴者呼びかけシステム [入力エラー]</title>";
    } else {
    echo "<title>傍聴者呼びかけシステム</title>";
    }

    ?>
    <link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../parts/css/writer_style.css" rel="stylesheet" type="text/css" media="all" />
 <script type="text/javascript" src="../parts/js/stop_submit.js"></script>
<script type="text/javascript" src="../parts/js/write_reload.js"></script>
<script type="text/javascript" src="../parts/js/subject_ch.js"></script> 
 </head>
  <body>
    <div id="wrapper">
      <div id="header">
        <p class="title">傍聴者呼びかけシステム</p>
        <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../auth/auth.php?mode=logout">ログアウト</a></span></div> 
        <div class="clear"><hr /></div>
        <p class="subtitle">傍聴者呼びかけシステム</p>
        <p class="top"><a href="../">トップへ</a></p>
        <div class="clear"><hr /></div>
      </div>
      <div id="inner">
        <div class="main">
          <form class="form" name="form" method="post" action="test.php" autocomplete="off">
            <div class="kind">
            </div>
            <div class="clear"><hr /></div>
            <div class="who">
              <fieldset>
                <legend class="general-bottom"><input type="radio" name="who" id="who-g" value="general" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error2']) && preg_match("/^general$/",$_SESSION['who'])){ echo "checked=\"checked\""; }} else { echo "checked=\"checked\""; } ?> /><label for="who-g">一般</label></legend>
                <div class="faculty">
                  <fieldset>
                    <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error3'])){ echo " class=\"error\""; }} ?>>学部・学域</legend>
                    <div class="faculty-in">
                      <input type="radio" name="faculty" id="faculty-e" value="電気通信学部・学域" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^E$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-e">電気通信学部・学域</label> 
                      <input type="radio" name="faculty" id="faculty-i" value="情報理工学部" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error3']) && preg_match("/^I$/",$_SESSION['faculty'])){ echo "checked=\"checked\""; }} ?> onclick="ChangeSubject();" /><label for="faculty-i">情報理工学部</label>
                    </div>
                  </fieldset>
                </div>
                <div class="subject">
                  <fieldset>
                    <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error5'])){ echo " class=\"error\""; }} ?>>学科</legend>
                    <div id="subject-in">
                      <?php

                      if (preg_match("/^re$/",$status) && empty($_SESSION['error3']) && ($_SESSION['faculty'] == '電気通信学部・学域' || $_SESSION['faculty'] == '情報理工学部')) {
                      if (preg_match("/^電気通信学部・学域$/",$_SESSION['faculty'])) {
                      $arysubject = array('C' => '情報通信工学科', 'J' => '情報工学科', 'E' => '電子工学科', 'F' => '量子・物質工学科', 'M' => '知能機械工学科', 'T' => 'システム工学科', 'H' => '人間コミュニケーション学科');
                      } else if (preg_match("/^I$/",$_SESSION['faculty'])) {
                      $arysubject = array('Ji' => '総合情報学科', 'I' => '情報・通信工学科', 'M' => '知能機械工学科', 'S' => '先進理工学科', 'K' => '先端工学基礎課程');
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
                    </div>
                    <div id="subject-name"></div>
                  </fieldset>
                </div>
                <div class="clear"><hr /></div>
                <div class="grade">
                  <fieldset>
                    <legend<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error4'])){ echo " class=\"error\""; }} ?>>学年</legend>
                    <div class="grade-in">
                      <input type="radio" name="grade" id="grade-1" value="1" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error4']) && preg_match("/^1$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-1">1</label>
                      <input type="radio" name="grade" id="grade-2" value="2" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error4']) && preg_match("/^2$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-2">2</label>
                      <input type="radio" name="grade" id="grade-3" value="3" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error4']) && preg_match("/^3$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-3">3</label>
                      <input type="radio" name="grade" id="grade-4" value="4" <?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error4']) && preg_match("/^4$/",$_SESSION['grade'])){ echo "checked=\"checked\""; }} ?> /><label for="grade-4">4</label>
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
          <div class="comment">
            <fieldset>
              <legend>理由</legend>
              <textarea class="comment-in<?php if (preg_match("/^re$/",$status)) { if (!empty($_SESSION['error7'])){ echo " error2"; }} ?>" name="comment" rows="3" cols="100"><?php if (preg_match("/^re$/",$status)) { if (empty($_SESSION['error7'])){ echo $_SESSION['comment']; }} ?></textarea>
            </fieldset>     
            <div class="submit">
              <input type="submit" value="　投稿　" />
            </div>
            <div class="reset">
              <input type="reset" value="リセット" onclick="return confirm('本当に入力内容を削除してもよろしいですか？');" />
            </div>
            <div class="clear"><hr /></div>
          </div>
        </div>
      </form>
    </div><!--main:end-->
    <div id="list">
    </div>
  </div><!--main:end-->
</div><!--innner:end-->
</div><!--wrapper:end-->
</body>
</html>
