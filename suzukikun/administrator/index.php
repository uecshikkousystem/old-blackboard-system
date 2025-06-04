<?php

session_start();
  
mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^admin$/",$row_login['position'])) {
	header("Location: ../");
	exit;
}

if (!preg_match("/^http:\/\/.*\/administrator\/.*\?mode=.+$/",$_SERVER["HTTP_REFERER"])) {
	$_SESSION['status'] = "";
}

$iniflg = 0;
$aryname = array('sets', 'num', 'tables_list', 'tables_ele', 'account', 'chat', 'user');

foreach ($aryname as $value) {
	$sql = "show tables like '". $value ."'";
	$res = mysql_query($sql,$conn);
	if (!mysql_num_rows($res)) {
		$iniflg = 1;
	}
}

if (!isset($_GET['mode']) && $iniflg == 0) {
	header("Location: ./?mode=conf");
	exit;
} else if ((!isset($_GET['mode']) || $_GET['mode'] != 'ini') && $iniflg == 1) {
	header("Location: ./?mode=ini");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理画面</title>
<link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/admin_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../parts/js/stop_submit.js"></script>
<script type="text/javascript" src="../parts/js/administrator.js"></script>
<script type="text/javascript" src="../parts/js/subject_ch.js"></script>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <h1 class="title"><span class="title-1">総会管理システム</span><span class="title-2">南理くん</span></h1>
    <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../auth/auth.php?mode=logout">ログアウト</a></span></div> 
    <div class="clear"><hr /></div>
    <h2 class="subtitle">管理画面</h2>
    <div class="clear"><hr /></div>
    <ul class="link-list">
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] == 'conf') { echo "2"; } ?>"><a href="./?mode=conf">設定</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] == 'que') { echo "2"; } ?>"><a href="./?mode=que">議案管理</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] == 'ele') { echo "2"; } ?>"><a href="./?mode=ele">候補者管理</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] == 'user') { echo "2"; } ?>"><a href="./?mode=user">ユーザー管理</a></li>
      <li class="link-top"><a href="../">トップへ</a></li>
    </ul>
    <div class="clear"><hr /></div>
  </div>
  <div id="inner">
<?php

if ($iniflg == 1) {
	echo "<div class=\"main\">\n";
	echo "<p class=\"init-com\">初期化設定が行われていません。このシステムを使用するためには下のボタンを押して、初期化設定を行ってください。</p>\n";
	echo "<div class=\"button-init\"><a href=\"initialization.php?set\">初期化設定</a></div>\n";
	echo "</div>\n";
} else {
	if ($_GET['mode'] === 'conf') {
		include("./conf.php");
	} else if ($_GET['mode'] === 'que') {
		include("./que.php");
	} else if ($_GET['mode'] === 'ele') {
		include("./ele.php");
	} else if ($_GET['mode'] === 'user') {
		include("./user.php");
	} else if ($_GET['mode'] === 'bu') {
		include("./bu.php");
	}
}

?>
  </div><!--innner:end-->
</div><!--wrapper:end-->
</body>
</html>
