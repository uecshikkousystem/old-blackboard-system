<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");
echo"1ok";
	
	$errflg = 0;
//	
//		if (empty($_POST['faculty'])) {
//			$_SESSION['error3'] = 1;
//			$errflg = 1;
//		} else {
//			$_SESSION['error3'] = "";
//		}
//		
//		if (empty($_POST['grade'])) {
//			$_SESSION['error4'] = 1;
//			$errflg = 1;
//		} else {
//			$_SESSION['error4'] = "";
//		}
		
		
//		if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['name'])) {
//			$_SESSION['error6'] = 1;
//			$errflg = 1;
//		} else if (!preg_match("/^[ぁ-ゞ]+$/u",$_POST['name'])) {
//			$_SESSION['error6'] = 2;
//			$errflg = 1;
//		} else {
//			$_SESSION['error6'] = "";
//		}
//	} else {
//		$_SESSION['error3'] = "";
//		$_SESSION['error4'] = "";
////		$_SESSION['error5'] = "";
//		$_SESSION['error6'] = "";
//	}
//	
//	if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['comment'])) {
//		$_SESSION['error7'] = 1;
//		$errflg = 1;
//	} else {
//		$_SESSION['error7'] = "";
//	}
	
//	if ($_SERVER["REQUEST_METHOD"]  == "POST") {
//		if($errflg == 0){			

			echo"2ok";
					$tablename = "audience";	
					$faculty = cnv_dbstr($_POST['faculty']);
					$grade = cnv_dbstr($_POST['grade']);
					$subject = cnv_dbstr($_POST['subject']);
					$name = cnv_dbstr(char_change($_POST['name']));
			$comment = cnv_dbstr($_POST['comment']);
			$check = no ;			
			$sql = "INSERT INTO " . $tablename . "( faculty, grade, name, comment, check, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $faculty . "',";
			$sql .= "'" . $grade . "',";
			$sql .= "'" . $name . "',";
			$sql .= "'" . $comment . "',";
			$sql .= "'no',";
			$sql .= "'" . date("Y/m/d H:i:s") . "'";
			$sql .= ")";
				
			$res = mysql_query($sql,$conn) or die("データ追加エラー");
				echo"$res";
			if ($res) {
				$_SESSION['status'] = "a_write_ok";
				
				$url = (isset($_GET['mode']) && $_GET['mode'] === "fromedit") ? "../parts/fin.php?audience" : "../parts/fin.php";
				header("Location: " . $url);
				exit;
			
			
		} else { echo "エラー"}
 



?>
