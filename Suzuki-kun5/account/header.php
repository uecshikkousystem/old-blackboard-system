<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("utf-8");
mb_http_input("auto");
mb_http_output("utf-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(info|infoadmin|admin)$/",$row_login['position'])) {
	header("Location: ../");
	exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>総会受付システム</title>
<link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/account_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../parts/js/stop_submit.js"></script>
<script type="text/javascript" src="../parts/js/account.js"></script>
</head>
<body onload="Cursor();"
<?php

if (!preg_match("/account\/index\.php$/", $_SERVER['REQUEST_URI'])) {
	echo " onkeypress=\"return Back(event);\"";
}

?>>
<div id="wrapper">
  <div id="header">
    <h1 class="title">総会受付システム</h1>
    <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../auth/auth.php?mode=logout">ログアウト</a></span></div> 
    <div class="clear"><hr /></div>
    <h2 class="subtitle">受付システム</h2>
    <p class="top"><a href="../">トップへ</a></p>
    <p class="top"><a href="./">入力画面へ</a></p>
    <div class="clear"><hr /></div>
  </div>
  <div id="inner">