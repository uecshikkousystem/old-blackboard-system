<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

if (preg_match("/^http:\/\/.*\/administrator\/.*\?mode=user.*$/",$_SERVER["HTTP_REFERER"])) {
	
	if (preg_match("/^del$/",$_GET['user']) && isset($_GET['id'])) {
		$sql = "delete from " . $tablename_user . " where id = '" . $_GET['id'] . "'";
		$res = mysql_query($sql, $conn);
		
		exit;
		
	} else if (preg_match("/^edit$/",$_GET['user']) && isset($_GET['id']))  {
		
		$errflg = 0;
		
		if (!isset($_GET['admin'])) {
			if (empty($_POST['position'])) {
				$errflg = 1;
				$err[1] = 1;
			}
		} 
		
		if (empty($_POST['lname'])) {
			$errflg = 1;
			$err[2] = 1;
		}
		
		if (empty($_POST['fname'])) {
			$errflg = 1;
			$err[3] = 1;
		}
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($errflg == 0) {
				$lname = cnv_dbstr($_POST['lname']);
				$fname = cnv_dbstr($_POST['fname']);
				if (isset($_GET['admin'])) {
					$position = "admin";
				} else {
					$position = cnv_dbstr($_POST['position']);
				}
					
				$sql = "UPDATE " . $tablename_user . " SET ";
				$sql .= "lname = '" . $lname . "',";
				$sql .= "fname = '" . $fname . "',";
				$sql .= "position = '" . $position . "'";
				$sql .= " WHERE id = '" . $_GET['id'] . "'";
				
				$res = mysql_query($sql,$conn) or die("ユーザー編集エラー");
				
				if ($res) {
					$url = "../administrator/index.php?mode=user&edit=ok";
					header("Location: $url");
					exit;
				}
			} else {
				$url = "../administrator/index.php?mode=user&edit=re";
			
				for ($i=1; $i<=3; $i++) {
					if (isset($err[$i])) {
						$url .= "&err" . $i;
					}
				}
			
				header("Location: $url");
				exit;
			}
		}
	}
}
?>