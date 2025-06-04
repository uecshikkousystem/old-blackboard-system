<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

if (!isset($_COOKIE['user_name']) || !preg_match("/^(editer|admin)$/",$row_login['position'])) {
	header("Location: ../../");
	exit;
}

if (!isset($_GET['mode'])) {
	header("Location: ./?mode=edit");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php

$ary = array('edit' => '[投稿編集管理]', 'question' => '[議案選択]', 'motion' => '[動議入力]', 'vote' => '[採決入力]', 'num' => '[票数入力]');

foreach ($ary as $key => $value) {
	if ($_GET['mode'] == $key) {
		echo "<title>審議管理システム " . $value . "</title>";
	}
}

echo "<link href=\"../../parts/css/default_style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />";
echo "<link href=\"../../parts/css/style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />";

$ary = array('edit', 'question', 'motion', 'vote', 'num');

foreach ($ary as $value) {
	if ($_GET['mode'] == $value) {
		echo "<link href=\"../../parts/css/" . $value . "_style.css\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />";
	}
}

echo "<script type=\"text/javascript\" src=\"../../parts/js/stop_submit.js\"></script>";

if ($_GET['mode'] == 'edit') {
	echo "<script type=\"text/javascript\" src=\"../../parts/js/edit_reload.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"../../parts/js/subject_ch.js\"></script>\n";
} else {
	echo "<script type=\"text/javascript\" src=\"../../parts/js/title_reload.js\"></script>\n";
}

?>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <h1 class="title">審議内容スクリーン表示システム</h1>
    <div class="userinfo"><span class="loginuser">ユーザー:</span><?php echo $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']); ?>]</span><span class="logout"><a href="../../auth/auth.php?mode=logout">ログアウト</a></span></div> 
    <div class="clear"><hr /></div>
    <h2 class="subtitle">審議管理システム [投稿編集管理]</h2>
    <div class="clear"><hr /></div>
    <ul class="link-list">
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] === 'edit') { echo "2"; } ?>"><a href="./?mode=edit">投稿編集管理</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] === 'question') { echo "2"; } ?>"><a href="./?mode=question">議案選択</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] === 'motion') { echo "2"; } ?>"><a href="./?mode=motion">動議入力</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] === 'vote') { echo "2"; } ?>"><a href="./?mode=vote">採決入力</a></li>
      <li class="link-button<?php if (isset($_GET['mode']) && $_GET['mode'] === 'num') { echo "2"; } ?>"><a href="./?mode=num">票数入力</a></li>
      <li class="link-top"><a href="../../">トップへ</a></li>
    </ul>
    <div class="clear"><hr /></div>
  </div>
  <div id="inner">
    <div id="space-title">
    </div>
<?php

$ary = array('question' => 'que_re', 'motion' => 'motion_re', 'vote' => 'vote_re', 'num' => 'num_re');

foreach ($ary as $key => $value) {
	if ($_GET['mode'] == $key) {
		if (isset($_SESSION['status'])) {
			if (!preg_match("/^$value/",$_SESSION['status'])) {
				$_SESSION['status'] = "";
			}
		} else {
			$_SESSION['status'] = "";
		}
	}
}


if ($_GET['mode'] === 'edit') {
	require_once("./edit.php");
} else if ($_GET['mode'] === 'question') {
	require_once("./question.php");
} else if ($_GET['mode'] === 'motion') {
	if (!preg_match("/^kochokai$/", $set['kind'])) {
		if ($row_usingnow['kind'] == 1) {
			require_once("./motion.php");
		} else {
			echo "<div class=\"main\"><p>現在、動議は入力できません。</p></div>";
		}
	} else {
		echo "<div class=\"main\"><p>公聴会のため、動議は入力できません。</p></div>";
	}
} else if ($_GET['mode'] === 'vote') {
	if (!preg_match("/^kochokai$/", $set['kind'])) {
		if ($row_usingnow['kind'] == 1) {
			require_once("./gene_vote.php");
		} else if ($row_usingnow['kind'] == 2) {
			$sql = "select id from " . $tablename_ele . " where (kind = 'main' or kind = 'sub')";
			$res = mysql_query($sql, $conn);
				
			if (mysql_num_rows($res) > 0) {
				require_once("./ele_vote.php");
			} else {
				echo "<div class=\"main\"><p>立候補者が未入力です。</p></div>";
			}
		} else {
			echo "<div class=\"main\"><p>現在、採決は入力できません。</p></div>";
		}
	} else {
		echo "<div class=\"main\"><p>公聴会のため、採決は入力できません。</p></div>";
	}	
} else if ($_GET['mode'] === 'num') {
	if (!preg_match("/^kochokai$/", $set['kind'])) {
		require_once("./num.php");
	} else {
		echo "<div class=\"main\"><p>公聴会のため、票数は入力できません。</p></div>";
	}
}

?>
  </div><!--innner:end-->
</div><!--wrapper:end-->
</body>
</html>