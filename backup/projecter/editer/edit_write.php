<?php

session_start();

mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

require_once("../../db/dbconnect.php");
require_once("../../parts/function.php");

if (preg_match("/^https:\/\/.*\/projecter\/editer\/.*\?mode=edit.*$/",$_SERVER["HTTP_REFERER"])) {
	
	if (isset($_GET['mode']) && preg_match("/up/",$_GET['mode'])) {
		$up_id = preg_replace("/up([\d]+)$/","$1",$_GET['mode']);
		$up_id2 = $up_id + 1;
		
		if ($row_usingnow['kind'] == 2) {
			$sql_one = "select * from " . $tablename_ele . " where ID = '" . $up_id2 . "'";
		} else {
			$sql_one = "select * from " . $tablename . " where ID = '" . $up_id2 . "'";
		}
		$res_one = mysql_query($sql_one,$conn) or die("データ抽出エラー");
		$row_one = mysql_fetch_array($res_one,MYSQL_ASSOC);
		
		if (empty($row_one['id'])) {
			exit;
		}
		
		if ($row_usingnow['kind'] == 2) {
			$kind_one = $row_one['kind'];
			$faculty_one = $row_one['faculty'];
			$grade_one = $row_one['grade'];
			$subject_one = $row_one['subject'];
			$fname_one = $row_one["fname"];
			$lname_one = $row_one["lname"];
			$comment_one = $row_one['comment'];
			$output_one = $row_one['output'];
			$date_one = $row_one['date'];
		} else {
			$kind_one = $row_one['kind'];
			$who_one = $row_one['who'];
			$faculty_one = $row_one['faculty'];
			$grade_one = $row_one['grade'];
			$subject_one = $row_one['subject'];
			$name_one = $row_one['name'];
			$comment_one = $row_one['comment'];
			$edit_one = $row_one['edit'];
			$writer_one = $row_one['writer'];
			$output_one = $row_one['output'];
			$date_one = $row_one['date'];
		}
		
		if ($row_usingnow['kind'] == 2) {
			$sql = "select * from " . $tablename_ele . " where ID = '" . $up_id . "'";
		} else {
			$sql = "select * from " . $tablename . " where ID = '" . $up_id . "'";
		}
		$res = mysql_query($sql,$conn) or die("データ抽出エラー");	
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
		
		if ($row_usingnow['kind'] == 2) {
			$sql = "REPLACE INTO " . $tablename_ele . " (id, kind, faculty, grade, subject, fname, lname, comment, output, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $up_id2 . "',";
			$sql .= "'" . $row['kind'] . "',";
			$sql .= "'" . $row['faculty'] . "',";
		    $sql .= "'" . $row['grade'] . "',";
			$sql .= "'" . $row['subject'] . "',";
			$sql .= "'" . $row['fname'] . "',";
			$sql .= "'" . $row['lname'] . "',";
			$sql .= "'" . $row['comment'] . "',";
			$sql .= "'" . $row['output'] . "',";
			$sql .= "'" . $row['date'] . "'";
			$sql .= ")";
		} else {
			$sql = "REPLACE INTO " . $tablename . " (id, kind, who, faculty, grade, subject, name, comment, edit, writer, output, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $up_id2 . "',";
			$sql .= "'" . $row['kind'] . "',";
			$sql .= "'" . $row['who'] . "',";
			$sql .= "'" . $row['faculty'] . "',";
		    $sql .= "'" . $row['grade'] . "',";
			$sql .= "'" . $row['subject'] . "',";
			$sql .= "'" . $row['name'] . "',";
			$sql .= "'" . $row['comment'] . "',";
			$sql .= "'" . $row['edit'] . "',";
			$sql .= "'" . $row['writer'] . "',";
			$sql .= "'" . $row['output'] . "',";
			$sql .= "'" . $row['date'] . "'";
			$sql .= ")";
		}
		
		$res = mysql_query($sql,$conn) or die("データ編集1エラー");
		
		if ($row_usingnow['kind'] == 2) {
			$sql2 = "REPLACE INTO " . $tablename_ele . " (id, kind, faculty, grade, subject, fname, lname, comment, output, date)";
			$sql2 .= "VALUES(";
			$sql2 .= "'" . $up_id . "',";
			$sql2 .= "'" . $kind_one . "',";
			$sql2 .= "'" . $faculty_one . "',";
		    $sql2 .= "'" . $grade_one . "',";
			$sql2 .= "'" . $subject_one . "',";
			$sql2 .= "'" . $fname_one . "',";
			$sql2 .= "'" . $lname_one . "',";
			$sql2 .= "'" . $comment_one . "',";
			$sql2 .= "'" . $output_one . "',";
			$sql2 .= "'" . $date_one . "'";
			$sql2 .= ")";
		} else {
			$sql2 = "REPLACE INTO " . $tablename . " (id, kind, who, faculty, grade, subject, name, comment, edit, writer, output, date)";
			$sql2 .= "VALUES(";
			$sql2 .= "'" . $up_id . "',";
			$sql2 .= "'" . $kind_one . "',";
			$sql2 .= "'" . $who_one . "',";
			$sql2 .= "'" . $faculty_one . "',";
		    $sql2 .= "'" . $grade_one . "',";
			$sql2 .= "'" . $subject_one . "',";
			$sql2 .= "'" . $name_one . "',";
			$sql2 .= "'" . $comment_one . "',";
			$sql2 .= "'" . $edit_one . "',";
			$sql2 .= "'" . $writer_one . "',";
			$sql2 .= "'" . $output_one . "',";
			$sql2 .= "'" . $date_one . "'";
			$sql2 .= ")";
		}
		
		$res2 = mysql_query($sql2,$conn) or die("データ編集2エラー");
		exit;
		
	} else if (isset($_GET['mode']) && preg_match("/down/",$_GET['mode'])) {
		$down_id = preg_replace("/down([\d]+)$/","$1",$_GET['mode']);
		$down_id2 = $down_id - 1;
		
		if ($row_usingnow['kind'] == 2) {
			$sql_one = "select * from " . $tablename_ele . " where ID = '" . $down_id2 . "'";
		} else {
			$sql_one = "select * from " . $tablename . " where ID = '" . $down_id2 . "'";
		}
		$res_one = mysql_query($sql_one,$conn) or die("データ抽出エラー");
		$row_one = mysql_fetch_array($res_one,MYSQL_ASSOC);
		
		if (empty($row_one['id'])) {
			exit;
		}
		
		if ($row_usingnow['kind'] == 2) {
			$kind_one = $row_one['kind'];
			$faculty_one = $row_one['faculty'];
			$grade_one = $row_one['grade'];
			$subject_one = $row_one['subject'];
			$fname_one = $row_one["fname"];
			$lname_one = $row_one["lname"];
			$comment_one = $row_one['comment'];
			$output_one = $row_one['output'];
			$date_one = $row_one['date'];
		} else {
			$kind_one = $row_one['kind'];
			$who_one = $row_one['who'];
			$faculty_one = $row_one['faculty'];
			$grade_one = $row_one['grade'];
			$subject_one = $row_one['subject'];
			$name_one = $row_one['name'];
			$comment_one = $row_one['comment'];
			$edit_one = $row_one['edit'];
			$writer_one = $row_one['writer'];
			$output_one = $row_one['output'];
			$date_one = $row_one['date'];
		}	
		
		if ($row_usingnow['kind'] == 2) {
			$sql = "select * from " . $tablename_ele . " where ID = '" . $down_id . "'";
		} else {
			$sql = "select * from " . $tablename . " where ID = '" . $down_id . "'";
		}
		$res = mysql_query($sql,$conn) or die("データ抽出エラー");	
		$row = mysql_fetch_array($res,MYSQL_ASSOC);
		
		if ($row_usingnow['kind'] == 2) {
			$sql = "REPLACE INTO " . $tablename_ele . " (id, kind, faculty, grade, subject, fname, lname, comment, output, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $down_id2 . "',";
			$sql .= "'" . $row['kind'] . "',";
			$sql .= "'" . $row['faculty'] . "',";
		    $sql .= "'" . $row['grade'] . "',";
			$sql .= "'" . $row['subject'] . "',";
			$sql .= "'" . $row['fname'] . "',";
			$sql .= "'" . $row['lname'] . "',";
			$sql .= "'" . $row['comment'] . "',";
			$sql .= "'" . $row['output'] . "',";
			$sql .= "'" . $row['date'] . "'";
			$sql .= ")";
		} else {
			$sql = "REPLACE INTO " . $tablename . " (id, kind, who, faculty, grade, subject, name, comment, edit, writer, output, date)";
			$sql .= "VALUES(";
			$sql .= "'" . $down_id2 . "',";
			$sql .= "'" . $row['kind'] . "',";
			$sql .= "'" . $row['who'] . "',";
			$sql .= "'" . $row['faculty'] . "',";
		    $sql .= "'" . $row['grade'] . "',";
			$sql .= "'" . $row['subject'] . "',";
			$sql .= "'" . $row['name'] . "',";
			$sql .= "'" . $row['comment'] . "',";
			$sql .= "'" . $row['edit'] . "',";
			$sql .= "'" . $row['writer'] . "',";
			$sql .= "'" . $row['output'] . "',";
			$sql .= "'" . $row['date'] . "'";
			$sql .= ")";
		}
		
		$res = mysql_query($sql,$conn) or die("データ編集1エラー");
		
		if ($row_usingnow['kind'] == 2) {
			$sql2 = "REPLACE INTO " . $tablename_ele . " (id, kind, faculty, grade, subject, fname, lname, comment, output, date)";
			$sql2 .= "VALUES(";
			$sql2 .= "'" . $down_id . "',";
			$sql2 .= "'" . $kind_one . "',";
			$sql2 .= "'" . $faculty_one . "',";
		    $sql2 .= "'" . $grade_one . "',";
			$sql2 .= "'" . $subject_one . "',";
			$sql2 .= "'" . $fname_one . "',";
			$sql2 .= "'" . $lname_one . "',";
			$sql2 .= "'" . $comment_one . "',";
			$sql2 .= "'" . $output_one . "',";
			$sql2 .= "'" . $date_one . "'";
			$sql2 .= ")";
		} else {
			$sql2 = "REPLACE INTO " . $tablename . " (id, kind, who, faculty, grade, subject, name, comment, edit, writer, output, date)";
			$sql2 .= "VALUES(";
			$sql2 .= "'" . $down_id . "',";
			$sql2 .= "'" . $kind_one . "',";
			$sql2 .= "'" . $who_one . "',";
			$sql2 .= "'" . $faculty_one . "',";
		    $sql2 .= "'" . $grade_one . "',";
			$sql2 .= "'" . $subject_one . "',";
			$sql2 .= "'" . $name_one . "',";
			$sql2 .= "'" . $comment_one . "',";
			$sql2 .= "'" . $edit_one . "',";
			$sql2 .= "'" . $writer_one . "',";
			$sql2 .= "'" . $output_one . "',";
			$sql2 .= "'" . $date_one . "'";
			$sql2 .= ")";
		}
		
		$res2 = mysql_query($sql2,$conn) or die("データ編集2エラー");
		exit;
		
	} else {
		
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
				
				$sql = "UPDATE " . $tablename . " SET ";
				$sql .= "kind = '" . $kind . "',";
				$sql .= "who = '" . $who . "',";
				$sql .= "faculty = '" . $faculty . "',";
				$sql .= "grade = '" . $grade . "',";
				$sql .= "subject = '" . $subject . "',";
				$sql .= "name = '" . $name . "',";
				$sql .= "comment = '" . $comment . "',";
				$sql .= "edit = 'yes'";
				$sql .= " WHERE writer = '" . urldecode($_GET['writer']) . "' and date = '" . urldecode($_GET['date']) . "'";
				
				$res = mysql_query($sql,$conn) or die("データ編集エラー");
				
				if ($res) {
					$_SESSION = array();
					header("Location: ./?mode=edit");
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
						if (empty($_SESSION['error6'])) {
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
				
				$url = "./?mode=edit&re&edit_id=" . $_GET['edit_id'];
				header("Location:" . $url);
				exit;
			}
		} else {
			$_SESSION['status'] = "edit_ng";
			header("Location: ../../parts/error_fin.php");
			exit;
		}
	}
} else {
	$_SESSION['status'] = "edit_ng";
	header("Location:  ../../parts/error_fin.php");
	exit;
}

?>