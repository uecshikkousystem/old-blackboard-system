<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/com_info.php");
require_once("../../parts/function.php");

if (preg_match("/^https:\/\/.*\/projecter\/editer\/.*\?mode=vote.*$/",$_SERVER["HTTP_REFERER"])) {
	
	if (isset($_POST['vote'])) {
	
		$errflg = 0;
		
		if (empty($_POST['motion'])) {
			$_SESSION['error1'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error1'] = "";
		}
	
		if (!preg_match("/^\d{1,4}$/",$_POST['ok']) || preg_match("/^0.+$/",$_POST['ok'])) {
			$_SESSION['error2'] = 2;
			$errflg = 1;
		} else {
			$_SESSION['error2'] = "";
		}
		
		if (!preg_match("/^\d{1,4}$/",$_POST['ng']) || preg_match("/^0.+$/",$_POST['ng'])) {
			$_SESSION['error3'] = 2;
			$errflg = 1;
		} else {
			$_SESSION['error3'] = "";
		}
	
		if ($_SERVER["REQUEST_METHOD"]  == "POST") {
			if ($errflg == 0) {
				$name = cnv_dbstr($_POST['motion']);
				$ok = cnv_dbstr($_POST['ok']);
				$ng = cnv_dbstr($_POST['ng']);
				
				if ($_POST['motion'] != 'saiketsu') {
					if ($ok > $ng) {
						$comment = $ok . "," . $ng .  ",ok";
					} else if ($ok <= $ng) {
						$comment = $ok . "," . $ng .  ",ng";
					}
				} else {
					if ($set['cal'] == 'auto') {
						$sql = "select student_id from " . $tablename_account . " where status = 'gicho'";
						$res = mysql_query($sql,$conn);
						$inin = cnv_dbstr(mysql_num_rows($res));
					} else if ($set['cal'] == 'manual') {
						$sql = "select num_inin from " . $tablename_num . " ORDER BY id DESC";
						$res = mysql_query($sql, $conn) or die("データ抽出エラー");
						$row = mysql_fetch_array($res, MYSQL_ASSOC);
						$inin = cnv_dbstr($row['num_inin']);
					}
					
					if ($ok > $ng) {
						$sum = $ok + $inin;
						$comment =  $sum . "(" . $ok . "+" . $inin . ")" . "," . $ng . ",ok";
					} else if ($ok <= $ng) {
						$sum = $ng + $inin;
						$comment = $ok . "," . $sum . "(" . $ng . "+" . $inin . "),ng";
					}	
				}
			
				$sql = "INSERT INTO " . $tablename . "(kind, name, comment, edit, writer, output, date)";
				$sql .= "VALUES(";
				$sql .= "'vote',";
				$sql .= "'" . $name . "',";
				$sql .= "'" . $comment . "',";
				$sql .= "'no',";
				$sql .= "'" . $_COOKIE['user_name'] . "',";
				$sql .= "'no',";
				$sql .= "'" . date("Y/m/d H:i:s") . "'";
				$sql .= ")";
				
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
					
				if ($res) {
					$_SESSION['status'] = "";
					header("Location: ./index.php?mode=edit");
					exit;
				}
			} else {
				
				if (!empty($_POST['motion'])) {
					$_SESSION['motion'] = cnv_dbstr($_POST['motion']);
				} else {
					$_SESSION['motion'] = "";
				}
				
				$_SESSION['ok'] = cnv_dbstr($_POST['ok']);
				$_SESSION['ng'] = cnv_dbstr($_POST['ng']);
				
				$_SESSION['status'] = "vote_re";
				header("Location: ./index.php?mode=vote");
				exit;
			}
		} else {
			$_SESSION['status'] = "vote_ng";
			header("Location: ../../parts/error_fin.php");
			exit;
		}
	
	} else if (isset($_POST['ele'])) {
		
		if (empty($_POST['name'])) {
			$_SESSION['error1'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error1'] = "";
		}
		
		if (!preg_match("/^\d{1,4}$/",$_POST['ok']) || preg_match("/^0.+$/",$_POST['ok'])) {
			$_SESSION['error2'] = 2;
			$errflg = 1;
		} else {
			$_SESSION['error2'] = "";
		}
		
		if (!preg_match("/^\d{1,4}$/",$_POST['ng']) || preg_match("/^0.+$/",$_POST['ng'])) {
			$_SESSION['error3'] = 2;
			$errflg = 1;
		} else {
			$_SESSION['error3'] = "";
		}
		
		if ($_SERVER["REQUEST_METHOD"]  == "POST") {
			if($errflg == 0){
				
				$sql_name = "select * from " . $tablename_ele . " where id = '" . $_POST['name'] . "'";
				$res_name = mysql_query($sql_name, $conn);
				$row_name = mysql_fetch_array($res_name,MYSQL_ASSOC);
				
				$ok = cnv_dbstr($_POST['ok']);
				$ng = cnv_dbstr($_POST['ng']);
				
				if ($set['cal'] == 'auto') {
					$sql = "select student_id from " . $tablename_account . " where status = 'gicho'";
					$res = mysql_query($sql,$conn);
					$inin = cnv_dbstr(mysql_num_rows($res));
				} else if ($set['cal'] == 'manual') {
					$sql = "select num_inin from " . $tablename_num . " ORDER BY id DESC";
					$res = mysql_query($sql, $conn) or die("データ抽出エラー");
					$row = mysql_fetch_array($res, MYSQL_ASSOC);
					$inin = cnv_dbstr($row['num_inin']);
				}
				
				if ($ok > $ng) {
					$sum = $ok + $inin;
					$comment =  $sum . "(" . $ok . "+" . $inin . ")" . "," . $ng . ",ok";
				} else if ($ok <= $ng) {
					$sum = $ng + $inin;
					$comment = $ok . "," . $sum . "(" . $ng . "+" . $inin . "),ng";
				}
			
				$sql = "INSERT INTO " . $tablename_ele . " (kind, faculty, grade, subject, fname, lname, comment, output, date)";
				$sql .= "VALUES(";
				$sql .= "'vote-" . $row_name['kind'] . "',";
				$sql .= "'" . $row_name['faculty'] . "',";
				$sql .= "'" . $row_name['grade'] . "',";
				$sql .= "'" . $row_name['subject'] . "',";
				$sql .= "'" . $row_name['fname'] . "',";
				$sql .= "'" . $row_name['lname'] . "',";
				$sql .= "'" . $comment . "',";
				$sql .= "'no',";
				$sql .= "'" . date("Y/m/d H:i:s") . "'";
				$sql .= ");";
			
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
				if ($res) {
					$_SESSION['status'] = "";
					header("Location: ./index.php?mode=edit");
					exit;
				}
			} else {
				$_SESSION['name'] = cnv_dbstr($_POST['name']);
				$_SESSION['ok'] = cnv_dbstr($_POST['ok']);
				$_SESSION['ng'] = cnv_dbstr($_POST['ng']);
				
				$_SESSION['status'] = "vote_re";
				header("Location: ./index.php?mode=vote");
				exit;
			}
		}
	 
	} else {
		$_SESSION['status'] = "vote_ng";
		header("Location: ../../parts/error_fin.php");
		exit;
	}
	
} else {
	$_SESSION['status'] = "vote_ng";
	header("Location: ../../parts/error_fin.php");
	exit;
}

?>