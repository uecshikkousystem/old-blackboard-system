<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(gene|writer|editer|info|infoadmin|chairman|output|admin)$/",$row_login['position'])) {
	header("Location: ../../");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>表示出力システム<?php if (isset($_GET['preview'])) { echo " [プレビュー]"; } ?></title>
<link href="../../parts/css/default_style_output.css" rel="stylesheet" type="text/css" media="all" />
<link href="../../parts/css/output_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../../parts/js/output_reload.js"></script>
</head>
<?php

if (isset($_GET['preview'])) {
	echo "<body>";
} else {
	echo "<body style=\"overflow:hidden\">";
}

?>
<div id="inner">
<?php

if (preg_match("/^sokai$/", $set['kind'])) {
	echo "<div class=\"top-title\">第" . $set['num'] . "回<div class=\"gakuyu\">学友会</div>総会";
} else if (preg_match("/^kochokai$/", $set['kind'])) {
	echo "<div class=\"top-title\"><div class=\"gakuyu\">第" . $set['num'] . "回学友会総会</div>公聴会";
} else {
	echo "<div class=\"top-title\"><div class=\"gakuyu\">第" . $set['num'] . "回学友会総会</div>意見交換会";
}
echo "<div id=\"num\"></div>";
echo "<div class=\"clear\"><hr /></div></div>";

?>
    <div id="list"></div>
    <div id="ng">障害が発生しました。しばらくお待ちください。</div>
  </div><!--inner:end-->
</body>
</html>
