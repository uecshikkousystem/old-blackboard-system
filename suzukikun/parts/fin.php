<?php

session_start();
  
mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("./com_info.php");
require_once("./function.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php

if (preg_match("/^write_ok$/",$_SESSION['status'])) {
	if (isset($_GET['edit']))
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=http://" . $_SERVER['HTTP_HOST'] . "/projecter/editer/?mode=edit\" />\n";
	else
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=http://" . $_SERVER['HTTP_HOST'] . "/projecter/writer/\" />\n";
		
	echo "<title>発言投稿システム [投稿完了]</title>\n";
} else if (preg_match("/^num_ok$/",$_SESSION['status'])) {
	echo "<meta http-equiv=\"refresh\" content=\"1;URL=" . $_SERVER["HTTP_REFERER"] . "\" />\n";
	echo "<title>審議管理システム [票数入力完了]</title>\n";
}

?>
<link href="css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/writer_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/stop_submit.js"></script>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <h1 class="title">審議内容スクリーン表示システム</h1>
    <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../auth/auth.php?mode=logout">ログアウト</a></span></div> 
    <div class="clear"><hr /></div>
<?php

if (preg_match("/^write_ok$/",$_SESSION['status'])) {
	echo "<p class=\"subtitle\">発言投稿システム [投稿完了]</p>\n";
} else if (preg_match("/^num_ok$/",$_SESSION['status'])) {
	echo "<p class=\"subtitle\">審議管理システム [票数入力完了]</p>\n";
}

?>
    <p class="top"><a href="../index.php">トップへ</a></p>
    <div class="clear"><hr /></div>
  </div>
  <div id="inner">
    <div class="main">
<?php

if (preg_match("/^write_ok$/",$_SESSION['status'])) {
	echo "<p>投稿完了</p>\n";
} else if (preg_match("/^num_ok$/",$_SESSION['status'])) {
	echo "<p>票数入力完了</p>\n";
}

?>
<?php
if (preg_match("/^a_write_ok$/",$_SESSION['status'])) {

$entry = 1;		
echo "<meta http-equiv=\"refresh\" content=\"1;URL=http://kurneko.com/Suzuki-kun4/account/index.php\" />\n";
		
} else if (preg_match("/^num_ok$/",$_SESSION['status'])) {
	echo "<meta http-equiv=\"refresh\" content=\"1;URL=" . $_SERVER["HTTP_REFERER"] . "\" />\n";
	echo "<title>審議管理システム [票数入力完了]</title>\n";
}

?>
    </div><!--main:end-->
  </div><!--innner:end-->
</div><!--wrapper:end-->
</body>
</html>
