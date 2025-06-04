<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../db/dbconnect.php");
require_once("../parts/function.php");

if (preg_match("/^https:\/\/.*\/administrator\/.*\?mode=(que|ele)$/",$_SERVER["HTTP_REFERER"])) {
	
	if (!isset($_POST['add-e'])) {
		
		if (isset($_GET['del_ele_id'])) {
			$sql = "delete from " . $tablename_ele . " where id = '" . $_GET['del_ele_id'] . "'";
			$res = mysql_query($sql, $conn);
			
			if ($res) {
				$_SESSION['status'] = "";
				header("Location: ./?mode=ele");
				exit;
			}
		} else if (isset($_GET['table_id'])) {
			$sql = "create table question" . $_GET['table_id'] . " (";
			$sql .= "id int(11) not null auto_increment,";
			$sql .= "kind varchar(50) character set utf8,";
			$sql .= "who varchar(50) character set utf8,";
			$sql .= "faculty varchar(10) character set utf8,";
			$sql .= "grade varchar(10) character set utf8,";
			$sql .= "subject varchar(10) character set utf8,";
			$sql .= "name varchar(70) character set utf8,";
			$sql .= "comment text character set utf8,";
			$sql .= "edit varchar(10) character set utf8,";
			$sql .= "writer varchar(70) character set utf8,";
			$sql .= "output varchar(10) character set utf8,";
			$sql .= "date datetime,";
			$sql .= "primary key (id)";
			$sql .= ")";
			
			$res = mysql_query($sql,$conn) or die("テーブル追加エラー");
			
			if ($res) {
				$_SESSION['status'] = "";
				header("Location: ./?mode=que");
				exit;
			}
		} else if (isset($_GET['drop_id'])) {
			$sql = "drop table question" . $_GET['drop_id'];
			$res = mysql_query($sql,$conn) or die("テーブル削除エラー");
			
			if ($row_usingnow['id'] == $_GET['drop_id']) {
				$sql = "UPDATE " . $tablename_tables . " SET ";
				$sql .= "usenow = 'no',";
				$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
				$sql .= " WHERE id = '" . $_GET['drop_id'] . "'";
				
				$res = mysql_query($sql,$conn) or die("データ編集エラー");
				
				$sql = "UPDATE " . $tablename_tables . " SET ";
				$sql .= "usenow = 'yes',";
				$sql .= "date = '" . date("Y/m/d H:i:s") . "'";
				$sql .= " WHERE kind = '6'";
				
				$res = mysql_query($sql,$conn) or die("データ編集エラー");
			}
			
			if ($res) {
				$_SESSION['status'] = "";
				header("Location: ./?mode=que");
				exit;
			}
		} else if (isset($_GET['delete_id'])) {
			$sql = "delete from " . $tablename_tables . " where id = '" . $_GET['delete_id'] . "'";
			$res = mysql_query($sql,$conn) or die("データ削除エラー");
			
			if ($res) {
				$_SESSION['status'] = "";
				header("Location: ./?mode=que");
				exit;
			}
		}
		
		$errflg = 0;
		
		if (preg_match("/^\s*([　]*\s*)*[　]*$/",$_POST['question'])) {
			$_SESSION['error1'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error1'] = "";
		}
		
		if ($_SERVER["REQUEST_METHOD"]  == "POST") {
			if($errflg == 0){
				if (!empty($_POST['faculty']) && !empty($_POST['grade']) && !empty($_POST['subject']) && !empty($_POST['fname']) && !empty($_POST['lname'])) {
					$faculty = cnv_dbstr($_POST['faculty']);
					$grade = cnv_dbstr($_POST['grade']);
					$subject = cnv_dbstr($_POST['subject']);
					$fname = cnv_dbstr($_POST['fname']);
					$lname = cnv_dbstr($_POST['lname']);
				} else {
					$faculty = "";
					$grade = "";
					$subject = "";
					$fname = "";
					$lname = "";
				}
				$question = cnv_dbstr($_POST['question']);
				
				$sql = "INSERT INTO " . $tablename_tables . " (kind ,faculty, grade, subject, fname, lname, question, usenow, date)";
				$sql .= "VALUES(";
				$sql .= "'1',";
				$sql .= "'" . $faculty . "',";
				$sql .= "'" . $grade . "',";
				$sql .= "'" . $subject . "',";
				$sql .= "'" . $fname . "',";
				$sql .= "'" . $lname . "',";
				$sql .= "'" . $question . "',";
				$sql .= "'no',";
				$sql .= "'" . date("Y/m/d H:i:s") . "'";
				$sql .= ")";
				
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
				if ($res) {
					$_SESSION['status'] = "";
					header("Location: ./?mode=que");
					exit;
				}
				
			} else {
				$_SESSION['kind'] = cnv_dbstr($_POST['kind']);
				$_SESSION['faculty'] = cnv_dbstr($_POST['faculty']);
				$_SESSION['grade'] = cnv_dbstr($_POST['grade']);
				$_SESSION['subject'] = cnv_dbstr($_POST['subject']);
				$_SESSION['fname'] = cnv_dbstr($_POST['fname']);
				$_SESSION['lname'] = cnv_dbstr($_POST['lname']);
				$_SESSION['question'] = cnv_dbstr($_POST['question']);
				
				$_SESSION['status'] = "que_re";
				header("Location: ./?mode=que");
				exit;
			}
		} else {
			$_SESSION['status'] = "que_ng";
			header("Location: ../parts/error_fin.php");
			exit;
		}
	
	} else {
		
		$errflg = 0;
			
		if (!isset($_POST['kind'])) {
			$_SESSION['error1'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error1'] = "";
		}
			
		if (!isset($_POST['faculty'])) {
			$_SESSION['error2'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error2'] = "";
		}
		
		if (!isset($_POST['grade'])) {
			$_SESSION['error3'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error3'] = "";
		}
		
		if (!isset($_POST['subject'])) {
			$_SESSION['error4'] = 1;
			$errflg = 1;
		} else {
			$_SESSION['error4'] = "";
		}
		
		if (isset($_POST['fname'])) {
			if (preg_match("/^\s*([　]*\s*)*[　]*$/",$_POST['fname'])) {
				$_SESSION['error5'] = 1;
				$errflg = 1;
			} else {
				$_SESSION['error5'] = "";
			}
		} else {
			$errflg = 1;
			$_SESSION['error5'] = "";
		}
		
		if (isset($_POST['lname'])) {
			if (preg_match("/^\s*([　]*\s*)*[　]*$/",$_POST['lname'])) {
				$_SESSION['error6'] = 1;
				$errflg = 1;
			} else {
				$_SESSION['error6'] = "";
			}
		} else {
			$errflg = 1;
			$_SESSION['error6'] = "";
		}
		
		if ($_SERVER["REQUEST_METHOD"]  == "POST") {
			if($errflg == 0){
				$kind = cnv_dbstr($_POST['kind']);
				$faculty = cnv_dbstr($_POST['faculty']);
				$grade = cnv_dbstr($_POST['grade']);
				$subject = cnv_dbstr($_POST['subject']);
				$fname = cnv_dbstr($_POST['fname']);
				$lname = cnv_dbstr($_POST['lname']);
			
				$sql = "INSERT INTO " . $tablename_ele . " (kind, faculty, grade, subject, fname, lname, output, date)";
				$sql .= "VALUES(";
				$sql .= "'" . $kind . "',";
				$sql .= "'" . $faculty . "',";
				$sql .= "'" . $grade . "',";
				$sql .= "'" . $subject . "',";
				$sql .= "'" . $fname . "',";
				$sql .= "'" . $lname . "',";
				$sql .= "'no',";
				$sql .= "'" . date("Y/m/d H:i:s") . "'";
				$sql .= ");";
			
				$res = mysql_query($sql,$conn) or die("データ追加エラー");
				
				if ($res) {
					$_SESSION['status'] = "";
					header("Location: ./?mode=ele");
					exit;
				}
			} else {
				$_SESSION['kind'] = cnv_dbstr($_POST['kind']);
				$_SESSION['faculty'] = cnv_dbstr($_POST['faculty']);
				$_SESSION['grade'] = cnv_dbstr($_POST['grade']);
				$_SESSION['subject'] = cnv_dbstr($_POST['subject']);
				$_SESSION['fname'] = cnv_dbstr($_POST['fname']);
				$_SESSION['lname'] = cnv_dbstr($_POST['lname']);
					
				$_SESSION['status'] = "ele_re";
				header("Location: ./?mode=ele");
				exit;
			}
		} else {
			$_SESSION['status'] = "ele_ng";
			header("Location: ../parts/error_fin.php");
			exit;
		}
	}
} else {
	$_SESSION['status'] = "";
	header("Location: ../parts/error_fin.php");
	exit;
}

?>