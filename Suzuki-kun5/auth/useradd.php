<?php

session_start();
$_SESSION = array();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");

$sql = "select * from " . $tablename_set . " where item = 'add'";
$res = mysql_query($sql,$conn);
$row = mysql_fetch_array($res,MYSQL_ASSOC);

if ($set['add'] === "no" || isset($_COOKIE['user_name'])) {
	header("Location: ../");
	exit;
}

if (isset($_GET['newadmin'])) {
	$sql =  "create table if not exists " . $tablename_user . " (";
	$sql .= "id int(11) not null auto_increment,";
	$sql .= "user varchar(70) not null,";
	$sql .= "passwd varchar(50) not null,";
	$sql .= "lname varchar(70) not null,";
	$sql .= "fname varchar(70) not null,";
	$sql .= "position varchar(50),";
	$sql .= "login datetime,";
	$sql .= "logout datetime,";
	$sql .= "makedate datetime not null,";
	$sql .= "useragent text character set utf8,";
	$sql .= "primary key (id)";
	$sql .= ")";
	
	$res = mysql_query($sql,$conn) or die("データ追加エラー");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>総会総合システム [ユーザー登録]</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/index_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../parts/js/auth.js"></script>
<script type="text/javascript" src="../parts/js/com.js"></script>
</head>
<body onkeypress="return vinfo(event);">
<div id="wrapper">
  <div class="useradd-window">
    <h1 class="title"><span class="title-1">総会管理システム</span><span class="title-2">南理くん</span></h1>
    <div class="clear"><hr /></div>
<?php

if (isset($_GET['newadmin'])) {
	echo "<h2 class=\"subtitle\">管理ユーザー登録</h2>";
} else {
	echo "<h2 class=\"subtitle\">ユーザー登録</h2>";
}

?>
<div class="clear"><hr /></div>
<?php

if (isset($_GET['add'])) {
	if (preg_match("/^re$/",$_GET['add'])) {
		echo "<p>入力にエラーがあります。</p>";
	} else if (preg_match("/^ng$/",$_GET['add'])) {
		echo "<p>無効なリクエストです。</p>";
	}
}

if (isset($_GET['newadmin'])) {
	echo "<p class=\"p-login\">管理ユーザーが存在しません。管理ユーザーを作成してください。</p>";
	echo "<form name=\"useraddform\" class=\"add-form\" method=\"post\" action=\"useradd_write.php?newadmin\">";
} else {
	echo "<form name=\"useraddform\" class=\"add-form\" method=\"post\" action=\"useradd_write.php\">";
}

?>
      <div class="name">
        <fieldset>
         <legend>名前</legend>
          姓 : <input type="text" name="lname" onfocus="FormCheckStart();" />
          名 : <input type="text" name="fname" onfocus="FormCheckStart();" />
        </fieldset>
      </div>
      <div class="user">
        <fieldset>
          <legend>ユーザー名(英数半角,ハイフン,アンダーバー)</legend>
          ユーザー名 : <input type="text" name="user" onfocus="FormCheckStart();" /><span id="usererr"></span>
        </fieldset>
      </div>
      <div class="passwd">
        <fieldset>
          <legend>パスワード(英数半角６文字以上,大文字小文字区別)</legend>
          パスワード　　　 : <input type="password" name="passwd" onfocus="FormCheckStart();" /><br />
          再入力パスワード : <input type="password" name="passwd2" onfocus="FormCheckStart();" /><span id="passwderr"></span>
        </fieldset>
      </div>
      <div class="submit">
        <input type="submit" name="submit" value="ユーザー登録" disabled="disabled"/>
      </div>
    </form>
  </div><!--useradd-window:end-->
</div><!--wrapper:end-->
</body>
</html>