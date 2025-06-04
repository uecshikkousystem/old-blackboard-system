<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/com_info.php");
require_once("../parts/function.php");

if (preg_match("/^http:\/\/.*\/chat\//",$_SERVER["HTTP_REFERER"])) {
	
	if (isset($_GET['mode']) && isset($_GET['id'])) {
		$sql = "select user from " . $tablename_chat . " where id = '" . $_GET['id'] . "'";	
		$res = mysql_query($sql, $conn);
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
		$user_name = $_COOKIE['user_name'];
		
		if (preg_match("/^$user_name$/",$row['user']) || preg_match("/^admin$/",$row_login['position'])) {
			$sql = "delete from " . $tablename_chat . " where id = '" . $_GET['id'] . "'";
			$res = mysql_query($sql,$conn) or die("データ削除エラー");
		} else {
			die("削除エラー");
		}
		
	} else {
		$errflg = 0;
		
		if (empty($_POST['addr'])) {
			$_SESSION['error1'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error1'] = "";
		}
	
		if (preg_match("/^\s*([　]*\s*)*[　]*$/u",$_POST['comment'])) {
			$_SESSION['error2'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error2'] = "";
		}
			
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if($errflg == 0){
				$user = cnv_dbstr($_COOKIE['user_name']);
				$position = cnv_dbstr($_GET['posi']);	
				$addr = cnv_dbstr($_POST['addr']);			
				$comment = chat_dbstr($_POST['comment']);

				$sql = "INSERT INTO " . $tablename_chat . "(user, position, addr, comment, date)";
				$sql .= "VALUES(";
				$sql .= "'" . $user . "',";
				$sql .= "'" . $position . "',";
				$sql .= "'" . $addr . "',";
				$sql .= "'" . $comment . "',";
				$sql .= "'" . date("Y/m/d H:i:s") . "'";
				$sql .= ")";
					
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
				if ($res) {
					$_SESSION['status'] = "";
					
					if (isset($_GET['all']))
						header("Location: ./?all");
					else
						header("Location: ./");
						
					exit;
				}
			} else {
				$_SESSION['addr'] = cnv_dbstr($_POST['addr']);
				$_SESSION['comment'] =cnv_dbstr($_POST['comment']);
			
				$_SESSION['status'] = "re";
				
				if (isset($_GET['all']))
					header("Location: ./?all");
				else
					header("Location: ./");
				
				exit;
			}
		}
	}
}

?>