<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(gene|writer|editer|info|infoadmin|chairman|admin)$/",$row_login['position'])) {
	header("Location: ../");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>鈴木ったー</title>
<link href="../parts/css/default_style_chat.css" rel="stylesheet" type="text/css" media="all" />
<link href="../parts/css/chat_style.css" rel="stylesheet" type="text/css" media="all" />
<?php

if (isset($_GET['all'])) {
	echo "<script type=\"text/javascript\" src=\"../parts/js/chat_admin.js\"></script>";
} else {
	echo "<script type=\"text/javascript\" src=\"../parts/js/chat.js\"></script>";
}

?>
</head>
<body>
<div id="wrapper">
  <div id="inner">
    <div class="box-top"><hr /></div>
    <div class="main-chat">
      <div class="title"><img src="../parts/image/title_s1.gif" width="200" height="45" alt="鈴木ったー" /></div>
      <p class="top"><a href="../">トップへ</a></p>
<?php

if (preg_match("/^admin$/",$row_login['position'])) {
	if (isset($_GET['all'])) {
		echo "<p class=\"top\"><a href=\"./\">通常表示</a></p>";
	} else {
		echo "<p class=\"top\"><a href=\"./?all\">全表示</a></p>";
	}
}

$pos_tmp = ($row_login['position'] === 'infoadmin') ? 'info' : $row_login['position'];

?>
      <div class="clear"><hr /></div>
      <div class="form-space">
      <form name="chatform" method="post" action="write.php?posi=<?php echo $pos_tmp; if (isset($_GET['all'])) { echo "&all"; } ?>">
      <div class="addr">
<?php

echo "<span>送信者 : " . $row_login['lname'] . $row_login['fname'] . "<span class=\"posi-name\">[" . name_change($pos_tmp) . "]</span></span><br /><span>宛先 : </span>";

$aryname = array('all' => '全ユーザー', 'writer' => '黒板(入力者)', 'editer' => '黒板(編集者)', 'info' => '受付', 'chairman' => '議長', 'admin' => 'システム管理');
	
foreach ($aryname as $key => $value) {
	echo "<input type=\"radio\" id=\"" . $key . "\" name=\"addr\" value=\"" . $key . "\"";
	if ($key == 'all') {
		echo " checked=\"checked\"";
	}
	echo " /><label for=\"" . $key . "\">" . $value . "</label>\n";
}

?>
		  </div>
    	  <div class="comment">
        <textarea name="comment" rows="3" cols="100"></textarea>
      </div>
  	  <div class="submit">
        <input name="submit" type="submit" value="鈴木ーと" disabled="disabled" />
      </div>
	  </form>
      </div>
    </div><!--main-chat:end-->
    <!--<div class="box-bottom"><hr /></div>-->
    <div class="box-top"><hr /></div>
    <div class="main-chat">
      <div id="new"></div>
      <div id="main-chat"></div>
    </div>
    <div class="box-bottom"><hr /></div>
  </div><!--inner:end-->
</div><!--wrapper:end-->
</body>
</html>
