<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

$_SESSION['status'] = '';
$_SESSION['form'] = array();
$_SESSION['errflg'] = array();
$errflg = 0;

if (preg_match("/^http:\/\/.*\/(index\.php|).*$/",$_SERVER["HTTP_REFERER"])) {

	if (preg_match("/^login$/",$_GET['mode'])) {

		if (empty($_POST['user'])) {
			$errflg = 1;
			$_SESSION['errflg'][1] = 1;
		}

		if (empty($_POST['passwd'])) {
			$errflg = 1;
			$_SESSION['errflg'][2] = 1;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($errflg == 0) {

				$user = strtolower($_POST['user']);

				$sql = "select * from " . $tablename_user . " where user = '" . $user . "'";
				$res = mysql_query($sql, $conn) or die("データ抽出エラー");
				$row = mysql_fetch_array($res,MYSQL_ASSOC);

				if (md5($_POST['passwd']) === $row['passwd']) {
					if ($_SERVER['HTTP_USER_AGENT']) {
						$useragent = cnv_dbstr($_SERVER["REMOTE_ADDR"] . ";" . $_SERVER['HTTP_USER_AGENT']);
					} else {
						$useragent = "";
					}

					$sql_login = "UPDATE " . $tablename_user . " SET ";
					$sql_login .= "login = '" . date("Y/m/d H:i:s") . "',";
					$sql_login .= "logout = NULL,";
					$sql_login .= "useragent = '" . $useragent . "'";
					$sql_login .= " WHERE user = '" . $user . "'";

					$res_login = mysql_query($sql_login,$conn);
					if (!$res_login){
						die("Error: " . mysql_error());
					}

					if ($res_login) {
						setcookie('user_name', $row['user'], 0, '/');

						header("Location: ../");
						exit;
					}
				} else {
					$_SESSION['form']['user'] = $_POST['user'];
					$_SESSION['status'] = 'login_not';
					header("Location: ../");
					exit;
				}
			} else {
				$_SESSION['status'] = 'login_re';
				header("Location: ../");
				exit;
			}
		} else {
			$_SESSION['status'] = 'ng';
			header("Location: ../");
			exit;
		}
	} else if (preg_match("/^logout$/",$_GET['mode'])) {
		if (isset($_COOKIE['user_name'])) {
			$user_name = $_COOKIE['user_name'];

			$useragent = ($_SERVER['HTTP_USER_AGENT']) ? cnv_dbstr($_SERVER["REMOTE_ADDR"] . ";" . $_SERVER['HTTP_USER_AGENT']) : '';

			$sql_logout = "UPDATE " . $tablename_user . " SET ";
			$sql_logout .= "logout = '" . date("Y/m/d H:i:s") . "',";
			$sql_logout .= "useragent = '" . $useragent . "'";
			$sql_logout .= " WHERE user = '" . $user_name . "'";

			$res_logout = mysql_query($sql_logout,$conn) or die("データ追加エラー");

			if ($res_logout) {
				setcookie('user_name', '', time() - 60, '/');

				$_SESSION['status'] = 'logout_ok';
				header("Location: ../");
				exit;
			}
		} else {
			$_SESSION['status'] = 'ng';
			header("Location: ../");
			exit;
		}
	} else {
		$_SESSION['status'] = 'ng';
		header("Location: ../");
		exit;
	}
} else {
	$_SESSION['status'] = 'ng';
	header("Location: ../");
	exit;
}

?>
