<?php
  
mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");


include("./dbuser/dbuser.php");
$conn = mysql_connect($sv, $user, $pass);

if ($conn) {
	header("Location: http://" . $_SERVER['HTTP_HOST']);
	exit;
}

//chmod("./dbuser", 0777);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>総会総合システム [データベース登録]</title>
<link href="../parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/index_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../parts/js/com.js"></script>
</head>
<body onkeypress="return vinfo(event);">
<div id="wrapper">
  <div class="dbregi-window">
    <h1 class="title"><span class="title-1">総会管理システム</span><span class="title-2">南理くん</span></h1>
    <div class="clear"><hr /></div>
    <p><br />データベースに問題があります。<br />MySQLの動作, MySQLのユーザーに問題がないか確認してください。</p>
    <!--<h2 class="subtitle">データベース登録</h2>
    <div class="clear"><hr /></div>
    <form method="post" action="#">
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
    </form>-->
  </div><!--dbregi-window:end-->
</div><!--wrapper:end-->
</body>
</html>