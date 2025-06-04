<?php

include("./header.php");

echo "<div class=\"main\">";

if (isset($_GET['res'])) {
	if (preg_match("/^re$/",$_GET['res'])) {
		if ($_SESSION['error1'] == 1) {
			echo "<p class=\"error-txt\">未入力です。</p>";
		} else if ($_SESSION['error1'] == 2) {
			echo "<p class=\"error-txt\">正しい学籍番号を入力してください。</p>";
		} else if ($_SESSION['error1'] == 3) {
			echo "<p class=\"error-txt\">該当者が存在しません。</p>";
		}
	} else if (preg_match("/^ng$/",$_GET['res'])) {
		echo "<p class=\"error-txt\">エラー</p>";
	}
	
	$res = $_GET['res'];
} else {
	echo "<p class=\"p-gaku\">学籍番号を入力してください</p>";
	$res = "";
}

?>
<form class="form" name="form" method="get" action="account.php">
  <input class="id-in<?php if (preg_match("/^re$/",$res)) { if ($_SESSION['error1'] == 1 || $_SESSION['error1'] == 2){ echo " error2"; }} ?>" type="text" name="student_id"<?php if (preg_match("/^re$/",$res) && $_SESSION['error1'] == 2) { echo " value=\"" . $_SESSION['input_num'] . "\""; } ?> onkeypress="return Enter(event);" onfocus="return Check();" autocomplete="off" /><br />
  <input class="submit" name="submit" type="submit" value="確認" disabled="disabled" />
</form>
</br>
<center> <li> <a href="./audience-con.php">傍聴者確認システム</a></li> </center>

<?php
// echo "$entry";
if (isset($_COOKIE['user_name']) && preg_match("/^(infoadmin|admin)$/",$row_login['position'])) {
	echo "</div>";
	echo "<div class=\"button3\"><a href=\"edit_index.php\">登録情報編集</a></div>";
	echo "<div class=\"clear\"><hr /></div>";
}

include("./footer.php");

?>
