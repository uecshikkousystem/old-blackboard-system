<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_output("UTF-8");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>エラー</title>
<link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/error_style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<div id="wrapper">
  <div id="inner">
    <div class="main-error">
<?php

if (preg_match("/^(write_ng|edit_ng|motion_ng|vote_ng|num_ng|que_ng|output_ng)$/",$_SESSION['status'])) {
	echo "<p>無効なリクエスト</p>\n";
} else if (preg_match("/^table_ng$/",$_SESSION['status'])) {
	echo "<p>初期化設定が行われていません。<br />管理画面から初期化設定を行ってください。</p>\n";
} else if (preg_match("/^cannot$/",$_SESSION['status'])) {
	echo "<p>審議が開始されていないため、投稿できません。</p>\n";
} else if (preg_match("/^table_not$/",$_SESSION['status'])) {
	echo "<p>議案が選択されていません。</p>\n";
} else if (preg_match("/^que_ng$/",$_SESSION['status'])) {
	echo "<p>議案追加エラー</p>\n";
} else if (preg_match("/^ele_ng$/",$_SESSION['status'])) {
	echo "<p>立候補者追加エラー</p>\n";
} else {
	echo "<p>不明なエラー</p>\n";
}

?>
    </div><!--main-error:end-->  
  </div><!--innner:end-->
</div><!--wrapper:end-->
</body>
</html>