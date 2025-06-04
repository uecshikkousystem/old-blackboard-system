<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8"); 
mb_http_input("auto");
mb_http_output("UTF-8");

require_once("./db/dbconnect.php");
require_once("./parts/com_info.php");
require_once("./parts/function.php");

$sql = "show tables like '". $tablename_user ."'";
$res = mysql_query($sql,$conn);
if (mysql_num_rows($res)) {
	$sql = "select * from " . $tablename_user . " where position = 'admin'";
	$res = mysql_query($sql, $conn) or die("データ抽出エラー");
	$num = mysql_num_rows($res);
}

if ($num == 0) {
	header("Location: ./auth/useradd.php?newadmin");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>総会総合システム<?php if (!isset($_COOKIE['user_name'])) { echo " [ログイン]"; } ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link href="./parts/css/default_style.css" rel="stylesheet" type="text/css" media="all" />
<link href="./parts/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="./parts/css/index_style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="./parts/js/com.js"></script>
<?php

if (!isset($_COOKIE['user_name']))
	echo "<script type=\"text/javascript\" src=\"./parts/js/login.js\"></script>\n";

echo "</head>";

if (!isset($_COOKIE['user_name'])) {
	echo "<body>";
} else {
	echo "<body onkeypress=\"return info(event);\">";
}

echo "<div id=\"wrapper\">";

if (isset($_COOKIE['user_name'])) {
	
	echo "<div id=\"header\">";
    echo "<h1 class=\"title\"><span class=\"title-1\">総会管理システム</span><span class=\"title-2\">南理くん</span></h1>";
	echo "<div class=\"userinfo\"><span class=\"loginuser\">ユーザー:</span>" . $row_login['lname'] . $row_login['fname'] . "<span class=\"posi\">[" . name_change($row_login['position']) . "]</span><span class=\"logout\"><a href=\"./auth/auth.php?mode=logout\">ログアウト</a></span></div>"; 
    echo "<div class=\"clear\"><hr /></div>";
	echo "</div>\n";
	echo "<div id=\"inner\">\n";
	
	echo "<div class=\"main\">";
	echo "<p class=\"title-index1\">審議内容スクリーン表示システム</p>";
	echo "<ul class=\"nav\">";
        
	if (preg_match("/^(writer|editer|admin)$/",$row_login['position'])) {
		echo "<li><a href=\"projecter/writer/\">発言投稿システム</a></li>";
	}
	
	if (preg_match("/^(editer|admin)$/",$row_login['position'])) {
		echo "<li><a href=\"projecter/editer/\">審議管理システム</a></li>";
	}
	
	if (preg_match("/^(gene|writer|editer|info|infoadmin|chairman|admin)$/",$row_login['position'])) {
        echo "<li><a href=\"projecter/output/?preview\">表示出力システム <span style=\"font-size:small\">[プレビュー]</span></a></li>";
	}
	
	if (preg_match("/^(admin|output)$/",$row_login['position'])) {
        echo "<li><a href=\"projecter/output/\">表示出力システム <span style=\"font-size:small\">[プロジェクター出力 (最適解像度:1280x720, F11キーで全画面表示)]</span></a></li>";
	}
	
	echo "</ul>";
	
	if (preg_match("/^(info|infoadmin|admin)$/",$row_login['position'])) {
		echo "<p class=\"title-index2\">総会受付システム</p>";
		echo "<ul class=\"nav\">";
        echo "<li><a href=\"account/\">受付システム</a></li>";
		echo "</ul>";
	}
	
	if (preg_match("/^(admin|chairman)$/",$row_login['position'])) {
		echo "<p class=\"title-index2\">議長システム</p>";
		echo "<ul class=\"nav\">";
        echo "<li><a href=\"projecter/president/\">議長システム</a></li>";
		echo "</ul>";
	}

	if (preg_match("/^(gene|writer|editer|info|infoadmin|chairman|admin)$/",$row_login['position'])) {
		echo "<p class=\"title-index2\">連絡用チャット</p>";
		echo "<ul class=\"nav\">";
		echo "<li><a href=\"chat/\">鈴木ったー</a></li>";
		echo "</ul>";
	}

	echo "</div>";
	echo "</div>";
	echo "<div id=\"footer\">";
	echo "<ul>";
	if (preg_match("/^(admin)$/",$row_login['position'])) {
		echo "<li><a href=\"administrator/\">管理画面</a></li>";
	}
	echo "<li><a href=\"#\" onclick=\"VerAlert(); return false;\">バージョン情報</li></ul>";
	echo "</div>";

} else {
	echo "<div class=\"login-window\">";
	echo "<h1 class=\"title\"><span class=\"title-1\">総会管理システム</span><span class=\"title-2\">南理くん</span></h1>";
	
	if (isset($_SESSION['status']) && $_SESSION['status'] === 'add_ok') {
		echo "<p id=\"p-login\"><span class=\"mes-ok\">ユーザー登録が完了しました。</span></p>";
	} else if (isset($_SESSION['status']) && $_SESSION['status'] === 'logout_ok') {
		echo "<p id=\"p-login\"><span class=\"mes-ok\">正しくログアウトしました。</span></p>";
	} else {
		echo "<p id=\"p-login\">ログインしてください。</p>";
	}
	
	if (isset($_SESSION['status'])) {
		if ($_SESSION['status'] === 'login_not') {
			echo "<p class=\"p-login\"><span class=\"mes-ng\">ユーザー名もしくはパスワードが正しくありません。</span></p>";
		} else if ($_SESSION['status'] === 'login_re') {
			echo "<p class=\"p-login\"><span class=\"mes-ng\">入力に不備があります。</span></p>";
		} else if ($_SESSION['status'] === 'ng') {
			echo "<p class=\"p-login\"><span class=\"mes-ng\">無効なリクエストです。</span></p>";
		}
	}
	
	echo "<form class=\"login-form\" method=\"post\" action=\"./auth/auth.php?mode=login\" autocomplete=\"off\">";
	echo "<div class=\"userpass\">";
	echo "ユーザー名 : <input ";
	if (isset($_SESSION['status']) && $_SESSION['status'] === 'login_re' && isset($_SESSION['errflg'][1]) && $_SESSION['errflg'][1] == 1) {
		echo " class=\"error2\"";
	}
	echo " type=\"text\" name=\"user\"";
	if (isset($_SESSION['status']) && $_SESSION['status'] === 'login_not') {
		echo " value=\"" . $_SESSION['form']['user'] . "\"";
	}
	echo " /><br />";
	echo "パスワード : <input ";
	if (isset($_SESSION['status']) && $_SESSION['status'] === 'login_re' && isset($_SESSION['errflg'][2]) && $_SESSION['errflg'][2] == 1) {
		echo " class=\"error2\"";
	}
	echo " type=\"password\" name=\"passwd\" /><br />";
	echo "</div>";
	echo "<div class=\"submit\">";
	echo "<input type=\"submit\" value=\"ログイン\" />";
	echo "</div>";
	echo "</form>";
	
	if ($set['add'] == "yes") {
		echo "<div class=\"useradd\"><a href=\"auth/useradd.php\">ユーザー登録</a></div>";
		echo "<div class=\"clear\"><hr /></div>";
	}
	
	echo "</div>\n";
}

$_SESSION = array();

?>
</div><!--wrapper:end-->
</body>
</html>
