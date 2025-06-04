<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/function.php");

if (preg_match("/^http:\/\/.*\/projecter\/(writer|editer)/",$_SERVER["HTTP_REFERER"])) {
	
	if ($row_usingnow['kind'] != 1) {
		$_SESSION['status'] = "cannot";
		header("Location: ../../parts/error_fin.php");
		exit;
	}
	
	$errflg = 0;
	
	if (empty($_POST['kind'])) {
		$_SESSION['error1'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error1'] = "";
	}

	if (empty($_POST['who'])) {
		$_SESSION['error2'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error2'] = "";

	}
	
	if (preg_match("/^general$/",$_POST['who'])) {
		
		if (empty($_POST['faculty'])) {
			$_SESSION['error3'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error3'] = "";
		}
		
		if (empty($_POST['grade'])) {
			$_SESSION['error4'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error4'] = "";
		}
		
		if (empty($_POST['subject'])) {
			$_SESSION['error5'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error5'] = "";
		}
		
		if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['name'])) {
			$_SESSION['error6'] = 1;
			$errflg = 1;
		} else if (!preg_match("/^[ぁ-ゞ]+$/u",$_POST['name'])) {
			$_SESSION['error6'] = 2;
			$errflg = 1;
		} else {
			$_SESSION['error6'] = "";
		}
	} else {
		$_SESSION['error3'] = "";
		$_SESSION['error4'] = "";
		$_SESSION['error5'] = "";
		$_SESSION['error6'] = "";
	}
	
	if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['comment'])) {
		$_SESSION['error7'] = 1;
		$errflg = 1;
	} else {
		$_SESSION['error7'] = "";
	}
	
	if ($_SERVER["REQUEST_METHOD"]  == "POST") {
		if($errflg == 0){
			$kind = cnv_dbstr($_POST["kind"]);
			
			setcookie('kind','',time() - 60);
			setcookie('kind',$kind,time() + 1 * 3600);
			
			$who = cnv_dbstr($_POST['who']);
			if (preg_match("/^general$/",$_POST['who'])) {
					$faculty = cnv_dbstr($_POST['faculty']);
					$grade = cnv_dbstr($_POST['grade']);
					$subject = cnv_dbstr($_POST['subject']);
					$name = cnv_dbstr(char_change($_POST['name']));
			} else {
				$faculty = "";
				$grade = "";
				$subject = "";
				$name = "";
			}
			$comment = cnv_dbstr($_POST['comment']);
			
			$sql = "INSERT INTO " . $tablename . "(kind, who, faculty, grade, subject, name, comment, edit, writer, output, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $kind . "',";
			$sql .= "'" . $who . "',";
			$sql .= "'" . $faculty . "',";
			$sql .= "'" . $grade . "',";
			$sql .= "'" . $subject . "',";
			$sql .= "'" . $name . "',";
			$sql .= "'" . $comment . "',";
			$sql .= "'no',";
			$sql .= "'" . $_COOKIE['user_name'] . "',";
			$sql .= "'no',";
			$sql .= "'" . date("Y/m/d H:i:s") . "'";
			$sql .= ")";
				
			$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
			if ($res) {
				$_SESSION['status'] = "write_ok";
				
				$url = (isset($_GET['mode']) && $_GET['mode'] === "fromedit") ? "../../parts/fin.php?edit" : "../../parts/fin.php";
				header("Location: " . $url);
				exit;
			}
			
		} else {
			if (empty($_SESSION['error1'])) {
				$_SESSION['kind'] = cnv_dbstr($_POST['kind']);
			}
			if (empty($_SESSION['error2'])) {
				$_SESSION['who'] = cnv_dbstr($_POST['who']);
				if (preg_match("/^general$/",$_POST['who'])) {
					if (empty($_SESSION['error3'])) {
						$_SESSION['faculty'] = cnv_dbstr($_POST['faculty']);
					}
					if (empty($_SESSION['error4'])) {
						$_SESSION['grade'] = cnv_dbstr($_POST['grade']);
					}
					if (empty($_SESSION['error5'])) {
						$_SESSION['subject'] = cnv_dbstr($_POST['subject']);
					}
					if (empty($_SESSION['error6']) or $_SESSION['error6'] == 2) {
						$_SESSION['name'] = cnv_dbstr($_POST['name']);
					}
				} else {
					$_SESSION['faculty'] = "";
					$_SESSION['grade'] = "";
					$_SESSION['subject'] = "";
					$_SESSION['name'] = "";
				}
			}
			if (empty($_SESSION['error7'])) {
				$_SESSION['comment'] = cnv_dbstr($_POST['comment']);
			}
			
			$url = (isset($_GET['mode']) && $_GET['mode'] === "fromedit") ? "../editer/?mode=edit&re" : "./?status=re";				
			header("Location: " . $url);
			exit;
		}
	} else {
		$_SESSION['status'] = "write_ng";
		header("Location: ../../parts/error_fin.php");
		exit;
	}
} else {
	$_SESSION['status'] = "write_ng";
	header("Location: ../../parts/error_fin.php");
	exit;
}

?>